<?php

App::uses('Migrations', 'Vendor');
App::uses('Fixtures', 'Vendor');

/**
 * The Plugin component has common tasks for plugin management
 */
class PluginComponent extends Component {

    public $DENY_LIST;
    public $PLUGINS;
    public $PLUGIN_FOLDER;
    public $MIGRATION_FOLDER;
    public $FIXTURE_FOLDER;
    public $ACTIVE_PLUGIN_FILE;
    public $PACKAGE_FILE;
    public $ICON;
    public $ACTIVATED_PLUGINS;
    public $Migrations;
    public $Fixtures;
    public $Schema;

    function __construct() {
        $this->ACTIVATED_PLUGINS = 0;
        $this->DENY_LIST = array('.', '..', 'System', 'DebugKit');
        $this->PLUGIN_FOLDER = APP . 'plugin' . DS;
        $this->ICON = $this->PLUGIN_FOLDER . "{plugin}" . DS . "webroot/img/pluginIco.png";
        $this->PACKAGE_FILE = $this->PLUGIN_FOLDER . "{plugin}" . DS . "package.json";
        $this->ACTIVE_PLUGIN_FILE = $this->PLUGIN_FOLDER . "{plugin}" . DS . "active";
        $this->MIGRATION_FOLDER = $this->PLUGIN_FOLDER . "{plugin}" . DS . 'Config' . DS . 'Migrations' . DS;
        $this->FIXTURE_FOLDER = $this->PLUGIN_FOLDER . "{plugin}" . DS . 'Config' . DS . 'Fixtures' . DS;

        $actualPlugin = array(
            'name' => 'System',
            'data' => $this->generatePluginInfo('System'),
            'path' => $this->PLUGIN_FOLDER . 'System',
            'active' => (is_file($this->PLUGIN_FOLDER . 'System' . DS . 'active')) ? true : false,
            'menu' => $this->generatePluginMenu('System'),
            'icon' => $this->getPluginIconAsBase64('System')
        );

        $this->PLUGINS = array($actualPlugin);

        $this->Schema = ClassRegistry::init('System.Schema');
        $this->Migrations = new Migrations();
        $this->Fixtures = new Fixtures();
    }

    /**
     * Return the plugin icon as Base64
     * 
     * @param String The plugin to return the icon in b64
     */
    public function getPluginIconAsBase64($plugin) {
        if (file_exists(str_replace("{plugin}", $plugin, $this->ICON))):
            $imgBinary = file_get_contents(str_replace("{plugin}", $plugin, $this->ICON));
            return "data:image/png;base64," . base64_encode($imgBinary);
        else:
            return null;
        endif;
    }

    /**
     * Return an array with informations about the plugin schema in database.
     * 
     * @param String The plugin to return database schema
     * @return List Schema array with "PLUGIN" and "VERSION" information about
     * plugin in database.
     */
    public function schema($plugin) {
        try {
            $schemaRequest = $this->Schema->find("first", array(
                "conditions" => array(
                    "Schema.plugin" => $plugin
                )
                    )
            );
            if (empty($schemaRequest["Schema"]["version"]) || !isset($schemaRequest["Schema"]["version"])):
                $schemaRequest["Schema"]["version"] = 0;
            endif;
            return $schemaRequest;
        } catch (Exception $ex) {
            CakeLog::write('activity', "Warning, trying to retrieve '" . $plugin . "' schema from database.");

            $schemaRequest = array(
                "Schema" => array(
                    "id" => "",
                    "plugin" => $plugin,
                    "version" => "000"
                )
            );
            return $schemaRequest;
        }
    }

    /**
     * Check if a specific plugin is outdated
     * (Database Schema Version < Migration Folder Last Version YML).
     * 
     * @param String The plugin to verify
     * @return Boolean TRUE if plugin is outdated. FALSE if not.
     */
    public function isOutdated($plugin = null) {
        $pluginSchema = $this->schema($plugin);
        $a = str_replace("{plugin}", $plugin, $this->MIGRATION_FOLDER);
        if (is_dir($a)):
            $b = scandir($a);
            $c = array_diff($b, array('.', '..'));
            $lastV = substr(end($c), 0, 3);
            return intval($pluginSchema["Schema"]["version"]) < intval($lastV);
        else:
            throw new Exception("Error");
        endif;
    }

    /**
     * Removes the plugin schema tables based in Migrations YML files.
     * 
     * @param String The plugin to verify
     */
    public function remove($plugin = null) {
        
    }

    /**
     * Update/Create the plugin schema tables based in Migration YML files.
     * 
     * @param String The plugin to migrate
     */
    public function migrate($plugin = 'System', $reverse = false) {

        $lastMigrated = 0;
        $migrationList = array_diff(scandir(str_replace("{plugin}", $plugin, $this->MIGRATION_FOLDER)), array('.', '..'));

        if ($reverse):
            $migrationList = array_reverse($migrationList);
        endif;

        $lastMigration = substr(end($migrationList), 0, 3);
        $pluginSchema = $this->schema($plugin);
        
        if (!$reverse):
            if($this->isOutdated($plugin)):
                try {
                    if (intval($pluginSchema["Schema"]["version"]) <= intval($lastMigration)):
                        foreach ($migrationList as $mgrOrder => $mgrValue):
                            if (intval($pluginSchema["Schema"]["version"]) <= intval(substr($mgrValue, 0, 3))):

                                $this->Migrations->load(str_replace("{plugin}", $plugin, $this->MIGRATION_FOLDER) . $mgrValue);
                                $this->Migrations->down();
                                $this->Migrations->up();

                                $lastMigrated = substr($mgrValue, 0, 3);
                            endif;
                        endforeach;
                    endif;
                    $this->activate($plugin);
                } catch (Exception $ex) {
                    return $ex->getMessage();
                }
            else:
                return __("The plugin is already up to date.");
            endif;
        else:
            try {
                foreach ($migrationList as $mgrOrder => $mgrValue):
                    if (intval($pluginSchema["Schema"]["version"]) >= intval(substr($mgrValue, 0, 3))):

                        $this->Migrations->load(str_replace("{plugin}", $plugin, $this->MIGRATION_FOLDER) . $mgrValue);
                        $this->Migrations->down();

                        $lastMigrated = intval(substr($mgrValue, 0, 3)) - 1;
                    endif;
                endforeach;
                $this->deactivate($plugin);
            } catch (Exception $ex) {
                return $ex->getMessage();
            }
        endif;
        if ($this->Schema->save(
                array(
                    "id" => $pluginSchema["Schema"]["id"],
                    "plugin" => $plugin,
                    "version" => $lastMigrated
                )
            )
        ):
            return true;
        else:
            return __("There is an error saving the plugin schema.");
        endif;
    }
    
    public function activate($plugin){
        $fp = fopen(str_replace("{plugin}", $plugin, $this->ACTIVE_PLUGIN_FILE), "wb");
        fclose($fp);
    }
    
    public function deactivate($plugin){
        unlink(str_replace("{plugin}", $plugin, $this->ACTIVE_PLUGIN_FILE));
    }

    /**
     * Update/Create the plugin schema tables based in Fixture YML files.
     * 
     * @param String The plugin to fixture
     */
    public function fixture($plugin = 'System') {
        
    }

    /**
     * Return an array with informations about all App plugins.
     * 
     * This array can be accessed anywhere by `$mahoneyPlugins`
     */
    public function getPlugins() {
        if (file_exists(APP . 'Config' . DS . 'installed')):
            $pluginFolder = scandir($this->PLUGIN_FOLDER);
            foreach ($pluginFolder as $plugin):
                if (is_file(str_replace("{plugin}", $plugin, $this->ACTIVE_PLUGIN_FILE)) && $plugin != 'System'):
                    $this->ACTIVATED_PLUGINS++;
                endif;
                if (is_dir($this->PLUGIN_FOLDER . $plugin) && !in_array($plugin, $this->DENY_LIST)):
                    $actualPlugin = array(
                        'name' => $plugin,
                        'data' => $this->generatePluginInfo($plugin),
                        'path' => $this->PLUGIN_FOLDER . $plugin,
                        'outdated' => $this->isOutdated($plugin),
                        'active' => (is_file(str_replace("{plugin}", $plugin, $this->ACTIVE_PLUGIN_FILE))) ? true : false,
                        'menu' => $this->generatePluginMenu($plugin),
                        'icon' => $this->getPluginIconAsBase64($plugin)
                    );
                    array_push($this->PLUGINS, $actualPlugin);
                endif;
            endforeach;
        endif;

        // Set the number of activated plugins
        Configure::write("Plugin.count", $this->ACTIVATED_PLUGINS);

        return $this->PLUGINS;
    }

    /**
     * Generates an array based in menu.yml file from inside specified plugin
     * folder.
     * 
     * @param String The plugin to read the package.json
     * @return Array Used to generate the menus
     */
    public function generatePluginMenu($plugin = null) {
        if (is_file(str_replace("{plugin}", $plugin, $this->PACKAGE_FILE))):
            $array = json_decode(file_get_contents(str_replace("{plugin}", $plugin, $this->PACKAGE_FILE)), true);
            return $array["config"]["menu"];
        else:
            return 0;
        endif;
    }

    /**
     * Generates an array based in info.yml file from inside specified plugin
     * folder.
     * 
     * @param String The plugin to read the package.json
     * @return Array Used to fetch plugin information
     */
    public function generatePluginInfo($plugin) {
        if (is_file(str_replace("{plugin}", $plugin, $this->PACKAGE_FILE))):
            $tempArray = json_decode(file_get_contents(str_replace("{plugin}", $plugin, $this->PACKAGE_FILE)), true);
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
