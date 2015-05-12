<?php
include "php/config.php";
include "php/connectionBDD.php"
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link href="css/index.css" rel="stylesheet"/>
</head>
<body>

<div id="header">
    <?php $auth = $_SESSION['AUTH'];
    if (!empty($_SESSION['AUTH']) && !empty($auth['login'])) {
        echo '
        <div id = "deconnection" >
            <form method = "post" action = "utilisateur/deconnection/" id = "deconnectionForm" >
                <input type = "submit" name = "submit" value = "Se déconnecter" />
            </form >
        </div >';
    } else {
        echo '
        <span id = "messages" ></span >
        <div id = "connection" >
            <form method = "post" action = "utilisateur/connection/" id = "connectionForm" >
                <label >
        Login :
                    <input type = "text" name = "login" />
                </label >
                <label >
        Mot de passe :
                    <input type = "password" name = "mdp" />
                </label >
                <input type = "submit" name = "submit" value = "Se connecter" />
            </form >
        </div >
        <div id = "inscription" >
            <form method = "post" action = "utilisateur/inscription/" id = "inscriptionForm" >
                <label >
        Login :
                    <input type = "text" name = "login" />
                </label >
                <label >
        Mot de passe :
                    <input type = "password" name = "mdp" />
                </label >
                <label >
        Ressaisissez le mot de passe :
                    <input type = "password" name = "mdpbis" />
                </label >
                <input type = "submit" name = "submit" value = "S\'inscrire" />
            </form >
        </div >';
    } ?>
</div>

<div id="content">
    <div>
        <input name="recherche" id="recherche" type="text"
               placeholder="Recherche par titre ou mot clé(3 caractères minimum)"/>
    </div>
    <div id="menu">
        <?php

        /**
         * LISTE DES CATEGORIES
         */

        $selectCategories = "
            SELECT
                cat . cat_id,
                cat . cat_label,
                array_agg(subcat . cat_id) AS ids_sous_cat,
                (cat . cat_id_parent_cat IS NOT NULL) AS est_sous_cat
            FROM categories AS cat
            LEFT JOIN categories AS subcat
            ON cat . cat_id = subcat . cat_id_parent_cat
            GROUP BY
                cat . cat_id,
                cat . cat_label,
                cat . cat_id_parent_cat
            ORDER BY
                est_sous_cat,
                cat_label";

        $categories = array();
        $souscategories = array();

        $stmt = $pdo->prepare($selectCategories);
        $stmt->execute();

        while ($row = $stmt->fetch()) {
            $id = $row['cat_id'];
            $cat = array();
            $cat['id'] = $id;
            $cat['label'] = $row['cat_label'];
            $cat['sous_cat'] = sqlToPhpArray($row['ids_sous_cat']);
            if ($row['est_sous_cat']) {
                $souscategories[$id] = $cat;
            } else {
                $categories[$id] = $cat;
            }
        }

        function afficherCategorie($cat, $souscategories)
        {
            $html = '<ul>';
            $label = $cat['label'];
            $html .= " <li data-c = \"$label\" class=\"categorie\">$label</li>";
            if (array_key_exists('sous_cat', $cat)) {
                foreach ($cat['sous_cat'] as $id_cat) {
                    $html .= afficherCategorie($souscategories[$id_cat], $souscategories);
                }
            }
            $html .= '</ul>';
            return $html;
        }

        $htmlListeCat = '<ul><li class="categorie">Toutes</li></ul>';
        foreach ($categories as $cat) {
            $htmlListeCat .= afficherCategorie($cat, $souscategories);
        }
        echo $htmlListeCat;

        ?>
    </div>

    <div>
        <div id="images">

        </div>
        <span id="precedente">Precedente</span>
        <span id="suivante">Suivante</span>
    </div>

    <div>
        <div id="utilisateurs">
        </div>
        <span id="logins_precedents"><<</span>
        <span id="logins_suivants">>></span>
    </div>
</div>

<div id="footer">

</div>

<script language="JavaScript" type="application/javascript" src="js/index.js"></script>
</body>

</html>