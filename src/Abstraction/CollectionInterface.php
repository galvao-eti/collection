<?php

/**
 * Collection
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

namespace Collection\Abstraction;

interface CollectionInterface extends \Iterator
{
    public function __construct(string $dataType = 'mixed', ?string $dataClass = null);
    public function validateTypes(mixed $data): bool;
    public function add(mixed $data, bool $lazy = true): void;
    public function get(?int $key): mixed;
    public function update(int $key, mixed $data, bool $silentOnNotFound = true): void;
    public function delete(int $key, bool $tidyUp = false, bool $silentOnNotFound = true): void;
    public function exists(int $key): bool;
}
