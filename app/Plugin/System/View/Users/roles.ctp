<?php
$this->Html->addCrumb(__('Users'), array("plugin" => "system", "controller" => "users"));
$this->Html->addCrumb(__('Manage roles'), array("plugin" => "system", "controller" => "users", "action" => "roles"));
?>
<div class="container">
    <h1><?= __('Manage roles'); ?></h1>
</div>