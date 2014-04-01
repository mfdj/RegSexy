<?php

require __DIR__ . '/../vendor/autoload.php';

use RegSexy\Modifiers as mod;
use RegSexy\RegEx;

$subject = 'Waldo Dogsly and Fink 9 theo 10';
$pattern = '(waldo)* (\w+ )+\d+';

// by default no modifiers are used

var_dump(
    RegEx::make($pattern)
        ->match($subject)->match
);

// these 3 are equivalant

var_dump(
    RegEx::make($pattern, 'iU')
        ->match($subject)->match
);

var_dump(
    RegEx::make($pattern, mod::CASELESS, mod::UNGREEDY)
        ->match($subject)->match
);

var_dump(
    RegEx::make($pattern)->caseless()->ungreedy()
        ->match($subject)->match
);
