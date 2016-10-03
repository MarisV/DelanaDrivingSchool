<?php

/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.12.9
 * Time: 20:47
 */

use Phalcon\Mvc\Model;

class News extends Model
{
    public $id;

    public $title;

    public $shortDescription;

    public $author;

    public $dateAdded;

    public $seoTitle;

    public $seoDescription;

    public $seoKeywords;

    public $languageId;

    public $image;

    public $published;

    public function columnMap()
    {
        return [
            'id'                =>  'id',
            'title'             =>  'title',
            'short_description' =>  'shortDescription',
            'full_description'  =>  'fullDescription',
            'author'            =>  'author',
            'date_added'        =>  'dateAdded',
            'seo_title'         =>  'seoTitle',
            'seo_description'   =>  'seoDescription',
            'seo_keywords'      =>  'seoKeywords',
            'language_id'       =>  'languageId',
            'image'             =>  'image',
            'published'         =>  'published'
        ];
    }

    public function initialize()
    {
        $this->hasOne('language_id', 'Languages', 'id');
    }

}