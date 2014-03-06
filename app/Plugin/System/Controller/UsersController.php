<?php

App::uses('System.SystemAppController', 'Controller');

class UsersController extends SystemAppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login', 'recover');
    }

    public $uses = array('System.User', 'System.Token');
    public $components = array('System.Security', 'System.Configurer', 'System.Mailer');

    public function recover($userid = null) {
        $this->set('pageTitle', __("Password recovery"));
        if (!AuthComponent::user() || $userid != null):
            if (!isset($this->request->query['get'])):
                if ($this->request->is("post") || $userid != null):
                    if($userid != null):
                        $userToRecovery = $this->User->find('first', array('conditions' => array('User.id' => $userid)));
                    else:
                        $userToRecovery = $this->User->find('first', array('conditions' => array('User.email' => $this->request->data["Recover"]["email"])));
                    endif;
                    if (!empty($userToRecovery)):

                        $tokenToSave = array(
                            "Token" => array(
                                "user_id" => $userToRecovery["User"]["id"],
                                "token" => $this->Security->genRandom(50),
                                "type" => "pwrecovery"
                            )
                        );

                        $vVars = array(
                            'username' => $userToRecovery["User"]["username"],
                            'recoverLink' => "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
                            'token' => $tokenToSave["Token"]["token"]
                        );
                        if($this->Token->save($tokenToSave)):
                            try {
                                // Sends the Email
                                $this->Mailer->send($userToRecovery["User"]["email"], __("About password change"), "System.recover", "System.recover", $vVars);
                                CakeLog::write('activity', 'Info: New token generated to "' . $userToRecovery["User"]["username"].'"');
                                $this->Session->setFlash(__("Thank you! We've sent you an email with the next steps."));
                            } catch (Exception $ex) {
                                // Delete last token from database:
                                $this->Token->delete($this->Token->getInsertID());
                                CakeLog::write('activity', 'Error: Error trying to send an email to "' . $userToRecovery["User"]["email"].'": ' . $ex->getMessage());
                                $this->Session->setFlash(__("The email with steps to recover your password cannot be sent. Please try again."));
                            }
                        else:
                            CakeLog::write('activity', 'Error: Error trying to store token data for "' . $vVars["username"].'"');
                            $this->Session->setFlash(__("Your token cannot be generated right now. Please try again."));
                        endif;
                        
                    else:
                        CakeLog::write('activity', 'Warning: ' . $_SERVER['REMOTE_ADDR'] . ' has requested email recovery for a unknow '. ($this->request->data["Recover"]["email"]) ? "address" : "user id" .': ' . ($this->request->data["Recover"]["email"]) ? $this->request->data["Recover"]["email"] : $userid);
                        $this->Session->setFlash(__("Thank you for your request. Check your email to know how to proceed."));
                    endif;
                    $this->redirect($this->referer());
                endif;
            else:
                if (isset($this->request->query['token'])):
                    $this->request->data["Recover"]["token"] = $this->request->query['token'];
                endif;
                if ($this->request->is("post")):
                    $tokenRequest = $this->Token->find('first', array('conditions' => array('Token.token' => $this->request->data["Recover"]["token"], 'Token.created >' => date('Y-m-d H:i:s', strtotime("-1 days")))));
                    if (!empty($tokenRequest)):
                        $updateUserPw = array(
                            "User" => array(
                                "id" => $tokenRequest["User"]["id"],
                                "password" => $this->request->data["Recover"]["password"]
                            )
                        );

                        if ($this->User->save($updateUserPw)):
                            try {
                                $this->Token->delete($tokenRequest["Token"]["id"]);
                                $this->Session->setFlash(__("Password successfully recovered. Login to continue."));
                                $this->Auth->logout();
                                $this->redirect(array("plugin" => "system", "controller" => "dashboard", "action" => "index"));
                            } catch (Exception $ex) {
                                $this->Session->setFlash(__("There was a problem saving your new password. Can you recover it again?") . " err: " . $ex->getMessage());
                            }
                        else:
                            $this->Session->setFlash(__("There was a problem saving your new password. Can you recover it again?"));
                        endif;
                    else:
                        $this->Session->setFlash(__("Sorry, we can't find any request with that token code."));
                    endif;
                endif;
            endif;
        else:
            $this->redirect($this->Auth->loginAction);
        endif;
    }

    public function widgetdata() {
        $usersInfo = array(
            'totalUsers' => $this->User->find('count'),
            'lastUser' => $this->User->find('first', array('order' => array('id' => 'DESC'))),
        );
        return $usersInfo;
    }

    public function index() {
        $siteName = "Mahoney";

        $render = "index";
        $pageTitle = __("Users");
        $this->User->recursive = 0;
        $users = $this->paginate();
        $this->set(compact('siteName', 'pageTitle', 'users'));

        try {
            $this->render($render);
        } catch (MissingViewException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }

    public function detail($id = null) {
        $siteName = "Mahoney";
        $render = "detail";

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $user = $this->User->read(null, $id);
        $pageTitle = $user['User']['username'] . "'s     " . __("profile");
        $this->set(compact('siteName', 'pageTitle', 'user'));

        try {
            $this->render($render);
        } catch (MissingViewException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }

    public function roles() {
        $siteName = "Mahoney";
        $render = "roles";
        $pageTitle = __("Manage roles");

        $this->set(compact('siteName', 'pageTitle'));

        try {
            $this->render($render);
        } catch (MissingViewException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }

    public function add($type = null) {

        $siteName = "Mahoney";
        $render = "add";
        $pageTitle = __("Add user");

        if ($this->request->is('POST')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                CakeLog::write('activity', AuthComponent::user()['username'] . ' added a new user: ' . $this->request->data['User']['username'] . ' (#' . $this->User->getLastInsertId() . ')');
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('siteName', 'pageTitle'));

        if ($type == "quick"):
            $this->redirect($this->referer());
        endif;

        try {
            $this->render($render);
        } catch (MissingViewException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                CakeLog::write('activity', AuthComponent::user()['username'] . ' edited the user ' . $this->request->data['User']['username'] . ' (#' . $this->request->data['User']['id'] . ')');
                $this->Session->setFlash(__('The user has been saved'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
            $this->redirect($this->referer());
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) {
        if ($this->request->is('post')):
            throw new MethodNotAllowedException();
        endif;
        $this->User->id = $id;
        $userId = AuthComponent::user();
        if ($id == 1):
            $this->Session->setFlash(__('Are you freaking insane? You cannot delete god.'));
        else:
            if (!$this->User->exists()):
                throw new NotFoundException(__('Invalid user'));
            endif;
            if ($this->User->delete()):
                CakeLog::write('activity', AuthComponent::user()['username'] . ' deleted an existing user #' . $id . "");
                $this->Session->setFlash(__('User deleted'));
            else:
                $this->Session->setFlash(__('User was not deleted'));
            endif;
            if ($userId["id"] == $id):
                $this->Session->setFlash(__('It was good fight by your side young padawan.'));
                $this->Auth->logout();
                $this->redirect($this->Auth->loginAction);
            endif;
        endif;
        $this->redirect($this->referer());
    }

    public function login() {
        $siteName = "Mahoney";
        $pageTitle = __("Login");
        $this->set(compact('siteName', 'pageTitle'));

        if ($this->request->is('POST')):
            if ($this->Auth->login()):
                CakeLog::write('activity', AuthComponent::user()['username'] . ' has logged in under IP ' . $_SERVER["REMOTE_ADDR"]);
                $this->redirect($this->referer());
            else:
                CakeLog::write('activity', $_SERVER["REMOTE_ADDR"] . ' failed attempting to login (Username used: ' . $this->request->data['User']['username'] . ')');
                $this->Session->setFlash(__('Invalid username or password, try again'));
                $this->redirect($this->Auth->redirect());
            endif;
        else:
            $this->redirect($this->Auth->redirect());
        endif;
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

}
