<?php
class DATABASE_CONFIG {

	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'prefix' => ''
		//'encoding' => 'utf8',
	);

	public $test = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'user',
		'password' => 'password',
		'database' => 'test_database_name',
		'prefix' => ''
		//'encoding' => 'utf8',
	);
        
        public function __construct() {
            $this->default = array_merge($this->default, Configure::read('App.database'));
	}
}
