RegSexy
===========

A PHP utility library that leverages the preg_* function family adding syntactic sugar, simplicity, and consistency so you can stay up on [the haps on the craps](http://rapgenius.com/Ice-cube-it-was-a-good-day-lyrics#note-9194,'Ice Cube - Today Was a Good Day'). Go outside, play with your best friend: the world's your oyester, kid!

### Features

* Lean, easy to read syntax!
* Method chaining!
* Nice Defaults!

``` php
use RegSexy\RegEx;

$subject = 'Cats are pretty funny I love, that, what is called… "ICanHasCheezburger?"!, '
         . 'is pretty great… but *really* I\'m more of a dog person. Got 2 little Chihuahuas at home!';

var_dump(
    RegEx::make( '(Chihuahua|Dachsund|Corgi)s' )
        ->match( $subject )
        ->match
);
```

### Hat Tip

This project draws inspiration from: 

- [KingCrunch/RegularExpression](https://github.com/KingCrunch/RegularExpression)
- [VerbalExpressions/PHPVerbalExpressions](https://github.com/VerbalExpressions/PHPVerbalExpressions)

### License

<a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/deed.en_US"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/3.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/InteractiveResource" property="dct:title" rel="dct:type">RegSexy</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="http://ixel.org" property="cc:attributionName" rel="cc:attributionURL">Mark Fox</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/deed.en_US">Creative Commons Attribution-ShareAlike 3.0 Unported License</a>.
