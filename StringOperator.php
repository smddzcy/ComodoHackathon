<?php

class StringOperator
{
    public static function tokenize($s){
        $s = preg_replace("#[^a-zA-Z0-9' ]#si",null,$s);
        $keys = [];
        foreach(preg_split('/\s+/',$s) as $k){
            $k = trim($k);
            if(!empty($k)) $keys[] = $k;
        }
        return $keys;
    }

}