<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php
                echo (Configure::read("Siteinfo.sitename")) ? Configure::read("Siteinfo.sitename") : $sitename;
                echo " | ";
                echo $pageTitle;
            ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('bootstrap.min');
        echo $this->Html->css('mahoney-base');
        if($authUser):
            echo $this->Html->css('System.systemBase');
        endif;

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body>
        <!-- Wrap all page content here -->
        <div class="wrap">
            <?php
            if ($authUser):
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
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $authUser['username']; ?> <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><?php echo $this->Html->link('My profile',array('plugin'=>'system','controller'=>'users','action'=>'detail', $authUser['id'])); ?></li>
                                    <li class="divider"></li>
                                    <li><?php echo $this->Html->link('Logout',array('plugin'=>'system','controller'=>'users','action'=>'logout')); ?></li>
                                </ul>
                            </li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
                <?php
            endif;
            ?>
            <div id="container">
                    <?php echo $this->Session->flash(); ?>
                    <?php echo $this->fetch('content'); ?>
            </div>
        </div>
        <?php
        echo $this->Html->script('com/jquery/jquery-1.11.0.min');
        echo $this->Html->script('com/bootstrap/bootstrap.min');
        echo $this->Html->script('mahoney-base');
        ?>
    </body>
</html>
