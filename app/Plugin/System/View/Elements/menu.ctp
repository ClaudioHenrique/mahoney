<?php
foreach ($mahoneyPlugins as $plugin):
    if ($plugin['active'] && $plugin['menu']):
        foreach ($plugin['menu'] as $key => $value):
            if (is_array($plugin['menu'][$key])):
                ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __(Inflector::humanize($key)); ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php
                        foreach ($plugin['menu'][$key] as $key2 => $value2):
                            if ($key2 == "config"):
                                ?>
                                <li class="divider"></li>
                                    <?php
                                endif;
                                ?>
                            <li><?php echo $this->Html->link(__(Inflector::humanize($key2)), $value2); ?></li>
                            <?php
                        endforeach;
                        ?>
                    </ul>
                </li>
                <?php
            else:
                ?>
                <li><?php echo $this->Html->link(__(Inflector::humanize($key)), $value); ?></li>
            <?php
            endif;
        endforeach;
    endif;
endforeach;
?>