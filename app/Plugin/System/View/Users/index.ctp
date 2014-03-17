<?php
$this->Html->addCrumb(__('Users'), array("plugin" => "system", "controller" => "users"));
?>
<div class="container">
    <div class="page-header">
        <h1><?= __('Users'); ?></h1>
        <p><?= __('Edit, Reset, Delete and check out the users registered in your app.'); ?></p>
    </div>
    <?= $this->HTML->link(__('Add new user'), array('plugin' => 'system','controller' => 'users','action' => 'add'), array('class' => 'btn btn-success')); ?>
    <hr/>
    <div class="row">
        <div class="col-sm-2" style="border-right: dotted 1px #ddd;">
            <?php
            $options = array(
                'class' => 'form-horizontal',
                'url' => array("plugin"=>"system", "controller"=>"users", "action"=>"batch"),
                'inputDefaults' => array(
                    'label' => false,
                    'div' => false,
                    'error' => false
                )
            );
            ?>
            <?= $this->Form->create('Batch', $options); ?>
            <?= $this->Form->input("action", array("label"=>"With selected: ", "class" => "form-control", "options" => array("delete" => "Delete"), "empty" => __("Select"))) ?>
            <div class="batch-objects"></div>
            <?= $this->Form->end(); ?>
        </div>
        <?php
            $options = array(
                'class' => 'form-horizontal',
                'type' => 'get',
                'inputDefaults' => array(
                    'label' => false,
                    'div' => false,
                    'error' => false
                )
            );
        ?>
        <?= $this->Form->create('Filter', $options); ?>
        <div class="col-sm-3">
            <?= $this->Form->input("email", array("label" => __("Email:"), "type"=>"text", "class" => "form-control", "value" => (isset($_GET["email"]) ? $_GET["email"] : ""))) ?>
        </div>
        <div class="col-sm-5">
            <?= $this->Form->input("name", array("label" => __("Name:"), "class" => "form-control", "value" => (isset($_GET["name"]) ? $_GET["name"] : ""))) ?>
        </div>
        <div class="col-sm-2 text-right">
            <p>
            <span class="tooltipElement" data-toggle="tooltip" data-original-title="<?= __('Filter posts') ?>"><?= $this->Html->link($this->Form->button('<i class="fa fa-filter"></i> ' . __('Filter'), array('type'=>'submit')), array('plugin' => 'system','controller' => 'users', 'action' => 'index'), array("escape" => false)) ?></span>
            </p>
            <span class="tooltipElement" data-toggle="tooltip" data-original-title="<?= __('Reset filter') ?>"><?= $this->Html->link($this->Form->button('<i class="fa fa-trash-o"></i> ' . __('Reset'), array('type'=>'button')), array('plugin' => 'system','controller' => 'users', 'action' => 'index'), array("escape" => false)) ?></span>
        </div>
    </div>
    <hr/>
    <?= $this->Paginator->numbers(); ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th data-sorter="false">
                    <?= $this->Form->checkbox("BatchAction", array("data-action" => "batch-toggle")); ?>
                </th>
                <th>
                    ID
                </th>
                <th>
                    <?= __('Role'); ?>
                </th>
                <th>
                    <?= __('Name'); ?>
                </th>
                <th>
                    Email
                </th>
                <th>
                    <?= __('Username'); ?>
                </th>
                <th data-sorter="false">
                    <?= __('Edit'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($users as $user):
                ?>
            <tr>
                <td>
                    <?= $this->Form->checkbox("Batch.".$user["User"]["id"], array("data-post" => $user["User"]["id"], "data-target" => "batch")); ?>
                </td>
                <td>
                    <?= $user['User']['id']; ?>
                </td>
                <td>
                    <?= array_flip(Configure::read("Role"))[$user['User']['role']]; ?>
                </td>
                <td>
                    <?= $user['User']['name']; ?>
                </td>
                <td>
                    <?= $user['User']['email']; ?>
                </td>
                <td>
                    <?= $user['User']['username']; ?>
                </td>
                <td>
                    <?php
                    if(AuthComponent::user()['role'] >= $user['User']['role']):
                        ?>
                    <span class="tooltipElement" data-toggle="tooltip" data-original-title="<?= __('Edit') . " " . $user["User"]["username"]; ?>"><?= $this->Html->link($this->Form->button('<i class="fa fa-edit"></i>', array("type"=>"button")), array("plugin"=>"system","controller"=>"users","action"=>"edit", $user['User']['id']), array("escape" => false)); ?></span>
                        <?php
                    endif;
                    ?>
                    <?php 
                    if(AuthComponent::user()['role'] >= $user['User']['role']):
                        if($user['User']['email'] == null):
                            ?>
                            <span class="tooltipElement" data-toggle="tooltip" data-original-title="<?= __('This user requires an email to reset his password'); ?>"><?= $this->Form->button('<i class="fa fa-refresh"></i>', array('class' => 'disabled',"escape" => false)) ?></span>
                            <?php
                        else:
                            ?>
                            <span class="tooltipElement" data-toggle="tooltip" data-original-title="<?= __('Recover password'); ?>"><?= $this->Html->link($this->Form->button('<i class="fa fa-refresh"></i>', array("type"=>"button")), array("plugin"=>"system","controller"=>"users","action"=>"recover", $user['User']['id']), array("escape" => false)) ?></span>
                            <?php
                        endif;
                    endif;
                    ?>
                    <?php
                    if(AuthComponent::user()['role'] >= $user['User']['role']):
                        ?>
                        <span class="tooltipElement" data-toggle="tooltip" data-original-title="<?= __('Delete') . " " . $user["User"]["username"]; ?>"><?= $this->Html->link($this->Form->button('<i class="fa fa-trash-o"></i>', array("type"=>"button")), array('plugin' => 'system','controller' => 'users', 'action' => 'delete', $user['User']['id']), array("escape" => false)) ?></span>
                        <?php
                    endif;
                    ?>
                </td>
            </tr>
                <?php
            endforeach;
            ?>
        </tbody>
    </table>
    <?php
    if(!$users):
    ?>
    <div class="container text-center">
        <span class="tooltipElement" data-toggle="tooltip" data-original-title="<?= __('Add user') ?>"><?= $this->Html->link($this->Form->button('<i class="fa fa-plus"></i>'), array('plugin' => 'system','controller' => 'users', 'action' => 'add'), array("escape" => false)) ?></span>
    </div>
    <?php
    endif;
    ?>
    <hr/>
    <?= $this->HTML->link(__('Add new user'), array('plugin' => 'system','controller' => 'users','action' => 'add'), array('class' => 'btn btn-success')); ?>
    <hr/>
    <?= $this->Paginator->numbers(); ?>
</div>
