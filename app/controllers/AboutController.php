<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.15.11
 * Time: 22:08
 */

namespace app\controllers;

use app\models\Teachers;

class AboutController extends BaseController
{
    public function beforeExecuteroute()
    {
        parent::beforeExecuteroute();

        $this->assets
            ->addJs('components/lightbox/featherlight.js')
            ->addCss('components/lightbox/featherlight.css');
    }

    public function lecturersAction()
    {
        $lecturers = Teachers::find([
            "profStatus = ?1",
            "bind" => [
                1 => Teachers::LECTURER
            ],
        ]);

        $this->view->setVar('lecturers', $lecturers);
    }

    public function instructorsAction()
    {
        $instructors = Teachers::find([
            "profStatus = ?1",
            "bind" => [
                1 => Teachers::INSTRUCTOR
            ],
        ]);

        $this->view->setVar('instructors', $instructors);
    }

    public function lecturerAction()
    {
        $id = $this->dispatcher->getParam('id');

        $lecturer = Teachers::findFirst($id);

        if ($lecturer !== false) {
            $this->view->setVar('lecturer', $lecturer);
        } else {
            $this->forwardTo404();
            return false;
        }
    }

    public function instructorAction()
    {
        $id = $this->dispatcher->getParam('id');

        $instructor = Teachers::findFirst($id);

        if ($instructor !== false) {
            $this->view->setVar('instructor', $instructor);
        } else {
            $this->forwardTo404();
            return false;
        }
    }
}