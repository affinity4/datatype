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
	 * @dataProvider providerCropChars
	 *
	 * @param $data
	 */
	public function testCropChars($data)
	{
		$this->assertEquals($data['expected'], Str::set($data['original'])->cropChars($data['at'], $data['append'], $data['flag'])->val);
	}

	/**
	 * Data provider for testCropChars
	 *
	 * @return array
	 */
	public function providerCropChars()
	{
		return [
			[
				[
					'original' => 'one two three four five six seven eight nine ten.',
					'at'       => 10,
					'append'   => '...',
					'flag'	   => Str::SOFT_CROP,
					'expected' => 'one two th...'
				]
			],
			[
				[
					'original' => 'one two three four five six seven eight nine ten.',
					'at'       => 10,
					'append'   => null,
					'flag' => Str::SOFT_CROP,
					'expected' => 'one two th'
				]
			],
			[
				[
					'original' => 'one two three four five six seven eight nine ten.',
					'at'       => 50,
					'append'   => null,
					'flag' => Str::SOFT_CROP,
					'expected' => 'one two three four five six seven eight nine ten.'
				]
			],
			[
				[
					'original' => 'one two three four five six seven eight nine ten.',
					'at'       => 50,
					'append'   => null,
					'flag' => Str::HARD_CROP,
					'expected' => 'one two three four five six seven eight nine ten.'
				]
			],
			[
				[
					'original' => 'one two three four five six seven eight nine ten.',
					'at'       => 50,
					'append'   => '...',
					'flag' => Str::SOFT_CROP,
					'expected' => 'one two three four five six seven eight nine ten.'
				]
			],
			[
				[
					'original' => 'one two three four five six seven eight nine ten.',
					'at'       => 50,
					'append'   => '...',
					'flag' => Str::HARD_CROP,
					'expected' => 'one two three four five six seven eight nine te...'
				]
			],

		];
	}
	/**
	 * @dataProvider providerCropWords
	 *
	 * @param $data
	 */
	public function testCropWords($data)
	{
		$this->assertEquals($data['expected'], Str::set($data['original'])->cropWords($data['at'], $data['append'])->val);
	}

	/**
	 * Data provider for testCropWords
	 *
	 * @return array
	 */
	public function providerCropWords()
	{
		return [
			[
				[
					'original'	=> 'one two three four five six seven eight nine ten.',
					'at'		=> 7,
					'append'   	=> '...',
					'expected' 	=> 'one two three four five six seven...'
				]
			],
			[
				[
					'original' 	=> 'one two three four five six seven eight nine ten.',
					'at'     	=> 7,
					'append' 	=> null,
					'expected' 	=> 'one two three four five six seven'
				]
			],
			[
				[
					'original' 	=> 'one two three four five six seven eight nine ten.',
					'at'		=> 12,
					'append' 	=> null,
					'expected' 	=> 'one two three four five six seven eight nine ten.'
				]
			],
			[
				[
					'original' 	=> 'one two three four five six seven eight nine ten.',
					'at'		=> 12,
					'append' 	=> null,
					'expected' 	=> 'one two three four five six seven eight nine ten.'
				]
			],
			[
				[
					'original' 	=> 'one two three four five six seven eight nine ten.',
					'at'		=> 12,
					'append' 	=> '...',
					'expected' 	=> 'one two three four five six seven eight nine ten.'
				]
			],
			[
				[
					'original' 	=> 'one two three four five six seven eight nine ten.',
					'at'		=> 12,
					'append' 	=> '&ellip;',
					'expected' 	=> 'one two three four five six seven eight nine ten.'
				]
			],

		];
	}

	/**
	 * @expectedException \Affinity4\Datatype\Exception\DatatypeException
	 *
	 * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->cropWords\(\) must be of type 'string'. Type .* given\.$/
	 */
	public function testCropWordsException()
	{
		Str::set(123)->cropWords(2, '...')->val;
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
		$this->assertEquals($expected, Str::set($value)->e()->val);
	}

	/**
	 * @expectedException \Affinity4\Datatype\Exception\DatatypeException
	 *
	 * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->e\(\) must be of type 'string'. Type .* given\.$/
	 */
	public function testEException()
	{
		Str::set(123)->e()->val;
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
		$this->assertEquals($expected, Str::set($value)->ee()->val);
	}

	/**
	 * @expectedException \Affinity4\Datatype\Exception\DatatypeException
	 *
	 * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->ee\(\) must be of type 'string'. Type .* given\.$/
	 */
	public function testEeException()
	{
		Str::set(123)->ee()->val;
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
	 * Test Str::set method
	 */
	public function testSet()
	{
		$this->assertInstanceOf(Str::class, Str::set('String'));
		$this->assertEquals('String', Str::set('String')->val);
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
		$this->assertEquals('Hello Luke Watts', Str::set('Hello {} {}')->format('Luke', 'Watts')->val);
		$this->assertEquals('Luke Watts is your name. How are you Mr. Watts?', Str::set('{} {} is your name. How are you Mr. {1}?')->format('Luke', 'Watts')->val);
		$this->assertEquals($expected, Str::set($format)->format($args)->val);
	}

	/**
	 * @expectedException \Affinity4\Datatype\Exception\DatatypeException
	 *
	 * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->format\(\) must be of type 'string'. Type .* given\.$/
	 */
	public function testFormatException()
	{
		Str::set(123)->format()->val;
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
		$this->assertEquals($expected, Str::set($value)->html()->val);
	}

	/**
	 * @expectedException \Affinity4\Datatype\Exception\DatatypeException
	 *
	 * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->html\(\) must be of type 'string'. Type .* given\.$/
	 */
	public function testHtmlException()
	{
		Str::set(123)->html()->val;
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
		$this->assertEquals($expected, Str::set($value)->htmlDecode()->val);
	}

	/**
	 * @expectedException \Affinity4\Datatype\Exception\DatatypeException
	 *
	 * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->htmlDecode\(\) must be of type 'string'. Type .* given\.$/
	 */
	public function testHtmlDecodeException()
	{
		Str::set(123)->htmlDecode()->val;
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
	 * Test lcFirst method
	 *
	 * @dataProvider providerLcFirst
	 *
	 * @param $value
	 * @param $expected
	 */
	public function testLcFirst($value, $expected)
	{
		$this->assertEquals($expected, Str::set($value)->lcFirst()->val);
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
		];
	}

	/**
	 * @expectedException \Affinity4\Datatype\Exception\DatatypeException
	 *
	 * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->lcFirst\(\) must be of type 'string'. Type .* given\.$/
	 */
	public function testLcFirstException()
	{
		Str::set(123)->lcFirst()->val;
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
		$this->assertEquals($expected, Str::set($value)->length()->val);
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
		];
	}

	/**
	 * @expectedException \Affinity4\Datatype\Exception\DatatypeException
	 *
	 * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->length\(\) must be of type 'string'. Type .* given\.$/
	 */
	public function testLengthException()
	{
		Str::set(123)->length()->val;
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
		$this->assertEquals($expected, Str::set($value)->lower()->val);
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
		];
	}

	/**
	 * @expectedException \Affinity4\Datatype\Exception\DatatypeException
	 *
	 * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->lower\(\) must be of type 'string'. Type .* given\.$/
	 */
	public function testLowerException()
	{
		Str::set(123)->lower()->val;
	}

	/**
	 * Test for pos method
	 *
	 * @dataProvider providerPos
	 *
	 * @param $needle
	 * @param $value
	 * @param $expected
	 */
	public function testPos($needle, $value, $expected)
	{
		$this->assertEquals($expected, Str::set($value)->pos($needle)->val);
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
		$this->assertEquals($expected, Str::set($string)->split($delimiter)->val);
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
		$this->assertEquals($expected, Str::set($string)->toInt()->val);
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
		$this->assertEquals($expected, Str::set($value)->ucFirst()->val);
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
			['123', '123'],
		];
	}

	/**
	 * @expectedException \Affinity4\Datatype\Exception\DatatypeException
	 *
	 * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->ucFirst\(\) must be of type 'string'. Type .* given\.$/
	 */
	public function testUcFirstException()
	{
		Str::set(123)->ucFirst()->val;
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
		$this->assertEquals($expected, Str::set($value)->ucWords()->val);
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
			['123', '123'],
		];
	}

	/**
	 * @expectedException \Affinity4\Datatype\Exception\DatatypeException
	 *
	 * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->ucWords\(\) must be of type 'string'. Type .* given\.$/
	 */
	public function testUcWordsException()
	{
		Str::set(123)->ucWords()->val;
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
		$this->assertEquals($expected, Str::set($value)->upper()->val);
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
			['123', '123'],
		];
	}

	/**
	 * @expectedException \Affinity4\Datatype\Exception\DatatypeException
	 *
	 * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->upper\(\) must be of type 'string'. Type .* given\.$/
	 */
	public function testUpperException()
	{
		Str::set(123)->upper()->val;
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
		$this->assertEquals($expected, Str::set($value)->trim($character_mask)->val);
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
		$this->assertEquals($expected, Str::set($value)->trimLeft($character_mask)->val);
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
		$this->assertEquals($expected, Str::set($value)->trimRight($character_mask)->val);
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