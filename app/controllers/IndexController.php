<?php

namespace app\controllers;

use app\models\News;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class IndexController extends BaseController
{
    const NEWS_PER_PAGE = 15; // TODO: Fix pagination

    public function indexAction()
    {
        $page = $this->request->getQuery('page', 'int');

        $news = News::find([
            "published =  'on'",
            'order' =>  'dateAdded desc'
        ]);

        $paginator = new PaginatorModel([
            'data'  =>  $news,
            'limit' =>  News::NEWS_PER_PAGE,
            'page'  =>  $page
        ]);

        $paginationData = $paginator->getPaginate();

        $this->view->setVar('news', $paginationData);
    }

}

