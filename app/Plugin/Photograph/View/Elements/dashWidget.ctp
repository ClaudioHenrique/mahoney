<div class="col-md-4">
    <div class="bs-example widget">
        <div class="hightlight">
            <h2><?php echo __('Photograph'); ?></h2>
            <p>Total Galleries: <strong>19</strong></p>
            <p>Total Galleries Size: <strong>1.2gb</strong></p>
        </div>
    </div>
    <div class="highlight">
        <?php echo $this->HTML->link(__('Add Gallery'), array('plugin' => 'system/photograph', 'controller' => 'galleries', 'action' => 'add'), array('class' => 'btn btn-default')); ?>
    </div>
</div>