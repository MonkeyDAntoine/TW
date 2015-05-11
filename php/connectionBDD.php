<?php
require_once "config.php";

$pdo = new PDO('pgsql:dbname=gallerie;host=localhost;user=postgres;password=postgres');

function sqlToPhpArray($array)
{
    return array_unique(array_filter(explode(',', preg_replace('(\{|\})', '', $array)), function ($e) {
        return $e != "NULL";
    }));
}