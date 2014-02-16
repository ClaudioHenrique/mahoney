<?php

App::uses('System.SystemAppController', 'Controller');

class DocsController extends SystemAppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }

    public $uses = array();

    public function index() {

        $siteName = "Mahoney";

        $pageTitle = __("Documentation");

        $this->set(compact('siteName', 'pageTitle'));

    }

}
