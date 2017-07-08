<?php
/**
 * Created by PhpStorm.
 * User: LukeWatts85
 * Date: 21/06/2017
 * Time: 15:11
 */

namespace Affinity4\Datatype;

use Affinity4\Datatype\Exception\DatatypeException;

class Datatype implements DatatypeInterface
{
    /**
     * @var
     */
    protected static $instance;

    /**
     * @var
     */
    public $val;

    /**
     * Throws exception for all child classes.
     *
     * @param $type
     * @param $value_to_check
     * @param $class_name
     * @param $function_name
     *
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     */
    public function exception($type, $value_to_check, $class_name = __CLASS__, $function_name = __FUNCTION__)
    {
        $type = strtolower($type);

        if ($type === 'array') {
            if (!$value_to_check instanceof \ArrayAccess && !is_array($value_to_check)) {
                throw new DatatypeException(sprintf('Value passed to %s::set($val)->%s() must be of type \'%s\' or instance of \'ArrayAccess\'. Type %s given.', $class_name, $function_name, $type, gettype($value_to_check)));
            }
        } else {
            if (!call_user_func('is_' . $type, $value_to_check)) {
                throw new DatatypeException(sprintf('Value passed to %s::set($val)->%s() must be of type \'%s\'. Type %s given.', $class_name, $function_name, $type, gettype($value_to_check)));
            }
        }
    }

    /**
     * @inheritdoc
     */
    public static function set($val)
    {
        static::$instance = new static;

        static::$instance->val = $val;

        return static::$instance;
    }

    /**
     * @inheritdoc
     */
    public function setVal($val)
    {
        $this->val = $val;
    }

    /**
     * @inheritdoc
     */
    public function getVal()
    {
        return $this->val;
    }
}