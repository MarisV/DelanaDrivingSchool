<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 17.30.4
 * Time: 15:54
 */

namespace app\models;


use library\SharedService;

class LanguageTranslate extends BaseModel
{
    /**
     *  Keyword id
     *
     * @var int
     */
    public $id;

    /**
     *  Language id
     *
     * @var int
     */
    public $languageId;

    /**
     *  Translate
     *
     * @var string
     */
    public $keyword;

    const GLOBAL_TRANSLATES_CACHE = 'global-translations-';

    public function columnMap()
    {
        return [
            'id'            =>  'id',
            'language_id'   =>  'languageId',
            'keyword'       =>  'keyword'
        ];
    }


    /**
     *  Load all translations
     *
     * @return array
     */
    public function loadTranslates(int $languageId = null) : array
    {
        if ($languageId !== null) {
            $languageExists = Languages::findFirst($languageId);
            if ($languageExists === false){
                $languageIdToLoad = LOCALE_ID;
            } else {
                $languageIdToLoad = $languageId;
            }
        } else {
            $languageIdToLoad = LOCALE_ID;
        }

        $cache = SharedService::getCache();
        $translations = $cache->get(self::GLOBAL_TRANSLATES_CACHE.$languageIdToLoad);

        if (!$translations) {

            $sth = $this->getPdo()->prepare(
                'SELECT k.keyword, IF(t.keyword != \'\', t.keyword, k.keyword) AS translate
                  FROM language_keywords AS k
                  LEFT JOIN language_translate AS t
                    ON k.id = t.id AND t.language_id = :langid');

            $sth->execute(array(
                ':langid' => $languageIdToLoad
            ));

            $translations = array();

            while ($row = $sth->fetch()) {
                $translations[$row['keyword']] = html_entity_decode($row['translate'], ENT_QUOTES, 'utf-8');
            }

           $cache->set('global-translations', $translations);
        }

        return $translations;
    }

    /**
     *  Update existing translate or inesrt new
     *
     * @param int $keywordId
     * @param int $languageId
     * @param string $newTranslate
     * @return bool
     */
    public function updateTranslate(int $keywordId, int $languageId, string $newTranslate) : bool
    {
        $existingTranslate = self::findFirst([
            'conditions' => 'id = '.$keywordId.' AND languageId = '. $languageId
        ]);

        if ($existingTranslate === false) {
            $result = $this->insertTranslate($keywordId, $languageId, $newTranslate);
        } else {
            $existingTranslate->keyword = $newTranslate;
            $result = $existingTranslate->save();
        }

        return $result;
    }

    /**
     *  Insery new translate
     *
     * @param int $keywordId
     * @param int $languageId
     * @param string $newTranslate
     * @return bool
     */
    public function insertTranslate(int $keywordId, int $languageId, string $newTranslate) : bool
    {
        $translateObject = new self();

        $translateObject->id = $keywordId;
        $translateObject->languageId = $languageId;
        $translateObject->keyword = $newTranslate;

        return $translateObject->create();
    }

    public function resetTranslatesCache()
    {
        $languages = Languages::find()->toArray();
        $cache = SharedService::getCache();

        foreach ($languages as $language) {
            $key = self::GLOBAL_TRANSLATES_CACHE . $language['id'];

            $cache->delete($key);
        }

    }
}