<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.30.10
 * Time: 12:55
 */

namespace app\models;

class Seo extends BaseModel
{
    public $id;

    public $languageId;

    public $mainPageTitle;

    public $mainPageSeoDescription;

    public $mainPageSeoKeywords;

    public function columnMap()
    {
        return [
            'id'                        =>  'id',
            'language_id'               =>  'languageId',
            'main_page_title'           =>  'mainPageTitle',
            'main_page_seo_description' =>  'mainPageSeoDescription',
            'main_page_seo_keywords'    =>  'mainPageSeoKeywords',
        ];

    }

}