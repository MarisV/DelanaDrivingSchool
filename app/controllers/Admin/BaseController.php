<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.19.10
 * Time: 21:58
 */

namespace app\controllers\Admin;

use Phalcon\Mvc\Controller;
use library\SharedService;
use library\Traits\BaseUrl;

class BaseController extends Controller 
{

    use BaseUrl;

    public function beforeExecuteRoute()
    {
        if (SharedService::isAdminLogged() !== true && $this->dispatcher->getActionName() != 'login' ) {
            $this->response->redirect('/admin/auth/login');
            return false;
        }

        $this->view->setViewsDir(APP_PATH . '/views/admin');

        $this->view->setLayout('admin');

        $this->assets->addCss('css/style.css')
            ->addCss('components/materialize/dist/css/materialize.min.css');

        $this->assets->addJs('components/jquery/dist/jquery.js')->addJs('js/init.js')
            ->addJs('components/materialize/dist/js/materialize.min.js');

        $this->view->setVar('admin', SharedService::getLoggedInAdmin());
    }
}