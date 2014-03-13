<?php

App::uses('Migrations', 'Vendor');

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
            $schemaRequest = $this->Schema->find("all", array(
                "conditions" => array(
                    "Schema.plugin" => $plugin
                )
                    )
            );
            return $schemaRequest;
        } catch (Exception $ex) {
            CakeLog::write('activity', "Warning, trying to retrieve '" . $plugin . "' schema from database.");

            $schemaRequest = [
                "Schema" => array(
                    "plugin" => $plugin,
                    "version" => "000"
                )
            ];
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
        $schemaV = $this->schema($plugin);
        $a = str_replace("{plugin}", $plugin, $this->MIGRATION_FOLDER);
        if (is_dir($a)):
            $b = scandir($a);
            $c = array_diff($b, array('.', '..'));
            $lastV = substr(end($c), 0, 3);
            return intval((isset($schemaV[0]["Schema"]["version"]) && !empty($schemaV[0]["Schema"]["version"]) ? $schemaV[0]["Schema"]["version"] : 0)) < intval($lastV);
        else:
            throw new Exception("Error");
        endif;
    }

    /**
     * Updates an plugin based on Migration files.
     * 
     * @param String The plugin to update
     * @return boolean The operation result
     * @throws Exception If operation fails
     */
    public function update($plugin) {
        $vList = array_diff(scandir(str_replace("{plugin}", $plugin, $this->MIGRATION_FOLDER)), array('.', '..'));
        $lastV = substr(end($vList), 0, 3);
        $schemaV = $this->schema($plugin);
        if (intval((isset($schemaV[0]["Schema"]["version"]) && !empty($schemaV[0]["Schema"]["version"]) ? $schemaV[0]["Schema"]["version"] : 0)) <= intval($lastV)):
            foreach ($vList as $key => $value):
                if (intval((isset($schemaV[0]["Schema"]["version"]) && !empty($schemaV[0]["Schema"]["version"]) ? $schemaV[0]["Schema"]["version"] : 0)) <= intval(substr($value, 0, 3))):
                    try {
                        $this->Migrations->load(str_replace("{plugin}", $plugin, $this->MIGRATION_FOLDER) . $value);
                        $this->Migrations->down();
                        $this->Migrations->up();
                    } catch (Exception $ex) {
                        throw new Exception($ex->getMessage());
                    }
                    $lastV = substr($value, 0, 3);
                endif;
            endforeach;

            try {
                $updateSchema = array(
                    "Schema" => array(
                        "id" => (isset($schemaV[0]["Schema"]["id"]) && !empty($schemaV[0]["Schema"]["id"])) ? $schemaV[0]["Schema"]["id"] : "",
                        "plugin" => $plugin,
                        "version" => $lastV
                    )
                );
                $this->Schema->save($updateSchema);

                return true;
            } catch (Exception $ex) {
                throw new Exception(__("There is an error trying to save schema for") . " '" . $plugin . "'. " . __("The error message was") . ": " . $ex->getMessage());
            }
        endif;
        return false;
    }

    /* gets url */

    public function getOfficialPlugins($url = 'https://api.github.com/users/kalvinmoraes/repos') {
        // create a new cURL resource
        $ch = curl_init();

        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        // grab URL and pass it to the browser
        $x = curl_exec($ch);

        // close cURL resource, and free up system resources
        curl_close($ch);
        
        return $x;
    }

    /**
     * Uninstall a plugin from database.
     * 
     * @param String The plugin to uninstall from database
     * @return boolean The operation result
     * @throws Exception If operation fails
     */
    public function uninstall($plugin) {

        $vList = array_reverse(array_diff(scandir(str_replace("{plugin}", $plugin, $this->MIGRATION_FOLDER)), array('.', '..')));
        $lastV = substr(end($vList), 0, 3);
        $schemaV = $this->schema($plugin);

        if (intval((isset($schemaV[0]["Schema"]["version"]) && !empty($schemaV[0]["Schema"]["version"]) ? $schemaV[0]["Schema"]["version"] : 0)) >= intval($lastV)):
            foreach ($vList as $key => $value):
                try {
                    if (intval((isset($schemaV[0]["Schema"]["version"]) && !empty($schemaV[0]["Schema"]["version"]) ? $schemaV[0]["Schema"]["version"] : 0)) >= intval(substr($value, 0, 3))):
                        $this->Migrations->load(str_replace("{plugin}", $plugin, $this->MIGRATION_FOLDER) . $value);
                        $this->Migrations->down();
                        $lastV = substr($value, 0, 3);
                    endif;
                } catch (Exception $ex) {
                    throw new Exception(__("There is an error trying to uninstall") . " '" . $plugin . "'. " . __("The error message was") . ": " . $ex->getMessage());
                }
            endforeach;

            try {

                if (isset($schemaV[0]["Schema"]["id"]) && !empty($schemaV[0]["Schema"]["id"])):
                    $this->Schema->delete($schemaV[0]["Schema"]["id"]);
                endif;

                return true;
            } catch (Exception $ex) {
                throw new Exception(__("There is an error trying to save schema for") . " '" . $plugin . "'. " . __("The error message was") . ": " . $ex->getMessage());
            }
        endif;

        return false;
    }

    /**
     * Return an array with informations about all App plugins.
     * 
     * This array can be accessed anywhere by `$mahoneyPlugin`
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
