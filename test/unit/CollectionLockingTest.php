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
    ValidDataProvider,
    InvalidDataProvider
};

use GalvaoEti\Collection\Collection;

class CollectionLockingTest extends TestCase
{
    private ?Collection $collection = null;

    protected function setUp(): void
    {
        $this->collection = null;
    }

    #[DataProviderExternal(ValidDataProvider::class, 'validString')]

    public function testLockedAdding(string $type, ?string $class, array $data)
    {
        $this->collection = new Collection($type, $class);
        $this->expectException(Exception::class);
        $this->collection->locked = true;

        foreach ($data as $value) {
            $this->collection->add($value);
        }

        $this->collection->prev();
    }

    #[DataProviderExternal(ValidDataProvider::class, 'validString')]

    public function testLockedUpdating(string $type, ?string $class, array $data)
    {
        $this->collection = new Collection($type, $class);
        $this->expectException(Exception::class);

        foreach ($data as $value) {
            $this->collection->add($value);
        }

        $this->collection->locked = true;
        $this->collection->allowOverwriting = true;
        $this->collection->prev();

        $this->collection->update(1, "SHOULDN'T UPDATE!");
    }

    #[DataProviderExternal(ValidDataProvider::class, 'validString')]

    public function testLockedDeleting(string $type, ?string $class, array $data)
    {
        $this->collection = new Collection($type, $class);
        $this->expectException(Exception::class);

        foreach ($data as $value) {
            $this->collection->add($value);
        }

        $this->collection->locked = true;
        $this->collection->allowOverwriting = true;
        $this->collection->prev();

        $this->collection->delete(2);
    }
}
