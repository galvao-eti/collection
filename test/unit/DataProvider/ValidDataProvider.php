<?php

declare(strict_types = 1);

namespace CollectionTest\DataProvider;

use \stdClass;

class ValidDataProvider
{
    public static function validMixed(): array
    {
        return [
            ['mixed', null, [2, true, 0.1]],
            ['mixed', null, ['test', [0, 2], new stdClass()]],
            ['mixed', null, [12, 'foo', 16.75]],
        ];
    }

    public static function validBool(): array
    {
        return [
            ['bool', null, [true, false, false]],
            ['bool', null, [false, true, true]],
            ['bool', null, [true, true, false]],
        ];
    }

    public static function validInteger(): array
    {
        return [
            ['integer', null, [1, 4, 6]],
            ['integer', null, [-2, -9, 1]],
            ['integer', null, [1000, 76, 21]],
        ];
    }

    public static function validDouble(): array
    {
        return [
            ['double', null, [2.1, 0.987, 13.14]],
            ['double', null, [15.16, 1.789, 0.001]],
            ['double', null, [-12.8, 9.080, -87.11]],
        ];
    }

    public static function validString(): array
    {
        return [
            ['string', null, ['abc', 'def', 'ghi']],
            ['string', null, ['jkl', 'mno', 'pqr']],
            ['string', null, ['stu', 'wxy', 'z++']],
        ];
    }


    public static function validArray(): array
    {
        return [
            [
                'array', null, [[2, 'asd', -9.1], ['foo', 'bar', true], [1, 3, 2]]
            ],
            [
                'array', null, [[2, 'asd', -9.1], ['foo', 'bar', true], [1, 3, 2]]
            ],
            [
                'array', null, [[2, 'asd', -9.1], ['foo', 'bar', true], [1, 3, 2]]
            ]
        ];
    }

    public static function validObject(): array
    {
        return [
            ['object', null, [new stdClass(), new stdClass(), new stdClass]],
        ];
    }

    public static function validClass(): array
    {
        return [
            ['object', stdClass::class, [new stdClass(), new stdClass(), new stdClass]],
        ];
    }
}
