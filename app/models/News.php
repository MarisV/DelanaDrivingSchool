<?php

/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.12.9
 * Time: 20:47
 */

namespace app\models;

use library\SharedService;
use library\Utils\Slug;

class News extends BaseModel
{
    /** @var  int */
    public $id;

    /** @var  string */
    public $title;

    /** @var  string */
    public $shortDescription;

    /** @var  string */
    public $author;

    /** @var  string */
    public $dateAdded;

    /** @var  string */
    public $seoTitle;

    /** @var  string */
    public $seoDescription;

    /** @var  string */
    public $seoKeywords;

    /** @var  string */
    public $languageId;

    /** @var  string */
    public $image;

    /** @var  string */
    public $published;

    const NEWS_PER_PAGE = 15;

    public function columnMap() : array
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

    public  function initialize()
    {
        $this->hasOne('language_id', 'Languages', 'id');
    }


    /**
     * Get link to new
     *
     * @return string
     */
    public function getLink() : string
    {
        return 'news/'.$this->id . '/' . Slug::generate($this->title);
    }

    public function prepareAuthorAndStatusFields()
    {
        $this->author = SharedService::getLoggedInAdmin()->username;
        $this->published = ($this->published == 'true') ? 'on' : 'off';
    }

    /**
     *  Delete article image
     *
     * @param $filepath
     * @return bool
     */
    public function deleteNewImage($filepath) : bool
    {
        $filepath = ltrim($filepath, '/');

        $deleteResult = false;

        if (file_exists($filepath)) {
            $deleteResult = unlink($filepath);
        }

        return $deleteResult;
    }

}