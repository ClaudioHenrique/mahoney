<?php
/**
 * The Configurer component has common tasks for security
 */
class ConfigurerComponent extends Component {

    public $Config;
    
    var $components = array("Inflector");
    
    public $CONTROLLER;
    
    public function __construct(ComponentCollection $collection) {
        $this->CONTROLLER = $collection->getController();
    }
    
    /**
     * Load All data from system_config table and put into configure data
     * e.g.: Configure::write("{Section}.{type}", "{value}");
     * 
     * @throws Exception If operation fails
     */
    public function loadMahoneyConf() {
        $this->Config = ClassRegistry::init('System.Config');
         try {
            $configRequest = $this->Config->find("all");
            if(!empty($configRequest)):
                foreach($configRequest as $key => $value):
                    Configure::write(Inflector::humanize($value["Config"]["section"]) . "." . $value["Config"]["type"], $value["Config"]["value"]);
                endforeach;
            endif;
         } catch(Exception $ex) {
             throw new Exception(__("Unable to set config data from database. Check your database connection."));
         }
    }
    
    /**
     * You can specify a single JS for each specific page.
     * 
     * Put your javascript file in "/webroot/js/controller/{controller}{Action}.js
     */
    public function getJsController() {
        if($this->CONTROLLER->params['plugin'] == "" || empty($this->CONTROLLER->params['plugin']) || !isset($this->CONTROLLER->params['plugin'])):
            return "controller/" . Inflector::slug($this->CONTROLLER->params['controller']) . Inflector::camelize($this->CONTROLLER->params['action']);
        else:
            return Inflector::camelize(Inflector::humanize($this->CONTROLLER->params['plugin'])) . ".controller/" . Inflector::slug($this->CONTROLLER->params['controller']) . Inflector::camelize($this->CONTROLLER->params['action']);
        endif;
    }

}
