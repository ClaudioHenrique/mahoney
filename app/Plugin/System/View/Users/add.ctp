<?php
$this->Html->addCrumb(__('Users'), array("plugin" => "system", "controller" => "users", "action" => "index"));
$this->Html->addCrumb(__('Add user'), array("plugin" => "system", "controller" => "users", "action" => "add"));
?>
<div class="globalTop">
    <div class="container">
        <div class="page-header">
            <h1><?= __("Add a new user"); ?></h1>
            <p><?= __("Add a new user and set their information here. Need more fields? What about the " . $this->Html->link(__('Profile Extension'), 'http://github.com/kalvinmoraes', array('target' => '_blank')) . " plugin?"); ?></p>
        </div>
    </div>
</div>
<?= $this->element("System.userForm"); ?>
