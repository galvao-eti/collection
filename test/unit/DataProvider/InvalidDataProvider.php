<?php

declare(strict_types = 1);

namespace GalvaoEti\CollectionTest\DataProvider;

use \stdClass;

use GalvaoEti\Collection\Collection;

class InvalidDataProvider
{
    public static function invalidBool(): array
    {
        return [
            ['bool', null, [true, 0, false]],
            ['bool', null, [false, 1, 1]],
            ['bool', null, [true, 0, '']],
        ];
    }

    public static function invalidInteger(): array
    {
        return [
            ['integer', null, [1, '4', 6]],
            ['integer', null, [-2, -9, "1"]],
            ['integer', null, [1000, 76, false]],
        ];
    }

    public static function invalidDouble(): array
    {
        return [
            ['double', null, [2.1, 0, 13.14]],
            ['double', null, ['15.16', 1, 0.001]],
            ['double', null, [-12.8, true, -87.11]],
        ];
    }

    public static function invalidString(): array
    {
        return [
            ['string', null, ['abc', false, 'ghi']],
            ['string', null, [[], 'mno', 'pqr']],
            ['string', null, ['stu', new stdClass(), 'z++']],
        ];
    }


    public static function invalidArray(): array
    {
        return [
            [
                'array', null, [2, ['foo', 'bar', true], [1, 3, 2]]
            ],
            [
                'array', null, [[2, 'asd', -9.1], ['foo', 'bar', true], 3]
            ],
            [
                'array', null, [new stdClass(), ['foo', 'bar', true], [1, 3, 2]]
            ]
        ];
    }

    public static function invalidObject(): array
    {
        return [
            ['object', null, [new stdClass(), 'foo', new stdClass()]],
        ];
    }

    public static function invalidClass(): array
    {
        return [
            ['object', stdClass::class, [new stdClass(), new Collection(), new stdClass()]],
        ];
    }
}
