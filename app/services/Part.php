<?php

namespace app\services;
class Part
{
    public static function part($part_name)
    {
        require_once "views/parts/" . $part_name . ".php";
    }
}