<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Core\Configure;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    protected $textLangCommon;

    protected $lang;

    protected $customerId;

    protected $deviceTypeId;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Common');

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }

    /**
     * Before filter callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->deviceTypeId = $this->Common->getDeviceType($this->request->header('User-Agent'));

        if (isset($this->request->query['lang'])) {
            $this->request->session()->write('lang', $this->request->query['lang']);
        } elseif (!$this->request->session()->check('lang')) {
            $this->request->session()->write('lang', 'vn');
        }
        $this->lang = $this->request->session()->read('lang');
        $this->set('lang', $this->lang);

        //1:PC,2:iPhone,3:android
        if ($this->deviceTypeId == 1) {
            if ($this->lang == 'jp') {
                $this->redirect(Configure::read('Common.domain.jp_url'));
            } else {
                $this->redirect(Configure::read('Common.domain.vn_url'));
            }
        }

        $this->textLangCommon = $this->lang == 'vn' ? '_vn' : '';
        $this->set('textLangCommon', $this->textLangCommon);
        $controller = Router::getRequest()->params['controller'];
        $controller = strtolower($controller);
        $this->set($controller, $this->Common->textForView($controller));
        if($controller == 'logout')
        {
            $this->request->session()->delete('userData');
            $this->redirect('/SearchJob');
        }

        if($this->request->session()->check('userData'))
        {
            $userData = $this->request->session()->read('userData');
            $this->set('userData', $userData);
            $this->customerId = $userData['customer_id'];
        }
    }
}
