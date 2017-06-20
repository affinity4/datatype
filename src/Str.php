<?php
/**
 * This file is part of Affinity4\DataType.
 *
 * (c) 2017 Luke Watts <luke@affinity4.ie>
 *
 * This software is licensed under the MIT license. For the
 * full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Affinity4\Datatype;

/**
 * Str Class
 *
 * @author  Luke Watts <luke@affinity4.ie>
 *
 * @since   0.0.1
 *
 * @package Affinity4\DataType
 */
class Str
{
    /**
     * @var
     */
    private static $instance;

    /**
     * @var
     */
    public $string;

    /**
     * Convert special characters to HTML entities
     *
     * @see http://php.net/manual/en/function.htmlspecialchars.php
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.3
     *
     * @return $this
     */
    public function e()
    {
        $this->string = htmlspecialchars($this->string, ENT_QUOTES|ENT_HTML5, 'UTF-8');

        return $this;
    }

    /**
     * Convert special HTML entities back to characters
     *
     * @see http://php.net/manual/en/function.htmlspecialchars_decode.php
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.3
     *
     * @return $this
     */
    public function ee()
    {
        $this->string = htmlspecialchars_decode($this->string, ENT_QUOTES|ENT_HTML5);

        return $this;
    }

    /**
     * The string to begin manipulating
     *
     * Instantiates class for chaining methods
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.3
     *
     * @param $str
     *
     * @return \Affinity4\Datatype\Str
     */
    public static function from($str)
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        self::$instance->string = $str;

        return self::$instance;
    }

    /**
     * Format a string using a patter with placeholders.
     *
     * Heavily inspired by pythons 'Some {} string'.format('formatted') method.
     *
     * Examples:
     * <code>
     * Str::from('User {0} {1} logged in. How are you Mr. {1}?')
     *      ->format('Luke', 'Watts')
     *      ->string; // User Luke Watts logged in. How are you Mr. Watts?
     * Str::from('User {} {} logged in. How are you Mr. {1}?')
     *      ->format('Luke', 'Watts')
     *      ->string; // User Luke Watts logged in. How are you Mr. Watts?
     * Str::from('User {0} {1} logged in. How are you Mr. {1}?')
     *      ->format(['Luke', 'Watts'])
     *      ->string; // User Luke Watts logged in. How are you Mr. Watts?
     * Str::from('{0} {first_name} {last_name} logged in. How are you Mr. {1}?')
     *      ->format(['first_name' => 'Luke', 'last_name' => 'Watts', 'admin'])
     *      ->string;
     *      // Admin Luke Watts logged in. How are you Mr. Watts?
     * </code>
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.3
     *
     * @return $this
     */
    public function format()
    {
        $args = func_get_args();

        if (count($args) === 1 && is_array($args[0])) {
            $counter = 0;
            if (preg_match('{}', self::$instance->string)) {
                $new = str_replace('{}', '{-|-}', self::$instance->string);

                $explode = explode('-|-', $new);

                $replace = '';
                while ($counter < count($explode) - 1) {
                    $replace .= $explode[$counter] . $counter;

                    ++$counter;
                }

                $this->string = $replace . $explode[count($explode) - 1];
            }

            $keys = array_keys($args[0]);

            $patterns = [];
            foreach ($keys as $key) {
                $patterns['/({(' . $key . ')})/'] = function ($match) use ($args) {
                    return $args[0][$match[2]];
                };
            }

            $this->string = preg_replace_callback_array($patterns, $this->string);

            return $this;
        } else {
            if (preg_match('/({[\d]+})/', self::$instance->string)) {
                $keys = array_keys($args);

                $patterns = [];
                foreach ($keys as $key) {
                    $patterns['/({(' . $key . ')})/'] = function ($match) use ($args) {
                        return $args[$match[2]];
                    };
                }

                $counter = 0;
                if (preg_match('{}', self::$instance->string)) {
                    $new = str_replace('{}', '{-|-}', self::$instance->string);

                    $explode = explode('-|-', $new);

                    $replace = '';
                    while ($counter < count($explode) - 1) {
                        $replace .= $explode[$counter] . $counter;

                        ++$counter;
                    }

                    $this->string = $replace . $explode[count($explode) - 1];
                }

                $this->string = preg_replace_callback_array($patterns, $this->string);

                return $this;
            } else {
                $format = str_replace('{}', '%s', $this->string);

                $this->string = vsprintf($format, $args);

                return $this;
            }
        }
    }

    /**
     * Convert all applicable characters to HTML entities
     *
     * @see http://php.net/manual/en/function.htmlentities.php
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.3
     *
     * @return $this
     */
    public function html()
    {
        $this->string = htmlentities($this->string, ENT_QUOTES|ENT_HTML5, 'UTF-8');

        return $this;
    }

    /**
     * Convert all HTML entities to their applicable characters
     *
     * @see http://php.net/manual/en/function.html-entity-decode.php
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.3
     *
     * @return $this
     */
    public function htmlDecode()
    {
        $this->string = html_entity_decode($this->string, ENT_QUOTES|ENT_HTML5, 'UTF-8');

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
     * @return $this
     */
    public function join($glue = ' ')
    {
        $this->string = implode($glue, $this->string);

        return $this;
    }

    /**
     * Convert first letter to lowercase
     *
     * @see http://php.net/manual/en/function.lcfirst.php
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.3
     *
     * @return $this
     */
    public function lcFirst()
    {
        $this->string = lcfirst($this->string);

        return $this;
    }

    /**
     * Counts the number of characters in a string
     *
     * @see http://php.net/manual/en/function.strlen.php
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.3
     *
     * @param string $str
     * @return $this
     */
    public static function length(string $str)
    {
        return strlen($str);
    }

    /**
     * Converts uppercase letters to lowercase
     *
     * @see http://php.net/manual/en/function.strtolower.php
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.3
     *
     * @return $this
     */
    public function lower()
    {
        $this->string = strtolower($this->string);

        return $this;
    }

    /**
     * Check if a string is contained in another string.
     *
     * @see http://php.net/manual/en/function.strpos.php
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since  0.0.1
     *
     * @param string $needle
     * @param string $haystack
     *
     * @return bool
     */
    public static function pos(string $needle, string $haystack)
    {
        return strpos($haystack, $needle);
    }

    /**
     * Explode a string into an array
     *
     * @see http://php.net/manual/en/function.explode.php
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.3
     *
     * @param        $str
     * @param string $delimiter
     *
     * @return array
     */
    public static function explode($str, $delimiter = '')
    {
        return explode($delimiter, $str);
    }

    /**
     * Split words into an array based on a delimiter
     *
     * @see http://php.net/manual/en/function.explode.php
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.3
     *
     * @param array $delimiters
     *
     * @return $this
     */
    public function split($delimiters = [' '])
    {
        $delims = array_map(function ($delimiter) {
            return ($delimiter == '/') ? '\/' : preg_quote($delimiter);
        }, $delimiters);

        $regex = '/[' . implode('', $delims) . ']/';

        self::$instance->string = preg_split($regex, self::$instance->string);

        return $this;
    }

    /**
     * Converts string to int if possible. Returns false otherwise
     *
     * @author Luke Watts
     *
     * @since 0.0.3
     *
     * @param string $str
     *
     * @return bool|int
     */
    public static function toInt($str)
    {
        if (is_callable($str)) {
            $str = $str();
        }

        if (is_bool($str)) {
            $str = ($str === true) ? 1 : 0;
        }

        if (is_object($str)) {
            if (method_exists($str, '__toString')) {
                return (preg_match('/[\d]+/', (string)$str, $match)) ? $match[0] : false;
            } else {
                return false;
            }
        }

        if (is_array($str)) {
            $integers = array_filter($str, function ($item) {
                return is_int($item);
            });

            return implode('', $integers);
        }

        return (preg_match('/[\d]+/', $str, $match)) ? (int)$match[0] : false;
    }

    /**
     * Trim outermost characters determined by a character mask
     *
     * @see http://php.net/manual/en/function.trim.php
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.3
     *
     * @param null $character_mask
     *
     * @return $this
     */
    public function trim($character_mask = null)
    {

        $this->string = ($character_mask !== null) ? trim($this->string, $character_mask) : trim($this->string);

        return $this;
    }

    /**
     * Trim leftmost characters determined by a character mask
     *
     * @see http://php.net/manual/en/function.ltrim.php
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.3
     *
     * @param null $character_mask
     *
     * @return $this
     */
    public function trimLeft($character_mask = null)
    {

        $this->string = ($character_mask !== null) ? ltrim($this->string, $character_mask) : ltrim($this->string);

        return $this;
    }

    /**
     * Trim rightmost characters determined by a character mask
     *
     * @see http://php.net/manual/en/function.rtrim.php
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.3
     *
     * @param null $character_mask
     *
     * @return $this
     */
    public function trimRight($character_mask = null)
    {

        $this->string = ($character_mask !== null) ? rtrim($this->string, $character_mask) : rtrim($this->string);

        return $this;
    }

    /**
     * Convert first letter to uppercase
     *
     * @see http://php.net/manual/en/function.ucfirst.php
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.3
     *
     * @return $this
     */
    public function ucFirst()
    {
        $this->string = ucfirst($this->string);

        return $this;
    }

    /**
     * Convert first letter of each word to uppercase
     *
     * @see http://php.net/manual/en/function.ucwords.php
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.3
     *
     * @return $this
     */
    public function ucWords()
    {
        $this->string = ucwords($this->string);

        return $this;
    }

    /**
     * Convert ot uppercase
     *
     * @see http://php.net/manual/en/function.strtoupper.php
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.3
     *
     * @return $this
     */
    public function upper()
    {
        $this->string = strtoupper($this->string);

        return $this;
    }

    /**
     * Get diff of two strings
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since  0.0.1
     *
     * @param string $str1
     * @param string $str2
     *
     * @return array|bool
     */
    public static function diff(string $str1, string $str2)
    {
        // TODO
    }
}