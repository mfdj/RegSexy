<?php

namespace RegSexy;

/**
 * ToDO:
 *  • http://us1.php.net/manual/en/function.preg-replace-callback.php
 *  • http://us1.php.net/manual/en/function.preg-grep.php
 *  • http://us1.php.net/manual/en/function.preg-filter.php
 *
 * Do not want to implement:
 * • http://us1.php.net/manual/en/function.preg-quote.php
 */

class RegEx
{
    // Static
    private static $delimeter = "~";

    // Instance
    private $undelimitedPattern;
    private $modifiers;
    private $getOffsets = true;

    /**
     * A factory method for static contexts; useful for often use-it-once situations.
     * New RegEx and ->pattern()
     *
     * @return RegEx
     */
    public static function make($undelimitedPattern)
    {
        $exp = new RegEx($undelimitedPattern);

        $modifiers = array_slice((func_get_args()), 1);

        if (!empty($modifiers))
            $exp->setModifiers(implode($modifiers));

        return $exp;
    }

    /**
     * Optionally pass a pattern as a constructor. See pattern().
     */
    function __construct($undelimitedPattern = null)
    {
        if ($undelimitedPattern)
        {
            $this->undelimitedPattern = $undelimitedPattern;

            $modifiers = array_slice((func_get_args()), 1);

            if (!empty($modifiers))
                $this->modifiers = implode($modifiers);
        }
    }

    /**
     * Complies a Perl Compatible Regular Expression and returns itself
     *
     * @param    $undelimitedPattern  String  A non-delimited PCRE pattern
     * @internal $modifiers           String  Optional valid pattern modifiers for (see Modifiers).
     *                                Modifiers can be expressed as a list of individual arguments or as a complete string.
     *                                Passing null or '' results in no modifiers being used.
     *
     * @return RegEx
     */
    public function pattern($undelimitedPattern)
    {
        $this->undelimitedPattern = $undelimitedPattern;

        return $this;
    }

    /**
     * Allows one to provide a delimited pattern.
     *
     * @param    $undelimitedPattern  String  A non-delimited PCRE pattern
     * @internal $modifiers           String  Optional valid pattern modifiers for (see Modifiers).
     *                                Modifiers can be expressed as a list of individual arguments or as a complete string.
     *                                Passing null or '' results in no modifiers being used.
     *
     * @return RegEx
     */
    //    public function delemited($undelimitedPattern)
    //    {
    //        $this->undelimitedPattern = $undelimitedPattern;
    //
    //        return $this;
    //    }

    /**
     * @param string , string, …
     */
    public function modifiers()
    {
        // all elements but the first are modifiers
        $modifiers = func_get_args();

        if (isset($modifiers))
            $this->modifiers = implode($modifiers);
    }

    /**
     * @return string
     */
    public function getRegEx()
    {
        return static::$delimeter
        . str_replace(static::$delimeter, '\\' . static::$delimeter, $this->undelimitedPattern)
        . static::$delimeter
        . $this->modifiers;
    }

    /**
     * @param $input
     * @param $replacement
     * @param $maxReplacements
     * @return mixed
     */
    public function replace($input, $replacement, $maxReplacements = -1)
    {
        return preg_replace($this->getRegEx(), $replacement, $input, $maxReplacements);
    }

    /**
     * @param string $input
     * @param int    $startByte
     *
     * @return MatchList
     */
    public function matchAll($input, $startByte = 0)
    {
        return $this->_match(true, $input, $startByte = 0);
    }

    /**
     * @param string $input
     * @param int    $startByte
     *
     * @return Match
     */
    public function match($input, $startByte = 0)
    {
        return $this->_match(false, $input, $startByte = 0);
    }

    /**
     * merges match() and matchAll() into a unified interface
     */
    private function _match($all, $input, $startByte = 0)
    {
        $offsets = $this->getOffsets;

        if ($all)
            preg_match_all($this->getRegEx(),
                           $input,
                           $results,
                           ($offsets ? PREG_OFFSET_CAPTURE : 0) | PREG_SET_ORDER,
                           $startByte);
        else
            preg_match($this->getRegEx(),
                       $input,
                       $results,
                ($offsets ? PREG_OFFSET_CAPTURE : 0),
                       $startByte);

        // normalize preg_match() $results to be equivilant preg_match_all()
        if (!$all)
            $results = array($results);

        $i       = 0;
        $len     = count($results);
        $matches = [];

        // examine each result (i.e. a match to the expression)
        for (; $i < $len; $i++)
        {
            $item = $results[$i];
            $k    = 0;
            $kLen = count($item);

            if ($kLen)
            {
                $m         = new Match;
                $matches[] = $m;
            }

            // these are properties of each result
            for (; $k < $kLen; $k++)
            {
                if ($k === 0) // first item is the string matching the pattern
                {
                    if ($offsets)
                    {
                        $m->match  = $item[$k][0];
                        $m->offset = $item[$k][1];
                    }
                    else
                        $m->match = $item[$k];
                }
                else // subsequent items are sub-expression matches
                {
                    if ($offsets)
                    {
                        $m->sub[]        = $item[$k][0];
                        $m->subOffsets[] = $item[$k][1];
                    }
                    else
                        $m->sub[] = $item[$k];
                }
            }
        }

        if ($all)
            return new MatchList($matches);

        return $matches[0]; // returns Match
    }

    /**
     * @param string $input
     * @param bool   $withDelims
     * @param int    $limit
     * @return array
     */
    public static function split($input, $withDelims = false, $limit = -1)
    {
        return preg_split(
            $this->getRegEx(),
            $input,
            $limit,
            ($withDelims ? PREG_SPLIT_DELIM_CAPTURE : 0) | PREG_SPLIT_NO_EMPTY
        );
    }

    /**
     * @param string $value
     * @return RegEx
     */
    public function setModifiers($value)
    {
        $this->modifiers = $value;

        return $this;
    }

    /**
     * Add a modifier
     * @param string $m PCRE modifier character
     * @return $this
     */
    public function addModifier($m)
    {
        if (strpos($this->modifiers, $m) === false)
            $this->modifiers .= $m;

        return $this;
    }

    /**
     * Remove modifier
     * @param string $m Modifier character
     * @return $this
     */
    public function removeModifier($m)
    {
        $this->modifiers = str_replace($m, '', $this->modifiers);

        return $this;
    }

    /**
     * Test
     *
     * tests the match of a string to the current regex
     *
     * @param  string $value The string to be tested
     * @return boolean true if it's a match
     */
    public function test($value)
    {
        return (bool)preg_match($this->getRegex(), $value);
    }

    /**
     * @param bool $enable
     * @return $this
     */
    public function withOffsetCapture($enable = true)
    {
        $this->getOffsets = $enable;

        return $this;
    }

    /**
     * Case Sensitivity
     * Match case insensitive or sensitive based on $enable value
     * @param  boolean $enable Enables or disables case sensitive. Default true
     * @return RegEx
     */
    public function caseless($enable = true)
    {
        return $enable ? $this->addModifier('i') : $this->removeModifier('i');
    }

    /**
     * Case Sensitivity
     * Match case insensitive or sensitive based on $enable value
     * @param  boolean $enable Enables or disables case sensitive. Default true
     * @return RegEx
     */
    public function extended($enable = true)
    {
        return $enable ? $this->addModifier('x') : $this->removeModifier('x');
    }

    /**
     * Stops at first match: toggles g modifier.
     * @param  boolean $enable Enables or disables g modifier. Default true
     * @return RegEx
     */
    public function stopAtFirst($enable = true)
    {
        return $enable ? $this->addModifier('g') : $this->removeModifier('g');
    }

    /**
     * Toggles m modifier
     * @param  boolean $enable Enables or disables m modifier. Default true
     * @return RegEx
     */
    public function searchOneLine($enable = true)
    {
        return $enable ? $this->addModifier('m') : $this->removeModifier('m');
    }

    /**
     * Toggles U modifier
     * @param bool $enable
     * @return $this
     */
    public function ungreedy($enable = true)
    {
        return $enable ? $this->addModifier('U') : $this->removeModifier('U');
    }

    /**
     * Toggles s modifier
     * @param bool $enable
     * @return $this
     */
    public function dotall($enable = true)
    {
        return $enable ? $this->addModifier('s') : $this->removeModifier('s');
    }

    /**
     * Retrieves the pattern.
     * @return string
     */
    public function __toString()
    {
        return $this->getRegex();
    }
}
