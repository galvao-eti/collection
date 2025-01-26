<?php

declare(strict_types = 1);

namespace GalvaoEti\CollectionTest;

use \InvalidArgumentException;
use \TypeError;

use PHPUnit\Framework\{
    Attributes\DataProviderExternal,
    TestCase
};

use GalvaoEti\CollectionTest\DataProvider\{
    ValidDataProvider
};

use GalvaoEti\Collection\Collection;

class CollectionDeletingTest extends TestCase
{
    private ?Collection $collection = null;

    protected function setUp(): void
    {
        $this->collection = null;
    }

    #[DataProviderExternal(ValidDataProvider::class, 'validString')]

    public function testDeleteLastItem(string $type, ?string $class, array $data)
    {
        $this->collection = new Collection($type, $class);

        foreach ($data as $value) {
            $this->collection->add($value);
        }

        $this->collection->prev();

        $this->collection->delete($this->collection->key());

        $this->assertEquals($this->collection->key(), 1);
        $this->assertEquals($this->collection->count(), 2);
    }

    #[DataProviderExternal(ValidDataProvider::class, 'validString')]

    public function testDeleteMiddleItem(string $type, ?string $class, array $data)
    {
        $this->collection = new Collection($type, $class);

        foreach ($data as $value) {
            $this->collection->add($value);
        }

        $this->collection->prev();

        $this->collection->delete(1, true);

        $this->assertEquals($this->collection->key(), 1);
        $this->assertEquals($this->collection->count(), 2);
    }
}
