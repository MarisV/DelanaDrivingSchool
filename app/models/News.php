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
    private function prepareNewDataFromJsonToModel($rawNew)
    {
        $fields =  $this->getModelsMetaData()->getReverseColumnMap($this);

        foreach ($rawNew as $value) {

            $fieldName = $value['name'];
            $fieldValue = $value['value'];

            if(array_key_exists($fieldName, $fields)) {
                $this->$fieldName = $fieldValue;
            }
        }

    }

    /**
     * Overrided method.  Prepare JSON encoded "New" data,
     * and save it.
     *
     * @param mixed $data
     * @param mixed $whiteList
     * @return bool
     */
    public function create($data = null, $whiteList = null)
    {
        $this->prepareNewDataFromJsonToModel($data);
        $this->author = SharedService::getLoggedInAdmin()->username;

        return parent::create();
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

}