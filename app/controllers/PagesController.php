<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.15.11
 * Time: 21:36
 */

namespace app\controllers;

use app\models\Pages;

class PagesController extends BaseController
{
    public function readAction() // TODO : Init SEO data. Do sorting by language
    {
        $pageId =  $this->dispatcher->getParam('id', ['int']);

        $page = Pages::findFirst($pageId);

        if ($page !== false) {
            $this->view->setVar('page', $page);
        } else {
            $this->forwardTo404();
            return false;
        }
    }
    
}