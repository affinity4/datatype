<?php
namespace Affinity4\Datatype\Test;

use Affinity4\Datatype\Arr;
use Affinity4\Datatype\Exception\DatatypeException;
use Affinity4\Datatype\Num;
use Affinity4\Datatype\Str;
use PHPUnit\Framework\TestCase;

class ArrTest extends TestCase
{
    /**
     * @dataProvider providerAvg
     *
     * @param $array
     * @param $expected
     */
    public function testAvg($array, $expected)
    {
        $this->assertInstanceOf(Num::class, Arr::set($array)->avg());
        $this->assertEquals($expected, Arr::set($array)->avg()->val);
    }

    /**
     * Data provider for testSum
     *
     * @return array
     */
    public function providerAvg()
    {
        return [
            [[1, 2, 3], 2],
            [['one', 'two', 'three'], 0],
            [['a' => 1.27, 'b' => '5.83'], 3.5499999999999998]
        ];
    }

    /**
     * @expectedException \Affinity4\Datatype\Exception\DatatypeException
     *
     * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->avg\(\) must be of type 'array'. Type .* given\.$/
     */
    public function testAvgException()
    {
        Arr::set(1)->avg()->val;
    }

    /**
     * @dataProvider providerColumns
     *
     * @param $array
     * @param $expected
     */
    public function testColumns($array, $expected)
    {
        $this->assertEquals($expected, Arr::set($array)->columns()->val);
    }

    /**
     * Data provider for testColumns
     *
     * @return array
     */
    public function providerColumns()
    {
        return [
            [[1, 2, 3], [[0, 1, 2], [1, 2, 3]]],
            [['fruit' => 'apple', 'color' => 'red'], [['fruit', 'color'], ['apple', 'red']]],
            [['fruit' => 'apple', 'colors' => ['red', 'green']], [['fruit', 'colors'], ['apple', ['red', 'green']]]],
        ];
    }

    /**
     * @expectedException \Affinity4\Datatype\Exception\DatatypeException
     *
     * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->columns\(\) must be of type 'array' or instance of 'ArrayAccess'. Type .* given\.$/
     */
    public function testColumnsException()
    {
        Arr::set(1)->columns()->val;
    }

    /**
     * @dataProvider providerExcept
     *
     * @param $value
     * @param $remove
     * @param $expected
     */
    public function testExcept($value, $remove, $expected)
    {
        $this->assertEquals($expected, Arr::set($value)->except($remove)->val);
    }

    /**
     * Data provider for testExcept
     *
     * @return array
     */
    public function providerExcept()
    {
        return [
            [[1, 2, 3, 4, 5, 6], [0, 2, 4], [1 => 2, 3 => 4, 5 => 6]],
        ];
    }

    /**
     * @expectedException \Affinity4\Datatype\Exception\DatatypeException
     *
     * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->except\(\) must be of type 'array' or instance of 'ArrayAccess'. Type .* given\.$/
     */
    public function testExceptException()
    {
        Arr::set(1)->except([1, 2, 3])->val;
    }

    /**
     * @dataProvider providerExists
     *
     * @param $value
     * @param $key
     * @param $callback
     * @param $expected
     */
    public function testExists($value, $key, $callback, $expected)
    {
        $this->assertEquals($expected, Arr::set($value)->exists($key, $callback)->val);
    }

    /**
     * Data provider for testExists
     *
     * @return array
     */
    public function providerExists()
    {
        return [
            [[1, 2, 3], 2, null, true],
            [[1, 2, 3], 3, null, false],
            [[1, 2, 3], 2, function ($key) {return $key * 2;}, 4],
            [[1, 2, 3], 3, function ($key) {return $key * 2;}, false],
        ];
    }

    /**
     * @expectedException \Affinity4\Datatype\Exception\DatatypeException
     *
     * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->exists\(\) must be of type 'array' or instance of 'ArrayAccess'. Type .* given\.$/
     */
    public function testExistsException()
    {
        Arr::set(1)->exists(1)->val;
    }

    /**
     * Data provider for testExistsCallback
     *
     * @return array
     */
    public function providerExistsCallback()
    {
        return [
            [[1, 2, 3], 2, function ($key) {
                return $key * 2;
            }, 6],
            [[1, 2, 3], 3, function ($key) {
                return $key * 2;
            }, false],
        ];
    }

    /**
     * @dataProvider providerFirst
     *
     * @param          $test
     * @param callable $callback
     * @param          $expected
     */
    public function testFirst($test, $callback, $expected)
    {
        $this->assertNotInstanceOf(Arr::class, Arr::set($test)->first($callback));
        $this->assertEquals($expected, Arr::set($test)->first($callback)->val);
    }

    public function providerFirst()
    {
        return [
            [[1, 2, 3], function ($item) {
                return $item < 3;
            }, 1],
            [['one', 'two', 'three'], null, 'one'],
        ];
    }

    /**
     * @expectedException \Affinity4\Datatype\Exception\DatatypeException
     *
     * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->first\(\) must be of type 'array' or instance of 'ArrayAccess'. Type .* given\.$/
     */
    public function testFirstException()
    {
        Arr::set(1)->first()->val;
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
        $this->assertInstanceOf(Str::class, Arr::set($value)->join($glue));
        $this->assertEquals($expected, Arr::set($value)->join($glue)->val);
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
     * @expectedException \Affinity4\Datatype\Exception\DatatypeException
     *
     * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->join\(\) must be of type 'array' or instance of 'ArrayAccess'. Type .* given\.$/
     */
    public function testJoinException()
    {
        Arr::set(1)->join()->val;
    }

    /**
     * @dataProvider providerLast
     *
     * @param $test
     * @param callable $callback
     * @param $expected
     */
    public function testLast($test, $callback, $expected)
    {
        $this->assertNotInstanceOf(Arr::class, Arr::set($test)->last($callback));
        $this->assertEquals($expected, Arr::set($test)->last($callback)->val);
    }

    /**
     * Data provider for testLast
     *
     * @return array
     */
    public function providerLast()
    {
        return [
            [[1, 2, 3], function ($item) {
                return $item < 3;
            }, 2],
            [['one', 'two', 'three'], null, 'three'],
        ];
    }

    /**
     * @expectedException \Affinity4\Datatype\Exception\DatatypeException
     *
     * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->last\(\) must be of type 'array' or instance of 'ArrayAccess'. Type .* given\.$/
     */
    public function testLastException()
    {
        Arr::set(1)->last()->val;
    }

    /**
     * @dataProvider providerMap
     * 
     * @param $array
     * @param $callback
     * @param $expected
     */
    public function testMap($array, $callback, $expected)
    {
        $this->assertEquals($expected, Arr::set($array)->map($callback)->val);
    }

    /**
     * @expectedException \Affinity4\Datatype\Exception\DatatypeException
     *
     * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->map\(\) must be of type 'array' or instance of 'ArrayAccess'. Type .* given\.$/
     */
    public function testMapException()
    {
        Arr::set(1)->map(function ($val) {
            return $val * 2;
        })->val;
    }

    /**
     * Data Provider for testMap
     *
     * @return array
     */
    public function providerMap()
    {
        return [
            [[1, 2, 3], function ($val) {
                return $val * 2;
            }, [2, 4, 6]]
        ];
    }

    /**
     * Test Arr::set method
     */
    public function testSet()
    {
        $array = [1, 2, 3];

        $this->assertInstanceOf(Arr::class, Arr::set($array));
        $this->assertEquals($array, Arr::set($array)->val);
    }

    /**
     * @dataProvider providerSum
     *
     * @param $array
     * @param $expected
     */
    public function testSum($array, $expected)
    {
        $this->assertInstanceOf(Num::class, Arr::set($array)->sum());
        $this->assertEquals($expected, Arr::set($array)->sum()->val);
    }

    /**
     * Data provider for testSum
     *
     * @return array
     */
    public function providerSum()
    {
        return [
            [[1, 2, 3], 6],
            [['one', 'two', 'three'], 0],
            [['a' => 1.27, 'b' => '5.83'], 7.0999999999999996]
        ];
    }

    /**
     * @expectedException \Affinity4\Datatype\Exception\DatatypeException
     *
     * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->sum\(\) must be of type 'array' or instance of 'ArrayAccess'. Type .* given\.$/
     */
    public function testSumException()
    {
        Arr::set(1)->sum()->val;
    }

    /**
     * @dataProvider providerUnset
     *
     * @param $value
     * @param $keys
     * @param $expected
     */
    public function testUnset($value, $keys, $expected)
    {
        $this->assertEquals($expected, Arr::set($value)->unset($keys)->val);
    }

    /**
     * Data provider for testUnset
     *
     * @return array
     */
    public function providerUnset()
    {
        return [
            [[1, 2, 3, 4, 5, 6], new \ArrayIterator([1, 2, 3]), [0 => 1, 4 => 5, 5 => 6]],
            [['one' => 1, 2, 3, 4, 5, 6], new \ArrayIterator([1, 2, 3]), ['one' => 1, 0 => 2, 4 => 6]],
            [[1, 2, 3, 4, 5, 6], [1, 2, 3], [0 => 1, 4 => 5, 5 => 6]],
            [['one' => 1, 2, 3, 4, 5, 6], [1, 2, 3], ['one' => 1, 0 => 2, 4 => 6]],
        ];
    }

    /**
     * @expectedException \Affinity4\Datatype\Exception\DatatypeException
     *
     * @expectedExceptionMessageRegExp /^Value passed to (\\?[A-Z][a-z\d_]+)+::set\(\$val\)->unset\(\) must be of type 'array' or instance of 'ArrayAccess'. Type .* given\.$/
     */
    public function testUnsetException()
    {
        Arr::set(1)->unset([1, 2, 3])->val;
    }

    public function providerTestGet(): array
    {
        return [
            ['Found me!', 'another.deeply.nested.thing'],
            [[1, 2, 3], 'something.deeply.nested.things\.with\.dots']
        ];
    }

    /**
     * @dataProvider providerTestGet
     *
     * @param mixed  $expected
     * @param string $pattern
     */
    public function testGet($expected, string $pattern)
    {
        $data = [
            'some' => [
                [
                    'deeply' => [
                        'nested' => [
                            'things.with.dots' => [1, 2, 3]
                        ]
                    ],
                    'thing' => 'else'
                ],
                [
                    'thing' => 'else'
                ]
            ],
            'something' => [
                'deeply' => [
                    'nested' => [
                        'things.with.dots' => [1, 2, 3]
                    ]
                ]
            ],
            'another' => [
                'deeply' => [
                    'nested' => [
                        'thing' => 'Found me!'
                    ]
                ]
            ]
        ];

        $actual = Arr::set($data)->get($pattern)->val;

        $this->assertEquals($expected, $actual);
    }

    public function testGetSearchPatternArray()
    {
        $data = [
            'some' => [
                [
                    'deeply' => [
                        'nested' => [
                            'things.with.dots' => [1, 2, 3]
                        ]
                    ],
                    'thing' => 'else'
                ],
                [
                    'thing' => 'else'
                ]
            ],
            'something' => [
                'deeply' => [
                    'nested' => [
                        'things.with.dots' => [1, 2, 3]
                    ]
                ]
            ],
            'another' => [
                'deeply' => [
                    'nested' => [
                        'thing' => 'found me'
                    ]
                ]
            ]
        ];

        $pattern = 'some.{\d+}.deeply.nested.{.+}.another.{.+}.thing\.with\.escaped\.dots';
        $expected = [
            'some',
            '/\d+/',
            'deeply',
            'nested',
            '/.+/',
            'another',
            '/.+/',
            'thing.with.escaped.dots'
        ];

        $Arr = Arr::set($data);
        $ReflectionMethod = new \ReflectionMethod($Arr, 'getSearchPatternArray');
        $ReflectionMethod->setAccessible(true);

        $actual = $ReflectionMethod->invokeArgs($Arr, [$pattern]);

        $this->assertEquals($expected, $actual);
    }

    public function providerTestSearch(): array
    {
        return [
            [
                [
                    [1, 2, 3],
                    [1, 2, 3]
                ],
                '{some.*}.{\d+}.{deep.*}.nested.things\.with\.dots'
            ],
            [
                [
                    'else',
                    'else'
                ],
                'some.{\d+}.thing'
            ],
            [
                [
                    [
                        'nested' => [
                            'things.with.dots' => [1, 2, 3]
                        ]
                    ],
                    [
                        'nested' => [
                            'things.with.dots' => [1, 2, 3]
                        ]
                    ]
                ],
                'some.{\d+}.{deep.*}'
            ]
        ];
    }

    /**
     * @dataProvider providerTestSearch
     *
     * @param mixed $expected
     * @param string $pattern
     */
    public function testSearch($expected, string $pattern)
    {
        $data = [
            'some' => [
                [
                    'deeply' => [
                        'nested' => [
                            'things.with.dots' => [1, 2, 3]
                        ]
                    ],
                    'deep' => [
                        'nested' => [
                            'things.with.dots' => [1, 2, 3]
                        ]
                    ],
                    'thing' => 'else'
                ],
                [
                    'thing' => 'else'
                ],
                'thing' => 'else'
            ],
            'something' => [
                'deeply' => [
                    'nested' => [
                        'things.with.dots' => [1, 2, 3]
                    ]
                ]
            ],
            'another' => [
                'deeply' => [
                    'nested' => [
                        'thing' => 'found me'
                    ]
                ]
            ]
        ];

        $actual = Arr::set($data)->search($pattern)->val;
        
        $this->assertEquals($expected, $actual);
    }
}