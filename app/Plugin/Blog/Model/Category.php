<?php

App::uses('AppModel', 'Model');

class Category extends AppModel {

    public $useTable = 'blog_categories';
    public $name = 'Category';
    
    public $validate = array(
        'slug' => array(
            'length' => array(
                'rule' => array('minLength', '3'),
                'message' => 'The name must contain 3 or more characters',
                'allowEmpty' => true
            )
        ),
        'name' => array(
            'length' => array(
                'rule' => array('minLength', '2'),
                'message' => 'The category must contain 2 or more characters',
                'allowEmpty' => true
            ),
            'unique' => array(
                'rule' => array('isUnique'),
                'message' => 'This category already exist'
            )
        )
    );

}