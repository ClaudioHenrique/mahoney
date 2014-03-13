<?php
Router::connect('/system', array('plugin' => 'system', 'controller' => 'dashboard', 'action' => 'index'));
Router::connect('/contact', array('plugin' => 'system', 'controller' => 'contact', 'action' => "index"));