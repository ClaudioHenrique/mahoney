<?php
$this->Html->addCrumb(__('Plugins'), array("plugin" => "system", "controller" => "plugins", "action"=>"index"));
$this->Html->addCrumb(__('Search'), array("plugin" => "system", "controller" => "plugins", "action" => "search"));
?>
<div class="container">
    <div class="page-header">
        <h1><?php echo __('Search Plugins'); ?></h1>
        <p><?php echo __('Search for the official plugins'); ?></p>
    </div>
<div class="row">
    <?php
    foreach ($officialPlugins as $plugin):
        ?>
            <div class="col-md-3">
                <div class="bs-example widget">
                    <h2><?php echo Inflector::humanize(substr($plugin['name'], strpos($plugin['name'], "-")+1)); ?></h2>
                    <h6><?php echo $plugin['description']; ?></h6>
                </div>
                <div class="highlight">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $this->HTML->link(__('Install'), array('plugin' => 'system', 'controller' => 'plugins', 'action' => 'install', $plugin['name']), array('class' => 'btn btn-success')); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    endforeach;
    ?>
    </div>

</div>