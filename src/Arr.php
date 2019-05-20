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
     * Get
     * 
     * A simplified version of CakePHP's Hash::get method
     *
     * @param string $path
     * 
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.5
     * 
     * @throws \Exception
     * @throws \InvalidArgumentException
     * 
     * @return \Affinity4\Datatype\Arr
     */
    public function get(string $path): \Affinity4\Datatype\Arr
    {
        $this->exception('array', $this->val, __CLASS__, __FUNCTION__);

        if (!(is_array($this->val) || $this->val instanceof ArrayAccess)) {
            throw new \InvalidArgumentException('Invalid data type, must be an array or \ArrayAccess instance.');
        }

        $parts = $this->getSearchPatternArray($path);

        switch (count($parts)) {
            case 1:
                $this->val = isset($this->val[$parts[0]]) ? $this->val[$parts[0]] : null;
            break;
            case 2:
                $this->val = isset($this->val[$parts[0]][$parts[1]]) ? $this->val[$parts[0]][$parts[1]] : null;
            break;
            case 3:
                $this->val = isset($this->val[$parts[0]][$parts[1]][$parts[2]]) ? $this->val[$parts[0]][$parts[1]][$parts[2]] : null;
            break;
            default:
                foreach ($parts as $key) {
                    if ((is_array($this->val) || $this->val instanceof ArrayAccess) && isset($this->val[$key])) {
                        $this->val = $this->val[$key];
                    } else {
                        $this->val = null;
                    }
                }
            break;
        }

        return $this;
    }

    /**
     * Search
     * 
     * Inspired by CakePHP's Hash::extract method
     * but uses regex instead of {s}, {d}, {*}
     * 
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.5
     *
     * @param string $pattern
     * @param string $delimiter
     * 
     * @throws \Exception
     * @throws \InvalidArgumentException
     * 
     * @return mixed
     */
    public function search(string $pattern, string $delimiter = '/')
    {
        $this->exception('array', $this->val, __CLASS__, __FUNCTION__);

        if (empty($pattern)) {
            return $this;
        }

        if (!preg_match('/(\.({.*})\.)/', $pattern)) {
            $this->val = $this->get($pattern)->val;
        } else {
            $pattern_segments = $this->getSearchPatternArray($pattern, $delimiter);

            $search = [];
            $top_level_keys = [];
            for ($i = 0; count($pattern_segments) > $i; $i++) {
                $segment = $pattern_segments[$i];
                switch($i) {
                    case 0 :
                        // If first segment then it must check all items against segment
                        // If it cannot find anything for the first then exit
                        // If it finds one or more it should put them all in the search variable
                        // The search variable is then what is searched through
                        foreach ($this->val as $k => $v) {
                            if (Str::set($segment)->startsWith('/') && Str::set($segment)->endsWith('/')) {
                                // is regex
                                if (preg_match($segment, $k) === 1) {
                                    $top_level_keys[] = $k;
                                    $search[$k] = $v;
                                }
                            } else {
                                // Normal string
                                if ($segment === $k) {
                                    $top_level_keys[] = $k;
                                    $search[$k] = $v;
                                }
                            }
                        }
                    break;
                    case 1:
                        $segment = $pattern_segments[$i];
                        $top_level_keys = [];
                        $next = [];
                        foreach ($search as $k => $v) {
                            $top_level_keys[] = $k;
                            if (is_array($v)) {
                                foreach ($v as $_k => $_v) {
                                    if (Str::set($segment)->startsWith('/') && Str::set($segment)->endsWith('/')) {
                                        if (preg_match($segment, $_k) === 1) {
                                            $next[][$_k] = $_v;
                                        }
                                    } else {
                                        if ($segment === $k) {
                                            $next[][$_k] = $_v;
                                        }
                                    }
                                }
                            }
                        }

                        $search = $next;
                    break;
                    case 2:
                        $segment = $pattern_segments[$i];
                        $top_level_keys = [];
                        $next = [];
                        foreach ($search as $search_v) {
                            foreach ($search_v as $k => $v) {
                                if (!is_array($v)) {
                                    $v = [$v];
                                }

                                foreach ($v as $_k => $_v) {
                                    $top_level_keys[] = $_k;
                                    if (Str::set($segment)->startsWith('/') && Str::set($segment)->endsWith('/')) {
                                        if (preg_match($segment, $_k) === 1) {
                                            $next[] = $_v;
                                        }
                                    } else {
                                        if ($segment === $_k) {
                                            $next[] = $_v;
                                        }
                                    }
                                }
                            }
                        }

                        $search = $next;
                    break;
                    default:
                        $segment = $pattern_segments[$i];
                        $top_level_keys = [];
                        $next = [];
                        $this->val = $search;
                        foreach ($this->val as $items) {
                            foreach ($items as $k => $v) {
                                if (Str::set($segment)->startsWith('/') && Str::set($segment)->endsWith('/')) {
                                    if (preg_match($segment, $k) === 1) {
                                        $next[] = $v;
                                    }
                                } else {
                                    if ($segment === $k) {
                                        $next[] = $v;
                                    }
                                }
                            }
                        }
                        $search = $next;
                    break;
                }
            }

            $this->val = $search;
        }

        return $this;
    }

    /**
     * Parse Pattern
     * 
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.5
     *
     * @param string $pattern
     * @param string $deliminter
     * 
     * @return array
     */
    private function getSearchPatternArray(string $pattern, string $delimiter = '/'): array
    {
        $token_map = [
            '<T_PRESERVE_DOT>' => [
                'preserve' => '\.',
                'token' => '<T_PRESERVE_DOT>'
            ],
            '<T_PRESERVE_REGEX_DOT>' => [
                'preserve' => '.',
                'token' => '<T_PRESERVE_REGEX_DOT>'
            ]
        ];

        $pattern_segments = explode('}.', $pattern);

        $pattern_segments = array_map(function($segment) use ($token_map) {
            return preg_replace('/(.*\.?{.*)(\.)(.*)/', "\\1{$token_map['<T_PRESERVE_REGEX_DOT>']['token']}\\3", $segment);
        }, $pattern_segments);

        $pattern = implode('}.', $pattern_segments);

        $pattern = str_replace($token_map['<T_PRESERVE_DOT>']['preserve'], $token_map['<T_PRESERVE_DOT>']['token'], $pattern);

        $pattern_segments = explode('.', $pattern);

        $pattern_segments = array_map(function($segment) use ($token_map, $delimiter) {
            $segment = str_replace($token_map['<T_PRESERVE_REGEX_DOT>']['token'], $token_map['<T_PRESERVE_REGEX_DOT>']['preserve'], $segment);
            $segment = str_replace($token_map['<T_PRESERVE_DOT>']['token'], '.', $segment);
            $segment = str_replace('{', $delimiter, $segment);
            $segment = str_replace('}', $delimiter, $segment);

            return $segment;
        }, $pattern_segments);


        return $pattern_segments;
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