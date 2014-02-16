<?php

App::uses('System.SystemAppController', 'Controller');

//App::uses('Migrations', 'Vendor');
//App::uses('Fixtures', 'Vendor');

class ConfigController extends SystemAppController {

    public $uses = array('System.Config', 'Blog.Post');
    public $components = array('System.Plugin', 'System.FileManager');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('install');
    }
    
    public function system_widgetdata() {
        $blogInfo = array(
            'totalPosts' => $this->Post->find('count'),
            'lastPost' => $this->Post->find('first')
        );
        return $blogInfo;
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

    public function index() {

        $siteName = "Mahoney";
        $render = "index";
        $pageTitle = __('Plugins');

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