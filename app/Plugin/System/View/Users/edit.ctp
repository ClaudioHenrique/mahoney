<?php
$this->Html->addCrumb(__('Users'), array("plugin" => "system", "controller" => "users", "action" => "index"));
$this->Html->addCrumb(__('Edit'), '');
$this->Html->addCrumb($this->request->data["User"]["username"], '');
?>
<div class="globalTop">
    <div class="container">
        <div class="page-header">
            <h1><?= __("Edit user"); ?></h1>
            <p><?= $this->request->data["User"]["username"]; ?></p>
        </div>
    </div>
</div>
<?= $this->element("System.userForm"); ?>
