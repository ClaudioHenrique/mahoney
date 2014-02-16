<?php
/**
 * The Plugin component has common tasks for plugin management
 */
class PluginComponent extends Component {

    private $PLUGIN_FOLDER;
    public $DENY_LIST = array('.', '..', 'System', 'DebugKit');
    public $PLUGINS;

    function __construct() {
        $this->PLUGIN_FOLDER = APP . 'plugin' . DS;

        $actualPlugin = array(
            'name' => 'System',
            'data' => $this->generatePluginInfo('System'),
            'path' => $this->PLUGIN_FOLDER . 'System',
            'active' => (is_file($this->PLUGIN_FOLDER . 'System' . DS . 'active')) ? true : false,
            'menu' => $this->generatePluginMenu('System')
        );

        $this->PLUGINS = array($actualPlugin);
    }
    
    /**
     * Return an array with informations about all App plugins.
     * 
     * This array can be accessed anywhere by $mahoneyPlugin
     */
    public function getPlugins() {
        $pluginFolder = scandir($this->PLUGIN_FOLDER);
        foreach ($pluginFolder as $plugin):
            if (is_dir($this->PLUGIN_FOLDER . $plugin) && !in_array($plugin, $this->DENY_LIST)):
                $actualPlugin = array(
                    'name' => $plugin,
                    'data' => $this->generatePluginInfo($plugin),
                    'path' => $this->PLUGIN_FOLDER . $plugin,
                    'active' => (is_file($this->PLUGIN_FOLDER . $plugin . DS . 'active')) ? true : false,
                    'menu' => $this->generatePluginMenu($plugin)
                );
                array_push($this->PLUGINS, $actualPlugin);
            endif;
        endforeach;
    }

    /**
     * Generates an array based in menu.yml file from inside specified plugin
     * folder.
     * 
     * @param string The plugin to read the menu.yml
     * @return array Used to generate the menus. 
     */
    public function generatePluginMenu($plugin) {
        if (is_file($this->PLUGIN_FOLDER . $plugin . DS . 'package.json')):
            $array = json_decode(file_get_contents($this->PLUGIN_FOLDER . $plugin . DS . 'package.json'), true);
            return $array["config"]["menu"];
        else:
            return 0;
        endif;
    }

    /**
     * Generates an array based in info.yml file from inside specified plugin
     * folder.
     * 
     * @param string The plugin to read the info.yml
     * @return array Used to fetch plugin information
     */
    public function generatePluginInfo($plugin) {
        if (is_file($this->PLUGIN_FOLDER . $plugin . DS . 'package.json')):
            $tempArray = json_decode(file_get_contents($this->PLUGIN_FOLDER . $plugin . DS . 'package.json'), true);
            $array = array(
                "name" => $tempArray["name"],
                "type" => $tempArray["type"],
                "version" => $tempArray["version"],
                "author" => $tempArray["author"],
                "description" => $tempArray["description"],
                "repository" => array(
                    "type" => $tempArray["repository"]["type"],
                    "url" => $tempArray["repository"]["url"]
                ),
                "homepage" => $tempArray["homepage"]
            );
            return $array;
        else:
            return 0;
        endif;
    }

}
