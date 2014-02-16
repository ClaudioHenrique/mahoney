<?php
App::import('Controller', 'System.SystemAppController');

class BlogAppController extends SystemAppController {
    
    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->layout = 'Blog.blogDefault';
    }
}