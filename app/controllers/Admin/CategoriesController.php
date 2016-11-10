<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.23.10
 * Time: 21:49
 */

namespace app\controllers\Admin;

use app\models\Categories;
use app\models\Languages;

class CategoriesController extends BaseController
{
    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();

        $this->assets->addJs('components/ckeditor/ckeditor.js');
        $this->assets->addJs('js/admin-categories.js');

        $langsMap = [];

        $visibleLanguages = Languages::find("visible = 'yes'");

        foreach ($visibleLanguages as $lang) {
            $langsMap[$lang->id] = $lang->name;
        }

        $this->view->setVar('langsMap', $langsMap);
        $this->view->setVar('languages', $visibleLanguages);
    }

    public function indexAction()
    {
        $allCategories = Categories::find();

        $this->view->setVar('categories', $allCategories);
    }

    public function addAction()
    {
        if ($this->request->isPost()) {

            $newCategory = $this->request->getPost();

            $category = new Categories();

            $category->initFromArray($newCategory);

            $result = $category->create();

            if ($result === false) {
                $errors = $category->getValidationMessages();
                $this->view->setVar('errors', $errors);
            } else {
                $this->response->redirect('/admin/categories');
                return false;
            }
        }
    }

    public function deleteAction()
    {
        $this->view->disable();

        $categoryId = $this->request->getPost('categoryId');

        $result = Categories::findFirst($categoryId)->delete();

        die(json_encode(['result' => $result]));
    }

    public function editAction()
    {
        $categoryId = $this->dispatcher->getParam('categoryId');
        $category = Categories::findFirst($categoryId);

        if ($this->request->isPost()) {

            $categoryData = $this->request->getPost();

            $categoryData['id'] = $categoryId;

            $category->initFromArray($categoryData);

            $result =  $category->save();

            if ($result === false) {
                $errors = $category->getValidationMessages();
                $this->view->setVar('errors', $errors);
            } else {
                $this->response->redirect('/admin/categories');
                return false;
            }
        }

        $this->view->setVar('category', $category);
    }
}