<?php
error_reporting(0);

$BASE_VIGNETTES = 'vignettes';

if (!function_exists('validerLoginMotDePasse')) {
    function validerLoginMotDePasse($login, $mdp)
    {
        $TAILLE_MIN_LOGIN = 3;
        $TAILLE_MAX_LOGIN = 10;
        $TAILLE_MIN_MOTDEPASSE = 5;
        $TAILLE_MAX_MOTDEPASSE = 20;

        $messages = array();
        $messages['erreurs'] = array();
        $messages['succes'] = array();

        if (empty($login) || strlen($login) < $TAILLE_MIN_LOGIN || strlen($login) > $TAILLE_MAX_LOGIN) {
            array_push($messages['erreurs'], "Le login doit être entre $TAILLE_MIN_LOGIN et $TAILLE_MAX_LOGIN caractères");
        }

        if (empty($mdp) || strlen($mdp) < $TAILLE_MIN_MOTDEPASSE || strlen($mdp) > $TAILLE_MAX_MOTDEPASSE) {
            array_push($messages['erreurs'], "Le mot de passe doit être entre $TAILLE_MIN_MOTDEPASSE et $TAILLE_MAX_MOTDEPASSE caractères");
        }

        return $messages;
    }
}
