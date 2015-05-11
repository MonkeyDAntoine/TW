<?php
require_once "../../php/config.php";

$auth = $_SESSION['AUTH'];
if (!empty($auth)) {
    $collection = $auth['login'];

    $from = $_GET['from'];
    $limit = $_GET['limit'];

    $clause = 'WHERE 1=1';

    $param = array();

    if (!empty($collection)) {
        $clause .= ' AND (:collection) = ANY(logins)';
        $param[':collection'] = $collection;
        if (!empty($from) && is_numeric($from) && $from > 0) {
            $clause .= ' OFFSET :from';
            $param[':from'] = $from;
        }

        if (!empty($limit) && is_numeric($limit) && $limit > 0) {
            $clause .= ' LIMIT :limit';
            $param[':limit'] = $limit;
        }

        include "../../php/requetePhoto.php";
    }
}
