<?php
$this->Html->addCrumb(__d("system","Users"), array("plugin" => "system", "controller" => "users", "action" => "index"));
$this->Html->addCrumb(sprintf(__d("system","Add %s"), __d("system","Users")), "");
?>
<div class="globalTop">
    <div class="container">
        <div class="page-header">
            <h1><?= sprintf(__d("system","Add a new user")); ?></h1>
            <p><?= sprintf(__d("system","Add a new user and set their information here. Need more fields? What about the")) . " " . $this->Html->link(sprintf(__d("system","Profile Extension")), 'http://github.com/kalvinmoraes', array('target' => '_blank')) . "?"; ?></p>
        </div>
    </div>
</div>
<?= $this->element("System.userForm"); ?>
