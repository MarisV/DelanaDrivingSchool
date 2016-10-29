<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.26.10
 * Time: 22:05
 */

namespace library\Traits;

use Phalcon\Di;

trait BaseUrl
{
    /**
     *  Returns base url
     *
     * @return string
     */
    public function getBaseUrl(){

        $request = Di::getDefault()->getShared('request');

        $url = $request->getScheme() . '://';
        $url .= $request->getHttpHost();
        $url .= $request->getServer('PHP_SELF') ? $request->getServer('PHP_SELF') : '/';

        return rtrim($url, '/index.php');
    }
}