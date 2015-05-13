<?php
require_once "../php/connectionBDD.php";

$recherche = $_GET['search'];
$login = $_GET['login'];

$from = $_GET['from'];
$limit = $_GET['limit'];

$clause = 'WHERE 1=1';

$param = array();

if (!empty($recherche)) {
    $clause .= ' AND lower("login") LIKE lower(:recherche)';
    $param[':recherche'] = '%'.$recherche.'%';
}
if (!empty($login)) {
    $clause .= ' AND lower("login") = lower(:login)';
    $param[':login'] = $login;
}
if (!empty($from) && is_numeric($from) && $from > 0) {
    $clause .= ' OFFSET :from';
    $param[':from'] = $from;
}

if (!empty($limit) && is_numeric($limit) && $limit > 0) {
    $clause .= ' LIMIT :limit';
    $param[':limit'] = $limit;
}

$requete =
    "
    SELECT * FROM
    (
        SELECT
        utl_login AS \"login\"
        FROM utilisateurs
        ORDER BY utl_login
        )
     AS LOGINS
     $clause
    ";

$stmt = $pdo->prepare($requete);
$stmt->execute($param);

$reponseJSON = array();
while ($row = $stmt->fetch()) {
    array_push($reponseJSON, $row['login']);
}

echo json_encode($reponseJSON);