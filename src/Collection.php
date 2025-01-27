<?php

/**
 * GalvaoEti\Collection
 * A versatile, fully-featured Linear Collection implementation.
 *
 * @author Er Galvão Abbott <galvao@php.net>
 * @version 1.0.1
 * @license https://www.apache.org/licenses/LICENSE-2.0.html Apache 2.0
 *
 * @link https://github.com/galvao-eti/collection
 * @link https://packagist.org/packages/galvao-eti/collection
 */

declare(strict_types = 1);

namespace GalvaoEti\Collection;

use \Exception;
use \InvalidArgumentException;
use \ValueError;

use GalvaoEti\Collection\Enumeration\Type;

class Collection implements Abstraction\CollectionInterface
{
    private int $cursor = 0;
    private int $dataCount = 0;

    public bool $locked = false;

    /**
     * allowOverwriting differs from locked in the sense that:
     * - Adding and Deleting items is still allowed
     * - What is *not* allowed is adding to a position which is already occupied (see line 83) or updating items
     */
    public bool $allowOverwriting = false;

    private array $data = [];
    private Type $dataType = Type::Mixed;
    private ?string $dataClass = null;

    public function __construct(string $dataType = 'mixed', ?string $dataClass = null)
    {
        if ($dataType === 'bool') {
            $dataType = 'boolean';
        }

        try {
            $this->dataType = Type::from($dataType);
        } catch (ValueError $e) {
            throw $e;
        }

        $this->dataClass = $dataClass;
    }

    public function validateTypes(mixed $data): bool
    {
        $type = gettype($data);

        if (($this->dataType !== Type::Mixed and $type !== $this->dataType->value) or
            ($type === 'object' and $this->dataClass !== null and !$data instanceof $this->dataClass)) {
            return false;
        }

        return true;
    }

    public function add(mixed $data, bool $lazy = true): void
    {
        if ($this->locked) {
            throw new Exception('Trying to add data to a locked collection.');
        }

        if (!$this->validateTypes($data)) {
            throw new InvalidArgumentException(
                'Data must be of type: ' . $this->dataType->value . ', ' . gettype($data) . ' given.'
            );
        }

        // Ensures that data is not overwritten
        if (!$this->exists($this->cursor) or $this->allowOverwriting) {
            $this->data[$this->cursor] = $data;
            $this->dataCount++;

            if ($this->cursor === $this->dataCount - 1) {
                $this->next();
            }

        } else {
            throw new Exception('A collection item already exists in position ' . $this->cursor);
        }
    }

    public function get(?int $key): mixed
    {
        if ($key === null) {
            return $this->data;
        }

        if ($this->exists($key)) {
            return $this->data[$key];
        }

        return [];
    }

    public function generateData()
    {
        foreach ($this->data as $data) {
            yield $data;
        }
    }

    public function update(int $key, mixed $data, bool $silentOnNotFound = true): void
    {
        if ($this->locked) {
            throw new Exception('Trying to update data on a locked collection.');
        }

        if (!$this->allowOverwriting) {
            throw new Exception('Trying to update data on a collection that is not overwritable.');
        }

        if (!$this->validateTypes($data)) {
            throw new InvalidArgumentException(
                'Data must be of type: ' . $this->dataType->value . ', ' . gettype($data) . ' given.'
            );
        }

        if (!$this->exists($key)) {
            if (!$silentOnNotFound) {
                throw new \Exception($key . ' not found.');
            }
        } else {
            $this->data[$key] = $data;
        }
    }

    public function delete(int $key, bool $tidyUp = false, bool $silentOnNotFound = true): void
    {
        if ($this->locked) {
            throw new Exception('Trying to delete data from a locked collection.');
        }

        if ($this->exists($key)) {
            unset($this->data[$key]);

            if ($key === $this->dataCount - 1) {
                $this->prev();
            }
        } else if (!$silentOnNotFound) {
            throw new Exception($key . ' not found.');
        }

        if ($tidyUp) {
            foreach ($this->data as $currentKey => $currentValue) {
                if ($currentKey > $key) {
                    unset($this->data[$currentKey]);
                    $this->prev();

                    $this->data[--$currentKey] = $currentValue;
                }
            }

            ksort($this->data);
        }

        $this->dataCount--;
    }

    public function exists(int $key): bool
    {
        return isset($this->data[$key]);
    }

    public function current(): mixed
    {
        return $this->data[$this->cursor];
    }

    public function key(): mixed
    {
        return $this->cursor;
    }

    public function next(): void
    {
        ++$this->cursor;
    }

    public function prev(): void
    {
        --$this->cursor;
    }

    public function rewind(): void
    {
        $this->cursor = 0;
    }

    public function valid(): bool
    {
        return isset($this->data[$this->cursor]);
    }

    public function count(): int
    {
        return $this->dataCount;
    }
}
