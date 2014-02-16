<?php
$this->Html->addCrumb(__('Blog'), '/system/blog');
$this->Html->addCrumb(__('Add post'), '/system/blog/posts/add');
?>
<div class="globalTop">
    <div class="container">
        <div class="page-header">
            <h1><?php echo __("Add a new post"); ?></h1>
        </div>
    </div>
</div>
<div class="container">
    <?php
    $options = array(
        'class' => 'form-horizontal',
        'inputDefaults' => array(
            'label' => false,
            'div' => false,
            'error' => false
        )
    );
    echo $this->Form->create('Post', $options);
    ?>
    <div class="form-group <?php echo $this->Form->isFieldError('Post.category_id') ? 'has-error has-feedback' : ''; ?>">
        <label for="inputCategory" class="col-sm-2 control-label"><?php echo __('Category'); ?></label>
        <div class="col-sm-3">
            <?php
            echo $this->Form->input('category_id', array(
                'options' => $categories,
                'class' => 'form-control',
                'id' => 'inputCategory'
            ));
            ?>
            <?php
            if ($this->Form->isFieldError('Post.category_id')):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
        <div class='col-sm-2'><?php echo $this->HTML->link(__('Manage categories'), array('plugin' => 'blog','controller' => 'categories','action' => 'index'), array('class' => 'btn btn-default')); ?></div>
        <div class='col-sm-7'><small><?php echo $this->Form->error('Post.category_id', null, array('wrap' => 'label', 'class' => 'error')); ?></small></div>
    </div>
    <div class="form-group <?php echo $this->Form->isFieldError('Post.title') ? 'has-error has-feedback' : ''; ?>">
        <label for="inputTitle" class="col-sm-2 control-label"><?php echo __('Title'); ?></label>
        <div class="col-sm-8">
            <?php echo $this->Form->input('title', array('class' => 'form-control', 'placeholder' => __('Title'), 'id' => 'inputTitle', 'required' => true, 'type' => 'text')); ?>
            <?php
            if ($this->Form->isFieldError('Post.title')):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
        <div class='col-sm-2'><small><?php echo $this->Form->error('Post.title', null, array('wrap' => 'label', 'class' => 'error')); ?></small></div>
    </div>
    <div class="form-group <?php echo $this->Form->isFieldError('Post.post') ? 'has-error has-feedback' : ''; ?>">
        <label for="inputPost" class="col-sm-2 control-label"><?php echo __('Post'); ?></label>
        <div class="col-sm-8">
            <?php echo $this->Form->input('post', array('class' => 'form-control', 'placeholder' => __('Post'), 'id' => 'inputPost', 'required' => true)); ?>
            <?php
            if ($this->Form->isFieldError('Post.post')):
                ?>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                <?php
            endif;
            ?>
        </div>
        <div class='col-sm-2'><small><?php echo $this->Form->error('Post.post', null, array('wrap' => 'label', 'class' => 'error')); ?></small></div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo $this->Form->end(array('label' => __('Add post'), 'class' => 'btn btn-default')); ?>
        </div>
    </div>
</div>
