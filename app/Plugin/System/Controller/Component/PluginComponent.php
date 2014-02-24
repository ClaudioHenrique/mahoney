<?php

/**
 * The Plugin component has common tasks for plugin management
 */
class PluginComponent extends Component {

    private $PLUGIN_FOLDER;
    public $DENY_LIST = array('.', '..', 'System', 'DebugKit');
    public $PLUGINS;
    public $Schema;

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

        $this->Schema = ClassRegistry::init('System.Schema');
    }

    public function uninstall($plugin = null) {
        if (!is_dir(APP . 'plugin' . DS . $plugin)):
            throw new Exception(__("Selected plugin does not exist"));
        endif;

        $migrationFolder = APP . 'plugin' . DS . $plugin . DS . 'Config' . DS . 'Migrations' . DS;

        if (!is_dir($migrationFolder)):
            throw new Exception(__("Selected plugin does not have Migrations Folder"));
        endif;

        $schemaRequest = $this->Schema->find("all", array(
            "fields" => array("Schema.version"),
            "conditions" => array(
                "Schema.plugin" => $plugin
            )
                )
        );
        $vInstalled = $schemaRequest[0]["Schema"]["version"];

        $vList = array_reverse(array_diff(scandir($migrationFolder), array('.', '..')));

        $startUninstall = false;

        foreach ($vList as $key => $value):
            if (substr($value, 0, 3) == $vInstalled):
                $startUninstall = true;
                $migrations->load($migrationFolder . $value);
                $migrations->down();
            endif;
            if ($startUninstall == true):
                $migrations->load($migrationFolder . $value);
                $migrations->down();
                $lastV = substr($value, 0, 3);
            endif;
        endforeach;

        $saveSchema = array(
            "Schema" => array(
                "plugin" => $plugin,
                "version" => $lastV
            )
        );

        $this->Schema->save($saveSchema);
    }

    public function update($plugin = null) {

        if (!is_dir(APP . 'plugin' . DS . $plugin)):
            throw new Exception(__("Selected plugin does not exist"));
        endif;

        $migrationFolder = APP . 'plugin' . DS . $plugin . DS . 'Config' . DS . 'Migrations' . DS;
        $fixtureFolder = APP . 'plugin' . DS . $plugin . DS . 'Config' . DS . 'Fixtures' . DS;

        if (!is_dir($migrationFolder) && !is_dir($fixtureFolder)):
            throw new Exception(__("Selected plugin does not have Migrations Folder"));
        endif;

        try {
            $schemaRequest = $this->Schema->find("all", array(
                "fields" => array("Schema.version"),
                "conditions" => array(
                    "Schema.plugin" => $plugin
                )
                    )
            );
            if (!empty($schemaRequest)):
                $vInstalled = $schemaRequest[0]["Schema"]["version"];
            else:
                $vInstalled = '000';
            endif;
        } catch (Exception $ex) {
            $vInstalled = '000';
        }

        $vList = array_diff(scandir($migrationFolder), array('.', '..'));
        $lastV = substr(end($vList), 0, 3);

        if ($lastV > $vInstalled):

            $migrations = new Migrations();
            $fixtures = new Fixtures();

            foreach ($vList as $key => $value):
                if (substr($value, 0, 3) > $vInstalled):
                    $migrations->load($migrationFolder . $value);
                    $migrations->down();
                    $migrations->up();
                    $fixtures->import($fixtureFolder . $value);

                    $lastV = substr($value, 0, 3);
                endif;
            endforeach;

            $saveSchema = array(
                "Schema" => array(
                    "plugin" => $plugin,
                    "version" => $lastV
                )
            );

            $this->Schema->save($saveSchema);

            return true;
        else:
            return false;
        endif;
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
