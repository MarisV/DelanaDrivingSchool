<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 17.19.2
 * Time: 19:00
 */

namespace app\models;


use library\SharedService;

class TranslateKeywordsModel extends BaseModel
{
    /**
     *  Keyword id
     *
     * @var int
     */
    public $id;

    /**
     *  Keyword
     *
     * @var string
     */
    public $keyword;

    /**
     *  Translates cache key
     */
    const TRANSLATES_CACHE_KEY = 'global-translations'.LOCALE_ID;

    /**
     * This model is mapped to the table translate_keywords
     */
    public function getSource()
    {
        return "translate_keywords";
    }


    /**
     *  Columns mapping
     *
     * @return array
     */
    public function columnMap() : array
    {
        return [
            'id'        =>  'id',
            'keyword'   =>  'keyword'
        ];
    }

    /**
     *  Load all translates
     *
     * @return array
     */
    public function getTranslates()
    {
        $cache = SharedService::getCache();

        $translations = $cache->get(self::TRANSLATES_CACHE_KEY);

        if (!$translations) {

            $pdo = $this->getPdo();

            $sql = 'SELECT tk.keyword as "key", t.translate 
                        FROM translate_keywords tk
                            LEFT JOIN translates t ON tk.id = t.keyword_id 
                                WHERE t.language_id = :languageId';

            $query = $pdo->prepare($sql);

            $query->execute([
                ':languageId'   =>  LOCALE_ID
            ]);

            $translations = $query->fetchAll(\PDO::FETCH_ASSOC);

            $translations = $this->formatTranslates($translations);

            $cache->set(self::TRANSLATES_CACHE_KEY, $translations, 86400);
        }
        return $translations;
    }

    /**
     *  Format translations array to associative array
     *
     * @param $translations array
     * @return array
     */
    private function formatTranslates($translations)
    {
        $formatted = [];

        if ($translations) {
            foreach ($translations as $id => $translation) {
                $formatted[$translation['key']] = $translation['translate'];
            }
        }

        return $formatted;
    }

    /**
     *  Insert new keyword into translations
     *
     * @param $keyword string
     * @return bool
     */
    public function insertKeyword($keyword)
    {
        $pdo = $this->getPdo();

        if (!$this->checkIfKeywordExists($keyword)) {
            $sql = 'INSERT INTO translate_keywords (keyword) VALUES(:keyword)';

            $query = $pdo->prepare($sql);

            $insertResult =  $query->execute([
                ':keyword'   =>  $keyword
            ]);

            if ($insertResult) {
                $this->clearCache();
            }
        }
        return false;
    }

    /**
     *  Check wjether given keyword exists in keywords list
     *
     * @param $keyword string
     * @return bool
     */
    private function checkIfKeywordExists($keyword)
    {
        $pdo = $this->getPdo();

        $sql = 'SELECT COUNT(*) as total FROM translate_keywords WHERE keyword = :keyword';

        $query = $pdo->prepare($sql);

        $query->execute([
            ':keyword'  =>  $keyword
        ]);

        return $query->fetchColumn() > 0;
    }

    /**
     *  Remove translations from cache
     */
    private function clearCache()
    {
        SharedService::getCache()->delete(self::TRANSLATES_CACHE_KEY);
    }
}