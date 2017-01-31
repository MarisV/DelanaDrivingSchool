<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.6.12
 * Time: 19:18
 */

namespace app\controllers;

use app\models\Polls;
use app\models\PollsAnswers;

class PollsController extends BaseController 
{
    public function voteAction()
    {
        $this->view->disable();

        $voteResult = false;
        $pollId = $this->request->getPost('pollId');
        $answerId = $this->request->getPost('answerId', ['int']);

        $poll = Polls::findFirst($pollId);
        $pollsAnswers = new PollsAnswers();

        if ($poll && $answerId != null) {
            $pollAnswerValidationResult = $pollsAnswers->validatePollAnswer($poll, $answerId);

            if ($pollAnswerValidationResult === true) {

                $hash = $pollsAnswers->getVoterHash($pollId);

                $pollsAnswers->answerId = $answerId;
                $pollsAnswers->pollId = $pollId;
                $pollsAnswers->answerHash = $hash;

                $voteResult = $pollsAnswers->create();
            }
        }

        return die(json_encode(['result' => $voteResult]));
    }
}