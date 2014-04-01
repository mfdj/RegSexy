<?php

require __DIR__ . '/../vendor/autoload.php';

use RegSexy\RegEx;

// Here's our test subject, a sentence about animals
$subject = 'Cats are pretty funny I love, that, what is called… "ICanHasCheezburger?"!, '
    . "is pretty great… but *really* I'm more of a dog person. Got two little Chihuahuas at home!";

// Create a (sexy) RegEx object
$someCats = new RegEx('(Chesire|Tabby|Siamese|ICanHasCheezburger\?)');
$firstCat = $someCats->match($subject);

if ($firstCat)
    var_dump($firstCat);
else
    die('shiiiit son');

// If you use the expression once you can use fluent syntax
//
var_dump(
    (new RegEx('(Chihuahua|Dachsund|Corgi)s'))->match($subject)->match
);

// the "make()" factory makes this even clenaer
var_dump(
    RegEx::make('(Chihuahua|Dachsund|Corgi)s')->match($subject)->match
);

// the Match object even implements __toString()
echo RegEx::make('(Chihuahua|Dachsund|Corgi)s')->match($subject);
