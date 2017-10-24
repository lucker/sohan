<?php
namespace app\models;

class test
{
    function __construct() {
        echo 'consstructor';
    }
    function __destruct() {
        echo 'destruct';
    }
    public function sum($a, $b)
    {
        return $a + $b;
    }
}