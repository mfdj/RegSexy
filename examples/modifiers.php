<?php

require __DIR__ . '/../vendor/autoload.php';

use RegSexy\Modifiers as mod;
use RegSexy\RegEx;

$subject = 'Waldo Dogsly and Fink 9 theo 10';
$pattern = '(waldo)* (\w+ )+\d+';

// by default no modifiers are used

var_dump(
    RegEx::newRegEx($pattern)
        ->matchInput($subject)->match
);

// these 3 are equivalant

var_dump(
    RegEx::newRegEx($pattern, 'iU')
        ->matchInput($subject)->match
);

var_dump(
    RegEx::newRegEx($pattern, mod::CASELESS, mod::UNGREEDY)
        ->matchInput($subject)->match
);

var_dump(
    RegEx::newRegEx($pattern)->caseless()->ungreedy()
        ->matchInput($subject)->match
);
