<?php

App::uses('System.SystemAppController', 'Controller');

class UsersController extends SystemAppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add', 'login');
        if ($this->Auth->user()):
            $this->set('userRoles', $this->Config->find('list', array('fields' => array('value', 'type'), 'conditions' => array('section' => 'role'))));
        endif;
    }

    public $uses = array('System.User', 'System.Config');

    public function widgetdata() {
        $usersInfo = array(
            'totalUsers' => $this->User->find('count'),
            'lastUser' => $this->User->find('first', array('order' => array('id' => 'DESC'))),
            'userRoles' => $this->Config->find('list', array('fields' => array('value', 'type'), 'conditions' => array('section' => 'role')))
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
                CakeLog::write('activity', $this->Auth->user()['username'] . ' added a new user: ' . $this->request->data['User']['username'] . ' (#' . $this->User->getLastInsertId() . ')');
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('siteName', 'pageTitle'));

        if($type == "quick"):
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
                CakeLog::write('activity', $this->Auth->user()['username'] . ' edited the user ' . $this->request->data['User']['username'] . ' (#' . $this->request->data['User']['id'] . ')');
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
        $userId = $this->Auth->user();
        if ($id == 1):
            $this->Session->setFlash(__('Are you freaking insane? You cannot delete god.'));
        else:
            if (!$this->User->exists()):
                throw new NotFoundException(__('Invalid user'));
            endif;
            if ($this->User->delete()):
                CakeLog::write('activity', $this->Auth->user()['username'] . ' deleted an existing user #' . $id . "");
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
                CakeLog::write('activity', $this->Auth->user()['username'] . ' has logged in under IP ' . $_SERVER["REMOTE_ADDR"]);
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
