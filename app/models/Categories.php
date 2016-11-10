<?php

/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.19.10
 * Time: 21:40
 */

namespace app\models;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\PresenceOf;

use library\Utils\Slug;

class Categories extends BaseModel
{

    public $id;

    public $title;

    public $content;

    public $seoTitle;

    public $seoDescription;

    public $seoKeywords;

    public $dateAdded;

    public $languageId;

    public $uri;


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
    public function initFromArray($categoryAsArray)
    {
        $fields =  $this->getModelsMetaData()->getReverseColumnMap($this);

        foreach ($categoryAsArray as $field => $value) {

            if (array_key_exists($field, $fields)) {
                $this->$field = $value;
            }
        }
    }


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

}