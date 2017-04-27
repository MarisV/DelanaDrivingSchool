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
use library\SharedService;


class NewsController extends BaseController
{
    private $cache;

    const NEWS_PER_PAGE = 12;

    public function beforeExecuteRoute()
    {
        parent::beforeExecuteroute();
    }

    public function indexAction()
    {
        $this->initAssets();

        $page = $this->dispatcher->getParam('page');

        $latestNews = News::find([
            'order'     =>  'dateAdded desc',
        ]);

        $visibleLanguages = Languages::find("visible = 'yes'");

        $paginator = new PaginatorModel([
            'data'  =>  $latestNews,
            'limit' =>  self::NEWS_PER_PAGE,
            'page'  =>  $page
        ]);

        $news = $paginator->getPaginate();

        $this->view->setVar('news', $news);
        $this->view->setVar('languages', $visibleLanguages);
    }



    public function addAction()
    {
        $this->view->disable();

        if (!SharedService::isAdminLogged()) {
            $this->forwardTo404();
            return false;
        }

        $new = $this->request->getPost('new');

        if ($new && $this->request->isAjax()) {

            if ($this->isNewForEdit($new)){

                $newId = $new['nstat'];

                $newToUpdate = News::findFirst($newId);

                $newToUpdate->initFromArray($new);

                $newToUpdate->prepareAuthorAndStatusFields();

                $createResult = $newToUpdate->save();

            } else {

                $newToSave = new News();

                $newToSave->initFromArray($new);

                $newToSave->prepareAuthorAndStatusFields();

                $createResult = $newToSave->create();
            }

            die(json_encode(['result' => $createResult]));
        }
    }

    public function deleteAction()
    {
        $this->view->disable();

        if(!SharedService::isAdminLogged()){
            $this->forwardTo404();
            return false;
        }

        $newId = $this->request->get('newId');

        if($newId && $this->request->isAjax()) {

            $newToDelete = News::findFirst($newId);

            if (!$newToDelete) {
                $deleteResult = 'Извините, произошла ошибка в процессе удаления!';
            } else {
                $newToDelete->deleteNewImage($newToDelete->image);
                $deleteResult = $newToDelete->delete();
            }

            die(json_encode(['result'   =>  $deleteResult]));
        }

    }

    public function getAction()
    {
        $this->view->disable();

        $newId = $this->request->getPost('id');

        $new = News::findFirst($newId);

        die(json_encode(['newresult' => $new]));
    }

    /**
     *  Check whether received new is for editing or adding
     *
     * @param $new
     * @return bool
     */
    private function isNewForEdit(&$new)
    {
        return !empty($new['nstat']);
    }

    private function initAssets()
    {
        $this->assets->addJs('components/ckeditor/ckeditor.js');
        $this->assets->addJs('components/AjaxUpload/SimpleAjaxUploader.js');
        $this->assets->addJs('js/admin-news.js');
    }

}