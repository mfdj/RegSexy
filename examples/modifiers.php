<?php



use RegSexy\RegEx;
use RegSexy\Modifiers as mod;

$subject = 'Waldo Dogsly and Fink 9 theo 10';
$pattern = '(waldo)* (\w+ )+\d+';

// no modifiers
$exp = RegEx::make($pattern);
out($exp);

// defaults
echo "Default modifiers: " . RegEx::$defaultModifiers . "\n";
$exp = RegEx::make($pattern)->defaultModifiers();
out($exp);

// these 4 are equivalant
$exp = RegEx::make($pattern,'iU');
out($exp);

$exp = RegEx::make($pattern, mod::CASELESS, mod::UNGREEDY);
out($exp);

$exp = RegEx::make($pattern)->caseless()->ungreedy();
out($exp);

$exp = RegEx::make($pattern)->defaultModifiers()->dotall(false);
out($exp);

function out($exp)
{
    global $subject;

    echo $exp . "\n";
    var_dump($exp->match($subject)->matchString);
    echo "\n";
}
