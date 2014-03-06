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
                if (is_array($plugin['menu'][$key])):
                ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __(Inflector::humanize($key)); ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                            <?php
                            foreach ($plugin['menu'][$key] as $key2 => $value2):
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
    endforeach;
?>
<?php
if(Configure::read("Plugin.count") > 0):
?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Plugins <span class="caret"></span></a>
                    <ul class="dropdown-menu">
        <?php
        foreach ($mahoneyPlugins as $plugin):
            if($plugin['name'] != 'System'):
                if ($plugin['active'] && $plugin['menu']):
                    foreach ($plugin['menu'] as $key => $value):
                        if (is_array($plugin['menu'][$key])):
                        ?>
                        <li>
                            <a class="trigger right-caret"><?= $key ?></a>
                            <ul class="dropdown-menu sub-menu">
                                <?php
                                foreach ($plugin['menu'][$key] as $key2 => $value2):
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
        ?>
                    </ul>
                </li>
<?php
endif;
?>
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