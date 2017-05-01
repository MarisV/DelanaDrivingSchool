<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.16.11
 * Time: 19:18
 */

namespace app\controllers\Admin;

use app\models\Feedback;

class FeedbackController extends BaseController
{
    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();

        $this->assets->addJs('js/admin-feedback.js')
            ->addJs('components/lightbox/featherlight.js')
            ->addCss('components/lightbox/featherlight.css');
    }

    public function indexAction()
    {
        $feedbackMessages = Feedback::find([
            'order' =>  'commentDate desc'
        ]);

        $this->view->setVar('feedbackMessages', $feedbackMessages);
    }

    public function deleteAction()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {
            $feedBackMessageId = $this->request->getPost('feedbackId', ['int']);

            $result = Feedback::findFirst($feedBackMessageId)->delete();

            die(json_encode(['result'   =>  $result]));
        }
    }
}