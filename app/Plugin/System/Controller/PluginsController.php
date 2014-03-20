<?php

App::uses('System.SystemAppController', 'Controller');

class PluginsController extends SystemAppController {

    public $uses = array('System.Schema');
    public $components = array('System.Plugin', 'System.FileManager');

    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function isAuthorized($user) {
        return parent::isAuthorized($user);
    }

    public function uninstall($plugin = null) {
        if (!in_array($plugin, $this->Plugin->DENY_LIST) && is_dir($this->Plugin->PLUGIN_FOLDER . $plugin)):
            $this->Plugin->uninstall($plugin);

            try {
                unlink(str_replace("{plugin}", $plugin, $this->Plugin->ACTIVE_PLUGIN_FILE));
                CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) The '%s' %s was %s with success."), sprintf(__d("system","Plugin")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], $plugin, sprintf(__d("system","plugin")), __d("system", "uninstalled")));
                $this->Session->setFlash(sprintf(__d("system","The '%s' %s was %s with success."), $plugin, sprintf(__d("system","plugin")), __d("system", "uninstalled")));
            } catch (Exception $ex) {
                CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Plugin")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], __d("system", "to uninstall"), $plugin, sprintf(__d("system","plugin")), $ex->getMessage()));
                $this->Session->setFlash(sprintf(__d("system","Error trying %s the '%s' %s."), __d("system", "to uninstall"), $plugin, __d("system","plugin")));
            }

        else:
            CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Plugin")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], __d("system", "to uninstall"), $plugin, sprintf(__d("system","plugin")), __d("system", "Access Denied")));
            $this->Session->setFlash(sprintf(__d("system","Error trying %s the '%s' %s."), __d("system", "to uninstall"), $plugin, __d("system","plugin")));
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
                CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) The '%s' %s was %s with success."), sprintf(__d("system","Plugin")), $plugin, sprintf(__d("system","plugin")), __d("system", "reseted")));
                $this->Session->setFlash(sprintf(__d("system","The '%s' %s was %s with success."), $plugin, sprintf(__d("system","plugin")), __d("system", "reseted")));
            } catch (Exception $ex) {
                CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Plugin")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], __d("system", "to reset"), $plugin, sprintf(__d("system","plugin")), $ex->getMessage()));
                $this->Session->setFlash(sprintf(__d("system","Error trying %s the '%s' %s."), __d("system", "to reset"), $plugin, __d("system","plugin")));
            }
        else:
            CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Plugin")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], __d("system", "to reset"), $plugin, sprintf(__d("system","plugin")), __d("system", "Access Denied")));
            $this->Session->setFlash(sprintf(__d("system","Error trying %s the '%s' %s."), __d("system", "to reset"), $plugin, __d("system","plugin")));
        endif;
        $this->redirect($this->referer());
    }

    public function update($plugin = null) {
        if (!in_array($plugin, $this->Plugin->DENY_LIST) && is_dir($this->Plugin->PLUGIN_FOLDER . $plugin)):
            if ($this->Plugin->isOutdated($plugin)):
                $this->Plugin->update($plugin);
                CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) The '%s' %s was %s with success."), sprintf(__d("system","Plugin")), $plugin, sprintf(__d("system","plugin")), __d("system", "updated")));
                $this->Session->setFlash(sprintf(__d("system","The '%s' %s was %s with success."), $plugin, sprintf(__d("system","plugin")), __d("system", "updated")));
            endif;
        else:
            CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Plugin")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], __d("system", "to update"), $plugin, sprintf(__d("system","plugin")), __d("system", "Access Denied")));
            $this->Session->setFlash(sprintf(__d("system","Error trying %s the '%s' %s."), __d("system", "to update"), $plugin, __d("system","plugin")));
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
                CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) The '%s' %s was %s with success."), sprintf(__d("system","Plugin")), $plugin, sprintf(__d("system","plugin")), __d("system", "disabled")));
                $this->Session->setFlash(sprintf(__d("system","The '%s' %s was %s with success."), $plugin, sprintf(__d("system","plugin")), __d("system", "disabled")));
            } catch (Exception $ex) {
                CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Plugin")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], __d("system", "to disable"), $plugin, sprintf(__d("system","plugin")), $ex->getMessage()));
                $this->Session->setFlash(sprintf(__d("system","Error trying %s the '%s' %s."), __d("system", "to disable"), $plugin, __d("system","plugin")));
            }
        else:
            CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Plugin")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], __d("system", "to disable"), $plugin, sprintf(__d("system","plugin")), __d("system", "Access Denied")));
            $this->Session->setFlash(sprintf(__d("system","Error trying %s the '%s' %s."), __d("system", "to disable"), $plugin, __d("system","plugin")));
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
                    try {
                        $this->Plugin->update($plugin);
                        CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) The '%s' %s was %s with success."), sprintf(__d("system","Plugin")), $plugin, sprintf(__d("system","plugin")), __d("system", "enabled")));
                        $this->Session->setFlash(sprintf(__d("system","The '%s' %s was %s with success."), $plugin, sprintf(__d("system","plugin")), __d("system", "enabled")));
                    } catch(Exception $ex) {
                        CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Plugin")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], __d("system", "to enable"), $plugin, sprintf(__d("system","plugin")), $ex->getMessage()));
                        $this->Session->setFlash(sprintf(__d("system","Error trying %s the '%s' %s."), __d("system", "to enable"), $plugin, __d("system","plugin")));
                    }
                endif;

                $fp = fopen(str_replace("{plugin}", $plugin, $this->Plugin->ACTIVE_PLUGIN_FILE), "wb");
                fclose($fp);
            } catch (Exception $ex) {
                CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Plugin")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], __d("system", "to enable"), $plugin, sprintf(__d("system","plugin")), $ex->getMessage()));
                $this->Session->setFlash(sprintf(__d("system","Error trying %s the '%s' %s."), __d("system", "to enable"), $plugin, __d("system","plugin")));
            }
        else:
            CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Plugin")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], __d("system", "to enable"), $plugin, sprintf(__d("system","plugin")), __d("system", "Access Denied")));
            $this->Session->setFlash(sprintf(__d("system","Error trying %s the '%s' %s."), __d("system", "to enable"), $plugin, __d("system","plugin")));
        endif;
        $this->redirect($this->referer());
    }

    public function delete($plugin = null) {
        if (!in_array($plugin, $this->Plugin->DENY_LIST) && is_dir($this->Plugin->PLUGIN_FOLDER . $plugin)):
            $this->Plugin->uninstall($plugin);
            $this->FileManager->recursiveExclude(APP . 'Plugin' . DS . $plugin);
            CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) The '%s' %s was %s with success."), sprintf(__d("system","Plugin")), $plugin, sprintf(__d("system","plugin")), __d("system", "deleted")));
            $this->Session->setFlash(sprintf(__d("system","The '%s' %s was %s with success."), $plugin, sprintf(__d("system","plugin")), __d("system", "deleted")));
        else:
            CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Plugin")), AuthComponent::user()["username"], $_SERVER["REQUEST_ADDR"], __d("system", "to delete"), $plugin, sprintf(__d("system","plugin")), __d("system", "Access Denied")));
            $this->Session->setFlash(sprintf(__d("system","Error trying %s the '%s' %s."), __d("system", "to delete"), $plugin, __d("system","plugin")));
        endif;
        $this->redirect($this->referer());
    }
    
//    public function install($plugin = null) {
//        
//        $officialRepos = json_decode($this->Plugin->getOfficialPlugins(), true);
//        foreach($officialRepos as $key => $value):
//            if($value["name"] == $plugin):
//                $x = $this->FileManager->installZipFromWeb(Inflector::humanize(substr($value["name"], strpos($value["name"], "-")+1)), "https://github.com/kalvinmoraes/".$value["name"]."/archive/master.zip", APP . "Plugin/");
//                if($x == true):
//                    $this->Session->setFlash(Inflector::humanize(substr($value["name"], strpos($value["name"], "-")+1)) . __d("system"," installed with success"));
//                else:
//                    $this->Session->setFlash(sprintf(__d("system","Cannot install ") . Inflector::humanize(substr($value["name"]), strpos($value["name"], "-")+1)) . " > " . $x);
//                endif;
//                $this->redirect(array("plugin"=>"system","controller"=>"plugins","action"=>"index"));
//            endif;
//        endforeach;
//        
//    }
    
//    public function search() {
//        $officialPlugins = array();
//        
//        $officialRepos = json_decode($this->Plugin->getOfficialPlugins(), true);
//        foreach($officialRepos as $key => $value):
//            if(strpos($value["name"], "mahoney-") !== false):
//                $officialPlugins[] = $value;
//            endif;
//        endforeach;
//        
//        $this->set('officialPlugins', $officialPlugins);
//    }

    public function index() {
        
        $pageTitle = __d("system","Plugins");
        $this->set(compact('pageTitle'));
        
    }

}
