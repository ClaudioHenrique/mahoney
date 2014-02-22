<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $uses = array();
    public $components = array(
        'System.Plugin',
        'Session',
        'Cookie',
        'Auth' => array(
            'loginRedirect' => array(
                'plugin' => 'system',
                'controller' => '',
                'action' => 'index'
            ),
            'logoutRedirect' => array(
                'plugin' => false,
                'controller' => 'site',
                'action' => 'index'
            ),
            'loginAction' => array(
                'controller' => '',
                'action' => 'index',
                'plugin' => 'system'
            ),
            'unauthorizedRedirect' => array(
                'plugin' => false,
                'controller' => 'site',
                'action' => 'index'
            ),
            'loginError' => 'Oops. Wrong credentials',
            'authError' => 'Did you really think you are allowed to see that?',
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'System.User'
                )
            ),
            'authorize' => array('Controller')
        )
    );

    function beforeRender() {
        if ($this->Session->check('Message.flash')) {
            $flash = $this->Session->read('Message.flash');

            if ($flash['element'] == 'default') {
                $flash['element'] = 'flashError';
                $this->Session->write('Message.flash', $flash);
            }
        }
    }

    function beforeFilter() {
        if (!file_exists(APP . 'Config' . DS . 'installed') && $this->params['controller'] != 'install' && $this->params['action'] != 'db'):
            $this->redirect('/install');
        endif;
        if (file_exists(APP . 'Config' . DS . 'installed')):
            $siteOptions = array();
            $this->uses = array("System.Config");
            foreach ($this->Config->find('all') as $key => $value):
                if($value["Config"]["section"] == "siteinfo")
                $siteOptions[$value["Config"]["type"]] = $value["Config"]["value"];
            endforeach;
            $this->set('appOptions', $siteOptions);
        endif;
        if($this->Auth->user()):
            $this->Plugin->getPlugins();
            $this->set('mahoneyPlugins', $this->Plugin->PLUGINS);
        endif;
        $this->set('authUser', $this->Auth->user());
    }

    public function isAuthorized($user) {
        if (isset($user['role']) && $user['role'] >= '4') {
            return true;
        }
        return false;
    }

}
