<?php
require_once "../../php/connectionBDD.php";

$login = $_POST['login'];
$mdp = $_POST['mdp'];
$mdpbis = $_POST['mdpbis'];

$messages = validerLoginMotDePasse($login, $mdp);

if (!empty($mdpbis)  && (empty($mdp) || $mdpbis != $mdp)) {
    array_push($messages['erreurs'], 'Le mot de passe de confirmation est incorrect');
}

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
        array_push($messages['erreurs'], "Ce login existe déjà");
    } else {
        $inscrire = "
            INSERT INTO utilisateurs(utl_login, utl_mdp)
            VALUES (:login, :motdepasse)
            ";

        $stmt = $pdo->prepare($inscrire);
        $stmt->execute(array(':login' => $login, ':motdepasse' => $mdp));
        $stmt->fetch();

        array_push($messages['succes'], "Inscription réussie");
    }
}

echo json_encode($messages);