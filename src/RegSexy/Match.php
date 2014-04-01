<?php

namespace RegSexy;

class Match
{
    public $match;
    public $offset;
    public $sub = [];
    public $subOffsets = [];

    function __toString()
    {
        return $this->match ? $this->match : '';
    }
}
