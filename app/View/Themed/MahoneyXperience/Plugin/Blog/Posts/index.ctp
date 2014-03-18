<div class="container">
    <div class="page-header">
        <h1><?php echo $thePost['Post']['title']; ?></h1>
    </div>
    <?php
    echo $thePost['Post']['post'];
    ?>
    <hr/>
    <h1><?= __("Comments"); ?></h1>
    <?php
    foreach ($thePost['Comment'] as $key => $value):
        ?>
        <div class="row">
            <span class="post-date"><?= $this->Time->format($value["created"], '%e de %B de %Y - %H:%M'); ?></span>
            <div class="comment-container">
                <div class="user-avatar"><?= $value['User']['name'] ?> <?= __("says:") ?></div>
                <div class="post-comment"><?= $value['comment']; ?></div>
            </div>
        </div>
        <?php
    endforeach;
    ?>
</div>