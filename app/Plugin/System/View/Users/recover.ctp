<?php

$this->Html->addCrumb(__('Users'), '/system/users');
$this->Html->addCrumb(__('Password recover'), '/system/users/recover');
?>
<div class="container">
    <div class="page-header">
        <h1><?php echo __('Password recovery'); ?></h1>
        <p><?php echo __('Easily recover your password'); ?></p>
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
            <label for="inputToken" class="col-sm-2 col-sm-offset-2 control-label"><?php echo __('Token'); ?></label>
            <div class="col-sm-4 text-center">
            <?php echo $this->Form->input('token', array('class' => 'text-center form-control', 'id' => 'inputToken', 'required' => true)); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword" class="col-sm-2 col-sm-offset-2 control-label"><?php echo __('New Password'); ?></label>
            <div class="col-sm-4 text-center">
            <?php echo $this->Form->input('password', array('type' => 'password', 'class' => 'text-center form-control', 'id' => 'inputPassword', 'required' => true)); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
            <?php echo $this->Form->end(array('label' => __('Recover'), 'class' => 'btn btn-info')); ?>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="container text-center">
        <h3><?php echo __('Type your email below'); ?></h3>
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
            <?php echo $this->Form->input('email', array('type' => 'email', 'class' => 'text-center form-control', 'placeholder' => __('your@email.com'), 'id' => 'inputEmail', 'required' => true)); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
            <?php echo $this->Form->end(array('label' => __('Recover'), 'class' => 'btn btn-info')); ?>
            </div>
        </div>
        <p class="text-muted">
            <?php echo $this->Html->link(__('Need help?'), '/system/docs#recover'); ?>
        </p>
    </div>
    <?php endif; ?>
</div>