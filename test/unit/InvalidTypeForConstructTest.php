<?php

declare(strict_types = 1);

namespace GalvaoEti\CollectionTest;

use \TypeError;

use PHPUnit\Framework\TestCase;

use GalvaoEti\Collection\Collection;

class InvalidTypeForConstructTesting extends TestCase
{
    private ?Collection $collection = null;

    protected function setUp(): void
    {
        $this->collection = null;
    }

    public function testConstructInvalidType(string $type, ?string $class, array $data)
    {
        $this->expectException(TypeError::class);
        $this->collection = new Collection('foo');
    }
}
