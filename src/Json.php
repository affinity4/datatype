<?php
/**
 * Created by PhpStorm.
 * User: LukeWatts85
 * Date: 21/06/2017
 * Time: 14:00
 */

namespace Affinity4\Datatype;

/**
 * Class Json
 *
 * @author Luke Watts <luke@affinity4.ie>
 *
 * @since 0.0.4
 *
 * @package Affinity4\Datatype
 */
class Json extends Datatype
{
    /**
     * Uglify json string
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     */
    public function prettify()
    {
        $array = json_decode($this->val);

        $this->val = json_encode($array, JSON_PRETTY_PRINT);

        return $this;
    }

    public function toArray($assoc = true)
    {
        return Arr::set(json_decode($this->val, $assoc));
    }

    /**
     * Uglify json string
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     */
    public function uglify()
    {
        $array = json_decode($this->val);

        $this->val = json_encode($array);

        return $this;
    }
}