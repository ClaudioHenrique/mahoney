<?php

App::uses('System.SystemAppController', 'Controller');

class DocsController extends SystemAppController {

    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function isAuthorized($user) {
        return parent::isAuthorized($user);
    }

    public $uses = array();

    public function index() {

        $pageTitle = __d("system","Documentation");

        $this->set(compact('pageTitle'));

    }

}
