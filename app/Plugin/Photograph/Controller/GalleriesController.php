<?php
App::uses('Photograph.PhotographAppController', 'Controller');

class GalleriesController extends PhotographAppController {
    
    var $uses = array();
    
    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function system_index(){
        
        $siteName = "Mahoney";
        $render = "index";
        $pageTitle = "Photograph | List galleries";
        
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
    
    public function system_add(){
        
        $siteName = "Mahoney";
        $render = "add";
        $pageTitle = "Photograph | Add galleries";
        
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