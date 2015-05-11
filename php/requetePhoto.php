<?php
require_once "connectionBDD.php";

$requete =
    "SELECT *
     FROM (
       SELECT
         pho_url                              AS url,
         pho_largeur || 'X' || pho_hauteur    AS \"size\",
         pho_vignette                         AS thumbnail,
         pho_nom_auteur                       AS author,
         pho_url_auteur                       AS url_author,
         pho_titre                            AS title,
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

    if (!empty($auth) && !empty($auth['login'])) {
        $logins = sqlToPhpArray($row['logins']);
        $description['favorite'] = !empty($logins) && (array_search(strtolower($auth['login']), $logins) >= 0);
    }

    array_push($reponseJSON['results'], $description);
}

echo json_encode($reponseJSON);