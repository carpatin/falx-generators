<?php

require 'src/Falx/Generators/ObservedGenerator.php';
use Falx\Generators\ObservedGenerator;

// Create an observed generator: one number producer observed by a logger and a sum computer
$observed = new ObservedGenerator('producer', 'logger', 'sum');

// Iterate observed generator
foreach ($observed->iterate() as $key => $value) {
    print "PRODUCED: " . $key . " : " . $value . PHP_EOL;
}

// While the logger simply outputs number the sum generator computes sum and it can be retrieved
print "SUM: " . $observed->getObserver(1)->getReturn() . PHP_EOL;


/*
 * Observed producer - produces some numbers
 */
function producer()
{
    for ($i = 0; $i < 10; $i++) {
        yield $i;
    }
}

/*
 * Observer logger
 */
function logger()
{
    $message = yield;
    while ($message !== null) {
        print 'DEBUG :' . $message . PHP_EOL;
        $message = yield;
    }
}

/*
 * Observer sum calculator
 */
function sum()
{
    $sum = 0;
    do {
        $number = yield;
        if (is_numeric($number)) {
            $sum += $number;
        }
    } while ($number !== null);

    return $sum;
}