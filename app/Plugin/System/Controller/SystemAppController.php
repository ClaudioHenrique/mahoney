<?php
App::uses('AppController', 'Controller');

class SystemAppController extends AppController {
    
    public function isAuthorized($user) {
        
        if(isset($user['role']) && $user['role'] >= 4):
            return true;
        endif;
        
        return parent::isAuthorized($user);
    }
    
    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->layout = 'System.systemDefault';
    }
}