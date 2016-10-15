<?php

/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.12.9
 * Time: 20:47
 */

use Phalcon\Mvc\Model;
use library\SharedService;
use library\Utils\Slug;

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

    /**
     *  Map JSON decoded model data to normal model.
     *
     * @param JSON $rawNew
     */
    public function mapDataFromArray($rawNew)
    {
        $fields =  $this->getModelsMetaData()->getReverseColumnMap($this);

        foreach ($rawNew as $field => $value) {

            if(array_key_exists($field, $fields)) {
                $this->$field = $value;
            }
        }

    }

    /**
     * Get link to new
     *
     * @return string
     */
    public function getLink()
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
     * @return mixed
     */
    public function deleteNewImage($filepath)
    {
        $filepath = ltrim($filepath, '/');

        $deleteResult = false;

        if (file_exists($filepath)) {
            $deleteResult = unlink($filepath);
        }

        return $deleteResult;
    }

}