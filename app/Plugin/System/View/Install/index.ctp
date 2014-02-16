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
    <div class="form-group">
        <label for="inputUsername" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?php echo __('The admin login'); ?>"><?php echo __('Username'); ?></label>
        <div class="col-sm-3">
            <?php echo $this->Form->input('username', array('class' => 'form-control', 'placeholder' => 'admin', 'id' => 'inputAdmin', 'required' => true, 'value' => 'admin')); ?>
        </div>
        <label for="inputPassword" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?php echo __('The admin password'); ?>"><?php echo __('Password'); ?></label>
        <div class="col-sm-3">
            <?php echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => __('Password'), 'id' => 'inputPassword', 'required' => true)); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="inputName" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?php echo __('Your name'); ?>"><?php echo __('Name'); ?></label>
        <div class="col-sm-3">
            <?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Cuzco, The Emperor', 'id' => 'inputAdmin', 'required' => false)); ?>
        </div>
        <label for="inputEmail" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?php echo __('Your email, for password recover and stuff'); ?>"><?php echo __('Email'); ?></label>
        <div class="col-sm-3">
            <?php echo $this->Form->input('email', array('class' => 'form-control', 'placeholder' => __('Email'), 'id' => 'inputEmail', 'required' => true)); ?>
        </div>
    </div>
    <div class="page-header text-left"><h4>Core Configuration</h4></div>
    <div class="form-group">
        <label for="inputHostname" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?php echo __('Your computer name. For environment based configuration.'); ?>"><?php echo __('Hostname'); ?></label>
        <div class="col-sm-8">
            <?php echo $this->Form->input('hostname', array('class' => 'form-control', 'placeholder' => __('Hostname'), 'id' => 'inputHostname', 'required' => true, 'value' => php_uname('n'))); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="inputDatabase" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?php echo __('Database name. Usually: Mahoney'); ?>"><?php echo __('Database'); ?></label>
        <div class="col-sm-8">
            <?php echo $this->Form->input('database', array('class' => 'form-control', 'placeholder' => __('Database'), 'id' => 'inputDatabase', 'required' => true, 'value' => 'mahoney')); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="inputSitename" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?php echo __('The root website where Mahoney will be installed'); ?>"><?php echo __('Website'); ?></label>
        <div class="col-sm-8">
            <?php echo $this->Form->input('sitename', array('class' => 'form-control', 'placeholder' => "http://" . $_SERVER['HTTP_HOST'], 'id' => 'inputSitename', 'required' => true, "value" => "http://" . $_SERVER['HTTP_HOST'])); ?>
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