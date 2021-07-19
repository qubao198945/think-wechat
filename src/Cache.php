<?php

namespace Qubao\ThinkWechat;

use Psr\SimpleCache\CacheInterface;
use think\Cache as ThinkCache;

class Cache implements CacheInterface
{
    function __construct(ThinkCache $cache)
    {  
        $this->cache = $cache;
    }

    public function get($key, $default = null)
    {
        return $this->cahce->get($key, $default);
    }
    public function set($key, $value, $ttl = null)
    {
        return $this->cache->set($key, $value, $ttl);
    }
    public function delete($key)
    {
        return $this->cache->delete($key);
    }
    public function clear()
    {
        return $this->cache->clear();
    }
    public function getMultiple($keys, $default = null)
    {

    }
    public function setMultiple($values, $ttl = null)
    {

    }
    public function deleteMultiple($keys)
    {

    }
    public function has($key)
    {
        return $this->cache->has($key);
    }
}