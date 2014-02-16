<?php
App::uses('Blog.BlogAppController', 'Controller');

class CategoriesController extends BlogAppController {
    
    var $uses = array('Blog.Category');
    
    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function index($category = null) {
        
        $siteName = "Mahoney";
        $render = "index";
        $pageTitle = "Blog | Category";
        
    }
    
    public function system_edit($id = null) {
        $siteName = "Mahoney";
        $pageTitle = "Blog | Add category";
        $categories = $this->Category->find('list', array('fields' => array('id', 'name')));
        
        $this->set(compact('siteName','pageTitle','categories'));
        
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Category->save($this->request->data)) {
                CakeLog::write('activity', '[BLOG] ' . $this->Auth->user()['username'] . ' edited the category ' . $this->request->data['Category']['name']);
                $this->Session->setFlash(__('The category has been saved'));
            } else {
                $this->Session->setFlash(__('The category could not be saved. Please, try again.'));
            }
            $this->redirect($this->referer());
        } else {
            $this->request->data = $this->Category->read(null, $id);
        }
    }
    
    public function system_delete($id = null) {
        if ($this->request->is('post')):
            throw new MethodNotAllowedException();
        endif;
        $this->Category->id = $id;
        if (!$this->Category->exists()):
            throw new NotFoundException(__('Invalid category'));
        endif;
        if ($this->Category->delete()):
            CakeLog::write('activity', $this->Auth->user()['username'] . ' deleted an existing category.');
            $this->Session->setFlash(__('Category deleted'));
        else:
            $this->Session->setFlash(__('Category was not deleted'));
        endif;
        $this->redirect($this->referer());
    }
    
    public function system_index(){
        
        $siteName = "Mahoney";
        $render = "system_index";
        $pageTitle = "Blog | Add category";
        
        if($this->request->is('post')):
            $this->Category->create();
            if($this->Category->save($this->request->data)):
                $this->Session->setFlash(__('Category saved'));
                CakeLog::write('activity', $this->Auth->user()['username'] . ' added a new category: ' . $this->request->data['Category']['name']);
            else:
                $this->Session->setFlash(__('Cannot save the specified category'));
            endif;
        endif;
        
        $categories = $this->Category->find('list', array('fields' => array('id', 'name')));
        
        $this->Category->recursive = 0;
        $categoryList = $this->paginate();
        
        $this->set(compact('siteName','pageTitle','categories','categoryList'));
        
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