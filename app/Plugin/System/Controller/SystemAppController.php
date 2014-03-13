<?php
App::uses('AppController', 'Controller');

class SystemAppController extends AppController {
    
    public function isAuthorized($user) {
        parent::isAuthorized($user);
        
        // Only admin can access System
        if (isset($user['role']) && intval($user['role']) >= 4):
            return true;
        endif;
        return false;
    }
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'System.systemDefault';
    }
}