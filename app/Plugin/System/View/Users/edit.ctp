<?php
$this->Html->addCrumb(__d("system","Users"), array("plugin" => "system", "controller" => "users", "action" => "index"));
$this->Html->addCrumb(__d("system","Edit"), '');
$this->Html->addCrumb($this->request->data["User"]["username"], '');
?>
<div class="globalTop">
    <div class="container">
        <div class="page-header">
            <h1><?= __d("system","Edit user"); ?></h1>
            <p><?= $this->request->data["User"]["username"]; ?></p>
        </div>
    </div>
</div>
<?= $this->element("System.userForm"); ?>
