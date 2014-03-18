<div class="container">
    <div class="page-header">
        <h1><?php echo $thePost['Post']['title']; ?></h1>
    </div>
    <?php
    echo $thePost['Post']['post'];
    ?>
    <hr/>
    <h1><?= count($thePost['Comment']) . " " . (count($thePost['Comment']) > 1 ? __("reviews") : __("review")); ?></h1>
    <?php
    foreach ($thePost['Comment'] as $key => $value):
        ?>
        <div class="post-container">
            <span class="post-date"><?= $this->Time->i18nFormat($value["created"], '%e de %B de %Y - %H:%M'); ?></span>
            <div class="comment-container">
                <div class="user-avatar"><?= $value['User']['name'] ?> <?= __("says:") ?></div>
                <div class="post-comment"><span class="baloon-tip"></span><?= $value['comment']; ?></div>
            </div>
            <div class="user-controls">
                <?php
                    if(AuthComponent::user()):
                        ?>
                        <span class="tooltipElement" data-toggle="tooltip" data-original-title="<?= __('Delete post') ?>"><?= $this->Html->link($this->Form->button('<i class="fa fa-trash-o"></i>', array('type'=>'button')), array('plugin' => 'blog','controller' => 'comments', 'action' => 'delete', $value['id']), array("escape" => false)) ?></span>
                        <?php
                    endif;
                ?>
            </div>
        </div>
        <?php
    endforeach;
    ?>
</div>