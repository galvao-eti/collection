<?php

declare(strict_types = 1);

namespace GalvaoEti\Collection;

use \Exception;
use \InvalidArgumentException;
use \TypeError;

use GalvaoEti\Collection\Enumeration\Type;

class Collection implements Abstraction\CollectionInterface
{
    private int $cursor = 0;
    private int $dataCount = 0;

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
        } catch (TypeError $e) {
            throw $e;
        }

        $this->dataClass = $dataClass;
    }

    public function add(mixed $data, bool $lazy = true): void
    {
        $valid = true;
        $type = gettype($data);

        if (($this->dataType !== Type::Mixed and $type !== $this->dataType->value) or
                ($type === 'object' and $this->dataClass !== null and !$data instanceof $this->dataClass)
            ) {
                    $valid = false;
        }

        if (!$valid) {
            throw new InvalidArgumentException('Data must be of type: ' . $this->dataType->value . ', ' . $type . ' given.');
        }

        // Ensures that data is not overwritten
        if (!$this->exists($this->cursor)) {
            $this->data[$this->cursor] = $data;
            $this->dataCount++;

            if ($lazy) {
                $this->next();
            }
        } else {
            throw new Exception('A collection item already exists in position ' . $this->cursor);
        }
    }

    public function get(int $key): mixed
    {
        if ($this->exists($key)) {
            return $this->data[$key];
        }

        return null;
    }

    public function generateData()
    {
        for ($c = 0; $c < $this->dataCount; $c++) {
            yield $this->data[$c];
        }
    }

    public function update(int $key, mixed $data, bool $silentOnNotFound = true): void
    {
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
        if ($this->exists($key)) {
            unset($this->data[$key]);
            $this->dataCount--;
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
    }

    public function exists(int $key): bool
    {
        if (isset($this->data[$key])) {
            return true;
        }

        return false;
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
