<?php
require_once "connectionBDD.php";

$requete =
    "SELECT *
     FROM (
       SELECT
         pho_url                              AS url,
         pho_mime_type                        AS mimetype,
         pho_largeur || ' x ' || pho_hauteur  AS \"size\",
         pho_vignette                         AS thumbnail,
         pho_nom_auteur                       AS author,
         pho_url_auteur                       AS url_author,
         pho_titre                            AS title,
         pho_type_licence                     AS licence,
         array_agg(DISTINCT (cat_label)) AS categories,
         array_agg(DISTINCT (mcl_mot))   AS motscles,
         array_agg(DISTINCT (utl_login)) AS logins
       FROM photos
         LEFT JOIN photo_categorie
           ON pho_id = pca_id_pho
         LEFT JOIN categories
           ON cat_id = ANY (getCategories(pca_id_cat))
         LEFT JOIN photo_mot_cle
           ON pho_id = pmc_id_pho
         LEFT JOIN mots_cles
           ON mcl_id = pmc_id_mcl
         LEFT JOIN favoris
           ON pho_id = fav_id_pho
         LEFT JOIN utilisateurs
           ON utl_id = fav_id_utl
       GROUP BY pho_url,
         pho_largeur,
         pho_hauteur,
         pho_vignette,
         pho_nom_auteur,
         pho_url_auteur,
         pho_titre,
         pho_type_licence,
         pho_mime_type,
         pho_date_ajout
       ORDER BY
         pho_date_ajout
     ) AS TOUTES_LES_PHOTOS
     $clause;
    ";

$stmt = $pdo->prepare($requete);
$stmt->execute($param);

$reponseJSON = array();
$reponseJSON['datetime'] = date('l jS \\of F Y h:i:s A');
$reponseJSON['status'] = 'ok';
$reponseJSON['thumbnails_dir'] = $BASE_VIGNETTES;
$reponseJSON['results'] = array();

$auth = $_SESSION['AUTH'];

$type_licence = array('BY', 'NC', 'ND', 'SA');

while ($row = $stmt->fetch()) {
    $description = array();
    $description['url'] = $row['url'];
    $description['size'] = $row['size'];
    $description['thumbnail'] = $row['thumbnail'];
    $description['author'] = $row['author'];
    $description['url_author'] = $row['url_author'];
    $description['title'] = $row['title'];
    $description['categories'] = sqlToPhpArray($row['categories']);
    $description['keywords'] = sqlToPhpArray($row['motscles']);
    $description['mime_type'] = $row['mimetype'];

    $licence = 'CC';
    $types = sqlToPhpArray($row['licence']);

    if (array_unique($types) === array('f')) {
        $licence .= '-Zero';
    } else {
        for ($i = 0; $i < 4; $i++) {
            if ($types[$i] == 't') {
                $licence .= '-' . $type_licence[$i];
            }
        }
    }
    $description['licence'] = $licence;

    if (!empty($auth) && !empty($auth['login'])) {
        $logins = sqlToPhpArray($row['logins']);
        if (!empty($logins)) {
            $index = array_search($auth['login'], $logins);
            $description['favorite'] = is_numeric($index) && $index >= 0;
        } else {
            $description['favorite'] = false;
        }
    }

    array_push($reponseJSON['results'], $description);
}

echo json_encode($reponseJSON);