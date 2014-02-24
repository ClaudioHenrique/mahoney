<?php

App::uses('System.SystemAppController', 'Controller');

App::uses('Migrations', 'Vendor');
App::uses('Fixtures', 'Vendor');

class PluginsController extends SystemAppController {

    public $uses = array('System.Schema');
    public $components = array('System.Plugin', 'System.FileManager');

    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function disable($plugin) {
        if($plugin != "System"):
            unlink(APP . 'Plugin' . DS . $plugin . DS . 'active');
            CakeLog::write('activity', $this->Auth->user()['username'] . " disabled " . $plugin . " plugin");
        else:
            $this->Session->setFlash(__("You cannot disable Mahoney Core"));
        endif;
        $this->redirect($this->referer());
    }

    public function enable($plugin) {
        $fp = fopen(APP . 'Plugin' . DS . $plugin . DS . 'active', "wb");
        fclose($fp);
        CakeLog::write('activity', $this->Auth->user()['username'] . " enabled " . $plugin . " plugin");
        $this->redirect($this->referer());
    }

    public function delete($plugin) {
        if($this->Plugin->uninstall($plugin)):
            $this->FileManager->recursiveExclude(APP . 'Plugin' . DS . $plugin);
            CakeLog::write('activity', $this->Auth->user()['username'] . " deleted " . $plugin . " plugin");
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
