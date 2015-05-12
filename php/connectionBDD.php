<?php
require_once "config.php";

$pdo = new PDO('pgsql:dbname=gallerie;host=localhost;port=5433','postgres','postgres');

function sqlToPhpArray($array)
{
    return array_filter(explode(',', preg_replace('(\{|\})', '', $array)), function ($e) {
        return $e != "NULL";
    });
}