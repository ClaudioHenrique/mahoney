<?php
App::uses('AppModel', 'Model');

class Token extends AppModel {
    
    public $tablePrefix = "system_";
    public $name = 'Token';
    
    public $belongsTo = array("System.User");

}