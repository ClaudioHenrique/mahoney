<?php

App::uses('System.SystemAppController', 'Controller');

class PluginsController extends SystemAppController {

    public $uses = array('System.Schema');
    public $components = array('System.Plugin', 'System.FileManager');

    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function migrate() {
        if($this->request->is('ajax')):
            $this->autoRender = false;
            $this->response->type('json');
            
            $data = $this->params['url']['data'];
            $migrate = $this->Plugin->migrate($data["plugin"], true);
            
            $responseArray = array(
                "status" => ($migrate == true) ? "OK" : "ERROR",
                "message" => ($migrate == true) ? __("Plugin migrated with success.") : $migrate
            );
            
            return json_encode($responseArray);
        endif;
    }

    public function index() {
        
        $pageTitle = __('Plugins');

        $this->set(compact('pageTitle'));
        
    }

}
