<?php

namespace app\controllers;

use app\models\LanguageKeywords;
use app\models\News;
use app\models\Translates;
use library\Helpers\Locale;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class IndexController extends BaseController
{
    const NEWS_PER_PAGE = 15; // TODO: Fix pagination

    public function indexAction()
    {
        $page = $this->request->getQuery('page', ['int']);

        $news = News::find([
            'published =  "on" AND languageId IN (' . Locale::getCurrentAndAllId() . ')',
            'order' =>  'dateAdded desc'
        ]);

        $paginator = new PaginatorModel([
            'data'  =>  $news,
            'limit' =>  self::NEWS_PER_PAGE,
            'page'  =>  $page
        ]);

        $paginationData = $paginator->getPaginate();

        $this->view->setVar('news', $paginationData);
    }

}

