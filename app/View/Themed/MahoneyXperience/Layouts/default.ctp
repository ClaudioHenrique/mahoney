<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php
                echo (Configure::read("Siteinfo.sitename")) ? Configure::read("Siteinfo.sitename") : "Mahoney";
                echo " | ";
                echo $pageTitle;
            ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('../com/css/bootstrap/bootstrap.min');
        echo $this->Html->css('../com/css/font-awesome/font-awesome.min');
        echo $this->Html->css('mahoneyBase');
        
        if(AuthComponent::user()):
            echo $this->Html->css('System.mahoneySystem');
        endif;

        echo $this->fetch('meta');
        echo $this->fetch('css');
        ?>
    </head>
    <body>
        <div class="wrap">
            <?php
            if (AuthComponent::user()):
                echo $this->element('System.adminNav');
            endif;
            ?>
            <div id="container">
                <?php echo $this->Session->flash(); ?>
                <?php echo $this->fetch('content'); ?>
            </div>
        </div>
        <?php
        echo $this->Html->script('../com/js/jquery/jquery-1.11.0.min');
        echo $this->Html->script('../com/js/bootstrap/bootstrap.min');
        echo $this->Html->script('../com/js/zclip/jquery.zclip.min');
        
        echo $this->Html->script('mahoneyBase');
        
        echo $this->fetch('script');
        
        if(AuthComponent::user()):
            echo $this->Html->script('System.mahoneySystem');
        endif;
        
        if(strpos($jsController, ".") !== false):
            $file = APP . "plugin\\" . explode(".", $jsController)[0] . "\\webroot\\js\\" . explode(".", $jsController)[1] . ".js";
        else:
            $file = APP . "webroot\\js\\" . explode(".", $jsController)[0] . ".js";
        endif;
        
        if(file_exists($file)):
            echo $this->Html->script($jsController);
        endif;
        ?>
    </body>
</html>
