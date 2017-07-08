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

use Affinity4\Datatype\Exception\DatatypeException;

/**
 * Str Class
 *
 * @author  Luke Watts <luke@affinity4.ie>
 *
 * @since   0.0.1
 *
 * @package Affinity4\DataType
 */
class Str extends Datatype
{
    const HARD_CROP = true;
    const SOFT_CROP = false;

    /**
     * Crops a sentence to a number of characters and optionally appends a string to the end.
     *
     * Example:
     * <code>
     * $long_sentence = 'one two three four five six seven eight nine ten.';
     * Str::set($long_sentence)->cropChars(13, '...'); // 'one two three...'
     * Str::set($long_sentence)->cropChars(13, '...', Str::HARD_CROP); // 'one two th...'
     * </code>
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     *
     * @param int  $at
     * @param null $append
     * @param bool $flag
     *
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return string
     */
    public function cropChars($at = 15, $append = null, $flag = Str::SOFT_CROP)
    {
        if (!is_string($this->val)) {
            throw new DatatypeException(sprintf('Value passed to %s::set($val)->%s() must be of type \'%s\'. Type %s given.', __CLASS__, __FUNCTION__, 'string', gettype($this->val)));
        }

        // If Str::HARD_CROP then the $at limit will include the length of the $append string
        // Otherwise the overall length will be the $at limit + $append length.
        if ($flag === Str::HARD_CROP) {
            $at = $at - strlen($append);
        }

        if (strlen($this->val) >= $at) {

            $sentence = str_split($this->val, $at)[0];

            $this->val = (is_string($append)) ? sprintf('%s%s', $sentence, $append) : $sentence;
        }

        return $this;
    }

    /**
     * Crops a sentence to a number of words and optionally appends a string to the end.
     *
     * Example:
     * <code>
     * $long_sentence = 'one two three four five six seven eight nine ten.';
     * Str::set($long_sentence)->cropWords(5, '...'); // 'one two three four five six seven...'
     * </code>
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.4
     *
     * @param int  $at
     * @param null $append
     *
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return string
     */
    public function cropWords($at = 10, $append = null)
    {
        $this->exception('string', $this->val, __CLASS__, __FUNCTION__);

        $words = explode(' ', $this->val);

        if (count($words) > $at) {
            $sentence = implode(' ', array_chunk($words, $at)[0]);

            $this->val = (is_string($append)) ? sprintf('%s%s', $sentence, $append) : $sentence;
        }

        return $this;
    }

    /**
     * Convert special characters to HTML entities
     *
     * @see http://php.net/manual/en/function.htmlspecialchars.php
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.3
     *
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return $this
     */
    public function e()
    {
        $this->exception('string', $this->val, __CLASS__, __FUNCTION__);

        $this->val = htmlspecialchars($this->val, ENT_QUOTES|ENT_HTML5, 'UTF-8');

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
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return $this
     */
    public function ee()
    {
        $this->exception('string', $this->val, __CLASS__, __FUNCTION__);

        $this->val = htmlspecialchars_decode($this->val, ENT_QUOTES|ENT_HTML5);

        return $this;
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
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return $this
     */
    public function format()
    {
        $this->exception('string', $this->val, __CLASS__, __FUNCTION__);

        $args = func_get_args();

        if (count($args) === 1 && is_array($args[0])) {
            $counter = 0;
            if (preg_match('{}', self::$instance->val)) {
                $new = str_replace('{}', '{-|-}', self::$instance->val);

                $explode = explode('-|-', $new);

                $replace = '';
                while ($counter < count($explode) - 1) {
                    $replace .= $explode[$counter] . $counter;

                    ++$counter;
                }

                $this->val = $replace . $explode[count($explode) - 1];
            }

            $keys = array_keys($args[0]);

            $patterns = [];
            foreach ($keys as $key) {
                $patterns['/({(' . $key . ')})/'] = function ($match) use ($args) {
                    return $args[0][$match[2]];
                };
            }

            $this->val = preg_replace_callback_array($patterns, $this->val);

            return $this;
        } else {
            if (preg_match('/({[\d]+})/', self::$instance->val)) {
                $keys = array_keys($args);

                $patterns = [];
                foreach ($keys as $key) {
                    $patterns['/({(' . $key . ')})/'] = function ($match) use ($args) {
                        return $args[$match[2]];
                    };
                }

                $counter = 0;
                if (preg_match('{}', self::$instance->val)) {
                    $new = str_replace('{}', '{-|-}', self::$instance->val);

                    $explode = explode('-|-', $new);

                    $replace = '';
                    while ($counter < count($explode) - 1) {
                        $replace .= $explode[$counter] . $counter;

                        ++$counter;
                    }

                    $this->val = $replace . $explode[count($explode) - 1];
                }

                $this->val = preg_replace_callback_array($patterns, $this->val);

                return $this;
            } else {
                $format = str_replace('{}', '%s', $this->val);

                $this->val = vsprintf($format, $args);

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
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return $this
     */
    public function html()
    {
        $this->exception('string', $this->val, __CLASS__, __FUNCTION__);

        $this->val = htmlentities($this->val, ENT_QUOTES|ENT_HTML5, 'UTF-8');

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
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return $this
     */
    public function htmlDecode()
    {
        $this->exception('string', $this->val, __CLASS__, __FUNCTION__);

        $this->val = html_entity_decode($this->val, ENT_QUOTES|ENT_HTML5, 'UTF-8');

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
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return $this
     */
    public function lcFirst()
    {
        $this->exception('string', $this->val, __CLASS__, __FUNCTION__);

        $this->val = lcfirst($this->val);

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
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return \Affinity4\Datatype\Integer
     */
    public function length()
    {
        $this->exception('string', $this->val, __CLASS__, __FUNCTION__);

        return Integer::set(strlen($this->val));
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
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return $this
     */
    public function lower()
    {
        $this->exception('string', $this->val, __CLASS__, __FUNCTION__);

        $this->val = strtolower($this->val);

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
     *
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return \Affinity4\Datatype\Integer
     */
    public function pos(string $needle)
    {
        $this->exception('string', $this->val, __CLASS__, __FUNCTION__);

        return Integer::set(strpos($this->val, $needle));
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
     * @param string $delimiter
     *
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return \Affinity4\Datatype\Arr
     */
    public function explode($delimiter = '')
    {
        $this->exception('string', $this->val, __CLASS__, __FUNCTION__);

        return Arr::set(explode($delimiter, $this->val));
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
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return \Affinity4\Datatype\Arr
     */
    public function split($delimiters = [' '])
    {
        $this->exception('string', $this->val, __CLASS__, __FUNCTION__);

        $delims = array_map(function ($delimiter) {
            return ($delimiter == '/') ? '\/' : preg_quote($delimiter);
        }, $delimiters);

        $regex = '/[' . implode('', $delims) . ']/';

        return Arr::set(preg_split($regex, self::$instance->val));
    }

    /**
     * Converts string to int if possible. Returns false otherwise
     *
     * @author Luke Watts
     *
     * @since 0.0.3
     *
     * @return bool|int
     */
    public function toInt()
    {
        if (is_callable($this->val)) {
            $val = $this->val;
            return Integer::set($val());
        }

        if (is_bool($this->val)) {
            $val = ($this->val === true) ? 1 : 0;

            return Integer::set($val);
        }

        if (is_object($this->val)) {
            if (method_exists($this->val, '__toString')) {
                $val = (preg_match('/[\d]+/', (string)$this->val, $match)) ? $match[0] : false;

                return Integer::set($val);
            } else {
                $this->val = false;

                return $this;
            }
        }

        if (is_array($this->val)) {
            $integers = array_filter($this->val, function ($item) {
                return is_int($item);
            });

            return Integer::set(implode('', $integers));
        }

        $val = (preg_match('/[\d]+/', $this->val, $match)) ? (int) $match[0] : false;

        return Integer::set($val);
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
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return $this
     */
    public function trim($character_mask = null)
    {
        $this->exception('string', $this->val, __CLASS__, __FUNCTION__);

        $this->val = ($character_mask !== null) ? trim($this->val, $character_mask) : trim($this->val);

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
     * @@throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return $this
     */
    public function trimLeft($character_mask = null)
    {
        $this->exception('string', $this->val, __CLASS__, __FUNCTION__);

        $this->val = ($character_mask !== null) ? ltrim($this->val, $character_mask) : ltrim($this->val);

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
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return $this
     */
    public function trimRight($character_mask = null)
    {
        $this->exception('string', $this->val, __CLASS__, __FUNCTION__);

        $this->val = ($character_mask !== null) ? rtrim($this->val, $character_mask) : rtrim($this->val);

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
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return $this
     */
    public function ucFirst()
    {
        $this->exception('string', $this->val, __CLASS__, __FUNCTION__);

        $this->val = ucfirst($this->val);

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
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return $this
     */
    public function ucWords()
    {
        $this->exception('string', $this->val, __CLASS__, __FUNCTION__);

        $this->val = ucwords($this->val);

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
     * @throws \Affinity4\Datatype\Exception\DatatypeException
     *
     * @return $this
     */
    public function upper()
    {
        $this->exception('string', $this->val, __CLASS__, __FUNCTION__);

        $this->val = strtoupper($this->val);

        return $this;
    }

    /**
     * Get diff of two strings
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since  0.0.4
     *
     * @param string $compare
     *
     * @return array|bool
     */
    public function diff(string $compare)
    {
        // TODO
    }
}