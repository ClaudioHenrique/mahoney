<div class="col-md-4">
    <div class="bs-example widget">
        <h2><?= __('Users'); ?></h2>
        <p>
            <?php
            $userWidgetData = $this->requestAction('/system/users/widgetdata');
            echo __('Total users') . ': <strong>' . $userWidgetData['totalUsers'] . '</strong><br/>';
            echo __('Last user') . ': <strong>' . $this->Html->link(($userWidgetData['lastUser']['User']['name'] != null) ? $userWidgetData['lastUser']['User']['name'] . " | " . $userWidgetData['lastUser']['User']['username'] : $userWidgetData['lastUser']['User']['username'], '/system/users/detail/' . $userWidgetData['lastUser']['User']['id']) . '</strong><br/>';
            ?>
        </p>
        <p><a href="#" onclick="return false;" data-toggle="collapse" data-target="#quickAddContent"><?= __('Quick add user'); ?></a></p>
        <div id="quickAddContent" class="highlight collapse">
            <?php
            $options = array(
                'class' => 'form-horizontal',
                'inputDefaults' => array(
                    'label' => false,
                    'div' => false,
                    'error' => false
                ),
                'url' => '/system/users/add/quick'
            );
            echo $this->Form->create('User', $options);
            ?>
            <div class="form-group <?= $this->Form->isFieldError('User.username') ? 'has-error has-feedback' : ''; ?>">
                <label for="inputUser" class="col-sm-3 control-label"><small><?= __('Username'); ?></small></label>
                <div class="col-sm-9">
                    <?= $this->Form->input('username', array('class' => 'form-control', 'placeholder' => __('Username'), 'id' => 'inputUser')); ?>
                </div>
            </div>
            <div class="form-group <?= $this->Form->isFieldError('User.password') ? 'has-error has-feedback' : ''; ?>">
                <label for="inputPassword" class="col-sm-3 control-label"><small><?= __('Password'); ?></small></label>
                <div class="col-sm-9">
                    <?= $this->Form->input('password', array('class' => 'form-control', 'placeholder' => __('Password'), 'id' => 'inputPassword')); ?>
                </div>
            </div>
            <div class="form-group <?= $this->Form->isFieldError('User.role') ? 'has-error has-feedback' : ''; ?>">
                <label for="inputRole" class="col-sm-3 control-label"><small><?= __('Role'); ?></small></label>
                <div class="col-sm-9">
                    <?php
                    foreach (array_flip(Configure::read("Role")) as $key => $value):
                        if (AuthComponent::user()['role'] < $key):
                            Configure::delete("Role." . $value);
                        endif;
                    endforeach;
                    echo $this->Form->input('role', array(
                        'options' => array_flip(Configure::read("Role")),
                        'class' => 'form-control',
                        'id' => 'inputRole'
                    ));
                    ?>
                    <?php
                    if ($this->Form->isFieldError('User.role')):
                        ?>
                        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        <?php
                    endif;
                    ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <?= $this->Form->end(array('label' => __('Add'), 'class' => 'btn btn-success')); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="highlight">
        <?= $this->HTML->link(__('List users'), array('plugin' => 'system', 'controller' => 'users', 'action' => 'index'), array('class' => 'btn btn-default')); ?> <?= $this->HTML->link(__('Manage roles'), array('plugin' => 'system', 'controller' => 'users', 'action' => 'roles'), array('class' => 'btn btn-default')); ?> <?= $this->HTML->link(__('Add user'), array('plugin' => 'system', 'controller' => 'users', 'action' => 'add'), array('class' => 'btn btn-default')); ?>
    </div>
</div>
<div class="col-md-12">
    <div class="bs-example widget">
        <div class="row">
            <div class="col-md-6">
                <h2><?= __('Activity Log'); ?></h2>
            </div>
            <div class="col-md-6">
                <h2 class="text-right"><input type="text" id="liveSearchActivityLog" class="form-control" placeholder="<?= __('Search'); ?>"></h2>
            </div>
        </div>
        <h6><?= __('Showing the last 100 activities'); ?></h6>
        <?php
        if (!file_exists(LOGS . 'activity.log')):
            ?>
            <p class="text-muted text-center"><?= __('There is no activity yet.'); ?></p>
            <?php
        else:
            ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>
                            Date
                        </th>
                        <th>
                            Activity
                        </th>
                    </tr>
                </thead>
            </table>
            <div class="hightlight logActivity">
                <table class="table table-striped">
                    <tbody>
                        <?php
                        $activityLog = file_get_contents(LOGS . 'activity.log');
                        $activityLog = explode("\n", $activityLog);
                        $activityLog = array_reverse($activityLog);
                        $activityLog = array_slice($activityLog, 0, 100);
                        foreach ($activityLog as $key => $value):
                            if ($value != null && $value != ""):
                                ?>
                                <tr class="
                                <?= (strpos($value, "deleted") > 0 || strpos($value, "deactivated") || strpos($value, "disabled") || strpos($value, "failed") || strpos($value, "fail")) ? "danger" : ""; ?>
                                <?= (strpos($value, "added") || strpos($value, "inserted") || strpos($value, "enabled") > 0) ? "success" : ""; ?>
                                <?= (strpos($value, "request") > 0) ? "info" : ""; ?>
                                    ">
                                    <td>
                                        <?= explode(" Activity: ", $value)[0]; ?>
                                    </td>
                                    <td class="activityCel">
                                        <?php
                                        $pattern = "/\(#(.*)\)/";
                                        if (strpos($value, '(#') !== false):
                                            preg_match($pattern, explode(" Activity: ", $value)[1], $matches);
                                            echo str_replace("#" . $matches[1], $this->Html->link("#" . $matches[1], array('plugin' => 'system', 'controller' => 'users', 'action' => 'detail', $matches[1])), explode(" Activity: ", $value)[1]);
                                        else:
                                            echo explode(" Activity: ", $value)[1];
                                        endif;
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            endif;
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
        endif;
        ?>
    </div>
    <div class="highlight">
        <?= $this->HTML->link(__('Clean Activity Log'), array('plugin' => 'system', 'controller' => 'config', 'action' => 'cleanlog'), array('class' => 'btn btn-default')); ?>
    </div>
</div>