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


class Pages extends BaseModel
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

    /** @var  int */
    public $orderIndex;

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
     *
     * @return mixed
     */
    public function getValidationMessages() : array
    {
        $errorMessages = $this->getMessages();

        foreach ($errorMessages as $message) {
            $result[$message->getField()] = $message->getMessage();
        }

        return $result;
    }

    /**
     * Update pages positions
     *
     * @param $positions
     * @return bool
     */
    public static function updatePagesPositions(array  $positions) : bool
    {
        $pages = self::find();

        $positionsCounter = 0;
        /** @var  $page Pages*/
        foreach ($pages as $page) {
            $page->orderIndex = $positions[$positionsCounter];
            $page->save();
            $positionsCounter++;
        }

        return true;
    }

    /**
     * Extract pages order positions from request string
     *
     * @param $positionsString
     * @return array
     */
    public static function getOrderPositionsFromString(string $positionsString) : array
    {
        $positions = [];

        if (!empty($positionsString)) {

            $firstDivide = explode('&', $positionsString);

            foreach ($firstDivide as $value) {
                $positions[] = explode('=', $value)[1];
            }
        }

        return $positions;
    }

}