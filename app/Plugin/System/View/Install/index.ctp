<?php
$this->Html->addCrumb(__('Config'), '/system/config');
$this->Html->addCrumb(__('Install'), '/system/config/install');
?>
<div class="container">
    <div class="page-header text-center">
        <h1><?php echo __('Welcome to Mahoney'); ?></h1>
        <h6>version <strong><?php echo $mahoneyPlugins[0]['data']['version']; ?></strong></h6>
    </div>
    <?php
    $options = array(
        'class' => 'form-horizontal',
        'inputDefaults' => array(
            'label' => false,
            'div' => false,
            'error' => false
        )
    );
    echo $this->Form->create('Config', $options);
    ?>
    <div class="page-header text-left"><h4>Admin account</h4></div>
    <div class="form-group <?php echo (isset($inputErrors) && (array_key_exists("username", $inputErrors) || array_key_exists("password", $inputErrors))) ? 'has-error has-feedback' : ''; ?>">
        <label for="inputUsername" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?php echo __('The admin login'); ?>"><?php echo __('Username'); ?></label>
        <div class="col-sm-3">
            <?php echo $this->Form->input('username', array('class' => 'form-control', 'placeholder' => 'admin', 'id' => 'inputUsername', 'required' => true, 'value' => 'admin')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("username", $inputErrors)):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
        <label for="inputPassword" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?php echo __('The admin password'); ?>"><?php echo __('Password'); ?></label>
        <div class="col-sm-3">
            <?php echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => __('Password'), 'id' => 'inputPassword', 'required' => true)); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("password", $inputErrors)):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
    </div>
    <div class="form-group <?php echo (isset($inputErrors) && (array_key_exists("name", $inputErrors) || array_key_exists("email", $inputErrors))) ? 'has-error has-feedback' : ''; ?>">
        <label for="inputName" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?php echo __('Your name'); ?>"><?php echo __('Name'); ?></label>
        <div class="col-sm-3">
            <?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Cuzco, The Emperor', 'id' => 'inputName', 'required' => false)); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("name", $inputErrors)):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
        <label for="inputEmail" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?php echo __('Your email, for password recover and stuff'); ?>"><?php echo __('Email'); ?></label>
        <div class="col-sm-3">
            <?php echo $this->Form->input('email', array('class' => 'form-control', 'placeholder' => __('Email'), 'id' => 'inputEmail', 'required' => true)); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("email", $inputErrors)):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
    </div>
    <div class="page-header text-left"><h4>Core Configuration</h4></div>
    <div class="form-group <?php echo (isset($inputErrors) && array_key_exists("hostname", $inputErrors)) ? 'has-error has-feedback' : ''; ?>">
        <label for="inputHostname" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?php echo __('Your computer name. For environment based configuration.'); ?>"><?php echo __('Hostname'); ?></label>
        <div class="col-sm-8">
            <?php echo $this->Form->input('hostname', array('class' => 'form-control', 'placeholder' => __('Hostname'), 'id' => 'inputHostname', 'required' => true, 'value' => php_uname('n'))); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("hostname", $inputErrors)):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
    </div>
    <div class="form-group <?php echo (isset($inputErrors) && array_key_exists("databasehost", $inputErrors)) ? 'has-error has-feedback' : ''; ?>">
        <label for="inputDatabasehost" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?php echo __('Database host. Usually: localhost'); ?>"><?php echo __('DB Host'); ?></label>
        <div class="col-sm-8">
            <?php echo $this->Form->input('databasehost', array('class' => 'form-control', 'placeholder' => __('localhost'), 'id' => 'inputDatabasehost', 'required' => true, 'value' => 'localhost')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("databasehost", $inputErrors)):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
    </div>
    <div class="form-group <?php echo (isset($inputErrors) && array_key_exists("databasename", $inputErrors)) ? 'has-error has-feedback' : ''; ?>">
        <label for="inputDatabaseName" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?php echo __('Database name. Usually: Mahoney'); ?>"><?php echo __('DB Name'); ?></label>
        <div class="col-sm-8">
            <?php echo $this->Form->input('databasename', array('class' => 'form-control', 'placeholder' => __('mahoney'), 'id' => 'inputDatabaseName', 'required' => true, 'value' => 'mahoney')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("databasename", $inputErrors)):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
    </div>
    <div class="form-group <?php echo (isset($inputErrors) && (array_key_exists("databaseuser", $inputErrors) || array_key_exists("databasepassword", $inputErrors))) ? 'has-error has-feedback' : ''; ?>">
        <label for="inputDatabaseUser" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?php echo __('The username of database'); ?>"><?php echo __('DB Username'); ?></label>
        <div class="col-sm-3">
            <?php echo $this->Form->input('databaseuser', array('class' => 'form-control', 'placeholder' => 'root', 'id' => 'inputDatabaseUser', 'required' => false, 'value' => 'root')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("databaseuser", $inputErrors)):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
        <label for="inputDatabasePassword" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?php echo __('The password of database'); ?>"><?php echo __('DB Password'); ?></label>
        <div class="col-sm-3">
            <?php echo $this->Form->input('databasepassword', array('type' => 'password', 'class' => 'form-control', 'id' => 'inputDatabasePassword')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("databasepassword", $inputErrors)):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
    </div>
    <div class="form-group <?php echo (isset($inputErrors) && array_key_exists("sitename", $inputErrors)) ? 'has-error has-feedback' : ''; ?>">
        <label for="inputSitename" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?php echo __('Your application name'); ?>"><?php echo __('Application Name'); ?></label>
        <div class="col-sm-8">
            <?php echo $this->Form->input('sitename', array('class' => 'form-control', 'placeholder' => "Mahoney", 'id' => 'inputSitename', 'required' => true, "value" => "Mahoney")); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("sitename", $inputErrors)):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
    </div>
    <div class="page-header"></div>
    <div class="form-group">
        <label for="securityMessage" class="col-sm-2 control-label"></label>
        <div class="col-sm-10">
            <blockquote class="text-left">
                <p><?php echo __('These generated tokens will ensure the safety of your application. Save in a safe place.'); ?></p>
                <footer><strong>Security Salt</strong>: <?php echo $salt; ?></footer>
                <footer><strong>Cipher Seed</strong>: <?php echo $seed; ?></footer>
            </blockquote>  
        </div>
    </div>
    <div class="form-signin">
        <?php echo $this->Form->end(array('label' => __('Get Started'), 'class' => 'btn btn-lg btn-success btn-block')); ?>
        <p class="text-muted text-center"><?php echo __('This software is maintened under'); ?> <br/> <a href="http://www.mozilla.org/MPL/2.0/" target="_blank"><?php echo __("Mozilla Public License 2.0"); ?></a></p>
        <p class="text-muted text-center"><a href="/system/docs" target="_blank"><?php echo __("Documentation"); ?></a> | <a href="http://github.com/kalvinmoraes/Mahoney" target="_blank"><?php echo __("Github"); ?></a></p>
    </div>
</div>