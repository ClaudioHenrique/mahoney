<?php
$this->Html->addCrumb(__d('system','Plugins'), array("plugin" => "system", "controller" => "plugins"));
?>
<div class="container">
    <div class="page-header">
        <h1><?= __d('system','Plugins'); ?></h1>
        <p><?= __d('system','Create a unique CMS with plugins for your app.'); ?></p>
        <?= $this->HTML->link(__d('system','Search'), array('plugin' => 'system', 'controller' => 'plugins', 'action' => 'search'), array('class' => 'btn btn-default')); ?>
    </div>

    <?php
    foreach ($mahoneyPlugins as $plugin):
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="bs-example widget">
                    <h2><?= $plugin['name']; ?></h2>
                    <img style="float:right;"src="<?= $plugin['icon'] ?>"/>
                    <h6><?= __d("system","Type") ?>: <strong><?= $plugin['data']['type']; ?></strong></h6>
                    <h6><?= __d("system","Version") ?>: <strong><?= $plugin['data']['version']; ?></strong></h6>
                    <h6><?= __d("system","Author") ?>: <strong><?= $plugin['data']['author']; ?></strong></h6>
                    <h6><?= __d("system","Description") ?>: <strong><?= $plugin['data']['description']; ?></strong></h6>
                </div>
                <div class="highlight">
                    <div class="row">
                        <?php
                        if($plugin['name'] != "System"):
                        ?>
                            <div class="col-md-6">
                                <?= ($plugin['active'] == 1) ? 
                                $this->HTML->link(__d('system','Disable'), array('plugin' => 'system', 'controller' => 'plugins', 'action' => 'disable', $plugin['name']), array('class' => 'btn btn-default'))
                                . " " .
                                (($plugin['outdated'] == true) ? $this->HTML->link(__d('system','Update'), array('plugin' => 'system', 'controller' => 'plugins', 'action' => 'update', $plugin['name']), array('class' => 'btn btn-info', 'confirm' => __d('system','Are you sure you want to update this plugin? All data from that same can be lost.'))) : "")
                                :
                                $this->HTML->link(__d('system','Enable'), array('plugin' => 'system', 'controller' => 'plugins', 'action' => 'enable', $plugin['name']), array('class' => 'btn btn-success')); ?>
                            </div>
                            <div class="col-md-6 text-right">
                                <?= $this->HTML->link(__d('system','Reset'), array('plugin' => 'system', 'controller' => 'plugins', 'action' => 'reset', $plugin['name']), array('class' => 'btn btn-default', 'confirm' => __d('system','Are you sure you want to reset all data from this plugin? All your saved data from this plugin will be lost.'))); ?> <?= $this->HTML->link(__d('system','Uninstall'), array('plugin' => 'system', 'controller' => 'plugins', 'action' => 'uninstall', $plugin['name']), array('class' => 'btn btn-warning', 'confirm' => __d('system','Are you sure you want to uninstall this plugin? All your saved data from this plugin will be lost.'))); ?> <?= $this->HTML->link(__d('system','Delete'), array('plugin' => 'system', 'controller' => 'plugins', 'action' => 'delete', $plugin['name']), array('class' => 'btn btn-danger', 'confirm' => __d('system','Are you sure you want to delete this plugin?'))); ?>
                            </div>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    endforeach;
    ?>

</div>