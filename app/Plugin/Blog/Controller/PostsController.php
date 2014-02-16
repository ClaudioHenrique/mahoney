<?php

App::uses('Blog.BlogAppController', 'Controller');

class PostsController extends BlogAppController {

    var $uses = array('Blog.Post', 'Blog.Config', 'Blog.Comment', 'Blog.Category', 'Blog.Tag');

    public function isAuthorized($user) {
        if (!parent::isAuthorized($user)) {
            if ($this->action === 'system_add') {
                return true;
            }
            if (in_array($this->action, array('system_edit', 'system_delete'))) {
                $postId = $this->request->params['pass'][0];
                return $this->Post->isOwnedBy($postId, $user['id']);
            }
        }
        return false;
    }

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function system_index() {

        $siteName = "Mahoney";
        $render = "system_index";
        $pageTitle = "Blog | List posts";

        $this->Post->recursive = 0;
        $posts = $this->paginate();

        $this->set(compact('siteName', 'pageTitle', 'posts'));

        try {
            $this->render($render);
        } catch (MissingViewException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }

    public function system_add() {

        $siteName = "Mahoney";
        $render = "system_add";
        $pageTitle = "Blog | Add post";

        $categories = $this->Category->find('list', array('fields' => array('id', 'name')));

        $this->set(compact('siteName', 'pageTitle', 'categories'));

        if ($this->request->is('post')):
            $this->request->data['Post']['user_id'] = $this->Auth->user()['id'];
        endif;

        try {
            $this->render($render);
        } catch (MissingViewException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }

}