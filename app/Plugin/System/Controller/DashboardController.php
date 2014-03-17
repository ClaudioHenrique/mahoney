<?php

App::uses('System.SystemAppController', 'Controller');

class DashboardController extends SystemAppController {
    
    public $uses = array();
    
    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function isAuthorized($user) {
        return parent::isAuthorized($user);
    }
    
    public function index() {
        
        if (AuthComponent::user()):
            $render = "index";
            $pageTitle = __('Dashboard');
        else:
            $render = "/Users/login";
            $pageTitle = __('Login');
        endif;
        
        $this->set(compact('pageTitle'));
        
        $this->render($render);
    }    
}