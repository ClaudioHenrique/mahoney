<?php
$this->Html->addCrumb(__d('system','Users'), array("plugin" => "system", "controller" => "users", "action" => "index"));
$this->Html->addCrumb(__d('system','Add user'), array("plugin" => "system", "controller" => "users", "action" => "add"));
?>
<div class="globalTop">
    <div class="container">
        <div class="page-header">
            <h1><?= __d("system","Add a new user"); ?></h1>
            <p><?= __d("system","Add a new user and set their information here. Need more fields? What about the") . " " . $this->Html->link(__d('system','Profile Extension'), 'http://github.com/kalvinmoraes', array('target' => '_blank')) . "?"; ?></p>
        </div>
    </div>
</div>
<?= $this->element("System.userForm"); ?>
