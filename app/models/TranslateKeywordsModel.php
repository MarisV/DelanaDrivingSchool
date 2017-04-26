<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 17.19.2
 * Time: 19:00
 */

namespace app\models;


use library\SharedService;

class TranslateKeywordsModel extends BaseModel
{
    /**
     *  Keyword id
     *
     * @var int
     */
    public $id;

    /**
     *  Keyword
     *
     * @var string
     */
    public $keyword;

    /**
     *  Translates cache key
     */
    const TRANSLATES_CACHE_KEY = 'global-translations'.LOCALE_ID;

    /**
     * This model is mapped to the table translate_keywords
     */
    public function getSource()
    {
        return "translate_keywords";
    }


    /**
     *  Columns mapping
     *
     * @return array
     */
    public function columnMap() : array
    {
        return [
            'id'        =>  'id',
            'keyword'   =>  'keyword'
        ];
    }


}