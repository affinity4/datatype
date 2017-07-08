<?php
/**
 * Created by PhpStorm.
 * User: LukeWatts85
 * Date: 21/06/2017
 * Time: 14:00
 */

namespace Affinity4\Datatype;

interface DatatypeInterface
{
    /**
     * Instantiates class for chaining methods and sets the value to manipulate
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     *
     * @param $val
     *
     * @return object
     */
    public static function set($val);

    /**
     * Sets the property $this->val to $val
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     *
     * @param $val
     *
     * @return void
     */
    public function setVal($val);

    /**
     * Gets the property $this->val
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     *
     * @return mixed
     */
    public function getVal();
}