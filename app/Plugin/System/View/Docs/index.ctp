<?php
$this->Html->addCrumb(__('Users'), '/system/users');
?>
<div class="container">
    <div class="page-header">
        <h1><?php echo __('Users'); ?></h1>
        <p><?php echo __('Edit, Reset, Delete and check out the users registered in your app.'); ?></p>
    </div>
    <?php echo $this->HTML->link(__('Add new user'), array('plugin' => 'system','controller' => 'users','action' => 'add'), array('class' => 'btn btn-success')); ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>
                    ID
                </th>
                <th>
                    <?php echo __('Role'); ?>
                </th>
                <th>
                    <?php echo __('Name'); ?>
                </th>
                <th>
                    Email
                </th>
                <th>
                    <?php echo __('Username'); ?>
                </th>
                <th data-sorter="false">
                    <?php echo __('Edit'); ?>
                </th>
                <th data-sorter="false">
                    <?php echo __('Reset password'); ?>
                </th>
                <th data-sorter="false">
                    <?php echo __('Delete'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($users as $user):
                ?>
            <tr>
                <td>
                    <?php echo $user['User']['id']; ?>
                </td>
                <td>
                    <?php echo $userRoles[$user['User']['role']]; ?>
                </td>
                <td>
                    <?php echo $user['User']['name']; ?>
                </td>
                <td>
                    <?php echo $user['User']['email']; ?>
                </td>
                <td>
                    <?php echo $user['User']['username']; ?>
                </td>
                <td>
                    <?php
                    if(AuthComponent::user()['role'] >= $user['User']['role']):
                        echo $this->HTML->link(__('Edit'), array('plugin' => 'system','controller' => 'users', 'action' => 'edit', $user['User']['id']));
                    endif;
                    ?>
                </td>
                <td>
                    <?php 
                    if(AuthComponent::user()['role'] >= $user['User']['role']):
                        if($user['User']['email'] == null):
                            ?>
                            <span class="tooltipElement" data-toggle="tooltip" data-original-title="<?php echo __('This user requires an email to reset his password'); ?>"><?php echo __('Reset password'); ?></span>
                            <?php
                        else:
                            echo $this->HTML->link(__('Reset password'), array('plugin' => 'system','controller' => 'users', 'action' => 'reset', $user['User']['id']));
                        endif;
                    endif;
                    ?>
                </td>
                <td>
                    <?php
                    if(AuthComponent::user()['role'] >= $user['User']['role']):
                        echo $this->HTML->link(__('Delete'), array('plugin' => 'system','controller' => 'users', 'action' => 'delete', $user['User']['id']));
                    endif;
                    ?>
                </td>
            </tr>
                <?php
            endforeach;
            ?>
        </tbody>
    </table>
</div>