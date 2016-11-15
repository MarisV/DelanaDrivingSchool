<?php

/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.19.10
 * Time: 21:40
 */

namespace app\models;

use library\Utils\Slug;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;


class Categories extends BaseModel
{

    /** @var  int */
    public $id;

    /** @var  string */
    public $title;

    /** @var  string */
    public $content;

    /** @var  string */
    public $seoTitle;

    /** @var  string */
    public $seoDescription;

    /** @var  string */
    public $seoKeywords;

    /** @var  string */
    public $dateAdded;

    /** @var  int */
    public $languageId;

    /** @var  string */
    public $uri;


    public function columnMap() : array
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
            'uri'               =>  'uri'
        ];
    }

    /**
     * Init some field before create record in database
     */
    public function beforeValidationOnCreate()
    {
        $this->dateAdded = date('Y-m-d');

        $this->uri = Slug::generate($this->title);
    }

    /**
     * Init some settings
     */
    public function initialize(){
        $this->setup(
            array('notNullValidations'=>false)
        );
    }

    /**
     *  Map page data array to cateogory model object
     *
     * @param array $categoryAsArray
     */
    /*public function initFromArray($categoryAsArray)
    {
        $fields =  $this->getModelsMetaData()->getReverseColumnMap($this);

        foreach ($categoryAsArray as $field => $value) {

            if (array_key_exists($field, $fields)) {
                $this->$field = $value;
            }
        }
    }*/


    /**
     *  Validation rules for Pages model
     *
     * @return bool
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            ['title', 'content'],
            new PresenceOf(
                [
                    'message' => [
                        'title'     =>  'Введите название категории',
                        'content'   =>  'Введите описание категории',
                    ]
                ]
            )
        );

        return $this->validate($validator);
    }

    /**
     * Get validation errors for Categories model
     *
     * @return mixed
     */
    public function getValidationMessages()
    {
        $errorMessages = $this->getMessages();

        foreach ($errorMessages as $message) {
            $result[$message->getField()] = $message->getMessage();
        }

        return $result;
    }

    public static function getCategoriesForMainPageWidgets() : array
    {
        $categories = self::find();

        $result = [];

        if ($categories) {
            foreach ($categories as $category) {
                $result[] = [
                    'title' =>  $category->title,
                    'href'  =>  '/category/'.$category->id . '/'.$category->uri
                ];
            }
        }

        return $result;
    }

}