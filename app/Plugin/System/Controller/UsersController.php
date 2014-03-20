<?php

App::uses('System.SystemAppController', 'Controller');

class UsersController extends SystemAppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login', 'recover', 'logout');
    }
    
    public function isAuthorized($user) {
        
        if (in_array($this->action, array('edit', 'delete'))) {
            $id = $this->request->params['pass'][0];
            if($this->User->read(null, $id)):
                $userToModify = $this->User->read(null, $id);
                if($user["role"] < $userToModify["User"]["role"]):
                    CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Users")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], __d("system", "to modify"), $userToModify["User"]["username"], sprintf(__d("system","user")), __d("system", "Access Denied")));
                    $this->Session->setFlash(sprintf(__d("system","Error trying %s the '%s' %s."), __d("system", "to modify"), $userToModify["User"]["username"], __d("system","user")));
                    return false;
                endif;
            endif;
        }
        
        return parent::isAuthorized($user);
    }

    public $uses = array('System.User', 'System.Token');
    public $components = array('System.Security', 'System.Configurer', 'System.Mailer', 'Paginator');
    
    public $paginate = array(
        'limit' => 25,
        'order' => array(
            'User.id' => 'desc'
        )
    );

    public function batch() {
        $action = $this->request->data["Batch"]["action"];
        unset($this->request->data["Batch"]["action"]);
        $count = count($this->request->data["Batch"]);
        if($count > 0):
            try {
                foreach($this->request->data["Batch"] as $key => $value):
                    $this->User->delete($value['id']);
                endforeach;
                CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) The '%s' batch has modified %s occurrences."), sprintf(__d("system","Users")), $action, $count));
                $this->Session->setFlash(sprintf(__d("system","The '%s' batch has modified %s occurrecies."), $action, $count));
                $this->redirect($this->referer());
            } catch(Exception $ex) {           
                CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Users")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], $action, sprintf(__d("system","%s occurrences"), $count), $ex->getMessage()));
                $this->Session->setFlash(sprintf(__d("system","Error trying to batch '%s' %s."), $action, sprintf(__d("system","%s occurrences"), $count)));
                $this->redirect($this->referer());
            }
        else:
            $this->redirect($this->referer());
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
        
        $pageTitle = __d("system","List Users");
        $this->User->recursive = 0;
        
        $this->Paginator->settings = $this->paginate;
        $conditions = array();
        foreach($this->params['url'] as $key => $value):
            if(!is_int($key)):
                $conditions[$key . " LIKE"] = "%".$value."%";
            endif;
        endforeach;
        if(count($conditions) > 0):
            $users = $this->Paginator->paginate($conditions);
        else:
            $users = $this->Paginator->paginate();
        endif;
        
        $this->set(compact('pageTitle', 'users'));

    }

    public function detail($id = null) {

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(sprintf(__d("system","Invalid %s"), __d("system", "user")));
        }
        $user = $this->User->read(null, $id);
        
        $pageTitle = $user['User']['username'] . "'s     " . __d("system","profile");
        
        $this->set(compact('pageTitle', 'user'));
    }

    public function roles() {
        
        $pageTitle = __d("system","Manage Roles");

        $this->set(compact('pageTitle'));
    }

    public function add($type = null) {
        
        $pageTitle = __d("system","Add Users");

        $this->set(compact('pageTitle'));

        if ($this->request->is('POST')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {                
                CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) The '%s' %s was %s with success."), sprintf(__d("system","Users")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], $this->request->data["User"]["username"], sprintf(__d("system","user")), __d("system", "added")));
                $this->Session->setFlash(sprintf(__d("system","The '%s' %s was %s with success."), $this->request->data["User"]["username"], sprintf(__d("system","user")), __d("system", "added")));
            } else {
                CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Users")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], __d("system", "to save"), $this->request->data["User"]["username"], sprintf(__d("system","user")), __d("system","Access Denied")));
                $this->Session->setFlash(sprintf(__d("system","Error trying %s the '%s' %s."), __d("system", "to save"), $this->request->data["User"]["username"], __d("system","user")));
            }
            if ($type == "quick"):
                $this->redirect($this->referer());
            else:
                $this->redirect(array("plugin"=>"system","controller"=>"users","action"=>"index"));
            endif;
        }
    }

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(sprintf(__d("system","Invalid %s"), __d("system", "user")));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data["User"]["id"] = $id;
            if ($this->User->save($this->request->data)) {
                CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) The '%s' %s was %s with success."), sprintf(__d("system","Users")), $this->request->data["User"]["username"], sprintf(__d("system","user")), __d("system", "edited")));
                $this->Session->setFlash(sprintf(__d("system","The '%s' %s was %s with success."), $this->request->data["User"]["username"], sprintf(__d("system","user")), __d("system", "edited")));
                $this->redirect(array("plugin"=>"system","controller"=>"users","action"=>"index"));
            } else {
                CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Users")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], __d("system", "to edit"), $this->request->data["User"]["username"], sprintf(__d("system","user")), __d("system","Access Denied")));
                $this->Session->setFlash(sprintf(__d("system","Error trying %s the '%s' %s."), __d("system", "to edit"), $this->request->data["User"]["username"], __d("system","user")));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
        }
    }

    public function delete($id = null) {
        if ($this->request->is('post')):
            throw new MethodNotAllowedException();
        endif;
        $this->User->id = $id;
        $userId = AuthComponent::user();
        if (!$this->User->exists()):
            throw new NotFoundException(sprintf(__d("system","Invalid %s"), __d("system","user")));
        endif;
        if ($id == 1):
            CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Users")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], __d("system", "to delete"), "#".$id, sprintf(__d("system","user")), __d("system", "Access Denied")));
            $this->Session->setFlash(sprintf(__d("system","Error trying %s the '%s' %s."), __d("system", "to delete"), "#".$id, __d("system","user")));
        else:
            if ($this->User->delete()):
                CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) The '%s' %s was %s with success."), sprintf(__d("system","Users")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], "#".$id, sprintf(__d("system","user")), __d("system", "deleted")));
                $this->Session->setFlash(sprintf(__d("system","The '%s' %s was %s with success."), "#".$id, sprintf(__d("system","user")), __d("system", "deleted")));
            else:
                CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Users")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], __d("system", "to delete"), "#".$id, sprintf(__d("system","user")), __d("system", "Access Denied")));
                $this->Session->setFlash(sprintf(__d("system","Error trying %s the '%s' %s."), __d("system", "to delete"), "#".$id, __d("system","user")));
            endif;
            if ($userId["id"] == $id):
                $this->Session->setFlash(sprintf(__d("system","It was good fight by your side young padawan.")));
                $this->Auth->logout();
                $this->redirect($this->Auth->loginAction);
            endif;
        endif;
        $this->redirect($this->referer());
    }

    public function login() {

        $pageTitle = __d("system","Login");
        
        $this->set(compact('pageTitle'));

        if ($this->request->is('POST')):
            if ($this->Auth->login()):
                CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) The '%s' %s was %s with success."), sprintf(__d("system","Users")), AuthComponent::user()['username'], sprintf(__d("system","user")), __d("system", "connected")));
                $this->redirect($this->referer());
            else:
                CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Users")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], __d("system", "to connect"), $this->request->data['User']['username'], sprintf(__d("system","user")), __d("system", "Invalid username or password")));
                $this->Session->setFlash(sprintf(__d("system", "Invalid username or password")));
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