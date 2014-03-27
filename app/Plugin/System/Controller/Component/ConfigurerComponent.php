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
            if (!empty($configRequest)):
                foreach ($configRequest as $key => $value):
                    Configure::write(Inflector::humanize($value["Config"]["plugin"]) . Inflector::humanize($value["Config"]["section"]) . "." . $value["Config"]["type"], $value["Config"]["value"]);
                endforeach;
            endif;
        } catch (Exception $ex) {
            //CakeLog::write("activity", __d("system", "[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s", __d("system", "Config"), AuthComponent::user()["username"], __d("system", "to apply"), __d("configuration variable"), __d("system", "to the environment"), $ex->getMessage()));
            throw new Exception(sprintf(__d("system", "Error trying %s the '%s' %s. Details: %e."), __d("system", "Config"), __d("system", "to apply"), __d("configuration variable"), __d("system", "to the environment")));
        }
    }

    public function getAvailableLanguages() {
        $localeDir = array_diff(scandir(APP . "Locale"), array(".", ".."));
        $locales = array();
        foreach ($localeDir as $key => $value):
            if (is_dir(APP . "Locale" . DS . $value)):
                if (is_file(APP . "Locale" . DS . $value . DS . "lang.json")):
                    $lang = json_decode(file_get_contents(APP . "Locale" . DS . $value . DS . "lang.json"));
                    $locales[] = array(
                        "Language" => $lang["language"],
                        "Abbreviation" => $lang["abbreviation"]
                    );
                endif;
            endif;
        endforeach;
        return $locales;
    }

    /**
     * You can specify a single JS for each specific page. (Plugin or not)
     * 
     * Put your javascript file in "/webroot/js/controller/{controller}{Action}.js
     */
    public function getJsController() {
        if ($this->CONTROLLER->params['plugin'] == "" || empty($this->CONTROLLER->params['plugin']) || !isset($this->CONTROLLER->params['plugin'])):
            return "controller/" . Inflector::slug($this->CONTROLLER->params['controller']) . Inflector::camelize($this->CONTROLLER->params['action']);
        else:
            return Inflector::camelize(Inflector::humanize($this->CONTROLLER->params['plugin'])) . ".controller/" . Inflector::slug($this->CONTROLLER->params['controller']) . Inflector::camelize($this->CONTROLLER->params['action']);
        endif;
    }

}
