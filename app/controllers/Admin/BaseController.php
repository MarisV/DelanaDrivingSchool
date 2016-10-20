<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.19.10
 * Time: 21:58
 */

namespace app\controllers\Admin;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;
use library\SharedService;

class BaseController extends Controller 
{
    public function beforeExecuteRoute()
    {
//        if (SharedService::isAdminLogged() !== true && $this->dispatcher->getActionName() != 'adminlogin' ) {
//            $this->response->redirect('/admin/auth/logout');
//            return false;
//        }

        $this->view->setLayout('admin');
//        $this->view->setRenderLevel(View::LEVEL_LAYOUT);

        $this->view->setVar('admin', SharedService::getLoggedInAdmin());
    }

}