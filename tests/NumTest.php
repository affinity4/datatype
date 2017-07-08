<?php
namespace Affinity4\Datatype\Test;

use Affinity4\Datatype\Datatype;
use Affinity4\Datatype\Num;
use PHPUnit\Framework\TestCase;

class NumTest extends TestCase
{
    /**
     * @dataProvider providerAdd
     *
     * @param $value
     * @param $add
     * @param $expected
     */
    public function testAdd($value, $add, $expected)
    {
        $this->assertEquals($expected, Num::set($value)->add($add)->val);
    }

    /**
     * @expectedException \Affinity4\Datatype\Exception\DatatypeException
     * @expectedExceptionMessageRegExp /^Value passed to Affinity4\\Datatype\\Num::set\(\$val\)\-\>add\(\) must be of type \'numeric\'. Type .* given.$/
     */
    public function testAddThrowsExceptionFromSet()
    {
        Num::set([123])->add([1, 2, 3])->val;
    }

    /**
     * @expectedException \Affinity4\Datatype\Exception\DatatypeException
     * @expectedExceptionMessageRegExp /^Value passed to Affinity4\\Datatype\\Num::set\(\$val\)\-\>add\(\$add\) must be an array, number or callable. Type .* given.$/
     */
    public function testAddThrowsExceptionFromAdd()
    {
        Num::set(2)->add('1')->val;
    }

    /**
     * Data provider for testAdd
     *
     * @return array
     */
    public function providerAdd()
    {
        return [
            [1, [1, 2, 3], 7],
            [2, [1.5, 2.5, 3.5], 9.5],
            [2, 2, 4],
            [2.5, 2.5, 5],
            [2, function () {return 1 + 1;}, 4]
        ];
    }

    /**
     * @dataProvider providerAvg
     *
     * @param $val
     * @param $avg
     * @param $expected
     */
    public function testAvg($val, $avg, $expected)
    {
        $this->assertEquals($expected, Num::set($val)->avg($avg)->val);
    }

    /**
     * @expectedException \Affinity4\Datatype\Exception\DatatypeException
     * @expectedExceptionMessageRegExp /^Value passed to Affinity4\\Datatype\\Num::set\(\$val\)\-\>avg\(\) must be of type \'numeric\'. Type .* given.$/
     */
    public function testAvgThrowsExceptionFromSet()
    {
        Num::set([1, 3, 2])->avg([1, 2, 3])->val;
    }

    /**
     * @expectedException \Affinity4\Datatype\Exception\DatatypeException
     * expectedExceptionMessageRegExp /^Value passed to Affinity4\\Datatype\\Num::set\(\$val\)\-\>avg\(\$avg\) must be an array, number or callable. Type .* given.$/
     */
    public function testAvgThrowsExceptionFromAvg()
    {
        Num::set(1)->avg('1')->val;
    }

    /**
     * Data provider for testAvg
     *
     * @return array
     */
    public function providerAvg()
    {
        return [
            [1, [1, 2, 3], 1.75]
        ];
    }

    /**
     * @dataProvider providerDivideBy
     *
     * Test Arr::set method
     */
    public function testDivideBy($num, $divisor, $expected)
    {
        $this->assertEquals($expected, Num::set($num)->divideBy($divisor)->val);
    }

    /**
     * @expectedException \Affinity4\Datatype\Exception\DatatypeException
     * @expectedExceptionMessageRegExp /^Value passed to Affinity4\\Datatype\\Num::set\(\$val\)\-\>divideBy\(\$num\) must be an array, number or callable. Type .* given.$/
     */
    public function testDivideByThrowsException()
    {
        Num::set(2)->divideBy('1')->val;
    }

    /**
     * Data provider for testDivideBy
     *
     * @return array
     */
    public function providerDivideBy()
    {
        return [
            [2, 2, 1],
            [5, 2, 2.5],
            ['10.6', 2, 5.3],
            [5, function () {return 1 + 1;}, 2.5]
        ];
    }

    /**
     * @dataProvider providerSet
     *
     * Test Arr::set method
     */
    public function testSet($num, $expected)
    {
        $this->assertInstanceOf(Num::class, Num::set($num));
        $this->assertEquals($expected, Num::set($num)->val);
    }

    /**
     * Data provider for testSet
     *
     * @return array
     */
    public function providerSet()
    {
        return [
            [1, 1],
            [1.1, 1.1],
            [1E01, 1e01],
            ['1', 1],
            ['1.1', 1.1],
        ];
    }
}
