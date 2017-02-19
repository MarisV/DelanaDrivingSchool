<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 17.15.2
 * Time: 21:02
 */

namespace library\Adapters\Cache;


interface CacheAdapterInterface
{
    /**
     *  Get value from cache
     *
     * @return mixed
     */
    public function get($key, $usePrefix = true);

    /**
     *  Set value to cache
     *
     * @return mixed
     */
    public function set($key, $data, $expiration = null, $usePrefix = true);

    /**
     *  Delete value from cache
     *
     * @return mixed
     */
    public function delete($key, $usePrefix = true);

}