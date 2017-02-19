<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 17.13.2
 * Time: 22:35
 */

namespace app\models;

class Translates extends BaseModel
{
    public $id;

    public $keywordId;

    public $languageId;

    public $translate;



    /**
     * This model is mapped to the table translates
     */
    public function getSource()
    {
        return "translates";
    }

    /**
     *  Columns mapping
     *
     * @return array
     */
    public function columnMap() : array
    {
        return [
            'id'                    =>  'id',
            'keyword_id'            =>  'keywordId',
            'language_id'           =>  'languageId',
            'translate'             =>  'translate'
        ];
    }
}