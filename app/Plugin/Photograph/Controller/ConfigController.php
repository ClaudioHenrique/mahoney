<?php
App::uses('Photograph.PhotographAppController', 'Controller');

class ConfigController extends PhotographAppController {
    
    var $uses = array();
    
    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function system_index(){
        
        $siteName = "Mahoney";
        $render = "index";
        $pageTitle = "Photograph | Configuration";
        
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