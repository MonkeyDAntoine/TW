<?php
require_once "../php/config.php";

$recherche = $_GET['search'];

if (!empty($recherche) && (strlen($recherche) > 2)) {

    $clause = "WHERE lower(title) LIKE lower(:recherche)";
    $param = array();
    $param[':recherche'] = "%$recherche%";

    include "../php/requetePhoto.php";
}