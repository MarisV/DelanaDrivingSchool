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
    /**
     * Record id
     *
     * @var int
     */
    public $id;

    /**
     *  SEO setting language id
     *
     * @var int
     */
    public $languageId;

    /**
     *  Main page title
     *
     * @var string
     */
    public $mainPageTitle;

    /**
     *  Main page SEO description
     *
     * @var string
     */
    public $mainPageSeoDescription;

    /**
     *  main page SEO keywords
     *
     * @var string
     */
    public $mainPageSeoKeywords;

    /**
     *  Columns mapping
     *
     * @return array
     */
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