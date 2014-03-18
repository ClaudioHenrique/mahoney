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
    <div class="form-group <?= $this->Form->isFieldError('User.role') ? 'has-error has-feedback' : ''; ?>">
        <label for="inputRole" class="col-sm-2 control-label"><?= __d('system','Role'); ?></label>
        <div class="col-sm-3">
            <?php
            foreach (Configure::read("Role") as $key => $value):
                if (AuthComponent::user()['role'] < $value):
                    Configure::delete("Role.".$key);
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
        <div class='col-sm-9'><small><?= $this->Form->error('User.role', null, array('wrap' => 'label', 'class' => 'error')); ?></small></div>
    </div>
    <div class="form-group <?= $this->Form->isFieldError('User.name') ? 'has-error has-feedback' : ''; ?>">
        <label for="inputName" class="col-sm-2 control-label"><?= __d('system','Name'); ?></label>
        <div class="col-sm-8">
            <?= $this->Form->input('name', array('class' => 'form-control', 'placeholder' => __d('system','Name'), 'id' => 'inputName', 'required' => false)); ?>
            <?php
            if ($this->Form->isFieldError('User.name')):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
        <div class='col-sm-2'><small><?= $this->Form->error('User.name', null, array('wrap' => 'label', 'class' => 'error')); ?></small></div>
    </div>
    <div class="form-group <?= $this->Form->isFieldError('User.email') ? 'has-error has-feedback' : ''; ?>">
        <label for="inputEmail" class="col-sm-2 control-label"><?= __d('system','Email'); ?></label>
        <div class="col-sm-8">
            <?= $this->Form->input('email', array('class' => 'form-control', 'placeholder' => __d('system','Email'), 'id' => 'inputEmail', 'required' => false)); ?>
            <?php
            if ($this->Form->isFieldError('User.email')):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
        <div class='col-sm-2'><small><?= $this->Form->error('User.email', null, array('wrap' => 'label', 'class' => 'error')); ?></small></div>
    </div>
    <div class="form-group <?= $this->Form->isFieldError('User.username') ? 'has-error has-feedback' : ''; ?>">
        <label for="inputUser" class="col-sm-2 control-label"><?= __d('system','Username'); ?></label>
        <div class="col-sm-8">
            <?= $this->Form->input('username', array('class' => 'form-control', 'placeholder' => __d('system','Username'), 'id' => 'inputUser')); ?>
            <?php
            if ($this->Form->isFieldError('User.username')):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
        <div class='col-sm-2'><small><?= $this->Form->error('User.username', null, array('wrap' => 'label', 'class' => 'error')); ?></small></div>
    </div>
    <div class="form-group <?= $this->Form->isFieldError('User.password') ? 'has-error has-feedback' : ''; ?>">
        <label for="inputPassword" class="col-sm-2 control-label"><?= __d('system','Password'); ?></label>
        <div class="col-sm-8">
            <?= $this->Form->input('password', array('class' => 'form-control', 'placeholder' => __d('system','Password'), 'id' => 'inputPassword')); ?>
            <?php
            if ($this->Form->isFieldError('User.password')):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
        <div class='col-sm-2'><small><?= $this->Form->error('User.password', null, array('wrap' => 'label', 'class' => 'error')); ?></small></div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= $this->Form->end(array('label' => __d('system','Save'), 'class' => 'btn btn-default')); ?>
        </div>
    </div>
</div>