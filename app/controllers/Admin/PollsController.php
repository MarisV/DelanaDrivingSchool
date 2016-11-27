<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.20.11
 * Time: 00:22
 */

namespace app\controllers\Admin;

use app\models\Polls;
use app\models\PollsAnswers;
use app\models\Languages;

class PollsController extends BaseController
{
    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();

        $this->assets->addJs('js/admin-polls.js')
            ->addJs('components/lightbox/featherlight.js')
            ->addCss('components/lightbox/featherlight.css');

        $visibleLanguages = Languages::find("visible = 'yes'");

        $this->view->setVar('languages', $visibleLanguages);
    }
    
    public function indexAction()
    {
        $activePolls = Polls::find();

        $this->view->setVar('polls', $activePolls);
    }

    public function addAction()
    {
        if ($this->request->isPost()) {

            $pollData = $this->request->getPost();

            $poll = new Polls();

            $poll->initFromArray($pollData);

            $poll->active = (isset($pollData['active']) && $pollData['active'] == 'on') ? 'yes' : 'no';

            $createResult = $poll->create();

            if ($createResult === false) {
                $createResult = $poll->getValidationMessages();

                $this->view->setVar('errors', $createResult);
            } else {
                $this->response->redirect('/admin/polls');
            }
        }
    }

    public function editAction()
    {
        $pollId = $this->dispatcher->getParam('pollId');

        $pollForEdit = Polls::findFirst($pollId);

        $this->view->setVar('poll', $pollForEdit);

        if ($this->request->isPost()) {

            $pollData = $this->request->getPost();

            $pollForEdit->initFromArray($pollData);

            $pollForEdit->active = (isset($pollData['active']) && $pollData['active'] == 'on') ? 'yes' : 'no';

            $saveResult = $pollForEdit->update();

            if ($saveResult === false) {
                $errors = $pollForEdit->getValidationMessages();
                $this->view->setVar('errors', $errors);
            } else {
                $this->response->redirect('/admin/polls');
                return false;
            }
        }

    }

    public function deleteAction()
    {
        $this->view->disable();

        if ($this->request->isPost() && $this->request->isAjax()) {

            $pollId = $this->request->getPost('pollId');

            $poll = Polls::find($pollId);

            $deleteResult = $poll->delete();

            die(json_encode(['result' => $deleteResult]));
        }
    }
}