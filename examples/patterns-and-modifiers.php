<?php

// Bootstrap.


use RegSexy\RegEx;

// If you've ever worked with PHP's native regular expression syntax (i.e. the preg_* functions)
// you're accustomed to blocks like this:
$pattern = "/f..k th../iu";
preg_match( $pattern, 'FRÅK THIS', $match );
var_dump( $match[0] );

// Where a pattern expression is a string with 3 main compoennts:
// 1. a delimiter like '/', the slash is conventional, '~' and '#' are also common
// 2. a pattern like 'f..k th..', the engine of your creation!
// 3. and optional modifiers like 'iu', which must be valid PCRE (google it)
//    [ crib sheet: i = case inensitve, u = UTF-8 comptaible ]
$pattern = "~f..k th..~iu"; // <- same pattern differnetly delimited
preg_match( $pattern, 'førk them', $match );
var_dump( $match[0] );

// With RegSexy you get cleaner declerations
// • No delimiters. They are added and escaped for you, no futzing.
// • Nice default modifiers 'isUu' but can easily be changed on the fly.
$match = RegEx::make( 'f..k th..' )->match( 'FÜNK THAT' )->matchString;
var_dump( $match );

// To specifiy your modifiers you have a couple of options.

// You can simply pass a string as the second variable
$match = RegEx::make( 'f..k th..', 'iu' )->match( 'fîrk THUR' )->matchString;
var_dump( $match );

// Or you can 'use' the modifier constants (which just hold strings)
// and pass each one invididually
use RegSexy\Modifiers as m; // <-- alias the namespace (fyi the modifiers are loaded with RegEx)
$match = RegEx::make( 'f..k th..', m::CASELESS, m::UTF8 )->match( 'Fink Thus' )->matchString;
var_dump( $match );

// If you want no modifiers, just pass null or an empty string
RegEx::make( 'f..k th..', null );
RegEx::make( 'f..k th..', '' );

// To simplify your workflow you can manually change the default modifiers
// on a per team/project basis, just check out RegEx.
// The default modifiers are private and static, so they'll never change at runtime.
// RegEx.php line 12ish: private static $defaultModifiers = "isUu";

// If you reuse multiple sets of modifiers then just add them to Modifiers.php
// const XTREME_MODIFIERS = 'X';
// const CLS_UTF8         = 'iu';