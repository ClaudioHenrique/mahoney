<?php
$this->Html->addCrumb(__d("system","Config"), array("plugin" => "system", "controller" => "config"));
$this->Html->addCrumb(__d("system","Install"), array("plugin" => "system", "controller" => "config", "action" => "install"));
?>
<div class="container">
    <div class="page-header text-center">
        <h1><?= __d("system","Welcome to Mahoney"); ?></h1>
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
    <div class="page-header text-left"><h4><?= __d("system","Admin Account") ?></h4></div>
    <div class="form-group">
        <div class="<?= (isset($inputErrors) && (array_key_exists("username", $inputErrors))) ? 'has-error has-feedback' : ''; ?>">
            <label for="inputUsername" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?= __d("system","The admin login"); ?>"><?= __d("system","Username"); ?></label>
            <div class="col-sm-3">
                <?= $this->Form->input('username', array('class' => 'form-control', 'placeholder' => 'admin', 'id' => 'inputUsername', 'value' => !empty($this->request->data["Config"]["username"]) ? $this->request->data["Config"]["username"] : 'admin')); ?>
                <?php
                if (isset($inputErrors) && array_key_exists("username", $inputErrors)):
                    ?>
                <span class="glyphicon glyphicon-remove form-control-feedback tooltipElement" data-toggle="tooltip" data-placement="left" title="<?= __d('system',$inputErrors["username"]); ?>"></span>
                    <?php
                endif;
                ?>
            </div>
        </div>
        <div class="<?= (isset($inputErrors) && (array_key_exists("password", $inputErrors))) ? 'has-error has-feedback' : ''; ?>">
            <label for="inputPassword" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?= __d("system","The admin password"); ?>"><?= __d("system","Password"); ?></label>
            <div class="col-sm-3">
            <?= $this->Form->input('password', array('class' => 'form-control', 'placeholder' => __d("system","Password"), 'id' => 'inputPassword')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("password", $inputErrors)):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback tooltipElement" data-toggle="tooltip" data-placement="left" title="<?= __d('system',$inputErrors["password"]); ?>"></span>
                <?php
            endif;
            ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="<?= (isset($inputErrors) && (array_key_exists("name", $inputErrors))) ? 'has-error has-feedback' : ''; ?>">
            <label for="inputName" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?= __d("system","Your name"); ?>"><?= __d("system","Name"); ?></label>
            <div class="col-sm-3">
            <?= $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Cuzco, The Emperor', 'id' => 'inputName', 'required' => false, 'value' => !empty($this->request->data["Config"]["name"]) ? $this->request->data["Config"]["name"] : '')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("name", $inputErrors)):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback tooltipElement" data-toggle="tooltip" data-placement="left" title="<?= __d('system',$inputErrors["name"]); ?>"></span>
                <?php
            endif;
            ?>
            </div>
        </div>
        <div class="<?= (isset($inputErrors) && (array_key_exists("email", $inputErrors))) ? 'has-error has-feedback' : ''; ?>">
            <label for="inputEmail" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?= __d("system","Your email, for password recover and stuff"); ?>"><?= __d("system","Email"); ?></label>
            <div class="col-sm-3">
            <?= $this->Form->input('email', array('class' => 'form-control', 'placeholder' => __d("system","Email"), 'id' => 'inputEmail', 'required' => true, 'value' => !empty($this->request->data["Config"]["email"]) ? $this->request->data["Config"]["email"] : '')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("email", $inputErrors)):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback tooltipElement" data-toggle="tooltip" data-placement="left" title="<?= __d('system',$inputErrors["email"]); ?>"></span>
                <?php
            endif;
            ?>
            </div>
        </div>
    </div>
    <div class="page-header text-left"><h4><?= __d("system","Core Configuration") ?></h4></div>
    <div class="form-group <?= (isset($inputErrors) && array_key_exists("hostname", $inputErrors)) ? 'has-error has-feedback' : ''; ?>">
        <label for="inputHostname" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?= __d("system","Your computer name. For environment based configuration."); ?>"><?= __d("system","Hostname"); ?></label>
        <div class="col-sm-8">
            <?= $this->Form->input('hostname', array('class' => 'form-control', 'placeholder' => __d("system","Hostname"), 'id' => 'inputHostname', 'required' => true, 'value' => !empty($this->request->data["Config"]["hostname"]) ? $this->request->data["Config"]["hostname"] : php_uname('n'))); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("hostname", $inputErrors)):
                ?>
            <span class="glyphicon glyphicon-remove form-control-feedback tooltipElement" data-toggle="tooltip" data-placement="left" title="<?= __d('system',$inputErrors["hostname"]); ?>"></span>
                <?php
            endif;
            ?>
        </div>
    </div>
    <div class="form-group <?= (isset($inputErrors) && array_key_exists("databasehost", $inputErrors)) ? 'has-error has-feedback' : ''; ?>">
        <label for="inputDatabasehost" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?= __d("system","Database host. Usually: localhost"); ?>"><?= __d("system","DB Host"); ?></label>
        <div class="col-sm-8">
            <?= $this->Form->input('databasehost', array('class' => 'form-control', 'placeholder' => __d("system","localhost"), 'id' => 'inputDatabasehost', 'required' => true, 'value' => !empty($this->request->data["Config"]["databasehost"]) ? $this->request->data["Config"]["databasehost"] : 'localhost')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("databasehost", $inputErrors)):
                ?>
            <span class="glyphicon glyphicon-remove form-control-feedback tooltipElement" data-toggle="tooltip" data-placement="left" title="<?= __d('system',$inputErrors["databasehost"]); ?>"></span>
                <?php
            endif;
            ?>
        </div>
    </div>
    <div class="form-group <?= (isset($inputErrors) && array_key_exists("databasename", $inputErrors)) ? 'has-error has-feedback' : ''; ?>">
        <label for="inputDatabaseName" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?= __d("system","Database name. Usually: Mahoney"); ?>"><?= __d("system","DB Name"); ?></label>
        <div class="col-sm-8">
            <?= $this->Form->input('databasename', array('class' => 'form-control', 'placeholder' => __d("system","mahoney"), 'id' => 'inputDatabaseName', 'required' => true, 'value' => !empty($this->request->data["Config"]["databasename"]) ? $this->request->data["Config"]["databasename"] : 'mahoney')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("databasename", $inputErrors)):
                ?>
            <span class="glyphicon glyphicon-remove form-control-feedback tooltipElement" data-toggle="tooltip" data-placement="left" title="<?= __d('system',$inputErrors["databasename"]); ?>"></span>
                <?php
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <div class="<?= (isset($inputErrors) && (array_key_exists("databaseuser", $inputErrors))) ? 'has-error has-feedback' : ''; ?>">
            <label for="inputDatabaseUser" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?= __d("system","The username of database"); ?>"><?= __d("system","DB Username"); ?></label>
            <div class="col-sm-3">
            <?= $this->Form->input('databaseuser', array('class' => 'form-control', 'placeholder' => 'root', 'id' => 'inputDatabaseUser', 'required' => false, 'value' => !empty($this->request->data["Config"]["databaseuser"]) ? $this->request->data["Config"]["databaseuser"] : 'root')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("databaseuser", $inputErrors)):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback tooltipElement" data-toggle="tooltip" data-placement="left" title="<?= __d('system',$inputErrors["databaseuser"]); ?>"></span>
                <?php
            endif;
            ?>
            </div>
        </div>
        <div class="<?= (isset($inputErrors) && (array_key_exists("databasepassword", $inputErrors))) ? 'has-error has-feedback' : ''; ?>">
            <label for="inputDatabasePassword" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?= __d("system","The password of database"); ?>"><?= __d("system","DB Password"); ?></label>
            <div class="col-sm-3">
            <?= $this->Form->input('databasepassword', array('type' => 'password', 'class' => 'form-control', 'id' => 'inputDatabasePassword')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("databasepassword", $inputErrors)):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback tooltipElement" data-toggle="tooltip" data-placement="left" title="<?= __d('system',$inputErrors["databasepassword"]); ?>"></span>
                <?php
            endif;
            ?>
            </div>
        </div>
    </div>
    <div class="form-group <?= (isset($inputErrors) && array_key_exists("sitename", $inputErrors)) ? 'has-error has-feedback' : ''; ?>">
        <label for="inputSitename" class="col-sm-2 control-label tooltipElement" data-toggle="tooltip" data-placement="right" title="<?= __d("system","Your application name"); ?>"><?= __d("system","Application Name"); ?></label>
        <div class="col-sm-8">
            <?= $this->Form->input('sitename', array('class' => 'form-control', 'placeholder' => "Mahoney", 'id' => 'inputSitename', 'required' => true, 'value' => !empty($this->request->data["Config"]["sitename"]) ? $this->request->data["Config"]["sitename"] : 'Mahoney')); ?>
            <?php
            if (isset($inputErrors) && array_key_exists("sitename", $inputErrors)):
                ?>
            <span class="glyphicon glyphicon-remove form-control-feedback tooltipElement" data-toggle="tooltip" data-placement="left" title="<?= __d('system',$inputErrors["sitename"]); ?>"></span>
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
                <p><?= __d("system","These generated tokens will ensure the safety of your application. Save in a safe place."); ?></p>
                <footer><strong>Security Salt</strong>: <?= $salt; ?></footer>
                <footer><strong>Cipher Seed</strong>: <?= $seed; ?></footer>
            </blockquote>  
        </div>
    </div>
    <div class="form-signin">
        <?= $this->Form->end(array('label' => __d("system","Get Started"), 'class' => 'btn btn-lg btn-success btn-block')); ?>
        <p class="text-muted text-center"><?= __d("system","This software is maintened under"); ?> <br/> <a href="http://www.mozilla.org/MPL/2.0/" target="_blank"><?= __d("system","Mozilla Public License 2.0"); ?></a></p>
        <p class="text-muted text-center"><a href="/system/docs" target="_blank"><?= __d("system","Documentation"); ?></a> | <a href="http://github.com/kalvinmoraes/Mahoney" target="_blank"><?= __d("system","Github"); ?></a></p>
    </div>
</div>