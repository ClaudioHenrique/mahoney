<?php

App::uses('System.SystemAppController', 'Controller');

class ContactController extends SystemAppController {

    public $uses = array('System.Config');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }
    
    public function isAuthorized($user) {
        return parent::isAuthorized($user);
    }

    /**
     * Cleans the activity log
     * 
     * @throws FileNotFoundException
     */
    public function index() {
        
        $this->set('pageTitle', __("Contact"));
        
        $this->layout = "default";
        
    }
}
