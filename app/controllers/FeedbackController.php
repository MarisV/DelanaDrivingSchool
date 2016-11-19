<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.16.11
 * Time: 19:17
 */

namespace app\controllers;

use app\models\Feedback;

class FeedbackController extends BaseController 
{
    public function indexAction()
    {
       
    }

    /**
     * Send feedback message
     */
    public function sendAction()
    {
        if ($this->request->isPost()) {
            $feedbackData = $this->request->getPost();

            $feedback = new Feedback();

            $feedback->initFromArray($feedbackData);

            $result = $feedback->create();

            if ($result === false) {
                $erros = $feedback->getValidationMessages();
                $this->view->setVar('errors', $erros);
            } else {
                $this->view->setVar('success', 'Сообщение успешно отправлено ');
            }

            $this->dispatcher->forward(
                [
                    "action" => "index"
                ]
            );
        }
    }

    public function allAction()
    {
        $feedbackMessages = Feedback::find([
            'order' =>  'commentDate desc'
        ]);

        $this->view->setVar('feedbackMessages', $feedbackMessages);
    }
}