<?php
$this->Html->addCrumb(__d("system","Users"), array("plugin" => "system", "controller" => "users", "action" => "index"));
$this->Html->addCrumb(__d("system","Manage Roles"), array("plugin" => "system", "controller" => "users", "action" => "roles"));
?>
<div class="container">
    <h1><?= __d("system","Manage Roles"); ?></h1>
</div>