<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.19.10
 * Time: 22:09
 */

namespace app\controllers\Admin;

use app\models\News;
use app\models\Languages;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;


class NewsController extends BaseController
{
    private $cache;

    const NEWS_PER_PAGE = 40;

    public function beforeExecuteRoute()
    {
        parent::beforeExecuteroute();
    }

    public function indexAction()
    {
        $this->assets->addJs('components/ckeditor/ckeditor.js');
        $this->assets->addJs('components/AjaxUpload/SimpleAjaxUploader.js');
        $this->assets->addJs('js/admin-news.js');

        $page = $this->dispatcher->getParam('page');

        $latestNews = News::find([
            'order'     =>  'dateAdded desc',
        ]);

        $visibleLanguages = Languages::find([
            'visible'   =>  'yes',
            'order'     =>  'id desc'
        ]);

        $paginator = new PaginatorModel([
            'data'  =>  $latestNews,
            'limit' =>  self::NEWS_PER_PAGE,
            'page'  =>  $page
        ]);

        $news = $paginator->getPaginate();

        $this->view->setVar('news', $news);
        $this->view->setVar('languages', $visibleLanguages);
    }
}