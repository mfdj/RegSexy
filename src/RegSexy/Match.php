<?php

namespace RegSexy;

class Match
{
    public $matchString;
    public $offset;
    public $sub = [];
    public $subOffsets = [];

    function __toString()
    {
        return 'Pattern matched: "' . $this->matchString . '"'
               . ( $this->offset !== null ? ' @ byte ' . $this->offset . ',' : '' )
               . ' with '
               . (
                    count($this->sub) > 0
                        ? count($this->sub) . ' sub-match' . ( count($this->sub) > 1 ? 'es' : '' )
                          . ' ("' . implode( '"', $this->sub) .'")'
                        : '0 sub-matches'
                );
    }
}
