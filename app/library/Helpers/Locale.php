<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 17.31.1
 * Time: 23:00
 */

namespace library\Helpers;

use app\models\Languages;

class Locale
{
    /**
     * Language code
     *
     * @var string
     */
    public $languageCode = 'lv';

    /**
     * Locale code
     *
     * @var string
     */
    public $localeCode = 'lv_LV';

    /**
     * Language id
     *
     * @var int
     */
    public $languageId = 1;

    /**
     * Valid languages
     *
     * @var array
     */
    public $validLanguages = array(
        'lv' => 1, // iso => id
        'ru' => 3,
        'en' => 2
    );

    /**
     * Flag is true, if language known from uri
     *
     * @var bool
     */
    public $knownFromUri = false;

    /**
     * Constructor
     *
     */
    public function __construct($uri, $ip, $autodetect = true)
    {
        if ($autodetect) {
            $this->autoDetect($uri, $ip);
        }
        $this->initValidLanguages();
    }

    /**
     *  Init valid active languages
     */
    private function initValidLanguages()
    {
        $this->validLanguages = Languages::getActiveLanguagesCodes();
    }
    
    /**
     * Autodetect locale from uri, cookie...
     *
     * @param string $uri
     * @param string $ip
     */
    public function autoDetect($uri, $ip)
    {

        // 1. try get from uri
        $languageCode = $this->getFromUri($uri);

        if ($languageCode && $this->isValidLanguageCode($languageCode)) {
            $this->knownFromUri = true;
            $this->initFromCode($languageCode);
            return;
        }

        // 2. if not known by 1, try get from cookie
        $languageCode = $this->getFromCookie();

        if ($languageCode && $this->isValidLanguageCode($languageCode)) {
            $this->initFromCode($languageCode);
            return;
        }

        // 3. if not known by 1 or 2, try find best
        $browserlang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
        $languageCode = locale_accept_from_http($browserlang);

        if ($languageCode && $this->isValidLanguageCode($languageCode)) {
            $languageCode = substr($languageCode, 0, 2);
            $this->initFromCode($languageCode);
            return;
        }


        if ($languageCode && $this->isValidLanguageCode($languageCode)) {
            $this->initFromCode($languageCode);
            return;
        }

        // 5. default case
        $this->initFromCode('lv');
    }

    /**
     * Init language code and id
     *
     * @param $languageCode
     * @throws \Exception
     */
    public function initFromCode($languageCode)
    {
        if (!$this->isValidLanguageCode($languageCode)) {
            throw new \Exception('Unknown locale: ' . $languageCode);
        }

        $this->languageCode = $languageCode;
        $this->languageId = $this->validLanguages[$languageCode];

        // @todo It dont work overall (eg. de_CH) correctly
        $languages =  Languages::find()->toArray();

        foreach($languages as $language) {
            if ($language['id'] == $this->languageId) {
                $this->localeCode = $language['code'];
                setlocale(LC_TIME, $language['code'] . '.utf-8'); // Set only LC_TIME, LC_ALL has a php bug

                break;
            }
        }

        // set cookie, if not set
        /* @var $cookies \Phalcon\Http\Response\Cookies */
//        $cookies = \Phalcon\DI::getDefault()->getCookies();
//        $cookies->useEncryption(false);
//        if (!$cookies->has('lg') || $cookies->get('lg')->getValue() != $this->languageId) {
//            $cookies->set('lg', $this->languageId, time() + 86400 * 1500, '/');
//            $cookies->get('lg')->send();
//        }
    }

    /**
     * Returns locale code from uri
     *
     * @param $uri
     * @return string
     */
    public function getFromUri($uri)
    {
        $parts = explode('/', trim($uri, '/'));

        if (isset($parts[0]) && $this->isValidLanguageCode($parts[0])) {
            return strtolower($parts[0]);
        }
    }

    /**
     * Returns locale code from cookie
     *
     * @return array
     */
    public function getFromCookie()
    {
        $languageId = isset($_COOKIE['language_id']) ? $_COOKIE['language_id'] : '';

        if (is_numeric($languageId) && $this->isValidLanguageId($languageId)) {
            return array_search($languageId, $this->validLanguages);
        }
    }

    /**
     * Returns true, if language code is valid
     *
     * @param string $languageCode
     * @return bool
     */
    public function isValidLanguageCode($languageCode)
    {
        return array_key_exists($languageCode, $this->validLanguages);
    }

    /**
     * Returns true, if language id is valid
     *
     * @param int $languageId
     * @return bool
     */
    public function isValidLanguageId($languageId)
    {
        return in_array($languageId, $this->validLanguages);
    }

    public static function getCurrentLocaleId()
    {
        $language =  Languages::getByIsoCode(LOCALE_CODE);

        return $language->id;
    }

    public static function getCurrentAndAllId()
    {
        return self::getCurrentLocaleId() . ', 5';

    }
}