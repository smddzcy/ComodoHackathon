<?php

class StringOperator
{
    /**
     * @param string $s
     * @return array
     */
    public static function tokenize($s)
    {
        $s = preg_replace("#[^a-zA-Z0-9' ]#si", null, $s);
        $keys = [];
        foreach (preg_split('/\s+/', $s) as $k) {
            $k = trim($k);
            if (!empty($k)) $keys[] = strtolower($k);
        }
        return $keys;
    }

    /**
     * @param string $s
     * @return string
     */
    public static function clearText($s)
    {
        return $s = strip_tags(preg_replace('/\s+/', ' ', preg_replace("#<noscript>.*?</noscript>#si", null, $s)));
    }

}