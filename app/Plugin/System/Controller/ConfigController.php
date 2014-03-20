<?php

App::uses('System.SystemAppController', 'Controller');

class ConfigController extends SystemAppController {

    public $uses = array('System.Config');
    
    public $components = array('System.FileManager');

    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function isAuthorized($user) {
        return parent::isAuthorized($user);
    }

    /**
     * Cleans the activity log
     * 
     * @throws FileNotFoundException
     */
    public function cleanlog() {
        if (file_exists(LOGS . 'activity.log')):
            $this->FileManager->commonExclude(LOGS . 'activity.log');
            CakeLog::write('activity', "Activity log deleted.");
        else:
            throw new NotFoundException(sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), AuthComponent::user()["username"], sprintf(__d("system","Config")), __d("system", "to open"), sprintf(__d("system","the activity log")), __d("system","The specified file/folder don't exist")));
        endif;
        $this->redirect($this->referer());
    }
}
