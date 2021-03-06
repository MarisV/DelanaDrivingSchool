<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.26.9
 * Time: 18:09
 */

namespace library;

use Phalcon\Di;

class SharedService
{
    /**
     * Legged in admin session key
     *
     * @var string
     */
    const LOGGED_IN_ADMIN_SESSION_KEY = 'logged_in_admin';

    public static function getDi()
    {
        return Di::getDefault();
    }


    /**
     * Return memcache instance
     *
     * @return \Memcache
     */
    public static function getCache()
    {
       return self::getDi()->getShared('cache');
    }


    /**
     * Check whether admin is logged in
     *
     * @return bool
     */
    public static function isAdminLogged() : bool
    {
        return self::getDi()->getShared('session')->has(self::LOGGED_IN_ADMIN_SESSION_KEY);
    }


    /**
     * Return logged admin object.
     *
     * @return \Administrators|bool
     */
    public static function getLoggedInAdmin()
    {
        if (self::isAdminLogged()) {
            return self::getDi()->getShared('session')->get(self::LOGGED_IN_ADMIN_SESSION_KEY);
        } else {
            return false;
        }
    }


    /**
     * Returns simple veiw from phalcon
     *
     * @return \Phalcon\Mvc\View\Simple
     */
    public static function getSimpleView()
    {
       return self::getDi()->get('simpleview');
    }


    /**
     * Get base URL
     *
     * @return string
     */
    public static function getBaseUrl() : string
    {
        $request = self::getDi()->getShared('request');

        $url =  $request->getScheme() . '://';
        $url .= $request->getHttpHost();
        $url .= $request->getServer('PHP_SELF') ? $request->getServer('PHP_SELF') : '/';

        return rtrim($url, 'index.php');
    }


    /**
     * Returns cookie service
     *
     * @return \Phalcon\Http\Response\Cookies
     */
    public static function getCookies()
    {
        return self::getDi()->getShared('cookies');
    }


    /**
     *  HTTP Request instance
     *
     * @return \Phalcon\Http\Request|\Phalcon\Http\RequestInterface
     */
    public static function getRequest()
    {
        return self::getDi()->get('request');
    }


    /**
     * Returns translate adapter
     *
     * @return \Phalcon\Translate\Adapter\NativeArray
     */
    public static function getTranslate()
    {
        return self::getDi()->get('translate');
    }

    /**
     *  Return db instance
     *
     * @return \Phalcon\Db\Adapter\Pdo\Mysql
     */
    public static function getDb()
    {
        return self::getDi()->getShared('db');
    }
}