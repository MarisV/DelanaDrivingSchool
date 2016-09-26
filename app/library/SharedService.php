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
    public static function isAdminLogged()
    {
        return self::getDi()->getShared('session')->has(self::LOGGED_IN_ADMIN_SESSION_KEY);
    }

    /**
     * Return logged admin object.
     *
     * @return mixed
     */
    public static function getLoggedInAdmin()
    {
        if (self::isAdminLogged()) {
            return self::getDi()->getShared('session')->get(self::LOGGED_IN_ADMIN_SESSION_KEY);
        } else {
            return false;
        }
    }

}