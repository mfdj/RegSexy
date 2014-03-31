<?php

namespace RegSexy;

/**
 * MatchList is an itterator like collection of Match objects
 *
 * @property-read  bool   $done     If itterator has recahed the last item
 * @property-read  Match  $next     Retrieves current element at pointer and post-increments pointer
 * @property-read  Match  $current  Retrieves current element at pointer
 * @property-read  int    $count    Number of elements
 * @property-read  int    $position Position of pointer
 * @proeprty-read  array  $source   The source of MatchList
 */
class MatchList
{
    private $done = false;
    private $source;
    private $pointer;
    private $max;
    private $count;

    /**
     * @param $source array A Match collection
     */
    function __construct( $source )
    {
        $this->source( $source );
    }

    /**
     * @param $a array A Match collection
     */
    public function source( $a )
    {
        $this->source  = $a;
        $this->count   = count( $a );
        $this->max     = $this->count - 1;
        $this->done    = ( $this->max === -1 );
        $this->pointer = -1;
    }

    /**
     * @param $name
     * @return int|null
     */
    public function __get( $name )
    {
        if ( $name === 'done' )
            return $this->done;

        if ( $name === 'next' )
        {
            $this->pointer++;

            if ( $this->pointer > $this->max )
                return null;
            else if ( $this->pointer === $this->max )
                $this->done = true;

            return $this->source[ $this->pointer ];
        }

        if ( $name === 'prev' )
        {
            $this->pointer--;

            if ( $this->pointer < 0 )
                return null;

            if ( $this->pointer < $this->max )
                $this->done = false;

            return $this->source[ $this->pointer ];
        }

        if ( $name === 'current' )
            return $this->pointer === -1 ? $this->source[ ++$this->pointer ] : $this->source[ $this->pointer ];

        if ( $name === 'position' )
            return $this->pointer === -1 ? 0 : $this->pointer;

        if ( $name === 'count' )
            return $this->count;

        if ( $name === 'first')
            return $this->source[0];

        if ( $name === 'last')
            return $this->source[ $this->max ];

        if ( $name === 'source')
            return $this->source;
    }

    /**
     * @param int $n
     * @return Match
     */
    public function item( $n )
    {
        return $this->source[ $n ];
    }

    function __toString()
    {
        $s = '<ol>Match List:';
        foreach( $this->source as $match )
            $s .= '<li>' . $match;
        $s .= '</ol>';

        return $s;
    }
}
