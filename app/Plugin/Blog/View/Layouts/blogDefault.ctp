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
            <?php echo $pageTitle . " | " . $siteName; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('bootstrap.min');
        echo $this->Html->css('System.docs.min');
        echo $this->Html->css('System.systemBase');

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
                                <?php
                                foreach ($mahoneyPlugins as $plugin):
                                    if ($plugin['active'] && $plugin['menu']):
                                        foreach ($plugin['menu'] as $key => $value):
                                            if (is_array($plugin['menu'][$key])):
                                                ?>
                                                <li class="dropdown">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __(Inflector::humanize($key)); ?> <b class="caret"></b></a>
                                                    <ul class="dropdown-menu">
                                                        <?php
                                                        foreach ($plugin['menu'][$key] as $key2 => $value2):
                                                            if($key2 == "config"):
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
                        <p class="text-muted">2014 - v1.0</p>
                    </div>
                    <div class="col-xs-6">
                        <p class="text-muted text-right"><a href="/system/docs"><?php echo __("help"); ?></a> | <a href="/system/docs#privacy"><?php echo __("privacy"); ?></a> | <a href="/system/docs#about"><?php echo __("about"); ?></a></p>
                    </div>
                </div>
            </div>
        </footer>
        <?php endif; ?>
        <?php
        echo $this->Html->script('com/jquery/jquery-1.11.0.min');
        echo $this->Html->script('com/bootstrap/bootstrap.min');
        echo $this->Html->script('System.com/tablesorter/jquery.tablesorter.min');
        echo $this->Html->script('mahoneyBase');
        echo $this->Html->script('System.systemBase');
        ?>
    </body>
</html>
