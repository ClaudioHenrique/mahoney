<?php
/**
 * The Configurer component has common tasks for security
 */
class ConfigurerComponent extends Component {

    public $Config;
    
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

}
