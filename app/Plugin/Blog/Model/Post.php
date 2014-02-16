<?php

App::uses('AppModel', 'Model');

class Post extends AppModel {

    public $useTable = 'blog_posts';
    public $name = 'Post';
    public $belongsTo = array('System.User', 'Blog.Category');

    public function isOwnedBy($post, $user) {
        return $this->field('id', array('id' => $post, 'user_id' => $user)) === $post;
    }

}