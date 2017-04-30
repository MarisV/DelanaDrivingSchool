<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 17.30.4
 * Time: 15:57
 */

namespace app\models;


class LanguageKeywords extends BaseModel
{
    /**
     *  Keyword id
     *
     * @var int
     */
    public $id;

    /**
     *  Keyword to translate
     *
     * @var string
     */
    public $keyword;

    public function getSource()
    {
        return 'language_keywords';
    }


    public function insertKeyword($keyword)
    {
        $keywordFromDatabase = self::findFirstByKeyword($keyword);

        if ($keywordFromDatabase === false) {
            $obj = new self();
            $obj->keyword = $keyword;
            $obj->create();
        }
    }
}