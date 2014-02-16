<?php
$this->Html->addCrumb(__('Blog'), '/system/blog/posts');
?>
<div class="container">
    <div class="page-header">
        <h1><?php echo __('Blog posts'); ?></h1>
        <p><?php echo __('Edit, Reset, Delete and check out the posts registered in your app blog.'); ?></p>
    </div>
    <?php echo $this->HTML->link(__('Add new post'), array('plugin' => 'blog','controller' => 'posts','action' => 'add'), array('class' => 'btn btn-success')); ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>
                    ID
                </th>
                <th>
                    <?php echo __('Author'); ?>
                </th>
                <th>
                    <?php echo __('Title'); ?>
                </th>
                <th>
                    <?php echo __('Category'); ?>
                </th>
                <th>
                    <?php echo __('Created'); ?>
                </th>
                <th>
                    <?php echo __('Modified'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($posts as $post):
                ?>
            <tr>
                <td>
                    <?php echo $post['Post']['id']; ?>
                </td>
                <td>
                    <?php echo $post['User']['username']; ?>
                </td>
                <td>
                    <?php echo $post['Post']['title']; ?>
                </td>
                <td>
                    <?php echo $post['Category']['name']; ?>
                </td>
                <td>
                    <?php echo $post['Post']['created']; ?>
                </td>
                <td>
                    <?php echo $post['Post']['modified']; ?>
                </td>
            </tr>
                <?php
            endforeach;
            ?>
        </tbody>
    </table>
</div>