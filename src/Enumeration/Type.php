<?php

/**
 * GalvaoEti\Collection
 * A versatile, fully-featured Collection implementation.
 *
 * @author Er Galvão Abbott <galvao@php.net>
 * @version 0.1.0-dev
 * @license https://www.apache.org/licenses/LICENSE-2.0.html Apache 2.0
 *
 * @link https://github.com/galvao-eti/collection
 * @link https://packagist.org/packages/galvao-eti/collection
 */

declare(strict_types = 1);

namespace GalvaoEti\Collection\Enumeration;

enum Type: string {
    case Mixed = 'mixed';
    case Int = 'integer';
    case Double = 'double';
    case Boolean = 'boolean';
    case String = 'string';
    case Object = 'object';
    case Array = 'array';
}
