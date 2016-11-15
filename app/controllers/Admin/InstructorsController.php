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
    }

    
    public function deleteAction()
    {
        $this->view->disable();

        if ($this->request->isAjax() && $this->request->isPost()) {

            $teacherId = $this->request->getPost('teacherId');

            $result = Teachers::find($teacherId)->delete();

            die(json_encode(['result' => $result]));
        }
    }

    public function editAction()
    {
        $teacherId = $this->dispatcher->getParam('teacherId',['int', 'trim']);
        $teacher = Teachers::findFirst($teacherId);

        if ($this->request->isPost()) {

            $teacherData = $this->request->getPost();

            $teacher->initFromArray($teacherData);

            $saveResult = $teacher->save();

            if ($saveResult === false) {
                $saveResult = $teacher->getValidationMessages();

                $this->view->setVar('errors', $saveResult);
            } else {
                $this->response->redirect('/admin/instructors');
            }
        }

        $this->view->setVar('teacher', $teacher);
    }
}