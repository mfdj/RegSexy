<?php

namespace RegSexy;

class Debug
{
    public static function match(Match $match)
    {
        return 'Pattern matched: "' . $match->match . '"'
        . ( $match->offset !== null ? ' @ byte ' . $match->offset . ',' : '' )
        . ' with '
        . (
        count($match->sub) > 0
            ? count($match->sub) . ' sub-match' . ( count($match->sub) > 1 ? 'es' : '' )
            . ' ("' . implode( '"', $match->sub) .'")'
            : '0 sub-matches'
        );
    }
}
