<?php
/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 16.26.9
 * Time: 19:15
 */

namespace library\Adapters\Cache;


class MemcachedAdapter implements CacheAdapterInterface
{
    /**
     * Memcached instance
     *
     * @var \Memcached
     */
    protected $memcached = null;

    /**
     * Flag is true if (sure) connected
     *
     * @var bool
     */
    protected $connected = false;

    /**
     * Prefix for all keys
     *
     * @var string
     */
    public $keyPrefix = '';

    /**
     * Use file cache as fallback
     *
     * @var bool
     */
    public $useFallback = true;

    /**
     * Constructor
     *
     * @param $keyPrefix string
     */
    public function __construct($keyPrefix = '')
    {
        $this->keyPrefix = $keyPrefix;
    }

    /**
     * Connect to memcached and return instance
     *
     * @return \Memcached
     */
    protected function getInstance()
    {
        if (null == $this->memcached) {
            $this->memcached = new \Memcached('DE_LANA_AUTO');

            if (!count($this->memcached->getServerList())) {
                $this->memcached->addServer('127.0.0.1', 11211);
            }
        }

        return $this->memcached;
    }

    /**
     * Try to get data with key.
     * Returns null, if data not exists or server not available.
     *
     * @param $key string
     * @param $usePrefix bool
     *
     * @return mixed
     */
    public function get($key, $usePrefix = true)
    {
        $key = crc32($key);

        if ($usePrefix && !empty($this->keyPrefix)) {
            $key = $this->keyPrefix . '.' . $key;
        }


        // try to get from memcache
        $data = $this->getInstance()->get($key);

        if ($data) {
            $this->connected = true;
            return $data;
        }

        if (!$this->connected && $this->useFallback) {
            return false;
           // return \SM::getFileCache()->get($key, false);
        }
    }

    /**
     * Store data with key
     *
     * @param $key string
     * @param $data mixed
     * @param $expiration int
     * @param $usePrefix bool
     * @return mixed
     */
    public function set($key, $data, $expiration = null, $usePrefix = true)
    {
        $key = crc32($key);

        if (!is_numeric($expiration)) {
            $expiration = 3600;
        }

        if ($usePrefix && !empty($this->keyPrefix)) {
            $key = $this->keyPrefix . '.' . $key;
        }

        // store into memcache
        $success = $this->getInstance()->set($key, $data, $expiration);

        if ($success) {
            $this->connected = true;
        } else {
            trigger_error('Memcached set failed with message: ' . $this->server()->getResultMessage(), E_USER_NOTICE);
        }

        if (!$success && $this->useFallback) {
            return false;
           // \SM::getFileCache()->set($key, $data, $expiration, false);
        }
    }

    /**
     * Delete item from cache
     *
     * @param $key
     * @param bool|true $usePrefix
     */
    public function delete($key, $usePrefix = true)
    {
        $key = crc32($key);

        if ($usePrefix && !empty($this->keyPrefix)) {
            $key = $this->keyPrefix . '.' . $key;
        }

        $data = $this->getInstance()->get($key);

//        if (\SM::getRegistry()->offsetExists($key)) {
//            \SM::getRegistry()->offsetUnset($key);
//        }

        if($data != false){
            $this->getInstance()->delete($key);
        }

       // \SM::getFileCache()->delete($key, false);
    }
}