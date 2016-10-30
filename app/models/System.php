<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.30.10
 * Time: 15:32
 */

namespace app\models;


class System extends BaseModel
{

    public $id;

    public $defaultSiteLanguage;


    public function columnMap()
    {
        return [
            'id'                    =>  'id',
            'default_site_language' =>  'defaultSiteLanguage'
        ];
    }

}