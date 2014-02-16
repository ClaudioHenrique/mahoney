<?php

App::uses('System.SystemAppController', 'Controller');

class PluginsController extends SystemAppController {

    public $uses = array();
    public $components = array('System.Plugin', 'System.FileManager');

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function disable($plugin) {
        unlink(APP . 'Plugin' . DS . $plugin . DS . 'active');
        CakeLog::write('activity', $this->Auth->user()['username'] . " disabled " . $plugin . " plugin");
        $this->redirect($this->referer());
    }

    public function enable($plugin) {
        $fp = fopen(APP . 'Plugin' . DS . $plugin . DS . 'active', "wb");
        fclose($fp);
        CakeLog::write('activity', $this->Auth->user()['username'] . " enabled " . $plugin . " plugin");
        $this->redirect($this->referer());
    }

    public function delete($plugin) {
        $this->FileManager->recursiveExclude(APP . 'Plugin' . DS . $plugin);
        CakeLog::write('activity', $this->Auth->user()['username'] . " deleted " . $plugin . " plugin");

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
