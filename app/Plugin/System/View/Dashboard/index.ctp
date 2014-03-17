<div class="globalTop">
    <div class="container">
        <div class="page-header">
            <h1><?= __("Welcome to your dashboard!"); ?></h1>
            <p><?= __("Here you can check the common information about your website and get a good view of what's happening around here"); ?></p>
        </div>
    </div>
</div>
<div class="container">
    <!-- Example row of columns -->
    <?php
    foreach ($mahoneyPlugins as $plugin):
        if ($plugin['active'] && $plugin['name'] != 'System'):
            if($this->_getElementFilename($plugin['name'] . '.dashWidget')):
                echo $this->element($plugin['name'] . '.dashWidget');
            endif;
        endif;
    endforeach;
    ?>
    <?php
    echo $this->element('System.dashWidget');
    ?>
</div>