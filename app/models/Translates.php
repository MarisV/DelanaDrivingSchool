<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 17.13.2
 * Time: 22:35
 */

namespace app\models;


use app\models\BaseModel;
use library\SharedService;

class Translates extends BaseModel
{
    public $id;

    public $keyword;

    public $languageId;

    public $translate;

    /**
     *  Columns mapping
     *
     * @return array
     */
    public function columnMap() : array
    {
        return [
            'id'                    =>  'id',
            'keyword'               =>  'keyword',
            'language_id'           =>  'languageId',
            'translate'             =>  'translate'
        ];
    }

    /**
     *  Load all translations for current language
     *
     * @return array|string
     */
    public static function loadTranslates()
    {
        $cache = SharedService::getCache();

        $cacheKey = 'global-translations-'. LOCALE_ID;

        $translations = $cache->get($cacheKey);

        if (!$translations) {
            $translations = [];

            $translationsData =  self::find([
                'columns'       => 'keyword, translate',
                'conditions'    => 'languageId = ?1',
                'bind'  => [
                    1 => LOCALE_ID
                ]
            ])->toArray();

            if ($translationsData) {
                foreach ($translationsData as $id => $translation) {
                    $translations[$translation['keyword']] = $translation['translate'];
                }
            }

            $cache->set($cacheKey, $translations, 36000);
        }

        return $translations;
    }
}