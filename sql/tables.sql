CREATE TABLE categories (
  cat_id            SERIAL PRIMARY KEY NOT NULL,
  cat_label         VARCHAR(255)       NOT NULL,
  cat_id_parent_cat INTEGER REFERENCES categories (cat_id)
);

CREATE TABLE mots_cles (
  mcl_id  SERIAL PRIMARY KEY NOT NULL,
  mcl_mot VARCHAR(255)       NOT NULL
);

CREATE TABLE photos (
  pho_id           SERIAL PRIMARY KEY NOT NULL,
  pho_vignette     VARCHAR(255)       NOT NULL,
  pho_nom_auteur   VARCHAR(255)       NOT NULL,
  pho_url_auteur   VARCHAR(255),
  pho_url          VARCHAR(255)       NOT NULL,
  pho_hauteur      SMALLINT           NOT NULL,
  pho_largeur      SMALLINT           NOT NULL,
  pho_type_licence BOOL [4]           NOT NULL, -- by,sa,nd,nc
  pho_titre        VARCHAR(255)       NOT NULL,
  pho_date_ajout   TIMESTAMP          NOT NULL DEFAULT current_timestamp
);

CREATE TABLE photo_categorie (
  pca_id_pho INTEGER REFERENCES photos (pho_id)     NOT NULL,
  pca_id_cat INTEGER REFERENCES categories (cat_id) NOT NULL,
  PRIMARY KEY (pca_id_cat, pca_id_pho)
);

CREATE TABLE photo_mot_cle (
  pmc_id_pho INTEGER REFERENCES photos (pho_id)    NOT NULL,
  pmc_id_mcl INTEGER REFERENCES mots_cles (mcl_id) NOT NULL,
  PRIMARY KEY (pmc_id_mcl, pmc_id_pho)
);

CREATE TABLE utilisateurs (
  utl_id         SERIAL PRIMARY KEY NOT NULL,
  utl_login      VARCHAR(50)        NOT NULL UNIQUE,
  utl_mdp        VARCHAR(255)       NOT NULL, -- mot de passe
  utl_date_ajout TIMESTAMP          NOT NULL DEFAULT current_timestamp
);

CREATE TABLE favoris (
  fav_id         SERIAL PRIMARY KEY                       NOT NULL,
  fav_id_utl     INTEGER REFERENCES utilisateurs (utl_id) NOT NULL,
  fav_id_pho     INTEGER REFERENCES photos (pho_id)       NOT NULL,
  fav_date_ajout TIMESTAMP                                NOT NULL DEFAULT current_timestamp
);

DROP FUNCTION IF EXISTS getCategories( INTEGER [] );
CREATE OR REPLACE FUNCTION getCategories(INTEGER [])
  RETURNS INTEGER [] AS $$
DECLARE
  categorie       INT;
  sc              INT;
  resultat        INT [];
  sous_categories INT [];
BEGIN
  FOREACH categorie IN ARRAY $1
  LOOP
--resultat := array_append(resultat, categorie);
    sous_categories := getCategories(categorie);
    IF (sous_categories IS NOT NULL)
    THEN
      FOREACH sc IN ARRAY sous_categories
      LOOP
        resultat := array_append(resultat, sc);
      END LOOP;
    END IF;
  END LOOP;
  RETURN resultat;
END;
$$
LANGUAGE plpgsql;

DROP FUNCTION IF EXISTS getCategories( INTEGER );
CREATE OR REPLACE FUNCTION getCategories(INTEGER)
  RETURNS INTEGER [] AS $$
SELECT array_append(getCategories(array_agg(cat.cat_id_parent_cat)), $1)
FROM categories cat
WHERE $1 = cat.cat_id
GROUP BY cat.cat_id
$$
LANGUAGE SQL;
