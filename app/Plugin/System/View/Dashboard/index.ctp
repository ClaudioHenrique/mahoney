<div class="globalTop">
    <div class="container">
        <div class="page-header">
            <h1><?php echo __("Welcome to your dashboard!"); ?></h1>
            <p><?php echo __("Here you can check the common information about your website and get a good view of what's happening around here"); ?></p>
        </div>
    </div>
</div>
<div class="container">
    <!-- Example row of columns -->
    <div class="row">
        <?php
        foreach ($mahoneyPlugins as $plugin):
            if ($plugin['active'] && $plugin['name'] != 'System'):
                if($this->_getElementFilename($plugin['name'] . '.dashWidget')):
                    echo $this->element($plugin['name'] . '.dashWidget');
                endif;
            endif;
        endforeach;
        ?>
    </div>
    <?php
    echo $this->element('System.dashWidget');
    ?>
</div>