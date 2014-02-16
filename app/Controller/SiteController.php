<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('AppController', 'Controller');
App::uses('Migrations', 'Vendor');
App::uses('Fixtures', 'Vendor');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class SiteController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }
    
    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = array();

    /**
     * Displays a view
     *
     * @param mixed What page to display
     * @return void
     * @throws NotFoundException When the view file could not be found
     * 	or MissingViewException in debug mode.
     */
    public function index() {
        
//        $render = "index";
        $siteName = "Mahoney";
        $pageTitle = "Welcome";
        
        $this->set(compact('siteName', 'pageTitle'));
        
//        $migrations = new Migrations();
//        $migrations->load(APP . 'plugin' . DS . 'System' . DS . 'Config' . DS . 'Migrations' . DS . '001_base.yml');
//        $migrations->down();
//        $migrations->up();
//        $migrations->load(APP . 'plugin' . DS . 'Blog' . DS . 'Config' . DS . 'Migrations' . DS . '001_base.yml');
//        $migrations->down();
//        $migrations->up();
//        $migrations->load(APP . 'plugin' . DS . 'Photograph' . DS . 'Config' . DS . 'Migrations' . DS . '001_base.yml');
//        $migrations->down();
//        $migrations->up();
//        
//        $oFixtures = new Fixtures(); 
//        $oFixtures->import(APP . 'plugin' . DS . 'System' . DS . 'Config' . DS . 'Fixtures' . DS . '001_base.yml');
//        $oFixtures->import(APP . 'plugin' . DS . 'Photograph' . DS . 'Config' . DS . 'Fixtures' . DS . '001_base.yml');
//        $oFixtures->import(APP . 'plugin' . DS . 'Blog' . DS . 'Config' . DS . 'Fixtures' . DS . '001_base.yml');
        
//        try {
//            $this->render($render);
//        } catch (MissingViewException $e) {
//            if (Configure::read('debug')) {
//                throw $e;
//            }
//            throw new NotFoundException();
//        }
    }

}
