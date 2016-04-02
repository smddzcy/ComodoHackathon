<?php

/**
 * Created by PhpStorm.
 * User: smddzcy
 * Date: 02/04/16
 * Time: 19:11
 */
class Keyword
{
    public $name = null;
    public $frequency = 0;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function setFreq($i)
    {
        $this->frequency = (int)$i;
    }

    public function incrementFreq()
    {
        $this->frequency++;
    }


}