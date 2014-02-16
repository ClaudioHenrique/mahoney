<div class="row">
    <div class="col-md-6">
        <div class="bs-example widget">
            <div class="hightlight">
                <h2><?php echo __('Blog'); ?></h2>
                <?php
                $blogWidgetData = $this->requestAction('/system/blog/config/widgetdata');
                echo __('Total posts') . ': <strong>' . $blogWidgetData['totalPosts'] . '</strong><br/>';
                echo __('Last post') . ': <strong>' . $blogWidgetData['lastPost']['Post']['title'] . '</strong><br/>';
                ?>
            </div>
        </div>
        <div class="highlight">
        </div>
    </div>
</div>