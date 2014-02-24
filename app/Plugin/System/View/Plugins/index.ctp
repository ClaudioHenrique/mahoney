<?php
$this->Html->addCrumb(__('Plugins'), '/system/plugins');
?>
<div class="container">
    <div class="page-header">
        <h1><?php echo __('Plugins'); ?></h1>
        <p><?php echo __('Create a unique CMS with thousands of plugins'); ?></p>
        <?php echo $this->HTML->link(__('Search'), array('plugin' => 'system', 'controller' => 'plugins', 'action' => 'search'), array('class' => 'btn btn-default')); ?> <?php echo $this->HTML->link(__('Upload plugin'), array('plugin' => 'system', 'controller' => 'plugins', 'action' => 'upload'), array('class' => 'btn btn-default')); ?>
    </div>

    <?php
    foreach ($mahoneyPlugins as $plugin):
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="bs-example widget">
                    <h2><?php echo $plugin['name']; ?></h2>
                    <h6>Type: <strong><?php echo $plugin['data']['type']; ?></strong></h6>
                    <h6>Version: <strong><?php echo $plugin['data']['version']; ?></strong></h6>
                    <h6>Author: <strong><?php echo $plugin['data']['author']; ?></strong></h6>
                    <h6>Description: <strong><?php echo $plugin['data']['description']; ?></strong></h6>
                </div>
                <div class="highlight">
                    <div class="row">
                        <?php
                        if($plugin['name'] != "System"):
                        ?>
                            <div class="col-md-6">
                                <?php echo ($plugin['active'] == 1) ? 
                                $this->HTML->link(__('Disable'), array('plugin' => 'system', 'controller' => 'plugins', 'action' => 'disable', $plugin['name']), array('class' => 'btn btn-default'))
                                . " " .
                                (($plugin['outdated'] == true) ? $this->HTML->link(__('Update'), array('plugin' => 'system', 'controller' => 'plugins', 'action' => 'update', $plugin['name']), array('class' => 'btn btn-info', 'confirm' => __('Are you sure you want to update this plugin? All data from that same can be lost.'))) : "")
                                :
                                $this->HTML->link(__('Enable'), array('plugin' => 'system', 'controller' => 'plugins', 'action' => 'enable', $plugin['name']), array('class' => 'btn btn-success')); ?>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php echo $this->HTML->link(__('Reset'), array('plugin' => 'system', 'controller' => 'plugins', 'action' => 'reset', $plugin['name']), array('class' => 'btn btn-default', 'confirm' => __('Are you sure you want to reset all data from this plugin? All your saved data from this plugin will be lost.'))); ?> <?php echo $this->HTML->link(__('Uninstall'), array('plugin' => 'system', 'controller' => 'plugins', 'action' => 'uninstall', $plugin['name']), array('class' => 'btn btn-warning', 'confirm' => __('Are you sure you want to uninstall this plugin? All your saved data from this plugin will be lost.'))); ?> <?php echo $this->HTML->link(__('Delete'), array('plugin' => 'system', 'controller' => 'plugins', 'action' => 'delete', $plugin['name']), array('class' => 'btn btn-danger', 'confirm' => __('Are you sure you want to delete this plugin?'))); ?>
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