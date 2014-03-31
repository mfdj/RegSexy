<?php

use RegSexy\RegEx;

// Here's our test subject, a sentence about animals
$subject = 'Cats are pretty funny I love, that, what is called… "ICanHasCheezburger?"!, '
         . 'is pretty great… but *really* I\'m more of a dog person. Got 2 little Chihuahuas at home!';

// Create a (sexy) RegEx object
$someCats = new RegEx('(Chesire|Tabby|Siamese|ICanHasCheezburger\?)');

// Compare the string against the expression with match() (returns a Match object)
$firstCat = $someCats->match( $subject );

// Check which cat was matched
var_dump( $firstCat->matchString );

// or check out the byte offset (maybe you're into that?)
var_dump( $firstCat->offset );

// If you're not going to reuse the RegEx instance
// you could use a chained expression
var_dump(
    (new RegEx('(Chihuahua|Dachsund|Corgi)s'))
    	->match( $subject )
    	->matchString
);

// and that's why using the factory method is handy (slightly clenaer)
var_dump(
    RegEx::make( '(Chihuahua|Dachsund|Corgi)s' )
    	->match( $subject )
    	->matchString
);

// the Match object even implements __toString(), nice for quick testing
echo RegEx::make( '(Chihuahua|Dachsund|Corgi)s' )->match( $subject );