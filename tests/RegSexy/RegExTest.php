<?php

use RegSexy\RegEx;

class RegExTest extends PHPUnit_Framework_TestCase
{
    public function testCreateNull()
    {
        $delim = RegEx::DELIMITER;
        $empty = $delim . $delim;

        $regex = new RegEx();

        $this->assertEquals(
            $empty,
            $regex->getRegEx(),
            'new Class(…)'
        );

        $regex = RegEx::make();

        $this->assertEquals(
            $empty,
            $regex->getRegEx(),
            'Class::make(…) factory'
        );
    }

    public function testCreateWithDelimiter()
    {
        $delim = RegEx::DELIMITER;
        $regex = new RegEx($delim . '+');

        $this->assertEquals(
            $delim . '\\' . "$delim+" . $delim,
            $regex->getRegEx(),
            'some message'
        );

        return $regex;
    }

    /**
     * @depends testCreateWithDelimiter
     */
    public function testMatchDelimiter(RegEx $regex)
    {
        $delim = RegEx::DELIMITER;

        for ($i = 1; $i < 10; $i++)
        {
            $expected = str_repeat($delim, $i);
            $actual = $regex->match($expected)->match;
            $this->assertEquals(
                $expected,
                $actual,
                "Match $i Delimiter" . ($i > 0 ? 's' : '')
            );
        }
    }
}

