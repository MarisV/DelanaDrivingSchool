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

    /**
     *  Load all translations
     *
     * @return array
     */
    public function loadTranslates(int $languageId = null) : array
    {
        $cache = SharedService::getCache();

        $translations = $cache->get('global-translations');

        if (!$translations) {

            $sth = $this->getPdo()->prepare(
                'SELECT k.keyword, IF(t.keyword != \'\', t.keyword, k.keyword) AS translate
                      FROM language_keywords AS k
                      LEFT JOIN language_translate AS t
                        ON k.id = t.id AND t.language_id = :langid'
            );

            $sth->execute(array(
                ':langid' => LOCALE_ID
            ));

            $translations = array();

            while ($row = $sth->fetch()) {
                $translations[$row['keyword']] = html_entity_decode($row['translate'], ENT_QUOTES, 'utf-8');
            }

           $cache->set('global-translations', $translations);
        }

        return $translations;
    }
}