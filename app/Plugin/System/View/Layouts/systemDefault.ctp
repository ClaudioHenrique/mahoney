<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php
                echo (Configure::read("Siteinfo.sitename")) ? Configure::read("Siteinfo.sitename") : $siteName;
                echo " | ";
                echo $pageTitle;
            ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('../com/css/bootstrap/bootstrap.min');
        echo $this->Html->css('../com/css/font-awesome/font-awesome.min');
        echo $this->Html->css('System.docs.min');
        echo $this->Html->css('System.mahoneySystem');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body>
        <!-- Wrap all page content here -->
        <div class="wrap">
            <?php
            if (AuthComponent::user()):
                ?>
                <!-- Fixed navbar -->
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
                                <?php echo $this->element('System.menu'); ?>
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
                <div class='container'>
                    <?php
                    echo $this->Html->getCrumbs(' > ', array(
                        'text' => 'Dashboard',
                        'url' => array('plugin' => 'system', 'controller' => '', 'action' => 'index'),
                        'escape' => false
                    ));
                    ?>
                </div>
                <?php
            endif;
            ?>
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->fetch('content'); ?>
        </div>
        <?php if(AuthComponent::user()): ?>
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6">
                        <p class="text-muted"><?php echo "<a href=\"".$mahoneyPlugins[0]["data"]["homepage"]."\" target=\"_blank\">Mahoney</a> " . $mahoneyPlugins[0]["data"]["version"] . " - " . date("Y"); ?></p>
                    </div>
                    <div class="col-xs-6">
                       <p class="text-muted text-right"><?= $this->Html->image('System.cake.power.gif') ?> | <?= $this->Html->link(__("help"), array("plugin" => "system", "controller" => "docs")); ?> | <?= $this->Html->link(__("privacy"), array("plugin" => "system", "controller" => "docs", "action" => "#privacy")); ?> | <?= $this->Html->link(__("about"), array("plugin" => "system", "controller" => "docs", "action" => "#about")); ?></p>
                    </div>
                </div>
            </div>
        </footer>
        <?php endif; ?>
        <?php
        echo $this->Html->script('../com/js/jquery/jquery-1.11.0.min');
        echo $this->Html->script('../com/js/bootstrap/bootstrap.min');
        echo $this->Html->script('System.com/tablesorter/jquery.tablesorter.min');
        echo $this->Html->script('System.mahoneySystem');
        
        if(is_file($jsController)):
            echo $this->Html->script($jsController);
        endif;
        
        ?>
    </body>
</html>
