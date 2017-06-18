<?php
/**
 * Created by PhpStorm.
 * User: LukeWatts85
 * Date: 14/06/2017
 * Time: 11:14
 */

namespace Affinity4\Datatype\Test;


use Affinity4\Datatype\Support\Inflector;
use PHPUnit\Framework\TestCase;

class InflectorTest extends TestCase
{
    /**
     * @expectedException \Affinity4\Datatype\Support\Exception\InflectorCacheException
     * @expectedExceptionMessageRegExp /^(.*) is not a correct cache key. Must be one of: (.*(, )?)$/
     */
    public function testSetCacheThrowsInvalidArgumentException()
    {
        $word = 'user';

        Inflector::setCache('no_such_key', $word);
    }

    /**
     * @throws \Affinity4\Datatype\Support\Exception\InflectorCacheException
     */
    public function testSetAndGetCache()
    {
        $word = 'user';

        Inflector::setCache('plural', $word);

        $this->assertArrayHasKey('plural', Inflector::getCache());
        $this->assertContains($word, Inflector::getCache()['plural']);
    }

    public function testGetCacheStore()
    {
        $word = 'user';

        Inflector::setCache('plural', $word);

        $this->assertContains($word, Inflector::getCacheStore('plural'));
    }

    public function testTableCase()
    {
        $expected = 'user_role';

        $this->assertEquals($expected, Inflector::tableCase('UserRole'));
        $this->assertEquals($expected, Inflector::tableCase('User-Role'));
        $this->assertEquals($expected, Inflector::tableCase('User.Role'));
        $this->assertEquals($expected, Inflector::tableCase('User_Role'));
    }

    public function testClassCase()
    {
        $expected = 'UserRole';

        $this->assertEquals($expected, Inflector::classCase('user_role'));
        $this->assertEquals($expected, Inflector::classCase('user.role'));
        $this->assertEquals($expected, Inflector::classCase('user-role'));
        $this->assertEquals($expected, Inflector::classCase('User_Role'));
        $this->assertEquals($expected, Inflector::classCase('User.Role'));
        $this->assertEquals($expected, Inflector::classCase('User-Role'));
        $this->assertEquals($expected, Inflector::classCase('userRole'));
        $this->assertEquals($expected, Inflector::classCase('user_Role'));
        $this->assertEquals($expected, Inflector::classCase('user.Role'));
        $this->assertEquals($expected, Inflector::classCase('user-Role'));
        $this->assertEquals($expected, Inflector::classCase('User Role'));
        $this->assertEquals($expected, Inflector::classCase('User role'));
        $this->assertEquals($expected, Inflector::classCase('user role'));
        $this->assertEquals($expected, Inflector::classCase('user Role'));
    }

    public function testCamelCase()
    {
        $expected = 'userRole';

        $this->assertEquals($expected, Inflector::camelCase('user_role'));
        $this->assertEquals($expected, Inflector::camelCase('user.role'));
        $this->assertEquals($expected, Inflector::camelCase('user-role'));
        $this->assertEquals($expected, Inflector::camelCase('User_Role'));
        $this->assertEquals($expected, Inflector::camelCase('User.Role'));
        $this->assertEquals($expected, Inflector::camelCase('User-Role'));
        $this->assertEquals($expected, Inflector::camelCase('userRole'));
        $this->assertEquals($expected, Inflector::camelCase('UserRole'));
        $this->assertEquals($expected, Inflector::camelCase('user_Role'));
        $this->assertEquals($expected, Inflector::camelCase('user.Role'));
        $this->assertEquals($expected, Inflector::camelCase('user-Role'));
        $this->assertEquals($expected, Inflector::camelCase('User Role'));
        $this->assertEquals($expected, Inflector::camelCase('User role'));
        $this->assertEquals($expected, Inflector::camelCase('user role'));
        $this->assertEquals($expected, Inflector::camelCase('user Role'));
    }

    public function testUpperCaseWords()
    {
        $expected = "Ara...I Wouldn't Be Fond O' The Drink, But When I Do Go A'it, I Do Go At It Awful-Very Hard!";
        $string = "Ara...I wouldn't be fond o' the drink, but when I do go a'it, I do go at it awful-very hard!";

        $this->assertEquals($expected, Inflector::upperCaseWords($string));
    }

    public function testTitleCase()
    {
        $expected = 'It\'s a Title-with-the-Words but and Which Should Be Capitalized';
        $string = 'It\'s_A_Title-With-The-Words But And Which Should Be Capitalized';

        $this->assertEquals($expected, Inflector::titleCase($string));
        $this->assertEquals('It\'s a Title-with-the-Words but and Which Should be Capitalized', Inflector::titleCase($string, 'conjunctions|be'));
    }

    /**
     * @dataProvider vocabularyProvider
     *
     * @param $singular
     * @param $plural
     */
    public function testPluralize($singular, $plural)
    {
        $this->assertEquals($plural, Inflector::pluralize($singular), "'$singular' should be pluralized to '$plural'");
    }

    /**
     * @dataProvider vocabularyProvider
     *
     * @param $singular
     * @param $plural
     */
    public function testSingular($singular, $plural)
    {
        $this->assertEquals($singular, Inflector::singularize($plural), "'$plural' should be singularized to '$singular'");
    }

    /**
     * @dataProvider ordinalProvider
     *
     * @param $number
     * @param $expected
     */
    public function testOrdinalize($number, $ordinal)
    {
        $this->assertEquals($ordinal, Inflector::ordinalize($number));
    }

    /**
     * @dataProvider ordinalProvider
     * @param $number
     * @param $ordinal
     */
    public function testDeordinalize($number, $ordinal)
    {
        $this->assertInternalType('integer', Inflector::deordinalize($ordinal));
        $this->assertEquals($number, Inflector::deordinalize($ordinal));
    }

    public function ordinalProvider()
    {
        return [
            [1, '1st'],
            [2, '2nd'],
            [3, '3rd'],
            [4, '4th'],
            [5, '5th'],
            [6, '6th'],
            [7, '7th'],
            [8, '8th'],
            [9, '9th'],
            [10, '10th'],
            [11, '11th'],
            [12, '12th'],
            [13, '13th'],
            [14, '14th'],
            [15, '15th'],
            [16, '16th'],
            [17, '17th'],
            [18, '18th'],
            [19, '19th'],
            [20, '20th'],
            [21, '21st'],
            [22, '22nd'],
            [23, '23rd'],
            [24, '24th'],
            [25, '25th'],
            [26, '26th'],
            [27, '27th'],
            [28, '28th'],
            [29, '29th'],
            [30, '30th'],
            [31, '31st'],
        ];
    }

    public function vocabularyProvider()
    {
        // Format: ['Singular', 'Plural']
        return [
            ['', ''],
            ['Alias', 'Aliases'],
            ['alumnus', 'alumni'],
            ['analysis', 'analyses'],
            ['aquarium', 'aquaria'],
            ['arch', 'arches'],
            ['atlas', 'atlases'],
            ['axe', 'axes'],
            ['baby', 'babies'],
            ['bacillus', 'bacilli'],
            ['bacterium', 'bacteria'],
            ['bureau', 'bureaus'],
            ['bus', 'buses'],
            ['Bus', 'Buses'],
            ['cactus', 'cacti'],
            ['cafe', 'cafes'],
            ['calf', 'calves'],
            ['categoria', 'categorias'],
            ['chateau', 'chateaux'],
            ['cherry', 'cherries'],
            ['child', 'children'],
            ['church', 'churches'],
            ['circus', 'circuses'],
            ['city', 'cities'],
            ['cod', 'cod'],
            ['cookie', 'cookies'],
            ['copy', 'copies'],
            ['crisis', 'crises'],
            ['criterion', 'criteria'],
            ['curriculum', 'curricula'],
            ['curve', 'curves'],
            ['deer', 'deer'],
            ['demo', 'demos'],
            ['dictionary', 'dictionaries'],
            ['domino', 'dominoes'],
            ['dwarf', 'dwarves'],
            ['echo', 'echoes'],
            ['elf', 'elves'],
            ['emphasis', 'emphases'],
            ['equipment', 'equipment'],
            ['family', 'families'],
            ['fax', 'faxes'],
            ['fish', 'fish'],
            ['flush', 'flushes'],
            ['fly', 'flies'],
            ['focus', 'foci'],
            ['foe', 'foes'],
            ['food_menu', 'food_menus'],
            ['FoodMenu', 'FoodMenus'],
            ['foot', 'feet'],
            ['fungus', 'fungi'],
            ['glove', 'gloves'],
            ['gulf', 'gulfs'],
            ['half', 'halves'],
            ['hero', 'heroes'],
            ['hippopotamus', 'hippopotami'],
            ['hoax', 'hoaxes'],
            ['hoof', 'hooves'],
            ['house', 'houses'],
            ['human', 'humans'],
            ['identity', 'identities'],
            ['index', 'indices'],
            ['information', 'information'],
            ['iris', 'irises'],
            ['kiss', 'kisses'],
            ['knife', 'knives'],
            ['leaf', 'leaves'],
            ['life', 'lives'],
            ['loaf', 'loaves'],
            ['man', 'men'],
            ['matrix', 'matrices'],
            ['matrix_row', 'matrix_rows'],
            ['medium', 'media'],
            ['memorandum', 'memoranda'],
            ['menu', 'menus'],
            ['Menu', 'Menus'],
            ['mess', 'messes'],
            ['moose', 'moose'],
            ['motto', 'mottoes'],
            ['mouse', 'mice'],
            ['neurosis', 'neuroses'],
            ['news', 'news'],
            ['NodeMedia', 'NodeMedia'],
            ['nucleus', 'nuclei'],
            ['oasis', 'oases'],
            ['octopus', 'octopuses'],
            ['pass', 'passes'],
            ['person', 'people'],
            ['plateau', 'plateaux'],
            ['potato', 'potatoes'],
            ['powerhouse', 'powerhouses'],
            ['quiz', 'quizzes'],
            ['radius', 'radii'],
            ['reflex', 'reflexes'],
            ['roof', 'roofs'],
            ['runner-up', 'runners-up'],
            ['scarf', 'scarves'],
            ['scratch', 'scratches'],
            ['series', 'series'],
            ['sheep', 'sheep'],
            ['shelf', 'shelves'],
            ['shoe', 'shoes'],
            ['son-in-law', 'sons-in-law'],
            ['species', 'species'],
            ['splash', 'splashes'],
            ['spy', 'spies'],
            ['stimulus', 'stimuli'],
            ['stitch', 'stitches'],
            ['story', 'stories'],
            ['syllabus', 'syllabi'],
            ['tax', 'taxes'],
            ['terminus', 'termini'],
            ['thesis', 'theses'],
            ['thief', 'thieves'],
            ['tomato', 'tomatoes'],
            ['tooth', 'teeth'],
            ['tornado', 'tornadoes'],
            ['try', 'tries'],
            ['vertex', 'vertices'],
            ['virus', 'viri'],
            ['volcano', 'volcanoes'],
            ['wash', 'washes'],
            ['watch', 'watches'],
            ['wave', 'waves'],
            ['wharf', 'wharves'],
            ['wife', 'wives'],
            ['woman', 'women'],
        ];
    }
}