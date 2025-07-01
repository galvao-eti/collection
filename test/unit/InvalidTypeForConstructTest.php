<?php

declare(strict_types = 1);

namespace CollectionTest;

use \ValueError;

use PHPUnit\Framework\TestCase;

use Collection\Collection;

class InvalidTypeForConstructTest extends TestCase
{
    private ?Collection $collection = null;

    protected function setUp(): void
    {
        $this->collection = null;
    }

    public function testConstructInvalidType()
    {
        $this->expectException(ValueError::class);
        $this->collection = new Collection('foo');
    }
}
