
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données : `mauri_drones`
--
CREATE database if not EXISTS mauri_drones;
use mauri_drones;

-- --------------------------------------------------------

--
-- Structure de la table `accessoires`
--

DROP TABLE IF EXISTS `accessoires`;
CREATE TABLE IF NOT EXISTS `accessoires` (
  `id_accessoire` int NOT NULL AUTO_INCREMENT,
  `marque` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_categorie` int NOT NULL,
  `compatibilite_drone` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caracteristiques` text COLLATE utf8mb4_unicode_ci,
  `prix_mru` decimal(10,2) DEFAULT NULL,
  `lien_image` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_accessoire`),
  KEY `id_categorie` (`id_categorie`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `accessoires`
--

INSERT INTO `accessoires` (`id_accessoire`, `marque`, `nom`, `id_categorie`, `compatibilite_drone`, `caracteristiques`, `prix_mru`, `lien_image`) VALUES
(1, 'DJI', 'Batterie Intelligente Flight Mavic 3', 5, 'DJI Mavic 3 / Cine / Classic', 'Lithium-Ion Polymere (LiPo 4S), 5000 mAh, tension nominale 15.4V, autonomie approx. 46 min.', 8900.00, 'https://se-cdn.djiits.com/tpc/uploads/photo/image/807c2c2a7ab230073143832888617c6a@large.jpg'),
(5, 'DJI', 'Hub de chargement bidirectionnel Mini 4 Pro', 5, 'DJI Mini 4 Pro / Mini 3', 'Batterie LiPo 2S, 2590 mAh, tension 7.32V, poids plume < 80g pour conformite reglementaire.', 2400.00, 'https://cdn.vjshop.vn/flycam/dji/dji-mavic-4-pro/anh-nen-trang/phu-kien/dji-mavic-240w-power-adapter-black.jpg'),
(6, 'DJI', 'Batterie de Vol Intelligente Plus Mini 4 Pro', 5, 'DJI Mini 4 Pro / Mini 3', 'Batterie Li-ion haute capacite, 3850 mAh, autonomie etendue jusqu a 45 min, poids accru.', 4200.00, 'https://media.hifi.lu/sys-master/products/9471843893278/1440x1440.43000999_02.webp'),
(10, 'DJI', 'Batterie de Vol Intelligente Air 3', 5, 'DJI Air 3', 'Batterie haute densite, cellules premium avec systeme intelligent de gestion de charge (BMS).', 7100.00, 'https://www.patrickmodelisme.com/media/catalog/product/cache/1/image/f2d1007472470961dfb965d124a78bcd/a/c/ac606efd1495e8f3c86e490c0f540187_origin.jpg'),
(11, 'DJI', 'Hub de chargement de batterie Air 3', 5, 'DJI Air 3', 'Batterie haute densite, cellules premium avec systeme intelligent de gestion de charge (BMS).', 2900.00, 'https://se-cdn.djiits.com/tpc/uploads/photo/image/82a9b2e26ca2d9a5d746d77cfe473d62@large.jpg'),
(15, 'DJI', 'Batterie Intelligente DJI Avata 2', 5, 'DJI Avata 2', 'Batterie haute densite, cellules premium avec systeme intelligent de gestion de charge (BMS).', 5900.00, 'https://www.camara.net/17232-large_default/dji-batterie-intelligente-li-ion-4s-2150mah-avata-2.jpg'),
(20, 'DJI', 'Batterie de Vol Intelligente Inspire 3 (TB51)', 5, 'DJI Inspire 3', 'Batterie haute densite, cellules premium avec systeme intelligent de gestion de charge (BMS).', 18500.00, 'https://boutique.dji-paris.com/img/cms/DJI-Inspire-3/DJI-Inspire-3-Changement-de-batterie-a-chaud-TB-51.jpg'),
(21, 'DJI', 'Hub de charge pour batteries TB51', 5, 'DJI Inspire 3', 'Batterie haute densite, cellules premium avec systeme intelligent de gestion de charge (BMS).', 9900.00, 'https://images.ctfassets.net/et769tc4wc1v/Obz5RHRaWp6HnSU4b9wln/063d2f359ca8aee2b142a95d90f9a326/DJI_Inspire_3_-_Battery_Charging_Hub.png'),
(2, 'DJI', 'Helices basse resistance (x4) Mavic 3', 6, 'DJI Mavic 3 / Cine / Classic', 'Profil aerodynamique optimise, reduction du bruit aerodynamique, fixation rapide quick-release.', 1870.00, 'https://images.tcdn.com.br/img/img_prod/471823/2_pares_de_helices_para_drone_dji_mavic_3_laranja_3234_3_5a58890bad36cead3df9a519e80da757.jpg'),
(7, 'DJI', 'Helices de rechange (paire) Mini 4 Pro', 6, 'DJI Mini 4 Pro', 'Helices ultra-legeres et silencieuses, vis de fixation fournies, equilibrage dynamique precis.', 650.00, 'https://www.masterairscrew.com/cdn/shop/products/Mini-3_black_main.jpg'),
(12, 'DJI', 'Helices silencieuses (paire) Air 3', 6, 'DJI Air 3', 'Conception haute performance, materiaux composites resistants aux impacts, faible trainee.', 850.00, 'https://dronescan.cl/wp-content/uploads/2023/12/Helices-Air-3-3-scaled.webp'),
(16, 'DJI', 'Helices tripales (paire) Avata 2', 6, 'DJI Avata 2', 'Conception haute performance, materiaux composites resistants aux impacts, faible trainee.', 750.00, 'https://rchobbysolutions.net/cdn/shop/products/2925-O-8.jpg'),
(22, 'DJI', 'Helices pliantes haute altitude Inspire 3', 6, 'DJI Inspire 3', 'Conception haute performance, materiaux composites resistants aux impacts, faible trainee.', 3400.00, 'https://cdn.awsli.com.br/800x800/2137/2137253/produto/225277447/i3hh_1-ls4vw5f46w.jpg'),
(24, 'Master Airscrew', 'Helices Stealth pour DJI Mavic 3 (x4)', 6, 'DJI Mavic 3 Series', 'Profil aerodynamique optimise, reduction du bruit aerodynamique, fixation rapide quick-release.', 2100.00, 'https://cdn.shopify.com/s/files/1/1006/7450/products/Mavic_air_Stealth_Propellers_Master_Airscrew_1024x.jpg'),
(43, 'Master Airscrew', 'Helices Performance Ludicrous Mini 3 Pro', 6, 'DJI Mini 3 / 3 Pro', 'Helices ultra-legeres et silencieuses, vis de fixation fournies, equilibrage dynamique precis.', 950.00, 'https://m.media-amazon.com/images/S/aplus-media-library-service-media/96007ea0-1a01-488b-91c7-eef7b6bbb026.jpg'),
(3, 'PolarPro', 'Kit filtres ND/PL x6 - Mavic & Air', 7, 'DJI Mavic 3 / Air 3', 'Filtres optiques haute definition, reduction des reflets, correction de l exposition, pas de dominante de couleur.', 4600.00, 'https://www.skypilot.dk/images/m2z-cs-vivid_1024x1024-p.jpg'),
(8, 'Pgytech', 'Filtres UV/CPL/ND Kit Professionnel Mini 4', 7, 'DJI Mini 4 Pro', 'Filtres optiques haute definition, reduction des reflets, correction de l exposition, pas de dominante de couleur.', 3100.00, 'https://down-th.img.susercontent.com/file/sg-11134201-7rbl5-lp9bu98zayvce4'),
(13, 'PolarPro', 'Filtres ND Directors Collection Air 3', 7, 'DJI Air 3', 'Filtres optiques haute definition, reduction des reflets, correction de l exposition, pas de dominante de couleur.', 5400.00, 'https://cdn.shopify.com/s/files/1/1050/9944/files/gear-fujifilm-lifestyle-block-mobile-nav.webp'),
(18, 'Flywoo', 'Kit de filtres ND pour Avata 2', 7, 'DJI Avata 2', 'Filtres optiques haute definition, reduction des reflets, correction de l exposition, pas de dominante de couleur.', 2800.00, 'https://cdn.idealo.com/folder/Product/204147/1/204147113/s1_produktbild_max/dji-avata-2-nd-filters-set-nd8-16-32.jpg'),
(33, 'PolarPro', 'Filtre FX Variable ND (2-5 stops) Mavic 3', 7, 'DJI Mavic 3 Classic', 'Filtres optiques haute definition, reduction des reflets, correction de l exposition, pas de dominante de couleur.', 3900.00, 'https://m.media-amazon.com/images/I/81uIDoCFdPL.jpg'),
(46, 'Freewell', 'Kit filtres All Day (x8) DJI Avata 2', 7, 'DJI Avata 2', 'Filtres optiques haute definition, reduction des reflets, correction de l exposition, pas de dominante de couleur.', 4200.00, 'https://enterpriseuav.co.uk/wp-content/uploads/2024/04/dji-avata-2-custom-filters-nd4-600x696.webp'),
(4, 'Nanuk', 'Sac rigide etanche IP67 - Mavic / Air / FPV', 8, 'DJI Mavic Series / Air 3', 'Rangement optimise avec separateurs rembourres, protection anti-choc, fermetures eclair tropicalisees.', 12500.00, 'https://m.media-amazon.com/images/I/817NIvS3FZL._AC_SL1500_.jpg'),
(9, 'GPC', 'Valise de transport rigide etanche Mini 4 Pro', 8, 'DJI Mini 4 Pro', 'Structure rigide en resine NK-7 ultra-resistante, etancheite IP67, mousse pre-decoupee haute densite.', 6800.00, 'https://m.media-amazon.com/images/I/71k6LZngLfL._AC_SL1500_.jpg'),
(14, 'Nanuk', 'Mallette de protection 915 etanche', 8, 'DJI Air 3', 'Rangement optimise avec separateurs rembourres, protection anti-choc, fermetures eclair tropicalisees.', 8900.00, 'https://nanuk.com/cdn/shop/products/nanuk-915-black-open-foam.jpg'),
(19, 'GPC', 'Sac a dos tactique pour DJI Avata 2', 8, 'DJI Avata 2 & Goggles 3', 'Rangement optimise avec separateurs rembourres, protection anti-choc, fermetures eclair tropicalisees.', 9500.00, 'https://oscarliang.com/wp-content/uploads/2024/05/dji-avata-2-backpack-carry-case-storage-1024x768.jpg'),
(35, 'Pgytech', 'Sac a dos OneMo 2 (22L) special Drone', 8, 'Universel', 'Volume extensible, compartiments modulables, acces rapide lateral, tissu impermeable et resistant a l usure.', 10500.00, 'https://www.photographiesdelannee.com/wp-content/uploads/2025/12/featured-test-du-sac-a-dos-pgytech-onemo-lite-22l.jpg'),
(44, 'GPC', 'Valise rigide pour DJI Matrice 30T', 8, 'DJI Matrice 30T', 'Structure rigide en resine NK-7 ultra-resistante, etancheite IP67, mousse pre-decoupee haute densite.', 24500.00, 'https://tse2.mm.bing.net/th/id/OIP.5t-6ah-8QHBuIJYtYUc6-gHaIR'),
(50, 'Nanuk', 'Mallette etanche de protection pour objectifs', 8, 'DJI Zenmuse DL Lenses', 'Rangement optimise avec separateurs rembourres, protection anti-choc, fermetures eclair tropicalisees.', 7600.00, 'https://www.allwan.eu/976-thickbox_default/malette-drone-protection-nanuk-915dji-spark-fly-plus.jpg'),
(17, 'DJI', 'Sangle de tete pour DJI Goggles 3', 9, 'DJI Goggles 3', 'Accessoire certifie d origine, concu specifiquement pour garantir l aerodynamisme et les performances du drone.', 1100.00, 'https://ae01.alicdn.com/kf/S668ee15edb054cb3b7b98e78d1d7213dI/Support-de-sangle-de-tete-reglable.jpg'),
(34, 'DJI', 'Pare-soleil pour ecran de radiocommande RC 2', 9, 'DJI RC 2', 'Reduction optimale des reflets, amelioration de la visibilite sur ecran en plein soleil, montage rapide pliable.', 1150.00, 'https://www.maisondudrone.com/wp-content/uploads/2023/07/Pare-Soleil-Protection-Ecran-2-en-1-Radiocommande-DJI-RC-2-600x600.jpg'),
(25, 'Pgytech', 'Piste d atterrissage pliante pour drone (75cm)', 10, 'Universel (Mini/Mavic/Air)', 'Materiau ABS leger, n impacte pas le comportement en vol ni l autonomie, fixation clipsable securisee.', 1400.00, 'https://cdn.mos.cms.futurecdn.net/2sxs9hKi4SZ4utgocXfrRa-650-80.jpg'),
(31, 'DJI', 'Kit de protections d helices 360 Mini 4 Pro', 10, 'DJI Mini 4 Pro', 'Materiau ABS leger, n impacte pas le comportement en vol ni l autonomie, fixation clipsable securisee.', 1600.00, 'https://www.durtom.com/wp-content/uploads/1200x900-M4P-PROT-2.jpg'),
(32, 'Pgytech', 'Attache-helices de protection Mini 4 Pro', 10, 'DJI Mini 4 Pro', 'Materiau ABS leger, n impacte pas le comportement en vol ni l autonomie, fixation clipsable securisee.', 680.00, 'https://m.media-amazon.com/images/I/81dx0qEpq7L._AC_SL1500_.jpg'),
(40, 'Pgytech', 'Extensions de train d atterrissage Air 3', 10, 'DJI Air 3', 'Materiau ABS leger, n impacte pas le comportement en vol ni l autonomie, fixation clipsable securisee.', 950.00, 'https://www.maisondudrone.com/wp-content/uploads/2020/10/Train-D-atterrissage-LED.jpg'),
(41, 'PolarPro', 'Protection de nacelle et capteurs Mavic 3', 10, 'DJI Mavic 3 Pro', 'Materiau ABS leger, n impacte pas le comportement en vol ni l autonomie, fixation clipsable securisee.', 1900.00, 'https://www.maisondudrone.com/wp-content/uploads/2023/06/Cache-Protection-Integral-Camera-Nacelle-Capteurs-Avant-drone-DJI-Mavic-3-1.jpg'),
(48, 'Anemotech', 'Anemometre digital portable de terrain', 10, 'Universel (Meteo)', 'Materiau ABS leger, n impacte pas le comportement en vol ni l autonomie, fixation clipsable securisee.', 2150.00, 'https://cdn.manomano.com/anemometre-numerique-debitmetre-portable.jpg'),
(38, 'DJI', 'Chargeur USB-C Rapide 65W GaN', 11, 'Universel', 'Technologie GaN (Nitrure de Gallium), compacite extreme, double port USB-C et USB-A, charge rapide standard PD.', 2450.00, 'https://m.media-amazon.com/images/I/6148E+VVjZL._AC_.jpg'),
(39, 'DJI', 'Station de charge d accu portable 100W', 11, 'Universel', 'Batterie haute densite, cellules premium avec systeme intelligent de gestion de charge (BMS).', 4100.00, 'https://boutique.dji-paris.com/10663-large_default/station-de-charge-bidirectionnelle-pour-dji-neo.jpg'),
(36, 'DJI', 'Module de transmission cellulaire DJI Dongle 4G', 12, 'DJI Mavic 3 / Pro', 'Connexion 4G LTE haut debit stable, basculement automatique en cas de coupure du signal O3/O4, format compact USB.', 6200.00, 'https://flycamgiare.vn/wp-content/uploads/2025/04/Module-4G-DJI-Cellular-Dongle-2-Chinh-Hang-VN.jpg'),
(49, 'DJI', 'Amplificateur de signal d antenne 2.4/5.8GHz', 12, 'Radiocommandes DJI', 'Connexion 4G LTE haut debit stable, basculement automatique en cas de coupure du signal O3/O4, format compact USB.', 3400.00, 'https://www.studiosport.fr/upload/image/booster-d-antennes-5-8-ghz-2-4-ghz-pour-radiocommande-dji.jpg'),
(47, 'Pgytech', 'Support de montage camera d action sur Mavic', 13, 'DJI Mavic 3 Series', 'Accessoire certifie d origine, concu specifiquement pour garantir l aerodynamisme et les performances du drone.', 1100.00, 'https://www.maisondudrone.com/wp-content/uploads/2020/10/2PGYTECH-Plaque-De-Base-Mavic.jpg'),
(26, 'DJI', 'Radiocommande DJI RC 2', 14, 'DJI Mini 4 Pro / Air 3', 'Reduction optimale des reflets, amelioration de la visibilite sur ecran en plein soleil, montage rapide pliable.', 14900.00, 'https://shop.prodrones.fr/4516-large_default/dji-rc-2.jpg'),
(27, 'DJI', 'Radiocommande Professionnelle DJI RC Pro', 14, 'DJI Mavic 3 / Air 3', 'Reduction optimale des reflets, amelioration de la visibilite sur ecran en plein soleil, montage rapide pliable.', 41000.00, 'https://www.flyingeye.fr/wp-content/uploads/2021/11/radiocommande-dji-rc-pro-2-1024x1024.jpg'),
(28, 'LifThor', 'Support de tablette pour radiocommande DJI', 14, 'DJI RC-N1 / RC-N2', 'Reduction optimale des reflets, amelioration de la visibilite sur ecran en plein soleil, montage rapide pliable.', 3800.00, 'https://www.lacameraembarquee.fr/47021-large_default/support-utility-mount-lifthor-pour-radiocommande-dji-rc-pro.jpg'),
(37, 'Hoodman', 'Lunette pare-soleil pour tablette iPad', 14, 'Universel', 'Reduction optimale des reflets, amelioration de la visibilite sur ecran en plein soleil, montage rapide pliable.', 2900.00, 'https://m.media-amazon.com/images/I/71I7CTdvpOL._AC_SL1500_.jpg'),
(45, 'DJI', 'Sangle de cou professionnelle pour RC Pro', 14, 'DJI RC Pro / Smart Controller', 'Reduction optimale des reflets, amelioration de la visibilite sur ecran en plein soleil, montage rapide pliable.', 1350.00, 'https://jesenslebonheur.fr/jeux-jouet/89774-large_default/fpvtosky-sangle-pour-dji-rc-2.jpg'),
(29, 'SanDisk', 'Carte MicroSDXC Extreme Pro 128 Go U3 V30', 15, 'Universel', 'Accessoire certifie d origine, concu specifiquement pour garantir l aerodynamisme et les performances du drone.', 1200.00, 'https://www.picstop.co.uk/user/products/large/ext-pro-sd-128gb-1(3).jpg'),
(30, 'SanDisk', 'Carte MicroSDXC Extreme Pro 256 Go U3 V30', 15, 'Universel', 'Accessoire certifie d origine, concu specifiquement pour garantir l aerodynamisme et les performances du drone.', 2300.00, 'https://kotech.ci/wp-content/uploads/2025/02/CarteMemoireSandisk256ExtermePro3.jpg'),
(23, 'DJI', 'Objectif DL 18mm F2.8 LS ASPH', 16, 'DJI Inspire 3 / Zenmuse X9', 'Accessoire certifie d origine, concu specifiquement pour garantir l aerodynamisme et les performances du drone.', 62000.00, 'https://se-cdn.djiits.com/tpc/uploads/photo/image/11967834f8234f4f432f82feb0ef2b78@large.jpg'),
(42, 'DJI', 'Cable de donnees haute vitesse USB-C 10Gbps', 17, 'Universel', 'Cable blinde haute vitesse, debits jusqu a 10 Gbps, gaine tressee en nylon renforce, connecteurs plaques or.', 980.00, 'https://media.infshop.fr/5424627-large_default/inf-cble-usb-32-type-c.webp');

-- --------------------------------------------------------

--
-- Structure de la table `cameras`
--

DROP TABLE IF EXISTS `cameras`;
CREATE TABLE IF NOT EXISTS `cameras` (
  `id_modele` int NOT NULL AUTO_INCREMENT,
  `marque` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modele` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_categorie` int NOT NULL,
  `resolution_max` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capteur` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `champ_de_vision` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `autonomie` int DEFAULT NULL,
  `prix_mru` decimal(10,2) DEFAULT NULL,
  `statut_stock` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lien_image` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_modele`),
  KEY `id_categorie` (`id_categorie`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cameras`
--

INSERT INTO `cameras` (`id_modele`, `marque`, `modele`, `id_categorie`, `resolution_max`, `capteur`, `champ_de_vision`, `autonomie`, `prix_mru`, `statut_stock`, `lien_image`) VALUES
(1, 'GoPro', 'HERO 13 Black', 18, '5.3K/60fps', '1/1.9\" CMOS', '156°', 90, 18500.00, 'En stock', 'https://image.alza.cz/products/OG013a1/OG013a1.jpg'),
(3, 'DJI', 'Osmo Action 5 Pro', 18, '4K/120fps', '1/1.3\" CMOS Pro', '155°', 120, 13400.00, 'En stock', 'Untitled_design_44_1600x.jpg'),
(5, 'GoPro', 'HERO Ultra-Legere', 18, '4K/30fps', '12 MP CMOS', '110°', 60, 11000.00, 'En stock', 'https://images.bike24.com/i/mb/d4/35/cd/gopro-hero-1-1737932.jpg'),
(6, 'Insta360', 'Ace Pro 2', 18, '8K/30fps', '1/1.3\" CMOS Leica', '151°', 100, 24500.00, 'En stock', 'https://res.insta360.com/static/29e2a58966be15bff212990b01652ca2/AcePro2-Thumbnail.jpg'),
(7, 'DJI', 'Osmo Action 6', 18, '4K/120fps', '1/1.1\" CMOS', '155°', 160, 15800.00, 'En stock', 'https://www.cined.com/content/uploads/2025/11/Osmo-Action-6-_5.jpg'),
(2, 'Insta360', 'X5 - Camera 360', 19, '8K/30fps', 'Double Capteur', '360°', 135, 22000.00, 'En stock', 'https://static.bhphotovideo.com/explora/sites/default/files/1-Insta360-X3.jpg'),
(4, 'Sony', 'ZV-E1 - Camera Vlog', 20, '4K/120fps', 'Plein Format Full Frame', '130°', 90, 78000.00, 'Sur commande', 'https://www.dpreview.com/files/p/articles/6259180541/Sony_ZV-E1_rear_screen.jpeg'),
(8, 'Sony', 'Alpha 7R VI', 20, '8K/30fps', 'Plein Format 61 MP', '155°', 120, 145000.00, 'Sur commande', 'https://www.ephotozine.com/articles/sony-alpha-a7r-hands-on-review-23186/images/highres-Sony-Alpha-A7R-with-55mm-13_1388670158.jpg'),
(10, 'Canon', 'EOS R5 Mark II', 20, '8K/30fps', 'Plein Format 45 MP', '115°', 125, 155000.00, 'En stock', 'https://sm.pcmag.com/t/pcmag_uk/review/c/canon-eos-/canon-eos-r5_13h9.1920.jpg'),
(9, 'Sony', 'FX3 Cinema', 21, '4K/120fps', 'Plein Format Exmor R', '140°', 140, 160000.00, 'Sur commande', 'https://sonymirrorlesspro.com/wp-content/uploads/2021/02/FX3ILME-FX3_front_image_02.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categorie` int NOT NULL AUTO_INCREMENT,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `type`, `nom`) VALUES
(1, 'drone', 'Aerien pro'),
(2, 'drone', 'sous-marin'),
(3, 'drone', 'Agriculture'),
(4, 'drone', 'Cinema'),
(5, 'Accessoire', 'Batterie'),
(6, 'Accessoire', 'Helices'),
(7, 'Accessoire', 'Filtres'),
(8, 'Accessoire', 'Transport'),
(9, 'Accessoire', 'Confort'),
(10, 'Accessoire', 'Securite'),
(11, 'Accessoire', 'Energie'),
(12, 'Accessoire', 'Reseau'),
(13, 'Accessoire', 'Extension'),
(14, 'Accessoire', 'Controle'),
(15, 'Accessoire', 'Stockage'),
(16, 'Camera', 'Camera'),
(17, 'Accessoire', 'connectique'),
(18, 'Camera', 'Action'),
(19, 'camera', '360'),
(20, 'camera', 'Plein Format'),
(21, 'camera', 'cinema');

-- --------------------------------------------------------

--
-- Structure de la table `drones`
--

DROP TABLE IF EXISTS `drones`;
CREATE TABLE IF NOT EXISTS `drones` (
  `id_drone` int NOT NULL AUTO_INCREMENT,
  `marque` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modele` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_categorie` int NOT NULL,
  `autonomie_m` int DEFAULT NULL,
  `capteur` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `portee_m` int DEFAULT NULL,
  `prix_final_MRU` decimal(10,2) DEFAULT NULL,
  `statut_stock` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lien_image` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_drone`),
  KEY `id_categorie` (`id_categorie`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `drones`
--

INSERT INTO `drones` (`id_drone`, `marque`, `modele`, `id_categorie`, `autonomie_m`, `capteur`, `portee_m`, `prix_final_MRU`, `statut_stock`, `lien_image`) VALUES
(1, 'DJI', 'Matrice 350 RTK', 1, 55, '5.1k', 20000, 480000.00, 'Sur commande', 'https://www.integraldrones.com.au/wp-content/uploads/2023/05/DJI-Matrice-350-drone-speaker-snow.jpg'),
(2, 'Autel Robotics', 'Evo Max 4T', 1, 42, '8K', 20000, 178500.00, 'En stock', 'https://cdn.mos.cms.futurecdn.net/7L46BwhU6xxRNAcDJ5CZmR-1200-80.jpg'),
(3, 'DJI', 'Matrice 30T', 1, 41, '4K', 15000, 340000.00, 'Sur commande', 'DJI-Matrice-4T-Drohne-in-der-Frontansicht.jpg'),
(4, 'Autel Robotics', 'Evo II Dual 640T V3', 1, 38, '4K', 15000, 195000.00, 'En stock', 'drone_autel_evo2_640t_enterprise_image6.jpg'),
(5, 'DJI', 'Mavic 3 Thermal (M3T)', 1, 45, '4K', 32000, 165000.00, 'En stock', 'Mavic-3T-schaut-in-die-Sonne.jpg'),
(6, 'DJI', 'Mavic 3 Enterprise (M3E)', 1, 45, '4K', 32000, 138000.00, 'En stock', 'Gambar-Tampak-Depan-Drone-DJI-Mavic-3-Enterprise-M3E.jpg'),
(7, 'DJI', 'Mini 4 Pro Fly More', 1, 34, '4K', 18000, 38000.00, 'En stock', 'https://cdn.vox-cdn.com/thumbor/NujOmviRqQcikQgXW9YEFbPfntY=/0x0:2340x1621/1200x628/filters:focal(1170x811:1171x812)/cdn.vox-cdn.com/uploads/chorus_asset/file/24952800/mini_4_pro_dji.jpg'),
(8, 'Quantum Systems', 'Trinity F90+ (VTOL)', 1, 90, '24MP', 100000, 790000.00, 'Sur commande', 'QuantumSystems-e1587688799605.jpg'),
(9, 'QYSEA', 'FIFISH V6 Expert', 2, 240, '4K', 100, 148000.00, 'En stock', 'qysea_yr010bc9400240801_fifish_v6_expert_m200_1865487.jpg'),
(10, 'Chasing', 'M2 Pro', 2, 240, '4K', 150, 195000.00, 'En stock', 'Chasing-M2-underwater-drone-ROV.png'),
(11, 'QYSEA', 'FIFISH V-EVO', 2, 240, '4K', 100, 58000.00, 'En stock', 'QYSEA-FIFISH-V-EVO-05.jpg'),
(12, 'Chasing', 'M2 Enterprise', 2, 300, '4K', 150, 290000.00, 'Sur commande', 'Chasing+M2+Pro+Max+(6).jpg'),
(13, 'Chasing', 'Dory', 2, 90, '1080p', 15, 22000.00, 'En stock', 'dory_banenr_wep_img1.jpg'),
(14, 'QYSEA', 'FIFISH W6', 2, 360, '16K', 350, 980000.00, 'Sur commande', 'qysea-fifish-w6-00-1068x740.jpg'),
(15, 'Geneinno', 'T1 Pro', 2, 240, '4K', 150, 119000.00, 'Sur commande', '90'),
(16, 'Deep Trekker', 'DTG3', 2, 720, '4K', 200, 540000.00, 'Sur commande', 'DTG3-Navigator.png'),
(17, 'DJI', 'Mavic 3 Multispectral (M3M)', 3, 43, '4K', 32000, 185000.00, 'En stock', 'maxresdefault.jpg'),
(18, 'DJI', 'Agras T40', 3, 19, '40L', 12, 536800.00, 'En stock', '2-DJI-AGRAS-T40-DJI_0453-2-web.jpg'),
(19, 'DJI', 'Inspire 3', 4, 28, '8K', 15, 560000.00, 'Sur commande', 'DJI-inspire-3-landscape1-1600x900.jpg'),
(20, 'DJI', 'Mavic 3 Pro Cine', 4, 46, '5.1K', 28000, 92000.00, 'En stock', 'https://se-cdn.djiits.com/tpc/uploads/carousel/image/0f65f523ec36e90fa03792967a85664a@ultra.jpg'),
(21, 'DJI', 'Avata 2 Studio Combo', 4, 23, '4K', 27, 36500.00, 'Sur commande', 'https://blog.freewellgear.com/wp-content/uploads/2024/04/Avata-2-Goggles-3-RC-Motion-3-2.jpeg'),
(22, 'DJI', 'Air 3S Cine', 4, 45, '4K', 32000, 59000.00, 'En stock', 'DJI-Air-3S-wide-angle-.jpg'),
(24, 'DJI', 'Mavic 3 Classic', 4, 46, '4K', 32000, 58000.00, 'En stock', 'dji-mavic-3-classic-review-fstoppers.jpg'),
(25, 'DJI', 'Avata Explorer Edition', 4, 18, '4K', 8000, 39000.00, 'En stock', 'DJI4126.zoom.a.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
