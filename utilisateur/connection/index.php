<?php
require_once "../../php/connectionBDD.php";

$login = $_POST['login'];
$mdp = $_POST['mdp'];

$messages = validerLoginMotDePasse($login, $mdp);

if (empty($messages['erreurs'])) {
    $loginExiste = "
            SELECT count(utl_login) > 0 AS existe
            FROM utilisateurs
            WHERE lower(utl_login) LIKE LOWER(:login);
        ";

    $stmt = $pdo->prepare($loginExiste);
    $stmt->execute(array(':login' => $login));
    $row = $stmt->fetch();

    if ($row['existe']) {
        $auth = "
            SELECT
              utl_id AS id,
              utl_login AS \"login\"
            FROM utilisateurs
            LEFT JOIN favoris
            ON utilisateurs.utl_id = favoris.fav_id_utl
            WHERE LOWER(utl_login) = LOWER(:login)
            AND utl_mdp = :mdp
            ";

        $stmt = $pdo->prepare($auth);
        $stmt->execute(array(':login' => $login, ':mdp' => $mdp));
        $row = $stmt->fetch();

        if ($row['login']) {
            $_SESSION['AUTH'] = array();

            $_SESSION['AUTH']['id'] = $row['id'];
            $_SESSION['AUTH']['login'] = $row['login'];

            array_push($messages['succes'], "Vous êtes connecté !");
        } else {
            array_push($messages['erreurs'], "Mot de passe incorrect");
        }
    } else {
        array_push($messages['erreurs'], "Ce login n'existe pas");
    }
}

echo json_encode($messages);