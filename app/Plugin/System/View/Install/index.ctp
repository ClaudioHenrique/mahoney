<?php
$this->Html->addCrumb(__('Config'), array("plugin" => "system", "controller" => "config"));
$this->Html->addCrumb(__('Install'), array("plugin" => "system", "controller" => "config", "action" => "install"));
?>
<div class="container">
    <div class="page-header text-center">
        <h1><?= __('Welcome to Mahoney'); ?></h1>
        <h6>version <strong><?= $mahoneyPlugins[0]['data']['version']; ?></strong></h6>
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
        <div class="<?= (isset($inputErrors) && (array_key_exists("username", $inputErrors))) ? 'has-error has-feedback' : ''; ?>">
            <label for="inputUsername" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?= __('The admin login'); ?>"><?= __('Username'); ?></label>
            <div class="col-sm-3">
                <?= $this->Form->input('username', array('class' => 'form-control', 'placeholder' => 'admin', 'id' => 'inputUsername', 'value' => !empty($this->request->data["Config"]["username"]) ? $this->request->data["Config"]["username"] : 'admin')); ?>
                <?php
                if (isset($inputErrors) && array_key_exists("username", $inputErrors)):
                    ?>
                <span class="glyphicon glyphicon-remove form-control-feedback tooltipElement" data-toggle="tooltip" data-placement="left" title="<?= __($inputErrors["username"]); ?>"></span>
                    <?php
                endif;
                ?>
            </div>
        </div>
        <div class="<?= (isset($inputErrors) && (array_key_exists("password", $inputErrors))) ? 'has-error has-feedback' : ''; ?>">
            <label for="inputPassword" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?= __('The admin password'); ?>"><?= __('Password'); ?></label>
            <div class="col-sm-3">
            <?= $this->Form->input('password', array('class' => 'form-control', 'placeholder' => __('Password'), 'id' => 'inputPassword')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("password", $inputErrors)):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback tooltipElement" data-toggle="tooltip" data-placement="left" title="<?= __($inputErrors["password"]); ?>"></span>
                <?php
            endif;
            ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="<?= (isset($inputErrors) && (array_key_exists("name", $inputErrors))) ? 'has-error has-feedback' : ''; ?>">
            <label for="inputName" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?= __('Your name'); ?>"><?= __('Name'); ?></label>
            <div class="col-sm-3">
            <?= $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Cuzco, The Emperor', 'id' => 'inputName', 'required' => false, 'value' => !empty($this->request->data["Config"]["name"]) ? $this->request->data["Config"]["name"] : '')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("name", $inputErrors)):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback tooltipElement" data-toggle="tooltip" data-placement="left" title="<?= __($inputErrors["name"]); ?>"></span>
                <?php
            endif;
            ?>
            </div>
        </div>
        <div class="<?= (isset($inputErrors) && (array_key_exists("email", $inputErrors))) ? 'has-error has-feedback' : ''; ?>">
            <label for="inputEmail" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?= __('Your email, for password recover and stuff'); ?>"><?= __('Email'); ?></label>
            <div class="col-sm-3">
            <?= $this->Form->input('email', array('class' => 'form-control', 'placeholder' => __('Email'), 'id' => 'inputEmail', 'required' => true, 'value' => !empty($this->request->data["Config"]["email"]) ? $this->request->data["Config"]["email"] : '')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("email", $inputErrors)):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback tooltipElement" data-toggle="tooltip" data-placement="left" title="<?= __($inputErrors["email"]); ?>"></span>
                <?php
            endif;
            ?>
            </div>
        </div>
    </div>
    <div class="page-header text-left"><h4>Core Configuration</h4></div>
    <div class="form-group <?= (isset($inputErrors) && array_key_exists("hostname", $inputErrors)) ? 'has-error has-feedback' : ''; ?>">
        <label for="inputHostname" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?= __('Your computer name. For environment based configuration.'); ?>"><?= __('Hostname'); ?></label>
        <div class="col-sm-8">
            <?= $this->Form->input('hostname', array('class' => 'form-control', 'placeholder' => __('Hostname'), 'id' => 'inputHostname', 'required' => true, 'value' => !empty($this->request->data["Config"]["hostname"]) ? $this->request->data["Config"]["hostname"] : php_uname('n'))); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("hostname", $inputErrors)):
                ?>
            <span class="glyphicon glyphicon-remove form-control-feedback tooltipElement" data-toggle="tooltip" data-placement="left" title="<?= __($inputErrors["hostname"]); ?>"></span>
                <?php
            endif;
            ?>
        </div>
    </div>
    <div class="form-group <?= (isset($inputErrors) && array_key_exists("databasehost", $inputErrors)) ? 'has-error has-feedback' : ''; ?>">
        <label for="inputDatabasehost" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?= __('Database host. Usually: localhost'); ?>"><?= __('DB Host'); ?></label>
        <div class="col-sm-8">
            <?= $this->Form->input('databasehost', array('class' => 'form-control', 'placeholder' => __('localhost'), 'id' => 'inputDatabasehost', 'required' => true, 'value' => !empty($this->request->data["Config"]["databasehost"]) ? $this->request->data["Config"]["databasehost"] : 'localhost')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("databasehost", $inputErrors)):
                ?>
            <span class="glyphicon glyphicon-remove form-control-feedback tooltipElement" data-toggle="tooltip" data-placement="left" title="<?= __($inputErrors["databasehost"]); ?>"></span>
                <?php
            endif;
            ?>
        </div>
    </div>
    <div class="form-group <?= (isset($inputErrors) && array_key_exists("databasename", $inputErrors)) ? 'has-error has-feedback' : ''; ?>">
        <label for="inputDatabaseName" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?= __('Database name. Usually: Mahoney'); ?>"><?= __('DB Name'); ?></label>
        <div class="col-sm-8">
            <?= $this->Form->input('databasename', array('class' => 'form-control', 'placeholder' => __('mahoney'), 'id' => 'inputDatabaseName', 'required' => true, 'value' => !empty($this->request->data["Config"]["databasename"]) ? $this->request->data["Config"]["databasename"] : 'mahoney')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("databasename", $inputErrors)):
                ?>
            <span class="glyphicon glyphicon-remove form-control-feedback tooltipElement" data-toggle="tooltip" data-placement="left" title="<?= __($inputErrors["databasename"]); ?>"></span>
                <?php
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <div class="<?= (isset($inputErrors) && (array_key_exists("databaseuser", $inputErrors))) ? 'has-error has-feedback' : ''; ?>">
            <label for="inputDatabaseUser" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?= __('The username of database'); ?>"><?= __('DB Username'); ?></label>
            <div class="col-sm-3">
            <?= $this->Form->input('databaseuser', array('class' => 'form-control', 'placeholder' => 'root', 'id' => 'inputDatabaseUser', 'required' => false, 'value' => !empty($this->request->data["Config"]["databaseuser"]) ? $this->request->data["Config"]["databaseuser"] : 'root')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("databaseuser", $inputErrors)):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback tooltipElement" data-toggle="tooltip" data-placement="left" title="<?= __($inputErrors["databaseuser"]); ?>"></span>
                <?php
            endif;
            ?>
            </div>
        </div>
        <div class="<?= (isset($inputErrors) && (array_key_exists("databasepassword", $inputErrors))) ? 'has-error has-feedback' : ''; ?>">
            <label for="inputDatabasePassword" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?= __('The password of database'); ?>"><?= __('DB Password'); ?></label>
            <div class="col-sm-3">
            <?= $this->Form->input('databasepassword', array('type' => 'password', 'class' => 'form-control', 'id' => 'inputDatabasePassword')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("databasepassword", $inputErrors)):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback tooltipElement" data-toggle="tooltip" data-placement="left" title="<?= __($inputErrors["databasepassword"]); ?>"></span>
                <?php
            endif;
            ?>
            </div>
        </div>
    </div>
    <div class="form-group <?= (isset($inputErrors) && array_key_exists("sitename", $inputErrors)) ? 'has-error has-feedback' : ''; ?>">
        <label for="inputSitename" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?= __('Your application name'); ?>"><?= __('Application Name'); ?></label>
        <div class="col-sm-8">
            <?= $this->Form->input('sitename', array('class' => 'form-control', 'placeholder' => "Mahoney", 'id' => 'inputSitename', 'required' => true, 'value' => !empty($this->request->data["Config"]["sitename"]) ? $this->request->data["Config"]["sitename"] : 'Mahoney')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("sitename", $inputErrors)):
                ?>
            <span class="glyphicon glyphicon-remove form-control-feedback tooltipElement" data-toggle="tooltip" data-placement="left" title="<?= __($inputErrors["sitename"]); ?>"></span>
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
                <p><?= __('These generated tokens will ensure the safety of your application. Save in a safe place.'); ?></p>
                <footer><strong>Security Salt</strong>: <?= $salt; ?></footer>
                <footer><strong>Cipher Seed</strong>: <?= $seed; ?></footer>
            </blockquote>  
        </div>
    </div>
    <div class="form-signin">
        <?= $this->Form->end(array('label' => __('Get Started'), 'class' => 'btn btn-lg btn-success btn-block')); ?>
        <p class="text-muted text-center"><?= __('This software is maintened under'); ?> <br/> <a href="http://www.mozilla.org/MPL/2.0/" target="_blank"><?= __("Mozilla Public License 2.0"); ?></a></p>
        <p class="text-muted text-center"><a href="/system/docs" target="_blank"><?= __("Documentation"); ?></a> | <a href="http://github.com/kalvinmoraes/Mahoney" target="_blank"><?= __("Github"); ?></a></p>
    </div>
</div>