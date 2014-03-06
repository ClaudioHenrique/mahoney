<?php
$this->Html->addCrumb(__('Users'), array("plugin" => "system", "controller" => "users"));
$this->Html->addCrumb($user['User']['name'], array("plugin" => "system", "controller" => "users", "action" => "detail", $user['User']['id']));
?>
<div class="container">
    <div class="page-header">
        <h1><?php echo __('User detail'); ?></h1>
        <h3><?php echo ($user['User']['name'] != null) ? $user['User']['name'] . " | " : ""; ?><?php echo $user['User']['username']; ?></h3>
    </div>
</div>