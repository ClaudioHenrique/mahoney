<?php
$this->Html->addCrumb(__d('system','Users'), array("plugin" => "system", "controller" => "users"));
$this->Html->addCrumb(__d('system','Manage roles'), array("plugin" => "system", "controller" => "users", "action" => "roles"));
?>
<div class="container">
    <h1><?= __d('system','Manage roles'); ?></h1>
</div>