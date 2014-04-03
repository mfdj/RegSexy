<?php

require __DIR__ . '/../vendor/autoload.php';

use RegSexy\RegEx;

// Clean up some phone numbers
$before = "101 454 3567, 2024543567, (303)454-3567, 404-454-3567, 505.454.3567";

$after = RegEx::newRegEx('[(]{0,1} (\d{3}) [)-\.\s]{0,1} (\d{3}) [-\.\s]{0,1} (\d{4})')
    ->extended()
    ->replace($before, '($1) $2-$3');

var_dump($before);
var_dump($after);
