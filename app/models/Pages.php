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

    public $orderIndex;

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
            'order_index'       =>  'orderIndex',
            'uri'               =>  'uri'
        ];
    }

    /**
     * Init some field before create record in database
     */
    public function beforeValidationOnCreate()
    {
        $this->dateAdded = date('Y-m-d');

        $pagesCount = Pages::count();

        $this->orderIndex = ($pagesCount == null) ? 1 : $pagesCount + 1;
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
     *  Map page data array to page model object
     *
     * @param array $pageAsArray
     */
    public function initFromArray($pageAsArray)
    {
        $fields =  $this->getModelsMetaData()->getReverseColumnMap($this);

        foreach ($pageAsArray as $field => $value) {

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
                        'title'     =>  'Введите заголовок страницы',
                        'content'   =>  'Введите содержание страницы',
                    ]
                ]
            )
        );

        return $this->validate($validator);
    }

    /**
     * Get validation errors for Pages model
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