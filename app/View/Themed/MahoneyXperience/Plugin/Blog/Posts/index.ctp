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
        foreach($thePost['Comment'] as $key => $value):
            ?>
            <div class="row">
            <?php
        endforeach;
    ?>
</div>