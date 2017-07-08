<?php
namespace Affinity4\Datatype;

/**
 * Class DatatypeFactory
 *
 * @author Luke Watts <luke@affinity4.ie>
 *
 * @since 0.0.4
 *
 * @package Affinity4\Datatype
 */
class DatatypeFactory extends Datatype
{
    /**
     * DatatypeFactory constructor
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     *
     * @param mixed $val
     */
    public function __construct($val)
    {
        $this->val = $val;

        return $this;
    }

    /**
     * Runs callback if th value passed to the DatatypeFactory constructor is an array
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     *
     * @param callable $callback
     *
     * @return mixed
     */
    public function isArray(callable $callback)
    {
        if (is_array($this->val) || $this->val instanceof \ArrayAccess) {
            static::$instance = call_user_func($callback, $this->val);
            $this->val = call_user_func($callback, $this->val)->val;
        }

        return $this;
    }

    /**
     * Runs callback if th value passed to the DatatypeFactory constructor is a string
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     *
     * @param callable $callback
     *
     * @return mixed
     */
    public function isString(callable $callback)
    {
        if (is_string($this->val)) {
            static::$instance = call_user_func($callback, $this->val);
            $this->val = call_user_func($callback, $this->val)->val;
        }

        return $this;
    }

    /**
     * Runs callback if th val passed to the DatatypeFactory constructor is an int
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     *
     * @param callable $callback
     *
     * @return mixed
     */
    public function isInteger(callable $callback)
    {
        if (is_int($this->val)) {
            static::$instance = call_user_func($callback, $this->val);
            $this->val = call_user_func($callback, $this->val)->val;
        }

        return $this;
    }
}