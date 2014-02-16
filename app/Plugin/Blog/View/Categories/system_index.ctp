<?php
$this->Html->addCrumb(__('Blog'), '/system/blog/posts');
$this->Html->addCrumb(__('Categories'), '/system/blog/categories');
?>
<div class="container">
    <div class="globalTop">
        <div class="container">
            <div class="page-header">
                <h1><?php echo __("Add"); ?></h1>
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
        echo $this->Form->create('Category', $options);
        ?>
        <div class="form-group <?php echo $this->Form->isFieldError('Category.parent') ? 'has-error has-feedback' : ''; ?>">
            <label for="inputParent" class="col-sm-2 control-label"><?php echo __('Parent'); ?></label>
            <div class="col-sm-3">
                <?php
                echo $this->Form->input('parent', array(
                    'options' => $categories,
                    'class' => 'form-control',
                    'id' => 'inputParent',
                    'empty' => 'none'
                ));
                ?>
                <?php
                if ($this->Form->isFieldError('Category.parent')):
                    ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <?php
                endif;
                ?>
            </div>
            <div class='col-sm-7'><small><?php echo $this->Form->error('Category.parent', null, array('wrap' => 'label', 'class' => 'error')); ?></small></div>
        </div>
        <div class="form-group <?php echo $this->Form->isFieldError('Category.name') ? 'has-error has-feedback' : ''; ?>">
            <label for="inputName" class="col-sm-2 control-label"><?php echo __('Category'); ?></label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => __('Category'), 'id' => 'inputName', 'required' => true, 'type' => 'text')); ?>
                <?php
                if ($this->Form->isFieldError('Category.name')):
                    ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <?php
                endif;
                ?>
            </div>
            <div class='col-sm-2'><small><?php echo $this->Form->error('Category.name', null, array('wrap' => 'label', 'class' => 'error')); ?></small></div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?php echo $this->Form->end(array('label' => __('Add category'), 'class' => 'btn btn-default')); ?>
            </div>
        </div>
    </div>
    <div class="page-header">
        <h1><?php echo __('Categories'); ?></h1>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>
                    ID
                </th>
                <th>
                    <?php echo __('Category'); ?>
                </th>
                <th>
                    <?php echo __('Parent'); ?>
                </th>
                <th>
                    <?php echo __('Edit'); ?>
                </th>
                <th>
                    <?php echo __('Delete'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($categoryList as $category):
                ?>
                <tr>
                    <td>
                        <?php echo $category['Category']['id']; ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($category['Category']['name'], '/blog/categories/' . Inflector::slug($category['Category']['name'])); ?>
                    </td>
                    <td>
                        <?php
                        if (isset($categories[$category['Category']['parent']])):
                            echo $categories[$category['Category']['parent']];
                        else:
                            echo "-";
                        endif;
                        ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link(__('Edit'), array('plugin' => 'blog', 'controller' => 'categories', 'action' => 'edit', $category['Category']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link(__('Delete'), array('plugin' => 'blog', 'controller' => 'categories', 'action' => 'delete', $category['Category']['id'])); ?>
                    </td>
                </tr>
                <?php
            endforeach;
            ?>
        </tbody>
    </table>
</div>