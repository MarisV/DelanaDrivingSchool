<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.30.10
 * Time: 12:55
 */

namespace app\models;

class System extends BaseModel
{
    public $id;

    public $mainPageTitle;

    public $mainPageSeoDescription;

    public $mainPageSeoKeywords;

    public $defaultSiteLanguage;


    public function columnMap()
    {
        return [
            'id'                        =>  'id',
            'main_page_title'           =>  'mainPageTitle',
            'main_page_seo_description' =>  'mainPageSeoDescription',
            'main_page_seo_keywords'    =>  'mainPageSeoKeywords',
            'default_site_language'     =>  'defaultSiteLanguage'
        ];

    }

}