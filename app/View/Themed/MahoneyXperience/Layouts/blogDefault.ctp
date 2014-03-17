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
        echo $this->Html->css('mahoneyBase');
        echo $this->Html->css('Blog.mahoneyBlog');
        
        if(AuthComponent::user()):
            echo $this->Html->css('System.mahoneySystem');
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
        
        echo $this->Html->script('mahoneyBase');
        echo $this->Html->script('Blog.mahoneyBlog');
        
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
