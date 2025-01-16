<?php

declare(strict_types = 1);

namespace GalvaoEti\Collection\Abstraction;

interface CollectionInterface extends \Iterator
{
    public function __construct(string $dataType = 'mixed', ?string $dataClass = null);
    public function add(mixed $data, bool $lazy = true): void;
    public function get(int $key): mixed;
    public function update(int $key, mixed $data, bool $silentOnNotFound = true): void;
    public function delete(int $key, bool $tidyUp = false, bool $silentOnNotFound = true): void;
    public function exists(int $key): bool;
}
