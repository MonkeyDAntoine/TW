<?php
require_once "../../../php/connectionBDD.php";

$auth = $_SESSION['AUTH'];
$path_vignette = $_GET['vignette'];


if (!empty($auth) && !empty($path_vignette)) {
    $id = $auth['id'];
    $vignette = preg_replace("/$BASE_VIGNETTES\\//", '', $path_vignette, 1);
    if (!empty($id) && $id > 0 && !empty($vignette)) {
        $supprimer = "DELETE FROM favoris WHERE fav_id_utl = :id AND fav_id_pho = (SELECT pho_id FROM photos WHERE pho_vignette LIKE :vignette)";
        $stmt = $pdo->prepare($supprimer);
        $stmt->execute(array(':id' => $id, ':vignette' => $vignette));
        $stmt->fetch();
    }
}
