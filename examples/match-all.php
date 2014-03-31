<?php

// Bootstrap.


// Example time.
use RegSexy\RegEx;

// Just a test string
$subject = 'Cats are pretty funny I love, that, what is called… "ICanHasCheezburger?"!, '
         . 'is pretty great… but *really* I\'m more of a dog person. Got 2 little Chihuahuas at home!';

var_dump( $subject );

// match() returns a Match object
$match = RegEx::make( '(Chihuahuas|ICanHasCheezburger\?)' )
            ->match( $subject );

// matchAll() returns a MatchList object, which is a basic itterator
$matches = RegEx::make( '(Chihuahuas|ICanHasCheezburger\?)' )
            ->matchAll( $subject );

// you can itterate over the ->source, the internal array
foreach ( $matches->source as $m )
    var_dump( $m->matchString );

// or use the built in itteration functionality
// ->next moves the pointer and returns the current item and null on complete (which is falsey)
while ( $matches->next )
    var_dump( $matches->current );

// You can grab a paticular item (careful, must be a valid index)
var_dump( $matches->item(1) );

// MatchList also implements __toString(), nice for quick testing
echo RegEx::make( '(Chihuahuas|ICanHasCheezburger\?)' )->matchAll( $subject );