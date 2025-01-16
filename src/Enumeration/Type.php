<?php

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
