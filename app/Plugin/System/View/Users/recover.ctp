<?php

$this->Html->addCrumb(__d('system','Users'), array("plugin" => "system", "controller" => "users"));
$this->Html->addCrumb(__d('system','Password recover'), array("plugin" => "system", "controller" => "users", "action" => "recover"));
?>
<div class="container">
    <div class="page-header">
        <h1><?= __d('system','Password recovery'); ?></h1>
        <p><?= __d('system','Easily recover your password'); ?></p>
    </div>
    <?php if(isset($this->request->query["get"])): ?>
    <div class="container text-center">
        <?php
        $options = array(
            'class' => 'form-horizontal',
            'inputDefaults' => array(
                'label' => false,
                'div' => false,
                'error' => false
            )
        );
        echo $this->Form->create('Recover', $options);
        ?>
        <div class="form-group">
            <label for="inputToken" class="col-sm-2 col-sm-offset-2 control-label"><?= __d('system','Token'); ?></label>
            <div class="col-sm-4 text-center">
            <?= $this->Form->input('token', array('class' => 'text-center form-control', 'id' => 'inputToken', 'required' => true)); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword" class="col-sm-2 col-sm-offset-2 control-label"><?= __d('system','New Password'); ?></label>
            <div class="col-sm-4 text-center">
            <?= $this->Form->input('password', array('type' => 'password', 'class' => 'text-center form-control', 'id' => 'inputPassword', 'required' => true)); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
            <?= $this->Form->end(array('label' => __d('system','Recover'), 'class' => 'btn btn-info')); ?>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="container text-center">
        <h3><?= __d('system','Type your email below'); ?></h3>
        <?php
        $options = array(
            'class' => 'form-horizontal',
            'inputDefaults' => array(
                'label' => false,
                'div' => false,
                'error' => false
            )
        );
        echo $this->Form->create('Recover', $options);
        ?>
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-4 text-center">
            <?= $this->Form->input('email', array('type' => 'email', 'class' => 'text-center form-control', 'placeholder' => __d('system','your@email.com'), 'id' => 'inputEmail', 'required' => true)); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
            <?= $this->Form->end(array('label' => __d('system','Recover'), 'class' => 'btn btn-info')); ?>
            </div>
        </div>
        <p class="text-muted">
            <?= $this->Html->link(__d('system','Need help?'), '/system/docs#recover'); ?>
        </p>
    </div>
    <?php endif; ?>
</div>