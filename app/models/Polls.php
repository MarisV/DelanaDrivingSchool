<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.22.11
 * Time: 19:53
 */

namespace app\models;


class Polls extends BaseModel
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $question;

    /**
     * @var int
     */
    public $languageId;

    /**
     * @var string
     */
    public $active;

    /**
     * @var string
     */
    public $answers;

    public function columnMap()
    {
        return [
            'id'            =>  'id',
            'question'      =>  'question',
            'language_id'   =>  'languageId',
            'active'        =>  'active',
            'answers'       =>  'answers'
        ];
    }

    public function initialize()
    {
        $this->hasOne('languageId', 'app\models\Languages', 'id');
    }

    public function afterValidation()
    {
        $this->answers = serialize($this->answers);
    }


}