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
                    $this->Html->image("System.mahoney-logo.png"), array('plugin' => false, 'controller' => 'site', 'action' => 'index'), array('title' => __('Visit website'), 'class' => 'navbar-brand', 'escape' => false)
            );
            ?>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
<?php
    foreach ($mahoneyPlugins as $plugin):
        if($plugin["active"]):
            foreach ($plugin['menu'] as $key => $value):
                if (isset($plugin['menu'][$key]["child"])):
                ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa <?= (isset($plugin['menu'][$key]["icon"]) ? $plugin['menu'][$key]["icon"] : ""); ?>"></i> <?= __(Inflector::humanize($key)); ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php
                        foreach ($plugin['menu'][$key]["child"] as $key2 => $value2):
                            if ($key2 == "Config" || $key == "Manage"):
                            ?>
                            <li class="divider"></li>
                            <?php
                            endif;
                            if($value2 != "icon"):
                                ?>
                                <li><?= $this->Html->link("<i class=\"fa ".(isset($value2["icon"]) ? $value2["icon"] : "")."\"></i> " . __(Inflector::humanize($key2)), (isset($value2["link"]) ? $value2["link"] : ""), array("escape" => false)); ?></li>
                                <?php
                            endif;
                        endforeach;
                        ?>
                    </ul>
                </li>
                <?php
                else:
                    if ($key == "Config" || $key == "Manage"):
                    ?>
                    <li class="divider"></li>
                    <?php
                    endif;
                    ?>
                <li><?= $this->Html->link("<i class=\"fa ".(isset($plugin["menu"][$key]["icon"]) ? $plugin["menu"][$key]["icon"] : "")."\"></i> " . __(Inflector::humanize($key)), (isset($plugin['menu'][$key]["link"]) ? $plugin['menu'][$key]["link"] : ""), array("escape" => false)); ?></li>
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
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?= AuthComponent::user()['username']; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?= $this->Html->link("<i class=\"fa fa-asterisk\"></i> " . __('My profile'),"/system/users/detail/" . AuthComponent::user()['id'], array("escape" => false)); ?></li>
                        <li class="divider"></li>
                        <li><?= $this->Html->link("<i class=\"fa fa-power-off\"></i> " . __('Logout'),"/system/users/logout", array("escape" => false)); ?></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>