<?php
require_once "../../../php/connectionBDD.php";

$auth = $_SESSION['AUTH'];
$path_vignette = $_GET['vignette'];


if (!empty($auth) && !empty($path_vignette)) {
    $id = $auth['id'];
    $vignette = preg_replace("/$BASE_VIGNETTES\\//", '', $path_vignette, 1);
    if (!empty($id) && $id > 0 && !empty($vignette)) {
        $ajouter = "INSERT INTO favoris(fav_id_utl, fav_id_pho) VALUES (:id, (SELECT pho_id FROM photos WHERE pho_vignette LIKE :vignette))";
        $stmt = $pdo->prepare($ajouter);
        $stmt->execute(array(':id' => $id, ':vignette' => $vignette));
        $stmt->fetch();
    }
}
