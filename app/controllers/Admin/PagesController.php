<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.23.10
 * Time: 21:49
 */

namespace app\controllers\Admin;


use app\models\Pages;
use app\models\Languages;

class PagesController extends BaseController
{
    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();

        $this->assets->addJs('components/ckeditor/ckeditor.js');
        $this->assets->addJs('js/admin-pages.js');

        $langsMap = [];

        $visibleLanguages = Languages::find([
            'visible'   =>  'yes',
            'order'     =>  'id desc'
        ]);

        foreach ($visibleLanguages as $lang) {
            $langsMap[$lang->id] = $lang->name;
        }

        $this->view->setVar('langsMap', $langsMap);
        $this->view->setVar('languages', $visibleLanguages);
    }

    public function indexAction()
    {

        $allPages = Pages::find();
        $this->view->setVar('pages', $allPages);
    }

    public function addAction()
    {
        if ($this->request->isPost()) {

            $newPage = $this->request->getPost();

            $page = new Pages();

            $page->initFromArray($newPage);

            $result = $page->create();

            if ($result === false) {
                $result = $page->getValidationMessages();
                die(json_encode(['result' => $result]));
            }

            $this->response->redirect('/admin/pages');
            return false;

        }
    }

    public function deleteAction()
    {
        $this->view->disable();

        $pageId = $this->request->getPost('pageId');

        $result = Pages::findFirst($pageId)->delete();

        die(json_encode(['result' => $result]));
    }

    public function editAction()
    {
        $pageId = $this->dispatcher->getParam('pageid');

        $page = Pages::findFirst($pageId);

        if ($this->request->isPost()) {

            $pageData = $this->request->getPost();

            $pageData['id'] = $pageId;

            $page->initFromArray($pageData);

            $result =  $page->save();

            if ($result === false) {
                $result = $page->getValidationMessages();
                die(json_encode(['result' => $result]));
            }

            $this->response->redirect('/admin/pages');
            return false;

        }

        $this->view->setVar('page', $page);
    }
}