# GalvaoEti\Collection

A versatile, fully-featured Linear [Collection](https://en.wikipedia.org/wiki/Collection_\(abstract_data_type\)) implementation.

## Installation

```bash
composer require galvao-eti/collection
```

## Features

Features are considered present (ticked) when fully unit tested.

Strongly Typed Collections:

- [x] Mixed (Default)
- [x] Integer
- [x] Double
- [x] Boolean
- [x] Array
- [x] Object
- [x] Objects of a specific class
- [x] Overwriting prevention when adding data with existing key or updating
- [x] Locking the collection (no more writing to it)
- [x] Deletion
- [x] Automatically rearranging the collection's keys upon deletion
- [x] Update items

## Usage

Example usage:
```php
<?php

require 'vendor/autoload.php';

use GalvaoEti\Collection\Collection;

$collection = new Collection('string');
$collection->add('foo');
$collection->add('bar', false);

foreach ($collection->generateData() as $item) {
    echo "$item<br>";
}
```

See the [bin/useCollection.php](/bin/useCollection.php) script for a more in-depth example.

## License

Apache 2.0

## Credits

Created by Er Galvão Abbott <galvao@php.net> for [Galvão Desenvolvimento de Sistemas](https://galvao.eti.br).
