<?php

App::uses('System.SystemAppController', 'Controller');

class ConfigController extends SystemAppController {

    public $uses = array('System.Config');

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
            throw new NotFoundException(__('The activity log does not exist!'));
        endif;
        $this->redirect($this->referer());
    }
}
