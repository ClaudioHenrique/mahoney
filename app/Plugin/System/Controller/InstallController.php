<?php

App::uses('System.SystemAppController', 'Controller');
App::uses('ConnectionManager', 'Model');

class InstallController extends SystemAppController {

    public $uses = array();
    public $components = array('System.Security', 'System.FileManager', 'System.Plugin');
    public $EMAIL_PROVIDERS = array(
        array(
            "provider" => "gmail",
            "host" => "ssl://smtp.gmail.com",
            "port" => "465"
        )
    );

    public function beforeFilter() {
        $this->Auth->allow('index');
        parent::beforeFilter();
    }
    
    public function isAuthorized($user) {
        return parent::isAuthorized($user);
    }

    public function index($type = null) {
        
        $pageTitle = __d("system","Installation");
        $this->set('pageTitle', $pageTitle);
        
        if (file_exists(APP . 'Config' . DS . 'installed')):
            $this->redirect($this->Auth->logoutRedirect);
        else:
            if (AuthComponent::user()):
                $this->Auth->logout();
                $this->redirect("/install");
            endif;
            if ($type == 'db'):
                if ($this->Session->read('installData') == ""):
                    $this->redirect('/install');
                else:
                    $this->uses = array('System.Config', 'System.User');

                    if (!$this->Plugin->update("System")):
                        $this->Session->setFlash(sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Database")), AuthComponent::user()["username"], $_SERVER["REMOTE_ADDR"], __d("system", "to save"), sprintf(__d("system","data into the database")), $this->ModelName->invalidFields()));
                        $this->redirect("/install");
                    endif;

                    $requestData = $this->Session->read('installData');
                    $this->Session->delete('installData');

                    $this->Config->create();

                    $putConfig = array(
                        array(
                            "Config" => array(
                                "plugin" => "system",
                                "section" => "siteinfo",
                                "type" => "sitename",
                                "value" => $requestData["Config"]["sitename"]
                            )
                        ),
                        array(
                            "Config" => array(
                                "plugin" => "system",
                                "section" => "email",
                                "type" => "from",
                                "value" => $requestData["Config"]["email"]
                            )
                        ),
                        array(
                            "Config" => array(
                                "plugin" => "system",
                                "section" => "email",
                                "type" => "username",
                                "value" => $requestData["Config"]["email"]
                            )
                        ),
                        array(
                            "Config" => array(
                                "plugin" => "system",
                                "section" => "email",
                                "type" => "fromName",
                                "value" => $requestData["Config"]["sitename"]
                            )
                        )
                    );
                    
                    foreach($this->EMAIL_PROVIDERS as $key => $value):
                        if (strpos($requestData["Config"]["email"], $value["provider"]) !== false):
                            $emailMergeConfig = array(
                                array(
                                    "Config" => array(
                                        "plugin" => "system",
                                        "section" => "email",
                                        "type" => "host",
                                        "value" => $value["host"]
                                    )
                                ),
                                array(
                                    "Config" => array(
                                        "plugin" => "system",
                                        "section" => "email",
                                        "type" => "port",
                                        "value" => $value["port"]
                                    )
                                ),
                                array (
                                    "Config" => array(
                                        "plugin" => "system",
                                        "section" => "role",
                                        "type" => sprintf(__d("system","Manager")),
                                        "value" => "5"
                                    )
                                ),
                                array (
                                    "Config" => array(
                                        "plugin" => "system",
                                        "section" => "role",
                                        "type" => sprintf(__d("system","Admin")),
                                        "value" => "4"
                                    )
                                ),
                                array (
                                    "Config" => array(
                                        "plugin" => "system",
                                        "section" => "role",
                                        "type" => sprintf(__d("system","Employee")),
                                        "value" => "3"
                                    )
                                ),
                                array (
                                    "Config" => array(
                                        "plugin" => "system",
                                        "section" => "role",
                                        "type" => sprintf(__d("system","Client")),
                                        "value" => "2"
                                    )
                                ),
                                array (
                                    "Config" => array(
                                        "plugin" => "system",
                                        "section" => "role",
                                        "type" => sprintf(__d("system","User")),
                                        "value" => "1"
                                    )
                                )
                            );
                            $putConfig = array_merge($putConfig, $emailMergeConfig);
                        endif;
                    endforeach;
                    if (!$this->Config->saveMany($putConfig)):
                        $this->Session->setFlash(sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Database")), AuthComponent::user()["username"], $_SERVER["REMOTE_ADDR"], __d("system", "to save"), sprintf(__d("system","data into the database")), $this->Config->invalidFields()));
                        $this->redirect("/install");
                    endif;

                    $this->User->create();

                    $putUser = array(
                        "User" => array(
                            "email" => $requestData["Config"]["email"],
                            "name" => $requestData["Config"]["name"],
                            "username" => $requestData["Config"]["username"],
                            "password" => $requestData["Config"]["password"],
                            "role" => "5"
                        )
                    );
                    if (!$this->User->save($putUser)):
                        $this->Session->setFlash(sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Database")), AuthComponent::user()["username"], $_SERVER["REMOTE_ADDR"], __d("system", "to create"), sprintf(__d("system","the admin user")), $this->Config->invalidFields()));
                        $this->redirect("/install");
                    endif;

                    $this->Session->setFlash(sprintf(__d("system","Mahoney successfully installed! Login to continue.")));

                    $fp = fopen(APP . 'Config' . DS . 'installed', "wb");
                    fclose($fp);

                    $this->redirect($this->Auth->loginAction);
                endif;
            else:
                $this->Session->write('salt', $this->Security->genRandom(40));
                $this->Session->write('seed', $this->Security->genrandom(29, "0123456789"));

                $salt = $this->Session->read('salt');
                $seed = $this->Session->read('seed');
                $this->set(compact('salt', 'seed'));
                if ($this->request->is('post')):

                    $inputErrors = array();

                    foreach ($this->request->data["Config"] as $key => $value):
                        if ($key != "name" && $key != "databasepassword"):
                            if ($value == ""):
                                $inputErrors[$key] = __d("system","This field must not be empty.");
                            endif;
                            if (strlen($value) > 25 || strlen($value) < 4):
                                $inputErrors[$key] = sprintf(__d("system","The characters length for this field must be between %f and %t."), "4","25");
                            endif;
                            if ($key == "email"):
                                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                    $inputErrors[$key] = sprintf(__d("system","This field requires a valid %f."), __d("system","email address"));
                                }
                            endif;
                        endif;
                    endforeach;

                    if (empty($inputErrors)):

                        $formErrors = array();

                        try {
                            $dbh = new PDO('mysql:host=' . $this->request->data["Config"]["databasehost"] . ';dbname=' . $this->request->data["Config"]["databasename"], $this->request->data["Config"]["databaseuser"], $this->request->data["Config"]["databasepassword"]);
                        } catch (PDOException $ex) {
                            
                            array_push($formErrors, sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Database")), AuthComponent::user()["username"], $_SERVER["REMOTE_ADDR"], __d("system", "to connect"), sprintf(__d("system","to database")), $ex->getMessage()));
                        }

                        try {
                            $databaseTemplate = array(
                                '{host}' => $this->request->data["Config"]["databasehost"],
                                '{login}' => $this->request->data["Config"]["databaseuser"],
                                '{password}' => $this->request->data["Config"]["databasepassword"],
                                '{database}' => $this->request->data["Config"]["databasename"]
                            );
                            $this->FileManager->templateFile(APP . 'Config' . DS . 'Environment' . DS . 'default.php', $databaseTemplate, APP . 'Config' . DS . 'Environment' . DS . 'default.php');
                            $this->FileManager->templateFile(APP . 'Config' . DS . 'Environment' . DS . 'default.php', $databaseTemplate, APP . 'Config' . DS . 'Environment' . DS . $this->request->data["Config"]["hostname"] . '.php');
                        } catch (Exception $ex) {
                            array_push($formErrors, sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Component")), AuthComponent::user()["username"], $_SERVER["REMOTE_ADDR"], __d("system", "to template"), sprintf(__d("system","the database configuration files")), $ex->getMessage()));
                        }

                        try {
                            $coreTemplate = array(
                                '{security.salt}' => $this->Session->read('salt'),
                                '{cipher.seed}' => $this->Session->read('seed')
                            );
                            $this->FileManager->templateFile(APP . 'Config' . DS . 'core.php', $coreTemplate);
                        } catch (Exception $ex) {
                            array_push($formErrors, __d("system","Unable to create security tokens in core file."));
                        }

                        if (empty($formErrors)):
                            $this->Session->write('installData', $this->request->data);
                            return $this->redirect('/install/db');
                        else:
                            $this->request->data["Config"]["password"] = "";
                            $this->request->data["Config"]["databasepassword"] = "";
                            $this->set("formErrors", $formErrors);
                        endif;
                    else:
                        $this->set("inputErrors", $inputErrors);
                    endif;
                endif;
            endif;
        endif;
    }

}
