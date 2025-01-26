<?php
declare(strict_types = 1);

chdir(__DIR__);

require '../vendor/autoload.php';

use GalvaoEti\Collection\Collection;

try {
    $c = new Collection('string');
} catch (Throwable $t) {
    echo $t->getMessage();
    exit(1);
}

try {
    $c->add('abc');
    $c->add('def');
    $c->add('ghi', false);
} catch (Throwable $e) {
    echo $e->getMessage();
}

var_dump($c->get(null));

try {
    $c->delete(1, true);
} catch (Throwable $e) {
    exit($e->getMessage());
}

foreach ($c->generateData() as $item) {
    echo $item . PHP_EOL;
}

var_dump($c->get(null));
echo $c->key();
