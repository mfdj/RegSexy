<?php

require __DIR__ . '/../vendor/autoload.php';

use RegSexy\Modifiers as m;
use RegSexy\RegEx;

// If you've ever worked with PHP's native regular expression syntax (i.e. the preg_* functions)
// you're accustomed to blocks like this:
$pattern = "/f..k th../iu";

preg_match($pattern, 'FRÅK THIS', $match);
var_dump($match[0]);

preg_match($pattern, 'førk them', $match);
var_dump($match[0]);

// A pattern is a string composed of 3 compoennts:
// 1. a delimiter like '/', the slash is conventional, '~' and '#' are also common
// 2. the pattern like 'f..k th..', the engine of your creation!
// 3. and optional modifiers like 'iu', which change some properties of the regex engine
$pattern = "/f..k th../";
$pattern = "~f..k th..~iu";
$pattern = "#f..k th..#u";

// With RegSexy you get cleaner declerations
// • No delimiters. They are added and escaped for you, no futzing.
$match = RegEx::newRegEx('f..k th..')->setModifiers('iU')->matchInput('FÜNK THAT');
var_dump($match);

// To specifiy your modifiers you have a couple of options.

// You can simply pass a string as the second variable
$match = RegEx::newRegEx('f..k th..', 'iu')->matchInput('fîrk THUR')->match;
var_dump($match);

// Or you can 'use' the modifier constants (which just hold strings)
// pass each invididually
$match = RegEx::newRegEx('f..k th..', m::CASELESS, m::UTF8)->matchInput('Fink Thus')->match;
var_dump($match);

