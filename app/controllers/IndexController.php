<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $page = $this->request->getQuery('page', 'int');

        $news = News::find();

        $paginator = new PaginatorModel([
            'data'  =>  $news,
            'limit' =>  15,
            'page'  =>  $page
        ]);

        $paginationData = $paginator->getPaginate();

        $this->view->setVar('news', $paginationData);
    }

}

