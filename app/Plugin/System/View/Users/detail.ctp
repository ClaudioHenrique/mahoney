<?php
$this->Html->addCrumb(__('Users'), array("plugin" => "system", "controller" => "users", "action" => "index"));
$this->Html->addCrumb($user['User']['name'], '');
?>
<div class="container">
    <div class="page-header">
        <h1><?= __('User detail'); ?></h1>
        <h3><?= ($user['User']['name'] != null) ? $user['User']['name'] . " | " : ""; ?><?= $user['User']['username']; ?></h3>
    </div>
</div>