<?php

App::uses('System.SystemAppController', 'Controller');

class PluginsController extends SystemAppController {

    public $uses = array('System.Schema');
    public $components = array('System.Plugin', 'System.FileManager');

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function uninstall($plugin = null) {
        if (!in_array($plugin, $this->Plugin->DENY_LIST) && is_dir($this->Plugin->PLUGIN_FOLDER . $plugin)):
            $this->Plugin->uninstall($plugin);

            try {
                unlink(str_replace("{plugin}", $plugin, $this->Plugin->ACTIVE_PLUGIN_FILE));
                $this->Session->setFlash("'" . $plugin . "' " . __("was uninstalled successfully"));
            } catch (Exception $e) {
                $this->Session->setFlash(__("Error at disable plugin") . " '" . $plugin . "', " . __("the error was the following") . ": " . $e->getMessage());
            }

        else:
            $this->Session->setFlash(__("You cannot disable") . " '" . $plugin . "'");
        endif;
        $this->redirect($this->referer());
    }

    /**
     * Reset's a specific plugin database.
     * 
     * @param String The plugin to reset
     */
    public function reset($plugin = null) {
        if (!in_array($plugin, $this->Plugin->DENY_LIST) && is_dir($this->Plugin->PLUGIN_FOLDER . $plugin)):
            try {
                $this->Plugin->uninstall($plugin);
                $this->Plugin->update($plugin);
            } catch (Exception $ex) {
                $this->Session->setFlash(__("Error trying to reset the plugin named") . ": '" . $plugin . "'");
            }
        else:
            $this->Session->setFlash(__("You cannot disable") . " '" . $plugin . "'");
        endif;
        $this->redirect($this->referer());
    }

    public function update($plugin = null) {
        if (!in_array($plugin, $this->Plugin->DENY_LIST) && is_dir($this->Plugin->PLUGIN_FOLDER . $plugin)):
            if ($this->Plugin->isOutdated($plugin)):
                $this->Plugin->update($plugin);
            endif;
        else:
            $this->Session->setFlash(__("You cannot disable") . " '" . $plugin . "'");
        endif;
        $this->redirect($this->referer());
    }

    /**
     * Disable a specific plugin.
     * 
     * @param String The plugin to modify
     */
    public function disable($plugin = null) {
        if (!in_array($plugin, $this->Plugin->DENY_LIST) && is_dir($this->Plugin->PLUGIN_FOLDER . $plugin)):
            try {
                unlink(str_replace("{plugin}", $plugin, $this->Plugin->ACTIVE_PLUGIN_FILE));
            } catch (Exception $e) {
                $this->Session->setFlash(__("Error at disable plugin") . " '" . $plugin . "', " . __("the error was the following") . ": " . $e->getMessage());
            }
        else:
            $this->Session->setFlash(__("You cannot disable") . " '" . $plugin . "'");
        endif;
        $this->redirect($this->referer());
    }

    /**
     * Enable a specific plugin
     * 
     * @param String The plugin to modify
     */
    public function enable($plugin = null) {
        if (!in_array($plugin, $this->Plugin->DENY_LIST) && is_dir($this->Plugin->PLUGIN_FOLDER . $plugin)):
            try {

                if ($this->Plugin->isOutdated($plugin)):
                    $this->Plugin->update($plugin);
                endif;

                $fp = fopen(str_replace("{plugin}", $plugin, $this->Plugin->ACTIVE_PLUGIN_FILE), "wb");
                fclose($fp);
            } catch (Exception $e) {
                $this->Session->setFlash(__("Error at enable plugin") . " '" . $plugin . "', " . __("the error was the following") . ": " . $e->getMessage());
            }
        else:
            $this->Session->setFlash(__("You cannot enable") . " '" . $plugin . "'");
        endif;
        $this->redirect($this->referer());
    }

    public function delete($plugin = null) {
        if (!in_array($plugin, $this->Plugin->DENY_LIST) && is_dir($this->Plugin->PLUGIN_FOLDER . $plugin)):
            $this->Plugin->uninstall($plugin);

            $this->FileManager->recursiveExclude(APP . 'Plugin' . DS . $plugin);
            CakeLog::write('activity', AuthComponent::user('username') . __("deleted the plugin") . " '" . $plugin . "'");
            $this->Session->setFlash(__("Plugin named") . " '" . $plugin . "' " . __("deleted successfully."));
        else:
            $this->Session->setFlash(__("You cannot delete") . " '" . $plugin . "'");
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
