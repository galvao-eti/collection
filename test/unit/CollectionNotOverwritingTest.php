<?php

declare(strict_types = 1);

namespace CollectionTest;

use \InvalidArgumentException;
use \TypeError;
use \Exception;

use PHPUnit\Framework\{
    Attributes\DataProviderExternal,
    TestCase
};

use CollectionTest\DataProvider\{
    ValidDataProvider,
    InvalidDataProvider
};

use Collection\Collection;

class CollectionNotOverwritingTest extends TestCase
{
    private ?Collection $collection = null;

    protected function setUp(): void
    {
        $this->collection = null;
    }

    #[DataProviderExternal(ValidDataProvider::class, 'validString')]

    public function testNonOverwritableAdding(string $type, ?string $class, array $data)
    {
        $this->collection = new Collection($type, $class);
        $this->expectException(Exception::class);

        foreach ($data as $value) {
            $this->collection->add($value);
        }

        $this->collection->prev();
        $this->collection->prev();

        $this->collection->add("SHOULDN'T ADD");
    }
 
    #[DataProviderExternal(ValidDataProvider::class, 'validString')]

    public function testNonOverwritableUpdate(string $type, ?string $class, array $data)
    {
        $this->collection = new Collection($type, $class);
        $this->expectException(Exception::class);

        foreach ($data as $value) {
            $this->collection->add($value);
        }

        $this->collection->prev();

        $this->collection->update(1, "SHOULDN'T UPDATE");
    }
}
