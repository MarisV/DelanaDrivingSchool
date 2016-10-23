<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.23.10
 * Time: 21:49
 */

namespace app\controllers\Admin;


use app\models\Pages;

class PagesController extends BaseController
{
    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();

        $this->assets->addJs('js/admin-pages.js');
    }

    public function indexAction()
    {
        $allPages = Pages::find();

        $this->view->setVar('pages', $allPages);
    }
}