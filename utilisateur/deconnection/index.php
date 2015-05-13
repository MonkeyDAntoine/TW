<?php
require_once "../../php/connectionBDD.php";

$auth = $_SESSION['AUTH'];
if (!empty($auth) && !empty($auth['login'])) {
    unset($_SESSION['AUTH']);
}