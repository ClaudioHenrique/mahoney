<?php
App::uses('AppController', 'Controller');

class SystemAppController extends AppController {
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'System.systemDefault';
    }
}