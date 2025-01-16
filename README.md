# GalvaoEti\Collection

A versatile, fully-featured Collection implementation.

## Installation

```bash
composer require galvao-eti/collection:0.2.0-alpha
```

## Features

Features are marked when fully tested.

Strongly Typed Collections:

- [x] Mixed (Default)
- [x] Integer
- [x] Double
- [x] Boolean
- [x] Array
- [x] Object
- [x] Objects of a specific class
- [ ] Customizable overwriting prevention
- [ ] Locking the collection (no more writing to it)
- [ ] Deletion
- [ ] Automatically rearranging the collection's keys upon deletion
- [ ] Update items

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
