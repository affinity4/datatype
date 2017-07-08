<?php
namespace Affinity4\Datatype;

use Affinity4\Datatype\Exception\DatatypeException;

/**
 * Class Arr
 *
 * @author Luke Watts <luke@affinity4.ie>
 *
 * @since 0.0.4
 *
 * @package Affinity4\Datatype
 */
class Arr extends Datatype
{
    /**
     * Return the average of numeric values in an array
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     *
     * @return object
     *
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     */
    public function avg()
    {
        if (!is_array($this->val)) {
            throw new DatatypeException(sprintf('Value passed to %s::set($val)->%s() must be of type \'%s\'. Type %s given.', __CLASS__, __FUNCTION__, 'array', gettype($this->val)));
        }

        $this->val = array_sum($this->val) / count($this->val);

        return Num::set($this->val);
    }

    /**
     * Splits an array into two arrays. One with keys and the other with values.
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     *
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return $this
     */
    public function columns()
    {
        $this->exception('array', $this->val, __CLASS__, __FUNCTION__);

        $this->val = [array_keys($this->val), array_values($this->val)];

        return $this;
    }

    /**
     * Core functionality for unset and except methods.
     *
     * @param $keys
     *
     * @return $this
     */
    private function del($keys)
    {
        if ($keys instanceof \ArrayAccess) {
            $keys = (array)$keys;
        }

        if (is_array($keys)) {
            foreach ($keys as $key) {
                if (array_key_exists($key, $this->val)) {
                    unset($this->val[$key]);
                }
            }
        } else {
            if (array_key_exists($keys, $this->val)) {
                unset($this->val[$keys]);
            }
        }

        return $this;
    }

    /**
     * Return array except for value or values given.
     *
     * @param $keys
     *
     * @return $this
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     */
    public function except($keys)
    {
        $this->exception('array', $this->val, __CLASS__, __FUNCTION__);

        $this->val = $this->del($keys)->val;

        return $this;
    }

    /**
     * Determine if the given key exists
     *
     * @param  string|int   $key
     * @param  callable     $callback
     *
     * @return bool
     */
    public function exists($key, callable $callback = null)
    {
        $this->exception('array', $this->val, __CLASS__, __FUNCTION__);

        if ($callback === null) {
            if ($this->val instanceof \ArrayAccess) {
                return Boolean::set($this->val->offsetExists($key));
            }

            return Boolean::set(array_key_exists($key, $this->val));
        } else {
            if ($this->val instanceof \ArrayAccess) {
                $exists = ($this->val->offsetExists($key)) ?: false;
            } else {
                $exists = (array_key_exists($key, $this->val)) ?: false;
            }

            if ($exists) {
                $this->val = call_user_func($callback, $key);

                return $this;
            } else {
                return Boolean::set($exists);
            }
        }
    }

    /**
     * Return the first element in an array which passes a callback condition.
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     *
     * @param  callable|null $callback
     *
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return mixed
     */
    public function first(callable $callback = null)
    {
        $this->exception('array', $this->val, __CLASS__, __FUNCTION__);

        if ($callback !== null) {
            $this->val = array_filter($this->val, $callback);
        }

        $instance  = self::typeFactory(array_shift($this->val));
        $this->val = self::typeFactory(array_shift($this->val))->getVal();

        return $instance;
    }

    /**
     * Removes one or more elements from the current array.
     *
     * @param mixed $keys
     *
     * @return $this
     */
    public function unset($keys)
    {
        $this->exception('array', $this->val, __CLASS__, __FUNCTION__);

        $this->val = $this->del($keys)->val;

        return $this;
    }

    /**
     * Join an array. Same as implode()
     *
     * @see http://php.net/manual/en/function.implode.php
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.3
     *
     * @param string $glue
     *
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return $this
     */
    public function join($glue = ' ')
    {
        $this->exception('array', $this->val, __CLASS__, __FUNCTION__);

        return Str::set(implode($glue, $this->val));
    }

    /**
     * Return the last element in an array which passes a callback condition.
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     *
     * @param callable|null $callback
     *
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return object
     */
    public function last(callable $callback = null)
    {
        $this->exception('array', $this->val, __CLASS__, __FUNCTION__);

        if ($callback !== null) {
            $this->val = array_filter($this->val, $callback);
        }

        $instance = self::typeFactory(end($this->val));
        $this->val = self::typeFactory(end($this->val))->getVal();

        return $instance;
    }

    /**
     * Maps a callback the each element of the array.
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     *
     * @see http://php.net/manual/en/function.array_map.php
     *
     * @param callable $callback
     *
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return $this
     */
    public function map(callable $callback)
    {
        $this->exception('array', $this->val, __CLASS__, __FUNCTION__);

        $this->val = array_map($callback, $this->val);

        return $this;
    }

    /**
     * Return the sum of the values in an array
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     *
     * @return \Affinity4\Datatype\Num
     *
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     */
    public function sum()
    {
        $this->exception('array', $this->val, __CLASS__, __FUNCTION__);

        $this->val = array_sum($this->val);

        return Num::set($this->val);
    }

    /**
     * Convert array to \Affinity4\Datatype\Json object
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     *
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return \Affinity4\Datatype\Json
     */
    public function toJson()
    {
        if (!is_array($this->val)) {
            throw new DatatypeException(sprintf('Value passed to %s::set($val)->%s() must be of type \'%s\'. Type %s given.', __CLASS__, __FUNCTION__, 'array', gettype($this->val)));
        }

        $json = json_encode($this->val);

        return Json::set($json);
    }

    /**
     * Datatype factory.
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     *
     * @param $val
     *
     * @return \Affinity4\Datatype\Arr|\Affinity4\Datatype\Integer|\Affinity4\Datatype\Str
     */
    private function typeFactory($val)
    {
        switch (gettype($val)) {
            case 'string' :
                return Str::set($val);
                break;
            case 'numeric' :
                return Num::set($val);
                break;
            case 'integer' :
                return Integer::set($val);
                break;
            case 'float':
                return FloatDouble::set($val);
                break;
            case 'double':
                return DoubleFloat::set($val);
                break;
            default :
                return Arr::set($val);
                break;
        }
    }
}