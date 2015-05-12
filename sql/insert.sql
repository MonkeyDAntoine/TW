INSERT INTO categories (cat_label)
VALUES
  ('Ordinateurs'), -- 1
  ('Logos'), -- 2
  ('Fonds d''écran');
-- 3

INSERT INTO categories (cat_label, cat_id_parent_cat)
VALUES
  ('OS', 1), -- 4
  ('Hardware', 1);
--5

INSERT INTO categories (cat_label, cat_id_parent_cat)
VALUES
  ('Android', 4), -- 6
  ('Firefox', 4), -- 7
  ('Linux', 4), -- 8
  ('Apple', 4), -- 9
  ('Windows', 4);
-- 10

INSERT INTO categories (cat_label, cat_id_parent_cat)
VALUES
  ('nVidia', 5), -- 11
  ('Intel', 5);
-- 12

INSERT INTO photos (pho_vignette, pho_nom_auteur, pho_url_auteur, pho_url, pho_largeur, pho_hauteur, pho_type_licence, pho_titre)
VALUES
  ('Android_robot.png', 'Google', 'http://developer.android.com/distribute/tools/promote/brand.html',
   'http://commons.wikimedia.org/wiki/File:Android_robot.png', '1024', '1218', '{1,0,0,1}', 'Logo Android'),
  ('Android_green_figure.png', 'Dsimic', 'http://en.wikipedia.org/wiki/User:Dsimic', 'http://upload.wikimedia.org/wikipedia/commons/e/ee/Android_green_figure%2C_next_to_its_original_packaging.jpg', '1280', '960', '{1,0,0,1}', 'Figure android verte à côté de son package original'),
  ('android_warrior.png', 'richtaur', 'http://richtaur.deviantart.com/', 'http://fc07.deviantart.net/fs71/f/2011/253/b/6/html5_android_warrior_by_richtaur-d49g6vf.png', '500', '500', '{1,0,0,1}', 'Guerrier Android HTML5'),
  ('android_chocolate.png', 'Polypous', 'http://polypous.deviantart.com/', 'http://fc00.deviantart.net/fs71/f/2014/280/7/b/android_love_chocolate_ii_by_polypous-d81yx0p.png', '835', '771', '{1,0,0,1}', 'Android aime le chocolat'),
  ('android_pacman_apple.png', 'jantik', 'https://www.flickr.com/photos/jantik/', 'https://www.flickr.com/photos/jantik/4620819221/', '640', '480', '{1,0,0,0}', 'Android Pacman mange Apple'),
  ('android_lollipop.png', 'Birdies100', 'https://www.flickr.com/photos/birdies100/', 'https://www.flickr.com/photos/birdies100/15545260615/', '450', '338', '{1,0,0,1}', 'Android Lollipop'),
  ('android_Hatsune_Miku.png', 'Charlie', 'https://www.flickr.com/photos/bakaotaku/', 'https://www.flickr.com/photos/bakaotaku/5416452868/', '640', '427', '{1,0,0,0}', 'Nendoroid Hatsune Miku HMO & Android'),

  ('firefox_logo.png', 'tapaponga', 'https://www.flickr.com/photos/tapaponga/', 'https://www.flickr.com/photos/tapaponga/6348329876/', '640', '614', '{1,0,0,1}', 'Logo Firefox'),
  ('firefox_wallpaper.png', 'Sandeep Kumar', 'https://www.flickr.com/photos/79395955@N00/', 'https://www.flickr.com/photos/79395955@N00/2751167818/', '640', '512', '{1,0,0,0}', 'Fond d''écran firefox'),
  ('firefox_os.png', 'J. Albert Bowden II', 'https://www.flickr.com/photos/jalbertbowdenii/', 'https://www.flickr.com/photos/jalbertbowdenii/8704455142/', '640', '367', '{1,0,0,0}', 'Firefox OS'),
  ('firefox_wallpaper2.png', 'Eros82', 'http://eros82.deviantart.com/', 'http://fc05.deviantart.net/fs31/i/2008/224/4/1/Firefox_wallpaper_3_by_Eros82.jpg', '800', '640', '{1,0,0,0}', 'Fond d''écran firefox'),

  ('ASUS_GTX-650.png', 'Dsimic', 'http://en.wikipedia.org/wiki/User:Dsimic', 'http://upload.wikimedia.org/wikipedia/commons/b/b7/ASUS_GTX-650_Ti_TOP_Cu-II_PCI_Express_3.0_x16_graphics_card.jpg', '1280', '960', '{1,0,0,1}', 'Asus Nvidia GeForce GTX 650 Ti TOP DirectCu-II'),
  ('Gigabyte_GTX770.png', 'Msaynevirta', 'http://commons.wikimedia.org/wiki/User:Msaynevirta', 'http://upload.wikimedia.org/wikipedia/commons/8/81/Gigabyte_GTX770-4GB.jpg', '2843', '1589', '{1,0,0,1}', 'Gigabyte GTX 770'),
  ('NVIDIA_GeForce_GTX_780_PCB-Front.png', 'GBPublic_PR', 'http://www.flickr.com/people/83620044@N06', 'http://upload.wikimedia.org/wikipedia/commons/1/11/NVIDIA_GeForce_GTX_780_PCB-Front.jpg', '4828', '2275', '{1,0,0,0}', 'NVIDIA GeForce GTX 780 PCB'),
  ('nvidia_wallpaper.png', 'BagoGames', 'https://www.flickr.com/photos/bagogames/', 'https://www.flickr.com/photos/bagogames/16510354657/', '640', '400', '{1,0,0,0}', 'Fond d''écran Nvidia'),
  ('Intel_Core_i7.png', 'Chris', 'https://www.flickr.com/photos/28079555@N04/', 'https://www.flickr.com/photos/28079555@N04/3201704432/', '4000', '3000', '{1,0,0,1}', 'CPU Intel i7-940'),

  ('windows8_logo.png', 'Simon.hess', 'http://commons.wikimedia.org/wiki/User:Simon.hess', 'http://upload.wikimedia.org/wikipedia/commons/c/c7/Windows_logo_-_2012.png', '1121', '1229', '{0,0,0,0}', 'Logo Windows 8 & Windows Server 2012'),
  ('windows7_logo.png', 'sipa', 'http://pixabay.com/fr/users/sipa-62896/', 'http://pixabay.com/fr/microsoft-drapeau-windows-7-win-7-237843/', '640', '640', '{0,0,0,0}', 'Logo Windows 7'),
  ('Windows_family.png', 'Codename Lisa', 'http://commons.wikimedia.org/wiki/User:Codename_Lisa', 'http://upload.wikimedia.org/wikipedia/commons/6/6d/Windows_Updated_Family_Tree.png', '2584', '1509', '{1,0,0,1}', 'Famille windows'),
  ('windows7_logo2.png', 'NEOidea', 'http://neoidea.deviantart.com/', 'http://fc06.deviantart.net/fs70/f/2011/154/9/a/windows_7_logo_by_neoidea-d3hzmjf.png', '512', '512', '{1,0,0,0}', 'Logo Windows 7'),

  ('linux_distributions.png', 'MuseScore', 'https://www.flickr.com/photos/musescore/', 'https://www.flickr.com/photos/musescore/16793281720/', '640', '640', '{1,0,0,0}', 'Différentes distributions Linux'),
  ('linux_logo.png', 'AgileLion Institute', 'https://www.flickr.com/photos/agilelioninstitute/',
   'https://www.flickr.com/photos/agilelioninstitute/9521718094/', '512', '594', '{1,0,0,0}', 'Logo Linux'),
  ('linux_logo2.png', 'OpenClips', 'http://pixabay.com/fr/users/OpenClips-30363/',
   'http://pixabay.com/fr/tux-manchot-des-animaux-mignon-158547/', '624', '640', '{0,0,0,0}', 'Logo Linux'),
  ('Power_of_Linux.png', 'debianforumru', 'http://debianart.org/cchost/files/debianforumru/1016',
   'http://debianart.org/cchost/people/debianforumru/debianforumru_-_Power_of_Linux.png', '1900', '1200', '{0,0,0,0}',
   'Power of Linux'),
  ('linux_wallpaper.png', 'cdooginz', 'http://cdooginz.deviantart.com/',
   'http://fc08.deviantart.net/fs71/i/2011/313/e/3/mini_linux_wallpaper_by_cdooginz-d4fmkge.jpg', '1100', '647',
   '{1,0,0,1}', 'Fond d''écran Linux'),

  ('mac_sur_table.png', 'CQuadratNet', 'http://pixabay.com/fr/users/CQuadratNet-377053/',
   'http://pixabay.com/fr/mac-pigiste-macintosh-macbook-459196/', '600', '396', '{0,0,0,0}', 'Macbook'),
  ('apple_logo.png', 'Nemo', 'http://pixabay.com/fr/users/Nemo-3736/',
   'http://pixabay.com/fr/apple-logo-mac-macintosh-311246/', '592', '640', '{0,0,0,0}', 'Logo Apple'),
  ('apple_wallpaper.png', 'Deeo-Elaclaire', 'http://deeo-elaclaire.deviantart.com/',
   'http://fc01.deviantart.net/fs43/f/2009/161/4/e/Titanium_by_Deeo_Elaclaire.jpg', '1600', '1200', '{1,0,0,0}',
   'Fond d''écran Apple'),
  ('apple_logo2.png', 'Apple, Inc.', 'http://en.wikipedia.org/wiki/Apple_Inc.',
   'http://upload.wikimedia.org/wikipedia/commons/a/a5/Apple_gray_logo.png', '2000', '2000', '{0,0,0,0}', 'Logo Apple'),
  ('apple_wallpaper2.png', 'Joseph Thornton', 'https://www.flickr.com/photos/jtjdt/',
   'https://www.flickr.com/photos/jtjdt/3821887527/', '640', '427', '{1,0,0,1}', 'Fond d''écran Apple');

INSERT INTO photo_categorie (pca_id_pho, pca_id_cat)
VALUES
  (1, 6), (1, 2),
  (2, 6),
  (3, 6),
  (4, 6),
  (5, 6), (5, 9),
  (6, 6),
  (7, 6),
  (8, 2), (8, 7),
  (9, 7), (9, 3),
  (10, 7), (10, 3),
  (11, 7),
  (11, 3),
  (12, 11),
  (13, 11),
  (14, 11),
  (15, 11), (15, 2), (15, 3),
  (16, 12),
  (17, 10), (17, 2),
  (18, 10), (18, 2),
  (19, 10),
  (20, 10),
  (21, 8),
  (22, 8), (22, 2),
  (23, 8), (23, 2),
  (24, 8), (24, 3),
  (25, 8), (25, 3),
  (26, 9),
  (27, 9), (27, 2),
  (28, 9), (28, 3),
  (29, 9), (29, 2),
  (30, 9), (30, 3);

INSERT INTO mots_cles (mcl_mot)
VALUES
  ('os'), -- 1
  ('android'), -- 2
  ('firefox'), -- 3
  ('linux'), -- 4
  ('apple'), -- 5
  ('windows'), -- 6

  ('logo'), -- 7
  ('wallpaper'), -- 8
  ('fond d''écran'), -- 9
  ('hardware'),

  ('carte graphique'), -- 10
  ('intel'), -- 11
  ('nvidia'), -- 12
  ('html5'), -- 13
  ('chocolat'), -- 14
  ('google'), -- 15
  ('vocaloid');
-- 16

INSERT INTO photo_mot_cle (pmc_id_pho, pmc_id_mcl)
VALUES
  (1, 2),
  (1, 7),

  (2, 2),

  (3, 2),
  (3, 14),

  (4, 2),
  (4, 8),
  (4, 9),
  (4, 15),

  (5, 2),
  (5, 8),
  (5, 9),

  (6, 2),
  (6, 16),

  (7, 2),
  (7, 17),

  (8, 3),
  (8, 7),

  (9, 3),
  (9, 8),
  (9, 9);

INSERT INTO utilisateurs (utl_login, utl_mdp)
VALUES
  ('test', 'mdptest');

INSERT INTO favoris (fav_id_utl, fav_id_pho)
VALUES
  (1, 1),
  (1, 3),
  (1, 4);
