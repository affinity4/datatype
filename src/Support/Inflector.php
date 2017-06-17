<?php
/**
 * Created by PhpStorm.
 * User: LukeWatts85
 * Date: 14/06/2017
 * Time: 11:03
 */

namespace Affinity4\Datatype\Support;


use Affinity4\Datatype\Support\Exception\InflectorCacheException;

class Inflector
{
    private static $rules = [
        'uninflectable' => [
            'shared' => [
                '/^(.*)([nrlm]ese)$/i' => '\1\2',
                '/^(.*)(cod)$/i' => '\1\2',
                '/^(.*)(deer)$/i' => '\1\2',
                '/^(.*)(equipment)$/i' => '\1\2',
                '/^(.*)(fish)$/i' => '\1\2',
                '/^(.*)(information)$/i' => '\1\2',
                '/^(.*)(measles)$/i' => '\1\2',
                '/^(.+)(media)$/i' => '\1\2',
                '/^(.*)(money)$/i' => '\1\2',
                '/^(.*)(moose)$/i' => '\1\2',
                '/^(news)$/i' => '\1',
                '/^(.*)(ois)$/i' => '\1\2',
                '/^(.*)(pox)$/i' => '\1\2',
                '/^(.*)(sheep)$/i' => '\1\2',
                '/^(.*)(rice)$/i' => '\1\2',
                '/^(.*)(series)$/' => '\1\2',
                '/^(.*)(species)$/i' => '\1\2',
            ],
            'plural' => [
                '/^(.*)(people)$/i' => '\1\2'
            ],
            'singular' => []
        ],
        'irregular' => [
            'plural' => [
                '/^(atlas|cargo|corpus|domino|echo|iris|motto|octopus|opus|penis|potato|sex|tornado|volcano)$/i' => '\1es',
                '/^(axe|brother|cafe|cookie|cow|demo|ganglion|genie|human|mongoose|move|niche|occiput|trilby|turf)$/i' => '\1s',
                '/^(chateau|niveau|plateau)$/i' => '\1x',
                '/^(criteri)on$/i' => '\1a',
                '/^(curricul|memorand)um$/i' => '\1a',
                '/^(f)oot$/i' => '\1eet',
                '/^(fung)us$/i' => '\1i',
                '/^(gen)us$/i' => '\1era',
                '/^(graffit)o$/i' => '\1i',
                '/^(hippopotam)us$/i' => '\1i',
                '/^(hoo|lea|loa)f$/i' => '\1ves',
                '/^(m)an$/i' => '\1en',
                '/^(mon)ey$/i' => '\1ies',
                '/^(mytho)s$/i' => '\1i',
                '/^(nucle|syllab)us$/i' => '\1i',
                '/^(num)en$/i' => '\1ina',
                '/^(ox)$/i' => '\1en',
                '/^(pe)rson$/i' => '\1ople',
                '/^(runner)(-up)$/i' => '\1s\2',
                '/^(soliloqu)y$/i' => '\1ies',
                '/^(son|daughter|mother|father|brother|sister)(-in-law)$/i' => '\1s\2',
                '/^(test)is$/i' => '\1es',
                '/^(thie)f$/i' => '\1ves',
                '/^(t)ooth$/i' => '\1eeth'
            ],
            'singular' => [
                '/^(chateau|niveau|plateau)x$/i' => '\1',
                '/^(criteri)a$/i' => '\1on',
                '/^(axe|cookie|curve|foe|wave)s$/i' => '\1',
                '/(curricul|memorand)a$/i' => '\1um',
                '/^(emphas|oas)es$/i' => '\1is',
                '/^(hippopotam)i$/i' => '\1us',
                '/(ie|ea|oa|oo)ves$/i' => '\1f',
                '/^(atlas|iris)es$/i' => '\1',
                '/^(hoax)es$/i' => '\1',
                '/^(neuros)es$/i' => '\1is',
                '/^(runner)s(-up)$/i' => '\1\2',
                '/^(plateau)x$/i' => '\1',
                '/^(son|daughter|mother|father|brother|sister)s(-in-law)$/i' => '\1\2',
                '/^(t)eeth$/i' => '\1ooth'
            ]
        ],
        'plural' => [
            '/^(ox)$/i' => '\1\2en',
            '/([m|l])ouse$/i' => '\1ice',
            '/(matr|vert|ind)(ix|ex)$/i' => '\1ices',
            '/([^aeiouy]|qu)y$/i' => '\1ies',
            '/(hive|gulf)$/i' => '\1s',
            '/(?:([^f])fe|([lr])f)$/i' => '\1\2ves',
            '/sis$/i' => 'ses',
            '/([ti])um$/i' => '\1a',
            '/(p)erson$/i' => '\1eople',
            '/(m)an$/i' => '\1en',
            '/(child)$/i' => '\1ren',
            '/(f)oot$/i' => '\1eet',
            '/(buffal|her|potat|tomat|volcan)o$/i' => '\1\2oes',
            '/(alumn|bacill|cact|foc|fung|nucle|radi|stimul|syllab|termin|vir)us$/i' => '\1i',
            '/us$/i' => 'uses',
            '/(analys|ax|bas|cris|test|thes)is$/i' => '\1es',
            '/(alias|status|ch|sh|ss|x)$/i' => '\1es',
            '/(quiz)$/i' => '\1zes',
            '/s$/' => 's',
            '/^$/' => '',
            '/$/' => 's'
        ],
        'singular' => [
            '/(medi)a$/i'                                                         => '\1um',
            '/(alias|status)es$/i'                                                    => '\1',
            '/^(.*)(menu)s$/i'                                                        => '\1\2',
            '/(quiz)zes$/i'                                                           => '\1',
            '/(matr)ices$/i'                                                          => '\1ix',
            '/(vert|ind)ices$/i'                                                      => '\1ex',
            '/^(ox)en/i'                                                              => '\1',
            '/(buffal|her|potat|tomat|volcan)oes$/i'                                  => '\1o',
            '/(alumn|bacill|cact|foc|fung|nucle|radi|stimul|syllab|termin|viri?)i$/i' => '\1us',
            '/([ftw]ax)es/i'                                                          => '\1',
            '/(analys|ax|cris|test|thes)es$/i'                                        => '\1is',
            '/(shoe|slave)s$/i'                                                       => '\1',
            '/(o)es$/i'                                                               => '\1',
            '/ouses$/'                                                                => 'ouse',
            '/([^a])uses$/'                                                           => '\1us',
            '/([m|l])ice$/i'                                                          => '\1ouse',
            '/(x|ch|ss|sh)es$/i'                                                      => '\1',
            '/(m)ovies$/i'                                                            => '\1\2ovie',
            '/(s)eries$/i'                                                            => '\1\2eries',
            '/([^aeiouy]|qu)ies$/i'                                                   => '\1y',
            '/([lr])ves$/i'                                                           => '\1f',
            '/(tive)s$/i'                                                             => '\1',
            '/(hive)s$/i'                                                             => '\1',
            '/(drive)s$/i'                                                            => '\1',
            '/([^fo])ves$/i'                                                          => '\1fe',
            '/(^analy)ses$/i'                                                         => '\1sis',
            '/(analy|diagno|^ba|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i'             => '\1\2sis',
            '/([dti])a$/i'                                                             => '\1um',
            '/(p)eople$/i'                                                            => '\1\2erson',
            '/(m)en$/i'                                                               => '\1an',
            '/(c)hildren$/i'                                                          => '\1\2hild',
            '/(f)eet$/i'                                                              => '\1oot',
            '/(n)ews$/i'                                                              => '\1\2ews',
            '/eaus$/i'                                                                 => 'eau',
            '/^(.*us)$/'                                                              => '\1',
            '/s$/i'                                                                   => ''
        ]
    ];

    private static $cache = [
        'uninflectable' => [],
        'irregular' => [],
        'plural' => [],
        'singular' => []
    ];

    /**
     * Sets a cache item by type
     *
     * Convention is to keep everything one level deep.
     * For further nesting you should use dot namespacing
     * E.g.
     *
     * <code>
     * Inflector::setCache('uninflectable.shared', 'sheep');
     * </code>
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.2
     *
     * @param $store
     * @param $cache
     *
     * @throws \Affinity4\Datatype\Support\Exception\InflectorCacheException
     */
    public static function setCache($store, $cache)
    {
        if (!array_key_exists($store, self::$cache)) {
            throw new InflectorCacheException($store, Inflector::getCache());
        }

        array_push(self::$cache[$store], $cache);
    }

    /**
     * Get the entire cache
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.2
     *
     * @return array
     */
    public static function getCache()
    {
        return self::$cache;
    }

    /**
     * Get cache store/key
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.2
     *
     * @param $store
     *
     * @return mixed
     */
    public static function getCacheStore($store)
    {
        if (!array_key_exists($store, self::$cache)) {
            throw new InflectorCacheException($store, self::$cache);
        }

        return self::$cache[$store];
    }

    /**
     * Table case a phrase or word.
     *
     * E.g
     * <code>
     * Inflector::tableCase('UserRole'); // user_role
     *
     * Inflector::tableCase('User-Role'); // user_role
     * Inflector::tableCase('User.Role'); // user_role
     * Inflector::tableCase('User_Role'); // user_role
     * </code>
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.2
     *
     * @param $phrase
     *
     * @return string
     */
    public static function tableCase($phrase)
    {
        return strtolower(preg_replace('/(?<=\w)(_|-|\.)?([A-Z])/', '_$2', $phrase));
    }

    /**
     * Converts a phrase into a PSR-4 class name
     *
     * Examples
     * <code>
     * Inflector::classCase('user_role'); // UserRole
     * Inflector::classCase('user.role'); // UserRole
     * Inflector::classCase('user-role'); // UserRole
     * Inflector::classCase('User_Role'); // UserRole
     * Inflector::classCase('User.Role'); // UserRole
     * Inflector::classCase('User-Role'); // UserRole
     * Inflector::classCase('userRole'); // UserRole
     * Inflector::classCase('user_Role'); // UserRole
     * Inflector::classCase('user.Role'); // UserRole
     * Inflector::classCase('user-Role'); // UserRole
     * Inflector::classCase('User Role'); // UserRole
     * Inflector::classCase('User role'); // UserRole
     * Inflector::classCase('user role'); // UserRole
     * Inflector::classCase('user Role'); // UserRole
     * </code>
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.2
     *
     * @param string $phrase
     *
     * @return string
     */
    public static function classCase($phrase)
    {
        $split = array_map(function ($word) {
            return ucwords($word);
        }, array_filter(explode(' ', str_replace(['.', '-', '_'], ' ', $phrase)), function ($word) {
            return !empty($word);
        }));

        $phrase = implode('', $split);

        return str_replace(" ", "", ucwords(strtr($phrase, "_-", "  ")));
    }

    /**
     * Camel cases a phrase. Similar to the classCase method
     * however always starting with a lowercase letter
     *
     * Examples
     * <code>
     * Inflector::camelCase('user_role'); // userRole
     * Inflector::camelCase('user.role'); // userRole
     * Inflector::camelCase('user-role'); // userRole
     * Inflector::camelCase('User_Role'); // userRole
     * Inflector::camelCase('User.Role'); // userRole
     * Inflector::camelCase('User-Role'); // userRole
     * Inflector::camelCase('userRole'); // userRole
     * Inflector::camelCase('UserRole'); // userRole
     * Inflector::camelCase('user_Role'); // userRole
     * Inflector::camelCase('user.Role'); // userRole
     * Inflector::camelCase('user-Role'); // userRole
     * Inflector::camelCase('User Role'); // userRole
     * Inflector::camelCase('User role'); // userRole
     * Inflector::camelCase('user role'); // userRole
     * Inflector::camelCase('user Role'); // userRole
     * </code>
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.2
     *
     * @param string $phrase
     *
     * @return string
     */
    public static function camelCase($phrase)
    {
        return lcfirst(self::classCase($phrase));
    }

    /**
     * Uppercases words with configurable delimeters between words.
     *
     * Takes a string and capitalizes all of the words, like PHP's built-in
     * ucwords function.  This extends that behavior, however, by allowing the
     * word delimeters to be configured, rather than only separating on
     * whitespace.
     *
     * Here is an example:
     * <code>
     * $string = "Ara...I wouldn't be fond o' the drink, but when I do go a'it, I do go at it awful-very hard!";
     *
     * Inflector::upperCaseWords($string);
     * // Ara-I-Wouldn't-Morning To All_of_you!
     * </code>
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.0.2
     *
     * @param string $string
     * @param string $delimiters
     *
     * @return string
     */
    public static function upperCaseWords($string, $delimiters = " \n\t\r\0\x0B-_,")
    {
        return preg_replace_callback(
            '/[^' . preg_quote($delimiters, '/') . ']+/',
            function ($matches) {
                return ucfirst($matches[0]);
            },
            $string
        );
    }

    /**
     * Returns a word in plural form.
     *
     * @param string $word The word in singular form.
     *
     * @return string The word in plural form.
     */
    public static function pluralize($word)
    {
        $word = trim($word);
        // Uninflectable
        if (isset(self::getCacheStore('uninflectable')[$word])) {
            return self::$cache['uninflectable'][$word];
        }

        // Uninflectable - Plural
        foreach (self::$rules['uninflectable'] as $type => $rules) {
            if ($type == 'shared' || $type == 'plural') {
                foreach ($rules as $rule => $replacement) {
                    if (preg_match($rule, $word)) {
                        self::$cache['uninflectable'][$word] = preg_replace($rule, $replacement, $word);
                        return self::$cache['uninflectable'][$word];
                    }
                }
            }
        }

        // Irregular
        if (isset(self::getCacheStore('irregular')[$word])) {
            return self::$cache['irregular'][$word];
        }

        foreach (self::$rules['irregular']['plural'] as $rule => $replacement) {
            if (preg_match($rule, $word)) {
                self::$cache['irregular'][$word] = preg_replace($rule, $replacement, $word);
                return self::$cache['irregular'][$word];
            }
        }

        // Plural
        if (isset(self::getCacheStore('plural')[$word])) {
            return self::$cache['plural'][$word];
        }

        foreach (self::$rules['plural'] as $rule => $replacement) {
            if (preg_match($rule, $word)) {
                self::$cache['plural'][$word] = preg_replace($rule, $replacement, $word);
                return self::$cache['plural'][$word];
            }
        }
    }

    public static function singularize($word)
    {
        $word = trim($word);

        // Uninflectable
        if (isset(self::getCacheStore('uninflectable')[$word])) {
            return self::$cache['uninflectable'][$word];
        }

        // Uninflectable - Plural
        foreach (self::$rules['uninflectable'] as $type => $rules) {
            if ($type == 'shared' || $type == 'singular') {
                foreach ($rules as $rule => $replacement) {
                    if (preg_match($rule, $word)) {
                        self::$cache['uninflectable'][$word] = preg_replace($rule, $replacement, $word);
                        return self::$cache['uninflectable'][$word];
                    }
                }
            }
        }

        // Irregular
        if (isset(self::getCacheStore('irregular')[$word])) {
            return self::$cache['irregular'][$word];
        }

        foreach (self::$rules['irregular']['singular'] as $rule => $replacement) {
            if (preg_match($rule, $word)) {
                self::$cache['irregular'][$word] = preg_replace($rule, $replacement, $word);
                return self::$cache['irregular'][$word];
            }
        }

        // Singular
        if (isset(self::getCacheStore('singular')[$word])) {
            return self::$cache['singular'][$word];
        }

        foreach (self::$rules['singular'] as $rule => $replacement) {
            if (preg_match($rule, $word)) {
                self::$cache['singular'][$word] = preg_replace($rule, $replacement, $word);
                return self::$cache['singular'][$word];
            }
        }
    }
}
