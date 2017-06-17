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
     * Get matching part of two strings.
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since  0.0.1
     *
     * @param string $str1
     * @param string $str2
     *
     * @return string
     */
    public function match(string $str1, string $str2)
    {
        $final = [];

        // Find the shortest
        $count = (strlen($str1) <= strlen($str2)) ? strlen($str1) : strlen($str2);

        // Get the number of items
        --$count;

        // Use a for loop to loop over the shortest array
        for ($i = 0; $i <= $count; $i++) {
            // Compare each key => value pair to the key => value pair in the other array
            if ($str1[$i] === $str2[$i]) {
                // They are the same
                $final[$i] = $str1[$i];
                continue;
            } else {
                break;
            }
        }

        // Return the string matching string
        return implode('', $final);
    }

    /**
     * Get diff of two strings.
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
    public function diff(string $str1, string $str2)
    {
        $str1 = $this->match($str1, $str2);

        // Find the longest string;
        $count = (strlen($str1) >= strlen($str2)) ? strlen($str1) : strlen($str2);
        $start_index = (strlen($str1) < strlen($str2)) ? strlen($str1) : strlen($str2);

        // Get the number of items
        --$count;

        // Use a for loop to loop over the shortest array
        for ($i = $start_index; $i <= $count; $i++) {
            $final[] = $str2[$i];
        }

        return (isset($final)) ? $final : false;
    }
}