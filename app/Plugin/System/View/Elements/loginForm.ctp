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
<?php echo $this->Session->flash('auth'); ?>
<h2 class="form-signin-heading"><?php echo __('Please sign in'); ?></h2>
<?php echo $this->Form->input('username', array('class' => 'form-control', 'placeholder' => __('Username'), 'autofocus' => 'autofocus', 'required' => 'required')); ?>
<?php echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => __('Password'), 'required' => 'required')); ?>
<p class="text-muted text-center"><?= $this->Html->link(__("Lost your password?"), array("plugin" => "system", "controller" => "users", "action" => "recover")); ?> | <?= $this->Html->link(__("Need help?"), "/".__("contact")); ?></p>
<?php echo $this->Form->end(array('label' => __('Sign in'), 'class' => 'btn btn-lg btn-success btn-block')); ?>