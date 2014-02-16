<?php

App::uses('AppModel', 'Model');

class Comment extends AppModel {
    
    public $useTable = 'blog_comments';
    public $name = 'Comment';
    public $belongsTo = array('System.User', 'Blog.Post');
}