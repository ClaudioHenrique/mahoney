<?php

App::uses('AppModel', 'Model');

class Tag extends AppModel {
    
    public $useTable = 'blog_tags';
    public $name = 'Tags';
    public $belongsTo = array('Blog.Post');
}