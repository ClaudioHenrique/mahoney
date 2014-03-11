<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php
            echo $this->Html->link(
                    $this->Html->image("mahoney-logo.png"), array('plugin' => false, 'controller' => 'site', 'action' => 'index'), array('title' => __('Visit website'), 'class' => 'navbar-brand', 'escape' => false)
            );
            ?>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
<?php
    foreach ($mahoneyPlugins as $plugin):
        if($plugin['name'] == 'System'):
            foreach ($plugin['menu'] as $key => $value):
                if (isset($plugin['menu'][$key]["child"])):
                ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa <?= (isset($plugin['menu'][$key]["icon"]) ? $plugin['menu'][$key]["icon"] : ""); ?>"></i> <?php echo __(Inflector::humanize($key)); ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                            <?php
                            foreach ($plugin['menu'][$key]["child"] as $key2 => $value2):
                                if ($key2 == "config" || $key == "manage"):
                                    ?>
                                    <li class="divider"></li>
                                <?php
                                elseif($value2 != "icon"):
                                    ?>
                                    <li><?php echo $this->Html->link(__(Inflector::humanize($key2)), $value2["link"]); ?></li>
                                    <?php
                                endif;
                                ?>
                            <?php
                            endforeach;
                            if($key == "Plugins"):
                            ?>
                            <?php if(Configure::read("Plugin.count") > 0): ?>
                            <li class="divider"></li>
                            <?php endif; ?>
                            <?php
                            foreach ($mahoneyPlugins as $plugin):
                                if($plugin['name'] != 'System'):
                                    if ($plugin['active'] && $plugin['menu']):
                                        foreach ($plugin['menu'] as $key => $value):
                                            if (isset($plugin['menu'][$key]["child"])):
                                            ?>
                                            <li>
                                                <a class="trigger right-caret"><?= $key ?></a>
                                                <ul class="dropdown-menu sub-menu">
                                                    <?php
                                                    foreach ($plugin['menu'][$key]["child"] as $key2 => $value2):
                                                        if ($key2 == "config"):
                                                            ?>
                                                    <li class="divider"></li>
                                                            <?php
                                                            endif;
                                                            ?>
                                                    <li><?php echo $this->Html->link(__(Inflector::humanize($key2)), $value2); ?></li>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </ul>
                                            </li>
                                            <?php
                                            else:
                                                ?>
                                            <li><?php echo $this->Html->link(__(Inflector::humanize($key)), $value); ?></li>
                                            <?php
                                            endif;
                                        endforeach;
                                    endif;
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </ul>
                </li>
                <?php
                else:
                    ?>
                <li><?php echo $this->Html->link("<i class=\"fa ".(isset($plugin["menu"][$key]["icon"]) ? $plugin["menu"][$key]["icon"] : "")."\"></i> " . __(Inflector::humanize($key)), $plugin['menu'][$key]["link"], array("escape" => false)); ?></li>
                    <?php
                endif;
            endforeach;
        endif;
    endforeach;
?>
<!-- RightNav -->
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo AuthComponent::user()['username']; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo $this->Html->link('My profile',array('plugin'=>'system','controller'=>'users','action'=>'detail', AuthComponent::user()['id'])); ?></li>
                        <li class="divider"></li>
                        <li><?php echo $this->Html->link('Logout',array('plugin'=>'system','controller'=>'users','action'=>'logout')); ?></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>