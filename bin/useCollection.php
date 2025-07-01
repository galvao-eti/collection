#! /usr/bin/env php
<?php
/**
 * Summary of the experiment of this example:
 *
 * Starting with the following collection:
 *
 * ['foo', 'bar', 'baz, 'quux']
 *
 * Perform additions, updates and deletes (including testing locking and overwriting) and end up with:
 *
 * ['quux', 'xuuq', 'baz, 'zab', 'foo']
 *
 * This will be done in a purposefully convoluted way to stress test the component.
 * Unit testing can be found in the test/unit folder
 *
 */

declare(strict_types = 1);

chdir(__DIR__);

require '../vendor/autoload.php';

use Collection\Collection;

try {
    $c = new Collection('string');
} catch (Throwable $t) {
    echo $t->getMessage();
    exit(1);
}

$c->allowOverwriting = true;

try {
    $c->add('foo');
    $c->add('bar');
    $c->add('baz');
    $c->add('quux');
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}

echo 'Initial collection state: ' . PHP_EOL;

var_dump($c->get(null));

echo 'Adding incorrect elements on purpose: ' . PHP_EOL;

try {
    $c->add('qqq');
    echo 'Added qqq' . PHP_EOL;
    $c->add('xxx');
    echo 'Added xxx' . PHP_EOL;
    $c->add('zzz');
    echo 'Added zzz' . PHP_EOL;
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}

echo 'Making the collection non-overwritable and trying to update the wrong elements...' . PHP_EOL;

$c->allowOverwriting = false;

try {
    $c->update(4, 'xuuq');
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}

echo 'Making the collection overwritable and trying again.' . PHP_EOL;

$c->allowOverwriting = true;

try {
    $prev = $c->get(4);
    $c->update(4, 'xuuq');
    echo 'Updated ' . $prev . ' to xuuq' . PHP_EOL;
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}

echo "Delete the item in index 5 ('xxx') and rearranging the keys" . PHP_EOL;

try {
    $c->delete(5, true);
    echo 'Deleted xxx' . PHP_EOL;
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}

echo "Locking the collection and trying to delete item which is now on index 5 ('zzz')" . PHP_EOL;

$c->locked = true;

try {
    $c->delete(5);
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}

echo 'Unlocking and trying again' . PHP_EOL;

$c->locked = false;

try {
    $c->delete(5);
    echo 'Deleted zzz' . PHP_EOL;
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}

// Adding the final items

try {
    $c->add('zab');
    echo 'Added zab' . PHP_EOL;
    $c->add('rab');
    echo 'Added rab' . PHP_EOL;
    $c->add('oof', false);
    echo 'Added oof' . PHP_EOL;
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}

// Using the collection's generator to display all it's items

foreach ($c->generateData() as $index => $item) {
    echo $index . ' => ' . $item . PHP_EOL;
}
