<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.11.11
 * Time: 16:14
 */

namespace app\controllers\Admin;

use app\models\Teachers;
use app\models\Languages;
use app\models\System;

class InstructorsController extends BaseController
{
    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();

        $this->assets->addJs('components/ckeditor/ckeditor.js')
            ->addJs('components/AjaxUpload/SimpleAjaxUploader.js')
            ->addJs('js/admin-teachers.js')
            ->addJs('components/lightbox/featherlight.js')
            ->addCss('components/lightbox/featherlight.css');
    }
    
    public function indexAction()
    {
        $this->view->setVar('teachers', Teachers::find());
    }

    public function addAction()
    {
        if ($this->request->isPost()) {

            $teacherData = $this->request->getPost();

            $teacher = new Teachers();

            $teacher->initFromArray($teacherData);

            $createResult = $teacher->create();

            if ($createResult === false) {
                $createResult = $teacher->getValidationMessages();

                $this->view->setVar('errors', $createResult);
            } else {
                $this->response->redirect('/admin/instructors');
            }
        }

        $this->view->setVar('defaultSiteLanguage', System::findFirst()->defaultSiteLanguage);
        $this->view->setVar('languages', Languages::find());
    }
}