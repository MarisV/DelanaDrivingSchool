<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.15.11
 * Time: 19:57
 */

namespace app\controllers;

use app\models\News;

class NewsController extends BaseController
{
    /**
     *  Perform new display
     */
    public function readAction() // TODO : Init SEO data.
    {
        $newId = $this->dispatcher->getParam('id', ['int']);

        $new = News::findFirst($newId);

        if ($new !== false && $new->published == 'on') {

            $this->view->setVars([
                'metaTitle'         =>  $new->seoTitle,
                'metaKeywords'      =>  $new->seoKeywords,
                'metaDescription'    =>  $new->seoDescription
            ]);

            $this->view->setVar('new', $new);
        } else {
            $this->forwardTo404();
            return false;
        }
    }
}