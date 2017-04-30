<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 17.14.2
 * Time: 19:39
 */

namespace library\Adapters\Translate;

use app\models\LanguageKeywords;
use app\models\TranslateKeywordsModel;
use Phalcon\Translate\Adapter;
use Phalcon\Translate\AdapterInterface;

class TranslateAdapter extends Adapter implements AdapterInterface
{
    private $translates;

    public function __construct(array $options)
    {
        parent::__construct($options);

        $this->translates = $options['content'];
    }

    private function initTranslates()
    {
        $this->translates = (new TranslateKeywordsModel())->getTranslates();
    }

    /**
     * Returns the translation string of the given key
     *
     * @param string $translateKey
     * @param mixed $placeholders
     * @return string
     */
    public function t($translateKey, $placeholders = null)
    {
        return $this->_($translateKey, $placeholders);
    }

    /**
     * Returns the translation related to the given key
     *
     * @param string $index
     * @param mixed $placeholders
     * @return string
     */
    public function query($index, $placeholders = null)
    {
        return $this->_($index, $placeholders);
    }

    /**
     * Check whether is defined a translation key in the internal array
     *
     * @param string $index
     * @return bool
     */
    public function exists($index)
    {
        return array_key_exists($index, $this->translates);
    }

    /**
     *  Translate keywords or insert new if not exists
     *
     * @param string $translateKey
     * @param array $placeholders
     * @return string
     */
    public function _($translateKey, $placeholders = NULL)
    {
        if ($this->exists($translateKey)) {
            return $this->translates[$translateKey];
        } else {
            (new LanguageKeywords())->insertKeyword($translateKey);
            return $translateKey;
        }
    }
}