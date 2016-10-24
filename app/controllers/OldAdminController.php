<?php

/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.12.9
 * Time: 21:17
 */

use Phalcon\Mvc\View;
use library\SharedService;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class AdminController extends ControllerBase
{
    private $cache;

    const NEWS_PER_PAGE = 40;

    public function beforeExecuteRoute()
    {
        parent::beforeExecuteroute();

        if (SharedService::isAdminLogged() !== true && $this->dispatcher->getActionName() != 'adminlogin' ) {
            $this->response->redirect('/admin/auth/login');
            return false;
        }

        $this->view->setLayout('admin');
        $this->view->setRenderLevel(View::LEVEL_LAYOUT);

        $this->cache = SharedService::getCache();
        $this->view->setVar('admin', SharedService::getLoggedInAdmin());
    }

    public function indexAction()
    {
        $this->dispatcher->forward(['controller' => 'admin', 'action' => 'news']);
        return false;
    }

}