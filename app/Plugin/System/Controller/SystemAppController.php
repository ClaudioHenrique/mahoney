<?php
App::uses('AppController', 'Controller');

class SystemAppController extends AppController {
    
    public $components = array('System.Plugin');
    
    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->Plugin->getPlugins();
        $this->set('mahoneyPlugins', $this->Plugin->PLUGINS);
        
        $this->layout = 'System.systemDefault';
    }
}