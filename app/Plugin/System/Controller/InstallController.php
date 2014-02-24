<?php

App::uses('System.SystemAppController', 'Controller');
App::uses('ConnectionManager', 'Model');

App::uses('Migrations', 'Vendor');
App::uses('Fixtures', 'Vendor');

class InstallController extends SystemAppController {

    public $uses = array();
    public $components = array('System.Security', 'System.FileManager', 'System.Plugin');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }

    public function index($type = null) {
        if (file_exists(APP . 'Config' . DS . 'installed')):
            $this->redirect($this->Auth->logoutRedirect);
        else:
            if ($this->Auth->user()):
                $this->Auth->logout();
                $this->redirect("/install");
            endif;
            if ($type == 'db'):
                if ($this->Session->read('installData') == ""):
                    $this->redirect('/install');
                else:
                    $this->uses = array('System.Config', 'System.User');
                
                    if(!$this->Plugin->update("System")):
                        $this->Session->setFlash(__("Unable to install database. Try again."));
                        $this->redirect("/install");
                    endif;

                    $requestData = $this->Session->read('installData');
                    $this->Session->delete('installData');

                    $this->Config->create();
                    $putConfig = array(
                        "Config" => array(
                            "global" => "config",
                            "section" => "siteinfo",
                            "type" => "sitename",
                            "value" => $requestData["Config"]["sitename"]
                        )
                    );
                    if (!$this->Config->save($putConfig)):
                        $this->Session->setFlash(__("Unable to set config properties to database. Try again."));
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
                        $this->Session->setFlash(__("Unable to create admin user. Try again."));
                        $this->redirect("/install");
                    endif;

                    $this->Session->setFlash(__("Mahoney successfully installed. Login to continue."));

                    $fp = fopen(APP . 'Config' . DS . 'installed', "wb");
                    fclose($fp);

                    $this->redirect($this->Auth->loginAction);
                endif;
            else:
                $this->Session->write('salt', $this->Security->genRandom(40));
                $this->Session->write('seed', $this->Security->genrandom(29, "0123456789"));

                $siteName = "Mahoney";
                
                $pageTitle = __('Installation');
                
                $salt = $this->Session->read('salt');
                $seed = $this->Session->read('seed');
                $this->set(compact('siteName', 'pageTitle', 'salt', 'seed'));
                if ($this->request->is('post')):

                    $inputErrors = array();

                    foreach ($this->request->data["Config"] as $key => $value):
                        if ($key != "name" && $key != "databasepassword"):
                            if ($value == ""):
                                $inputErrors[$key] = __("This field must not be empty.");
                            endif;
                            if(strlen($value) > 25 || strlen($value) < 4):
                                $inputErrors[$key] = __("The characters length for this field must be between 4 and 25.");
                            endif;
                            if($key == "email"):
                                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                    $inputErrors[$key] = __("Put a valid email address.");
                                }
                            endif;
                        endif;
                    endforeach;

                    if (empty($inputErrors)):

                        $formErrors = array();

                        try {
                            $dbh = new PDO('mysql:host=' . $this->request->data["Config"]["databasehost"] . ';dbname=' . $this->request->data["Config"]["databasename"], $this->request->data["Config"]["databaseuser"], $this->request->data["Config"]["databasepassword"]);
                        } catch (PDOException $ex) {
                            array_push($formErrors, __("Unable to connect to database."));
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
                            $this->FileManager->templateFile(APP . 'Config' . DS . 'database.php', $databaseTemplate);
                        } catch (Exception $ex) {
                            array_push($formErrors, __("Unable to create database config files."));
                        }

                        try {
                            $coreTemplate = array(
                                '{security.salt}' => $this->Session->read('salt'),
                                '{cipher.seed}' => $this->Session->read('seed')
                            );
                            $this->FileManager->templateFile(APP . 'Config' . DS . 'core.php', $coreTemplate);
                        } catch (Exception $ex) {
                            array_push($formErrors, __("Unable to create security tokens in core file."));
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
