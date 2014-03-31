<?php

namespace RegSexy;

class RegEx
{
    // Static
    private static $delimeter = "~";

    // Instance
    private $undelimitedPattern;
    private $_modifiers;
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
            $this->modifiers = implode($modifiers);

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
     * @param string, string, …
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
     * An internal method that does the work for the API parllel match() and matchAll()
     */
    private function _match($all, $input, $startByte = 0)
    {
        if ($all)
            preg_match_all($this->getRegEx(),
                           $input,
                           $result,
                           ($this->getOffsets ? PREG_OFFSET_CAPTURE : 0) | PREG_SET_ORDER,
                           $startByte);
        else
            preg_match($this->getRegEx(),
                       $input,
                       $result,
                ($this->getOffsets ? PREG_OFFSET_CAPTURE : 0),
                       $startByte);

        if (!$all) // normalize the difference in $result between preg_match & preg_match_all
            $result = array($result);

        $matches = array();
        for ($i = 0, $resultLen = count($result); $i < $resultLen; $i++)
        {
            $items     = & $result[$i];
            $m         = new Match;
            $matches[] = $m;

            for ($k = 0, $itemCount = count($items); $k < $itemCount; $k++)
            {
                if ($k == 0) // first item is the pattern match
                {
                    if ($this->getOffsets)
                    {
                        $m->matchString = $items[$k][0];
                        $m->offset      = $items[$k][1];
                    }
                    else
                        $m->matchString = $items[$k];
                }
                else // subsequent items are sub matches
                {
                    if ($this->getOffsets)
                    {
                        $m->sub[]        = $items[$k][0];
                        $m->subOffsets[] = $items[$k][1];
                    }
                    else
                        $m->sub[] = $items[$k];
                }
            }
        }

        if ($all)
            return new MatchList($matches);

        return $matches[0];
    }

    /**
     * @param      $input
     * @param bool $withDelims
     * @param      $limit
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
     * @param $value
     * @return RegEx
     */
    public function setModifiers($value)
    {
        $this->modifiers = $value;

        return $this;
    }

    /**
     * Add a modifier
     * @param string $m Modifier character
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
     * @access public
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
    public function withOffsets($enable = true)
    {
        $this->getOffsets = $enable;

        return $this;
    }

    /**
     * Case Sensitivity
     *
     * Match case insensitive or sensitive based on $enable value
     *
     * @access public
     * @param  boolean $enable Enables or disables case sensitive. Default true
     * @return RegEx
     */
    public function caseless($enable = true)
    {
        return $enable ? $this->addModifier('i') : $this->removeModifier('i');
    }

    /**
     * Stop At First
     *
     * Toggles g modifier
     *
     * @access public
     * @param  boolean $enable Enables or disables g modifier. Default true
     * @return RegEx
     */
    public function stopAtFirst($enable = true)
    {
        return $enable ? $this->addModifier('g') : $this->removeModifier('g');
    }

    /**
     * SearchOneLine
     *
     * Toggles m modifier
     *
     * @access public
     * @param  boolean $enable Enables or disables m modifier. Default true
     * @return RegEx
     */
    public function searchOneLine($enable = true)
    {
        return $enable ? $this->addModifier('m') : $this->removeModifier('m');
    }

    /**
     * @param bool $enable
     * @return $this
     */
    public function ungreedy($enable = true)
    {
        return $enable ? $this->addModifier('U') : $this->removeModifier('U');
    }

    /**
     * @param bool $enable
     * @return $this
     */
    public function dotall($enable = true)
    {
        return $enable ? $this->addModifier('s') : $this->removeModifier('s');
    }

    /**
     * Magic method to retrieve the pattern.
     *
     * @access public
     * @return string
     */
    public function __toString()
    {
        return $this->getRegex();
    }
}
