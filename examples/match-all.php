<?php

require __DIR__ . '/../vendor/autoload.php';

use RegSexy\RegEx;

echo "<pre>";

// Just a test string
$subject = 'Cats are pretty funny I love, that, what is called… "ICanHasCheezburger?"!, '
    . 'is pretty great… but *really* I\'m more of a dog person. Got 2 little Chihuahuas at home!';

// match() returns a Match object
$match = RegEx::make('(Chihuahuas|ICanHasCheezburger\?)')
    ->match($subject);

var_dump($subject);

// matchAll() returns a MatchList object, which is a basic itterator
$matches = RegEx::make('(Chihuahuas|ICanHasCheezburger\?)')
    ->matchAll($subject);

foreach ($matches as $index => $v)
    echo "match ".(++$index).": $v\n";

// You can grab a paticular item
var_dump($matches->match(1)->match);

// MatchList also implements __toString(), nice for quick testing
echo RegEx::make('(Chihuahuas|ICanHasCheezburger\?)')->matchAll($subject);
