<?php
App::uses('System.SystemAppController', 'Controller');

class DashboardController extends SystemAppController {
    
    public $uses = array();
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }
    
    public function index() {
        
        $siteName = "Mahoney";
        if (AuthComponent::user('id')):
            $render = "index";
            $pageTitle = __('Dashboard');
        else:
            $render = "/Users/login";
            $pageTitle = __('Login');
        endif;
        
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
}