<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.30.10
 * Time: 15:32
 */

namespace app\models;

use library\SharedService;
use app\models\Languages;

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
    public function columnMap() : array
    {
        return [
            'id'                    =>  'id',
            'default_site_language' =>  'defaultSiteLanguage'
        ];
    }

    /**
     * Get default language code or selecte before
     *
     * @return string
     */
    public static function getSelectedBeforeOrDefaultSiteLanguage() : string
    {
        $cookies = SharedService::getCookies();

        if ($cookies->has('lang')) {
            $languageId = $cookies->get('lang');
        } else {
            $languageId = self::findFirst()->id;
        }

        $language = Languages::findFirst('id = '. $languageId);

        return $language->code;
    }

}