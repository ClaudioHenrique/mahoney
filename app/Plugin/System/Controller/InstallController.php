<?php

App::uses('System.SystemAppController', 'Controller');

//App::uses('Migrations', 'Vendor');
//App::uses('Fixtures', 'Vendor');

class InstallController extends SystemAppController {

    public $uses = array();
    
    public $components = array('System.Security');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }

    public function index() {
        if (file_exists(APP . 'Config' . DS . 'installed')):
            $this->redirect($this->Auth->logoutRedirect);
        else:
            $this->Session->write('salt', $this->Security->genRandom(40));
            $this->Session->write('seed', $this->Security->genrandom(29, "0123456789"));
            $siteName = "Mahoney";
            $pageTitle = __('Installation');
            $salt = $this->Session->read('salt');
            $seed = $this->Session->read('seed');
            $this->set(compact('siteName', 'pageTitle', 'salt', 'seed'));
            if ($this->request->is('post')):
                $formErrors = array();
                $this->request->data["Config"]["password"] = "";
                pr($this->request->data);
            else:
                
            endif;
            
        endif;
    }

}
