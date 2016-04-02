<?php

/**
 * Created by PhpStorm.
 * User: smddzcy
 * Date: 02/04/16
 * Time: 19:01
 */
class StringOperator
{
    public static function tokenize(String $s){
        $s = preg_replace("#[^a-zA-Z' ]#si",null,$s);
        $keys = [];
        foreach(preg_split('/\s+/',$s) as $k){
            $k = trim($k);
            if(!empty($k)) $keys[] = new Keyword($k);
        }
        return $keys;
    }

}


print_r(StringOperator::tokenize("Hey wow, dude what's up ???!!"));