<?php
$options = array(
    'class' => 'form-signin',
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    ),
    'role' => 'form',
    'url' => '/system/users/login'
);
echo $this->Form->create('User', $options);
?>
<?= $this->Session->flash('auth'); ?>
<h2 class="form-signin-heading"><?= __d("system","Please sign in"); ?></h2>
<?= $this->Form->input('username', array('class' => 'form-control', 'placeholder' => __d("system","Username"), 'autofocus' => 'autofocus', 'required' => 'required')); ?>
<?= $this->Form->input('password', array('class' => 'form-control', 'placeholder' => __d("system","Password"), 'required' => 'required')); ?>
<p class="text-muted text-center"><?= $this->Html->link(sprintf(__d("system","Lost your password?")), array("plugin" => "system", "controller" => "users", "action" => "recover")); ?> | <?= $this->Html->link(sprintf(__d("system","Need help?")), "/contact"); ?></p>
<?= $this->Form->end(array('label' => __d("system","Sign in"), 'class' => 'btn btn-lg btn-success btn-block')); ?>