<?php

namespace RegSexy;

class Match
{
    public $match;
    public $offset;
    public $sub = array();
    public $subOffsets = array();

    function __toString()
    {
        return $this->match ? $this->match : '';
    }
}
