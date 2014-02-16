<?php

App::uses('AppModel', 'Model');

class User extends AppModel {

    public $name = 'User';
    public $tablePrefix = 'system_';
    
    public $validate = array(
        'name' => array(
            'length' => array(
                'rule' => array('minLength', '3'),
                'message' => 'The name must contain 3 or more characters',
                'allowEmpty' => true
            )
        ),
        'email' => array(
            'isValid' => array(
                'rule' => array('email'),
                'message' => 'The email format is incorrect',
                'allowEmpty' => true
            ),
            'unique' => array(
                'rule' => array('isUnique'),
                'message' => 'This email already exists'
            ),
        ),
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
            ),
            'unique' => array(
                'rule' => array('isUnique'),
                'message' => 'This username already exists'
            ),
            'length' => array(
                'rule' => array('minLength', '5'),
                'message' => 'The username must contain 5 or more characters'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            ),
            'length' => array(
                'rule' => array('minLength', '5'),
                'message' => 'The password must contain 5 or more characters'
            )
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('1', '2', '3', '4', '5')),
                'message' => 'Please enter a valid role'
            )
        )
    );

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }

}