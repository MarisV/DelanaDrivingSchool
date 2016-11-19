<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.19.11
 * Time: 23:20
 */

namespace app\controllers\Admin;

use app\models\Course;

class CoursesController extends BaseController
{
    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();

        $this->assets->addJs('js/admin-courses.js')
            ->addJs('components/lightbox/featherlight.js')
            ->addCss('components/lightbox/featherlight.css');
    }

    /**
     *  List of applications for courses
     */
    public function applicationsAction()
    {
        $allApplications = Course::find();

        $this->view->setVar('courses', $allApplications);
    }

    /**
     * Delete application for course by id
     */
    public function deleteApplicationAction()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {

            $applicationId = $this->request->getPost('applicationId',['trim']);

            $deleteResult = Course::findFirst($applicationId)->delete();

            die(json_encode(['result'   =>  $deleteResult]));
        }
    }
}