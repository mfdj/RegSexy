<?php

require __DIR__ . '/../vendor/autoload.php';

use RegSexy\RegEx;

$subject = <<< EOT
  1. RegEx
  2. RegExp
  3. Regular Expression
  4. Regular Expressions
  5. RegularExpression
  6. RegularExpressions
EOT;

// (RegExp|RegEx|Regular Expressions)
// (Regular Expressions|RegExp|RegEx)
// Reg(ular)*\s*Ex(p)*(ression)*(s)*

$matches = RegEx::make('[0-9]\. (RegEx|RegExp|Regular Expressions)')
    ->matchAll($subject);

while (!$matches->done)
{
    echo "<li>";
    var_dump($matches->next->match);
}
