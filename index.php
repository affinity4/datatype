<?php
require_once __DIR__ . '/vendor/autoload.php';

use Affinity4\Datatype;

// $value = Datatype\Arr::set([1, 2, 3, 4])->first(function ($item) {
//     return $item == 2;
// })->val;

$unknown = ['one', 'two', 'three'];

var_dump((new Datatype\DatatypeFactory($unknown))
    ->isString(function ($value) {
        return Datatype\Str::set($value)->split();
    })
    ->isArray(function ($value) {
        return Datatype\Arr::set($value)->last();
    })
    ->isInteger(function ($value) {
        return Datatype\Integer::set($value)->divideBy(2);
    })
);

function testTernary($array, $key, callable $callback)
{
    if ($array instanceof \ArrayAccess) {
        $exists = ($array->offsetExists($key)) ?: false;
    } else {
        $exists = (array_key_exists($key, $array)) ?: false;
    }

    return $exists;
}

$arr = new \ArrayIterator([1, 2, 3]);

var_dump(Affinity4\Datatype\Arr::set(['one' => 1, 2, 3, 4, 5, 6])->unset($arr)->val);