<?php
namespace Affinity4\Datatype\Test;

use PHPUnit\Framework\TestCase;
use Affinity4\Datatype\Str;

class StrTest extends TestCase
{
	public function setUp()
	{
		$this->str = new Str; 
	}

	/**
	 * @covers Str::match
	 */
	public function testMatch()
	{
		$this->assertEquals('one two three', $this->str->match('one two three', 'one two three four five'));
	}
}