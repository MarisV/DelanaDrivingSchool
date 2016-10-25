<?php

/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.19.10
 * Time: 21:40
 */

namespace app\models;


class Pages extends BaseModel
{

    public $id;

    public $title;

    public $content;

    public $seoTitle;

    public $seoDescription;

    public $seoKeywords;

    public $dateAdded;

    public $languageId;


    public function columnMap()
    {
        return [
            'id'                =>  'id',
            'title'             =>  'title',
            'content'           =>  'content',
            'seo_title'         =>  'seoTitle',
            'seo_description'   =>  'seoDescription',
            'seo_keywords'      =>  'seoKeywords',
            'date_added'        =>  'dateAdded',
            'language_id'       =>  'languageId',
            'order_index'       =>  'orderIndex'
        ];
    }


}