<?php

declare(strict_types = 1);

namespace GalvaoEti\CollectionTest;

use \InvalidArgumentException;
use \TypeError;
use \Exception;

use PHPUnit\Framework\{
    Attributes\DataProviderExternal,
    TestCase
};

use GalvaoEti\CollectionTest\DataProvider\{
    ValidDataProvider
};

use GalvaoEti\Collection\Collection;

class CollectionUpdatingTest extends TestCase
{
    private ?Collection $collection = null;

    protected function setUp(): void
    {
        $this->collection = null;
    }

    #[DataProviderExternal(ValidDataProvider::class, 'validString')]

    public function testUpdateString(string $type, ?string $class, array $data)
    {
        $this->collection = new Collection($type, $class);

        foreach ($data as $value) {
            $this->collection->add($value);
        }

        $this->collection->allowOverwriting = true;
        $this->collection->prev();

        $this->collection->update(1, 'UPDATED');

        $this->assertEquals($this->collection->key(), 2);
        $this->assertEquals($this->collection->count(), 3);
        $this->assertEquals($this->collection->get(1), 'UPDATED');
    }

    #[DataProviderExternal(ValidDataProvider::class, 'validString')]

    public function testUpdateWithWrongType(string $type, ?string $class, array $data)
    {
        $this->collection = new Collection($type, $class);

        foreach ($data as $value) {
            $this->collection->add($value);
        }

        $this->collection->allowOverwriting = true;
        $this->expectException(InvalidArgumentException::class);
        $this->collection->prev();

        $this->collection->update(1, [2, 3, 4]);
    }
}
