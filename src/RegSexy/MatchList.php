<?php

namespace RegSexy;

/**
 * MatchList is an Iterator for a collection of RegSexy\Match objects
 */
class MatchList implements \IteratorAggregate
{
    private $source;

    /**
     * @param $source array A Match collection
     */
    function __construct($matches)
    {
        if (is_array($matches))
            $this->source = $matches;
    }

    function getIterator()
    {
        return new \ArrayIterator($this->source);
    }

    /**
     * @param int $n
     * @return Match
     */
    public function match( $n )
    {
        return $this->source[ $n ];
    }

    /**
     * @param int $n
     * @return Match
     */
    public function match( $n )
    {
        return $this->source[ $n ];
    }

    function __toString()
    {
        return implode(', ', $this->source);
    }
}
