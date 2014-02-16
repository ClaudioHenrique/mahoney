<?php
$this->Html->addCrumb(__('Users'), '/system/users');
$this->Html->addCrumb(__('User detail'), '/system/users/detail');
?>
<div class="container">
    <div class="page-header">
        <h1><?php echo __('User detail'); ?></h1>
        <h3><?php echo ($user['User']['name'] != null) ? $user['User']['name'] . " | " : ""; ?><?php echo $user['User']['username']; ?></h3>
    </div>
</div>