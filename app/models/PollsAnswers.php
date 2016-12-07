<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.6.12
 * Time: 20:12
 */

namespace app\models;

use app\models\BaseModel;
use app\models\Polls;
use library\SharedService;


class PollsAnswers extends BaseModel
{
    public $id;

    public $pollId;

    public $answerId;

    public $answerHash;

    public function columnMap()
    {
        return [
            'id'            =>  'id',
            'poll_id'       =>  'pollId',
            'answer_id'     =>  'answerId',
            'answer_hash'   =>  'answerHash'
        ];
    }

    /**
     * @param \app\models\Polls $poll
     * @param int $answerId
     * @return bool
     */
    public function validatePollAnswer(Polls $poll, int $answerId) : bool
    {
        $result = false;
        $availableAnswers = unserialize($poll->answers);

        if (in_array($answerId, array_keys($availableAnswers))) {
            $result = true;
        }

        $hash = $this->getVoterHash($poll->id);

        if ($this->getIsVotedByHash($hash) === true) {
            $result = false; // Already voted
        }

        return $result;
    }

    /**
     *  Get voter hash
     *
     * @param int $pollId
     * @param int $answerId
     * @return string
     */
    public function getVoterHash(int $pollId) : string
    {
        /** @var  $request \Phalcon\Http\Request */
        $request = SharedService::getRequest();

        $ipAddress = $request->getClientAddress();
        $userAgent = $request->getUserAgent();

        $str = $ipAddress . '-' . $userAgent . '-' . $pollId;

        $hash = md5(md5(md5($str)));

        return $hash;
    }

    public function getIsVotedByHash(string $hash)
    {
        $vote = self::findFirstByAnswerHash($hash);

        if ($vote !== false) {
            return $vote->answerHash === $hash;
        }

        return false;
    }
    
}