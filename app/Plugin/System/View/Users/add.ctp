<?php
$this->Html->addCrumb(__('Users'), '/system/users');
$this->Html->addCrumb(__('Add user'), '/system/users/add');
?>
<div class="globalTop">
    <div class="container">
        <div class="page-header">
            <h1><?php echo __("Add a new user"); ?></h1>
            <p><?php echo __("Add a new user and set their information here. Need more fields? What about the " . $this->Html->link(__('Profile Extension'), 'http://github.com/kalvinmoraes', array('target' => '_blank')) . " plugin?"); ?></p>
        </div>
    </div>
</div>
<div class="container">
    <?php
    $options = array(
        'class' => 'form-horizontal',
        'inputDefaults' => array(
            'label' => false,
            'div' => false,
            'error' => false
        )
    );
    echo $this->Form->create('User', $options);
    ?>
    <div class="form-group <?php echo $this->Form->isFieldError('User.role') ? 'has-error has-feedback' : ''; ?>">
        <label for="inputRole" class="col-sm-2 control-label"><?php echo __('Role'); ?></label>
        <div class="col-sm-3">
            <?php
            foreach (array_flip(Configure::read("Role")) as $key => $value):
                if (AuthComponent::user()['role'] < $key):
                    Configure::delete("Role.".$value);
                endif;
            endforeach;
            echo $this->Form->input('role', array(
                'options' => array_flip(Configure::read("Role")),
                'class' => 'form-control',
                'id' => 'inputRole'
            ));
            ?>
            <?php
            if ($this->Form->isFieldError('User.role')):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
        <div class='col-sm-9'><small><?php echo $this->Form->error('User.role', null, array('wrap' => 'label', 'class' => 'error')); ?></small></div>
    </div>
    <div class="form-group <?php echo $this->Form->isFieldError('User.name') ? 'has-error has-feedback' : ''; ?>">
        <label for="inputName" class="col-sm-2 control-label"><?php echo __('Name'); ?></label>
        <div class="col-sm-8">
            <?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => __('Name'), 'id' => 'inputName', 'required' => false)); ?>
            <?php
            if ($this->Form->isFieldError('User.name')):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
        <div class='col-sm-2'><small><?php echo $this->Form->error('User.name', null, array('wrap' => 'label', 'class' => 'error')); ?></small></div>
    </div>
    <div class="form-group <?php echo $this->Form->isFieldError('User.email') ? 'has-error has-feedback' : ''; ?>">
        <label for="inputEmail" class="col-sm-2 control-label"><?php echo __('Email'); ?></label>
        <div class="col-sm-8">
            <?php echo $this->Form->input('email', array('class' => 'form-control', 'placeholder' => __('Email'), 'id' => 'inputEmail', 'required' => false)); ?>
            <?php
            if ($this->Form->isFieldError('User.email')):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
        <div class='col-sm-2'><small><?php echo $this->Form->error('User.email', null, array('wrap' => 'label', 'class' => 'error')); ?></small></div>
    </div>
    <div class="form-group <?php echo $this->Form->isFieldError('User.username') ? 'has-error has-feedback' : ''; ?>">
        <label for="inputUser" class="col-sm-2 control-label"><?php echo __('Username'); ?></label>
        <div class="col-sm-8">
            <?php echo $this->Form->input('username', array('class' => 'form-control', 'placeholder' => __('Username'), 'id' => 'inputUser')); ?>
            <?php
            if ($this->Form->isFieldError('User.username')):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
        <div class='col-sm-2'><small><?php echo $this->Form->error('User.username', null, array('wrap' => 'label', 'class' => 'error')); ?></small></div>
    </div>
    <div class="form-group <?php echo $this->Form->isFieldError('User.password') ? 'has-error has-feedback' : ''; ?>">
        <label for="inputPassword" class="col-sm-2 control-label"><?php echo __('Password'); ?></label>
        <div class="col-sm-8">
            <?php echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => __('Password'), 'id' => 'inputPassword')); ?>
            <?php
            if ($this->Form->isFieldError('User.password')):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
        <div class='col-sm-2'><small><?php echo $this->Form->error('User.password', null, array('wrap' => 'label', 'class' => 'error')); ?></small></div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo $this->Form->end(array('label' => __('Add user'), 'class' => 'btn btn-default')); ?>
        </div>
    </div>
</div>
