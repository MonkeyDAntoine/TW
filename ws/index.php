<?php
require_once "../php/config.php";

$categorie = $_GET['category'];
$auteur = $_GET['author'];
$motscles = $_GET['keywords'];
if (strlen($motscles) > 0) {
    $motscles = explode(',', $motscles);
}

$collection = $_GET['collection'];

$from = $_GET['from'];
$limit = $_GET['limit'];

$clause = 'WHERE 1=1';

$param = array();

if (!empty($categorie)) {
    $clause .= ' AND (:categorie) = ANY(categories)';
    $param[':categorie'] = $categorie;
}
if (!empty($auteur)) {
    $clause .= ' AND (author) = (:auteur)';
    $param[':auteur'] = $auteur;
}
if (!empty($motscles) && count($motscles) > 0) {
    $clause .= ' AND overlap(motscles,:motscles)';
    $param[':motscles'] = $motscles;
}

if (!empty($collection)) {
    $clause .= ' AND (:collection) = ANY(logins)';
    $param[':collection'] = $collection;
}

if (!empty($from) && is_numeric($from) && $from > 0) {
    $clause .= ' OFFSET :from';
    $param[':from'] = $from;
}

if (!empty($limit) && is_numeric($limit) && $limit > 0) {
    $clause .= ' LIMIT :limit';
    $param[':limit'] = $limit;
}

include "../php/requetePhoto.php";

