<?php
/**
 * Created by PhpStorm.
 * User: LukeWatts85
 * Date: 14/06/2017
 * Time: 12:23
 */

namespace Affinity4\Datatype\Support\Exception;


class InflectorCacheException extends \InvalidArgumentException
{
    /**
     * InflectorCacheException constructor
     *
     * @param string $store
     * @param array $cache
     */
    public function __construct($store, array $cache)
    {
        parent::__construct($store . ' is not a correct cache key. Must be one of: ' . implode(', ', array_keys($cache)));
    }
}