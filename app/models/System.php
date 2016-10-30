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
    /**
     *  Record id
     *
     * @var int
     */
    public $id;

    /**
     *  Default site language id
     *
     * @var int
     */
    public $defaultSiteLanguage;


    public function initialize()
    {
        $this->hasOne('default_site_language', 'Languages', 'id');
    }

    /**
     *  Columns mapping
     *
     * @return array
     */
    public function columnMap()
    {
        return [
            'id'                    =>  'id',
            'default_site_language' =>  'defaultSiteLanguage'
        ];
    }

}