<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.15.11
 * Time: 21:10
 */

namespace app\controllers;

use app\models\Categories;

class CategoryController extends BaseController
{
    public function readAction() // TODO : Init SEO data. Do sorting by language
    {
        $categoryId = $this->dispatcher->getParam('categoryId');

        $category = Categories::findFirst($categoryId);

        if ($category !== false) {
            $this->view->setVar('category', $category);
        } else {
            $this->forwardTo404();
            return false;
        }
    }
}