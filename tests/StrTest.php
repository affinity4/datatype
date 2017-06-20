<?php
namespace Affinity4\Datatype\Test;

use PHPUnit\Framework\TestCase;
use Affinity4\Datatype\Str;

/**
 * Class StrTest
 *
 * @package Affinity4\Datatype\Test
 */
class StrTest extends TestCase
{
	/**
	 * @var
	 */
	private $str;

	/**
	 * @var
	 */
	private $mockToString;

	/**
	 * Setup for tests
	 */
	public function setUp()
	{
		$this->str = new Str;
		$this->mockToString = $this->getMockBuilder('ToString')->setMethods(['__toString'])->getMock();
	}

	/**
	 * Tests e method
	 *
	 * @dataProvider providerE
	 *
	 * @param $value
	 * @param $expected
	 */
	public function testE($value, $expected)
	{
		$this->assertEquals($expected, Str::from($value)->e()->string);
	}

	/**
	 * Tests ee method
	 *
	 * @dataProvider providerE
	 *
	 * @param $expected
	 * @param $value
	 */
	public function testEe($expected, $value)
	{
		$this->assertEquals($expected, Str::from($value)->ee()->string);
	}

	/**
	 * Data Provider for testE and testEe methods
	 *
	 * @return array
	 */
	public function providerE()
	{
		return [
			['<a href=\'test\'>Test</a>', '&lt;a href=&apos;test&apos;&gt;Test&lt;/a&gt;'],
		];
	}

	/**
	 * Test Str::from method
	 */
	public function testFrom()
	{
		$this->assertInstanceOf(Str::class, Str::from('String'));
		$this->assertEquals('String', Str::from('String')->string);
	}

	/**
	 * Test format method
	 *
	 * @dataProvider providerFormat
	 *
	 * @param $format
	 * @param $args
	 * @param $expected
	 */
	public function testFormat($format, $args, $expected)
	{
		$this->assertEquals('Hello Luke Watts', Str::from('Hello {} {}')->format('Luke', 'Watts')->string);
		$this->assertEquals('Luke Watts is your name. How are you Mr. Watts?', Str::from('{} {} is your name. How are you Mr. {1}?')->format('Luke', 'Watts')->string);
		$this->assertEquals($expected, Str::from($format)->format($args)->string);
	}

	/**
	 * Provider for testFormat method
	 *
	 * @return array
	 */
	public function providerFormat()
	{
		return [
			['Hello {} {}', ['Luke', 'Watts'], 'Hello Luke Watts'],
			['Hello {0} {1}', ['Luke', 'Watts'], 'Hello Luke Watts'],
			['Hello {0} {1}. How are you Mr. {1}?', ['Luke', 'Watts'], 'Hello Luke Watts. How are you Mr. Watts?'],
			['Hello {} {}. How are you Mr. {1}?', ['Luke', 'Watts'], 'Hello Luke Watts. How are you Mr. Watts?'],
			['Hello {first_name} {last_name}. How are you Mr. {last_name}?', ['first_name' => 'Luke', 'last_name' => 'Watts'], 'Hello Luke Watts. How are you Mr. Watts?'],
			['Hello {first_name} {last_name}. You are an {}', ['first_name' => 'Luke', 'last_name' => 'Watts', 'admin'], 'Hello Luke Watts. You are an admin'],
			['Hello {first_name} {last_name}. You are an {0}', ['first_name' => 'Luke', 'last_name' => 'Watts', 'admin'], 'Hello Luke Watts. You are an admin']
		];
	}

	/**
	 * Test html method
	 *
	 * @dataProvider providerHtml
	 *
	 * @param $value
	 * @param $expected
	 */
	public function testHtml($value, $expected)
	{
		$this->assertEquals($expected, Str::from($value)->html()->string);
	}

	/**
	 * Test htmlDecode method
	 *
	 * @dataProvider providerHtml
	 *
	 * @param $expected
	 * @param $value
	 */
	public function testHtmlDecode($expected, $value)
	{
		$this->assertEquals($expected, Str::from($value)->htmlDecode()->string);
	}

	/**
	 * Data Provider for testHtml method
	 *
	 * @return array
	 */
	public function providerHtml()
	{
		return [
			['<script>alert(\'XSS Attack!\');</script>', '&lt;script&gt;alert&lpar;&apos;XSS Attack&excl;&apos;&rpar;&semi;&lt;&sol;script&gt;'],
		];
	}

	/**
	 * Test join method
	 *
	 * @dataProvider providerJoin
	 *
	 * @param $value
	 * @param $glue
	 * @param $expected
	 */
	public function testJoin($value, $glue, $expected)
	{
		$this->assertEquals($expected, Str::from($value)->join($glue)->string);
	}

	/**
	 * Data Provider for testJoin method
	 *
	 * @return array
	 */
	public function providerJoin()
	{
		return [
			[['one', 'two', 'three'], ' ', 'one two three'],
			[[1, 2, 3], ' ', '1 2 3'],
			[['one', 'two', 'three'], '+', 'one+two+three'],
			[[1, 2, 3], '|', '1|2|3']

		];
	}

	/**
	 * Test lcFirst method
	 *
	 * @dataProvider providerLcFirst
	 *
	 * @param $value
	 * @param $expected
	 */
	public function testLcFirst($value, $expected)
	{
		$this->assertEquals($expected, Str::from($value)->lcFirst()->string);
	}

	/**
	 * Data Provider for testLcFirst method
	 *
	 * @return array
	 */
	public function providerLcFirst()
	{
		return [
			['one two three', 'one two three'],
			['One two three', 'one two three'],
			['One Two Three', 'one Two Three'],
			['ONE TWO THREE', 'oNE TWO THREE'],
			['123', '123'],
			[123, 123]
		];
	}

	/**
	 * Test length method
	 *
	 * @dataProvider providerLength
	 *
	 * @param $value
	 * @param $expected
	 */
	public function testLength($value, $expected)
	{
		$this->assertEquals($expected, Str::length($value));
	}

	/**
	 * Data Provider for testLength method
	 *
	 * @return array
	 */
	public function providerLength()
	{
		return [
			['one two three', 13],
			['One two three four', 18],
			['1', 1],
			['', 0],
			['123', 3],
			[123, 3],
			[false, false],
		];
	}

	/**
	 * Test lower method
	 *
	 * @dataProvider providerLower
	 *
	 * @param $value
	 * @param $expected
	 */
	public function testLower($value, $expected)
	{
		$this->assertEquals($expected, Str::from($value)->lower()->string);
	}

	/**
	 * Data Provider for testLower method
	 *
	 * @return array
	 */
	public function providerLower()
	{
		return [
			['one two three', 'one two three'],
			['One two three', 'one two three'],
			['One Two Three', 'one two three'],
			['ONE TWO THREE', 'one two three'],
			['123', '123'],
			[123, 123]
		];
	}

	/**
	 * Test for pos method
	 *
	 * @dataProvider providerPos
	 */
	public function testPos($needle, $haystack, $expected)
	{
		$this->assertEquals($expected, Str::pos($needle, $haystack));
	}

	/**
	 * Data provider for testPos method
	 *
	 * @return array
	 */
	public function providerPos()
	{
		return [
			['one two three', 'one two three four five', 0],
			['two three', 'one two three four five', 4],
			['five six', 'one two three four five', false],
		];
	}

	/**
	 * Test split method
	 *
	 * @dataProvider providerSplit
	 *
	 * @param $string
	 * @param $delimiter
	 * @param $expected
	 */
	public function testSplit($string, $delimiter, $expected)
	{
		$this->assertEquals($expected, Str::from($string)->split($delimiter)->string);
	}

	/**
	 * Data provider for testSplit
	 *
	 * @return array
	 */
	public function providerSplit()
	{
		return [
			['one two three', [' '], ['one', 'two', 'three']],
			['one two-three+four', [' ', '-', '+'], ['one', 'two', 'three', 'four']],
			['one two-three+four|five', [' ', '-', '+', '|'], ['one', 'two', 'three', 'four', 'five']]
		];
	}

	/**
	 * Test Str::toInt method
	 *
	 * @dataProvider providerToInt
	 *
	 * @param $string
	 * @param $expected
	 */
	public function testToInt($string, $expected)
	{
		$this->assertEquals($expected, Str::toInt($string));
	}

	/**
	 * Data provider for testToInt method
	 *
	 * @return array
	 */
	public function providerToInt()
	{
		return [
			['123', 123],
			[' 123', 123],
			[
				function () {
					return '123';
				}, 123
			],
			[true, 1],
			[false, 0],
			[new ToString, 123],
			[[1, 2, 'some text', 3], 123]
		];
	}

	/**
	 * Test ucFirst method
	 *
	 * @dataProvider providerUcFirst
	 *
	 * @param $value
	 * @param $expected
	 */
	public function testUcFirst($value, $expected)
	{
		$this->assertEquals($expected, Str::from($value)->ucFirst()->string);
	}

	/**
	 * Data provider for testUcFirst method
	 *
	 * @return array
	 */
	public function providerUcFirst()
	{
		return [
			['One two three', 'One two three'],
			['ONE TWO THREE', 'ONE TWO THREE'],
			['one two three', 'One two three'],
			[123, 123],
			['123', '123'],
		];
	}

	/**
	 * Test ucWords method
	 *
	 * @dataProvider providerUcWords
	 *
	 * @param $value
	 * @param $expected
	 */
	public function testUcWords($value, $expected)
	{
		$this->assertEquals($expected, Str::from($value)->ucWords()->string);
	}

	/**
	 * Data provider for testUcWordsmethod
	 *
	 * @return array
	 */
	public function providerUcWords()
	{
		return [
			['One Two Three', 'One Two Three'],
			['ONE TWO THREE', 'ONE TWO THREE'],
			['one two three', 'One Two Three'],
			['One two three', 'One Two Three'],
			[123, 123],
			['123', '123'],
		];
	}

	/**
	 * Test upper method
	 *
	 * @dataProvider providerUpper
	 *
	 * @param $value
	 * @param $expected
	 */
	public function testUpper($value, $expected)
	{
		$this->assertEquals($expected, Str::from($value)->upper()->string);
	}

	/**
	 * Data provider for testUpper method
	 *
	 * @return array
	 */
	public function providerUpper()
	{
		return [
			['ONE TWO THREE', 'ONE TWO THREE'],
			['One Two Three', 'ONE TWO THREE'],
			['One two three', 'ONE TWO THREE'],
			['one two three', 'ONE TWO THREE'],
			[123, 123],
			['123', '123'],
		];
	}

	/**
	 * Test trim method
	 *
	 * @dataProvider providerTrim
	 *
	 * @param $value
	 * @param $character_mask
	 * @param $expected
	 */
	public function testTrim($value, $character_mask, $expected)
	{
		$this->assertEquals($expected, Str::from($value)->trim($character_mask)->string);
	}

	/**
	 * Data provider for testTrim method
	 *
	 * @return array
	 */
	public function providerTrim()
	{
		return [
			['one two three', null, 'one two three'],
			[' one two three', null, 'one two three'],
			[' one two three ', null, 'one two three'],
			['one two three ', null, 'one two three'],
			['-123', '-', '123'],
			['-123-', '-', '123'],
			['123-', '-', '123'],
		];
	}

	/**
	 * Test trimLeft method
	 *
	 * @dataProvider providerTrimLeft
	 *
	 * @param $value
	 * @param $character_mask
	 * @param $expected
	 */
	public function testTrimLeft($value, $character_mask, $expected)
	{
		$this->assertEquals($expected, Str::from($value)->trimLeft($character_mask)->string);
	}

	/**
	 * Data provider for testTrimLeft method
	 *
	 * @return array
	 */
	public function providerTrimLeft()
	{
		return [
			['one two three', null, 'one two three'],
			[' one two three', null, 'one two three'],
			[' one two three ', null, 'one two three '],
			['one two three ', null, 'one two three '],
			['-123', '-', '123'],
			['-123-', '-', '123-'],
			['123-', '-', '123-'],
		];
	}

	/**
	 * Test trimRight method
	 *
	 * @dataProvider providerTrimRight
	 *
	 * @param $value
	 * @param $character_mask
	 * @param $expected
	 */
	public function testTrimRight($value, $character_mask, $expected)
	{
		$this->assertEquals($expected, Str::from($value)->trimRight($character_mask)->string);
	}

	/**
	 * Data provider for testTrimRight method
	 *
	 * @return array
	 */
	public function providerTrimRight()
	{
		return [
			['one two three', null, 'one two three'],
			[' one two three', null, ' one two three'],
			[' one two three ', null, ' one two three'],
			['one two three ', null, 'one two three'],
			['-123', '-', '-123'],
			['-123-', '-', '-123'],
			['123-', '-', '123'],
		];
	}
}

/**
 * Class ToString
 *
 * @package Affinity4\Datatype\Test
 */
class ToString
{
	public $value;

	public function __construct()
	{
		$this->value = '123';
	}

	public function __toString()
	{
		return (string) $this->value;
	}
}