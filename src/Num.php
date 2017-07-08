<?php
namespace Affinity4\Datatype;

use Affinity4\Datatype\Exception\DatatypeException;
use Affinity4\Datatype\Exception\ExceptionHandlerTrait;

/**
 * Class Num
 *
 * @author Luke Watts <luke@affinity4.ie>
 *
 * @since 0.0.4
 *
 * @package Affinity4\Datatype
 */
class Num extends Datatype
{
    /**
     * Sum of value plus sum of array passed to add()
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     *
     * @param array|float|int $add
     *
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return $this
     */
    public function add($add)
    {
        $this->exception('numeric', $this->val, __CLASS__, __FUNCTION__);

        if (is_string($add) || is_bool($add)) {
            throw new DatatypeException(sprintf('Value passed to %s::set($val)->%s($add) must be an array, number or callable. Type %s given.', __CLASS__, __FUNCTION__, gettype($add)));
        }

        if (is_callable($add)) {
            $this->val = $this->val + $add();
        }

        if (is_array($add)) {
            array_push($add, $this->val);

            $this->val = array_sum($add);
        }

        if (is_numeric($add)) {
            $this->val = $this->val + $add;
        }

        return $this;
    }

    public function avg($avg)
    {
        $this->exception('numeric', $this->val, __CLASS__, __FUNCTION__);

        if (is_string($avg) || is_bool($avg)) {
            throw new DatatypeException(sprintf('Value passed to %s::set($val)->%s($avg) must be an array, number or callable. Type %s given.', __CLASS__, __FUNCTION__, gettype($avg)));
        }

        if (is_array($avg)) {
            array_push($avg, $this->val);

            $this->val = array_sum($avg) / count($avg);
        }

        return $this;
    }
    
    /**
     * Divide by $num
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     *
     * @param float|double|int|callable $num
     *
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return $this
     */
    public function divideBy($num)
    {
        $this->exception('numeric', $this->val, __CLASS__, __FUNCTION__);

        if (is_string($num) || is_bool($num)) {
            throw new DatatypeException(sprintf('Value passed to %s::set($val)->%s($num) must be an array, number or callable. Type %s given.', __CLASS__, __FUNCTION__, gettype($num)));
        }

        if (is_callable($num) || $num instanceof \Closure) {
            $num = $num();
        }

        $this->val = $this->val / $num;

        return $this;
    }
}