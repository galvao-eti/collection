<?php

declare(strict_types = 1);

namespace GalvaoEti\CollectionTest;

use \InvalidArgumentException;

use PHPUnit\Framework\{
    Attributes\DataProviderExternal,
    TestCase
};

use GalvaoEti\CollectionTest\DataProvider\{
    ValidDataProvider,
    InvalidDataProvider
};

use GalvaoEti\Collection\Collection;

class CollectionAddingTest extends TestCase
{
    private ?Collection $collection = null;

    protected function setUp(): void
    {
        $this->collection = null;
    }

    #[DataProviderExternal(ValidDataProvider::class, 'validMixed')]
    #[DataProviderExternal(ValidDataProvider::class, 'validBool')]
    #[DataProviderExternal(ValidDataProvider::class, 'validInteger')]
    #[DataProviderExternal(ValidDataProvider::class, 'validDouble')]
    #[DataProviderExternal(ValidDataProvider::class, 'validString')]
    #[DataProviderExternal(ValidDataProvider::class, 'validArray')]
    #[DataProviderExternal(ValidDataProvider::class, 'validObject')]
    #[DataProviderExternal(ValidDataProvider::class, 'validClass')]
    public function testValidCollection(string $type, ?string $class, array $data)
    {
        $this->collection = new Collection($type, $class);

        foreach ($data as $value) {
            $this->collection->add($value);
        }

        $this->collection->prev();

        $this->assertEquals($this->collection->key(), 2);
        $this->assertEquals($this->collection->count(), 3);
    }

    #[DataProviderExternal(InvalidDataProvider::class, 'invalidBool')]
    #[DataProviderExternal(InvalidDataProvider::class, 'invalidInteger')]
    #[DataProviderExternal(InvalidDataProvider::class, 'invalidDouble')]
    #[DataProviderExternal(InvalidDataProvider::class, 'invalidString')]
    #[DataProviderExternal(InvalidDataProvider::class, 'invalidArray')]
    #[DataProviderExternal(InvalidDataProvider::class, 'invalidObject')]
    #[DataProviderExternal(InvalidDataProvider::class, 'invalidClass')]

    public function testInvalidInvalidCollection(string $type, ?string $class, array $data)
    {
        $this->collection = new Collection($type, $class);
        $this->expectException(InvalidArgumentException::class);

        foreach ($data as $value) {
            $this->collection->add($value);
        }

        $this->collection->prev();

    }
}
