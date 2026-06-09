-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 09 juin 2026 à 16:51
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mauri_drones`
--

-- --------------------------------------------------------

--
-- Structure de la table `accessoires`
--

DROP TABLE IF EXISTS `accessoires`;
CREATE TABLE IF NOT EXISTS `accessoires` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_categorie` int NOT NULL,
  `nom` varchar(200) NOT NULL,
  `marque` varchar(100) DEFAULT NULL,
  `compatibilite` varchar(200) DEFAULT NULL,
  `caracteristiques` text,
  `prix_mru` decimal(10,2) NOT NULL,
  `statut_stock` varchar(60) DEFAULT 'En stock',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_id_categorie` (`id_categorie`),
  KEY `idx_marque` (`marque`),
  KEY `idx_prix` (`prix_mru`)
) ;

--
-- Déchargement des données de la table `accessoires`
--

INSERT INTO `accessoires` (`id`, `id_categorie`, `nom`, `marque`, `compatibilite`, `caracteristiques`, `prix_mru`, `statut_stock`, `created_at`, `updated_at`) VALUES
(1, 1, 'Batterie Intelligente Flight Mavic 3', 'DJI', 'DJI Mavic 3 / Cine / Classic', 'Lithium-Ion Polymère (LiPo 4S), 5000 mAh, tension nominale 15.4 V, autonomie approx. 46 min.', 8900.00, 'INDISPENSABLE', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(2, 1, 'Hub de chargement bidirectionnel Mini 4 Pro', 'DJI', 'DJI Mini 4 Pro / Mini 3', 'Batterie LiPo 2S, 2590 mAh, tension 7.32 V, poids plume < 80 g pour conformité réglementaire.', 2400.00, 'INDISPENSABLE', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(3, 1, 'Batterie de Vol Intelligente Plus Mini 4 Pro', 'DJI', 'DJI Mini 4 Pro / Mini 3', 'Batterie Li-ion haute capacité, 3850 mAh, autonomie étendue jusqu\'à 45 min, poids accru.', 4200.00, 'MEILLEUR VENTE', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(4, 1, 'Batterie de Vol Intelligente Air 3', 'DJI', 'DJI Air 3', 'Batterie haute densité, cellules premium avec système intelligent de gestion de charge (BMS).', 7100.00, 'INDISPENSABLE', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(5, 1, 'Hub de chargement de batterie Air 3', 'DJI', 'DJI Air 3', 'Batterie haute densité, cellules premium avec système intelligent de gestion de charge (BMS).', 2900.00, 'STANDARD', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(6, 1, 'Batterie Intelligente DJI Avata 2', 'DJI', 'DJI Avata 2', 'Batterie haute densité, cellules premium avec système intelligent de gestion de charge (BMS).', 5900.00, 'INDISPENSABLE', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(7, 1, 'Batterie de Vol Intelligente Inspire 3 (TB51)', 'DJI', 'DJI Inspire 3', 'Batterie haute densité, cellules premium avec système intelligent de gestion de charge (BMS).', 18500.00, 'INDISPENSABLE', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(8, 1, 'Hub de charge pour batteries TB51', 'DJI', 'DJI Inspire 3', 'Batterie haute densité, cellules premium avec système intelligent de gestion de charge (BMS).', 9900.00, 'STANDARD', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(9, 2, 'Hélices basse résistance (x4) Mavic 3', 'DJI', 'DJI Mavic 3 / Cine / Classic', 'Profil aérodynamique optimisé, réduction du bruit aérodynamique, fixation rapide quick-release.', 1870.00, 'PROMO -15%', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(10, 2, 'Hélices de rechange (paire) Mini 4 Pro', 'DJI', 'DJI Mini 4 Pro', 'Hélices ultra-légères et silencieuses, vis de fixation fournies, équilibrage dynamique précis.', 650.00, 'STANDARD', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(11, 2, 'Hélices silencieuses (paire) Air 3', 'DJI', 'DJI Air 3', 'Conception haute performance, matériaux composites résistants aux impacts, faible traînée.', 850.00, 'STANDARD', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(12, 2, 'Hélices tripales (paire) Avata 2', 'DJI', 'DJI Avata 2', 'Conception haute performance, matériaux composites résistants aux impacts, faible traînée.', 750.00, 'PROMO -10%', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(13, 2, 'Hélices pliantes haute altitude Inspire 3', 'DJI', 'DJI Inspire 3', 'Conception haute performance, matériaux composites résistants aux impacts, faible traînée.', 3400.00, 'NOUVEAU', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(14, 2, 'Hélices Stealth pour DJI Mavic 3 (x4)', 'Master Airscrew', 'DJI Mavic 3 Series', 'Profil aérodynamique optimisé, réduction du bruit aérodynamique, fixation rapide quick-release.', 2100.00, 'PERF PRO', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(15, 2, 'Hélices Performance Ludicrous Mini 3 Pro', 'Master Airscrew', 'DJI Mini 3 / 3 Pro', 'Hélices ultra-légères et silencieuses, vis de fixation fournies, équilibrage dynamique précis.', 950.00, 'PERF PRO', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(16, 3, 'Kit filtres ND/PL x6 - Mavic & Air', 'PolarPro', 'DJI Mavic 3 / Air 3', 'Filtres optiques haute définition, réduction des reflets, correction de l\'exposition, pas de dominante de couleur.', 4600.00, 'NOUVEAU', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(17, 3, 'Filtres UV/CPL/ND Kit Professionnel Mini 4', 'Pgytech', 'DJI Mini 4 Pro', 'Filtres optiques haute définition, réduction des reflets, correction de l\'exposition, pas de dominante de couleur.', 3100.00, 'NOUVEAU', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(18, 3, 'Filtres ND Directors Collection Air 3', 'PolarPro', 'DJI Air 3', 'Filtres optiques haute définition, réduction des reflets, correction de l\'exposition, pas de dominante de couleur.', 5400.00, 'NOUVEAU', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(19, 3, 'Kit de filtres ND pour Avata 2 (ND8/16/32/64)', 'Flywoo', 'DJI Avata 2', 'Filtres optiques haute définition, réduction des reflets, correction de l\'exposition, pas de dominante de couleur.', 2800.00, 'STANDARD', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(20, 3, 'Filtre FX Variable ND (2-5 stops) Mavic 3', 'PolarPro', 'DJI Mavic 3 Classic', 'Filtres optiques haute définition, réduction des reflets, correction de l\'exposition, pas de dominante de couleur.', 3900.00, 'NOUVEAU', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(21, 3, 'Kit filtres All Day (x8) DJI Avata 2', 'Freewell', 'DJI Avata 2', 'Filtres optiques haute définition, réduction des reflets, correction de l\'exposition, pas de dominante de couleur.', 4200.00, 'NOUVEAU', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(22, 4, 'Sac rigide étanche IP67 - Mavic / Air / FPV', 'Nanuk', 'DJI Mavic Series / Air 3', 'Rangement optimisé avec séparateurs rembourrés, protection anti-choc, fermetures éclair tropicalisées.', 12500.00, 'VOYAGE', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(23, 4, 'Valise de transport rigide étanche Mini 4 Pro', 'GPC', 'DJI Mini 4 Pro', 'Structure rigide en résine NK-7 ultra-résistante, étanchéité IP67, mousse pré-découpée haute densité.', 6800.00, 'VOYAGE', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(24, 4, 'Mallette de protection 915 étanche', 'Nanuk', 'DJI Air 3', 'Rangement optimisé avec séparateurs rembourrés, protection anti-choc, fermetures éclair tropicalisées.', 8900.00, 'VOYAGE', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(25, 4, 'Sac à dos tactique pour DJI Avata 2', 'GPC', 'DJI Avata 2 & Goggles 3', 'Rangement optimisé avec séparateurs rembourrés, protection anti-choc, fermetures éclair tropicalisées.', 9500.00, 'VOYAGE', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(26, 4, 'Sac à dos OneMo 2 (22L) spécial Drone', 'Pgytech', 'Universel', 'Volume extensible, compartiments modulables, accès rapide latéral, tissu imperméable et résistant à l\'usure.', 10500.00, 'VOYAGE', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(27, 4, 'Valise rigide pour DJI Matrice 30T', 'GPC', 'DJI Matrice 30T', 'Structure rigide en résine NK-7 ultra-résistante, étanchéité IP67, mousse pré-découpée haute densité.', 24500.00, 'ENTREPRISE', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(28, 4, 'Mallette étanche de protection pour objectifs', 'Nanuk', 'DJI Zenmuse DL Lenses', 'Rangement optimisé avec séparateurs rembourrés, protection anti-choc, fermetures éclair tropicalisées.', 7600.00, 'VOYAGE', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(29, 5, 'Sangle de tête pour DJI Goggles 3', 'DJI', 'DJI Goggles 3', 'Accessoire certifié d\'origine, conçu spécifiquement pour garantir le confort et la stabilité des goggles FPV.', 1100.00, 'NOUVEAU', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(30, 5, 'Pare-soleil pour écran de radiocommande RC 2', 'DJI', 'DJI RC 2', 'Réduction optimale des reflets, amélioration de la visibilité sur écran en plein soleil, montage rapide pliable.', 1150.00, 'STANDARD', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(31, 6, 'Objectif DL 18mm F2.8 LS ASPH', 'DJI', 'DJI Inspire 3 / Zenmuse X9', 'Objectif DL monture native, ouverture F2.8, couverture plein format, 15 éléments optiques en 11 groupes.', 62000.00, 'TOP QUALITÉ', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(32, 7, 'Piste d\'atterrissage pliante pour drone (75cm)', 'Pgytech', 'Universel (Mini/Mavic/Air)', 'Matériau ABS léger, surface de 75 cm de diamètre, n\'impacte pas le comportement en vol, fixation clipsable.', 1400.00, 'INDISPENSABLE', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(33, 7, 'Kit de protections d\'hélices 360° Mini 4 Pro', 'DJI', 'DJI Mini 4 Pro', 'Matériau ABS léger, protection complète 360°, fixation clipsable sécurisée sans outils.', 1600.00, 'SÉCURITÉ', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(34, 7, 'Attache-hélices de protection Mini 4 Pro', 'Pgytech', 'DJI Mini 4 Pro', 'Matériau ABS léger, n\'impacte pas le comportement en vol ni l\'autonomie, fixation clipsable sécurisée.', 680.00, 'STANDARD', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(35, 7, 'Extensions de train d\'atterrissage Air 3', 'Pgytech', 'DJI Air 3', 'Matériau ABS léger, surélèvent le drone de 30 mm, protègent la nacelle lors des atterrissages sur terrain irrégulier.', 950.00, 'STANDARD', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(36, 7, 'Protection de nacelle et capteurs Mavic 3', 'PolarPro', 'DJI Mavic 3 Pro', 'Matériau ABS léger, protège la nacelle et les capteurs de vision lors du transport, fixation clipsable.', 1900.00, 'NOUVEAU', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(37, 7, 'Anémomètre digital portable de terrain', 'Anemotech', 'Universel (Météo)', 'Mesure de la vitesse du vent en temps réel, plage 0–30 m/s, précision ±3%, écran LCD rétroéclairé, piles incluses.', 2150.00, 'SÉCURITÉ', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(38, 8, 'Radiocommande DJI RC 2', 'DJI', 'DJI Mini 4 Pro / Air 3', 'Écran intégré 5.5 pouces 1080p, luminosité 1000 nits, autonomie 4h, transmission O3 jusqu\'à 20 km.', 14900.00, 'NOUVEAU', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(39, 8, 'Radiocommande Professionnelle DJI RC Pro', 'DJI', 'DJI Mavic 3 / Air 3', 'Écran intégré 5.5 pouces 1000 nits, stockage 64 Go, Android embarqué, autonomie 3h, protection IP54.', 41000.00, 'INDISPENSABLE', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(40, 8, 'Support de tablette pour radiocommande DJI', 'LifThor', 'DJI RC-N1 / RC-N2', 'Alliage d\'aluminium anodisé, compatible tablettes jusqu\'à 12.9 pouces, rotule de réglage multi-angles.', 3800.00, 'PRO', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(41, 8, 'Lunette pare-soleil pour tablette iPad', 'Hoodman', 'Universel', 'Réduction optimale des reflets, amélioration de la visibilité sur écran en plein soleil, montage rapide pliable.', 2900.00, 'PRO', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(42, 8, 'Sangle de cou professionnelle pour RC Pro', 'DJI', 'DJI RC Pro / Smart Controller', 'Sangle rembourrée, répartition du poids sur les épaules, décrochage rapide de sécurité, longueur réglable.', 1350.00, 'STANDARD', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(43, 9, 'Carte MicroSDXC Extreme Pro 128 Go U3 V30', 'SanDisk', 'Universel', 'Classe V30 / U3 / A2, vitesse lecture 200 Mo/s, vitesse écriture 90 Mo/s, résistante eau/aimant/rayons X.', 1200.00, 'INDISPENSABLE', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(44, 9, 'Carte MicroSDXC Extreme Pro 256 Go U3 V30', 'SanDisk', 'Universel', 'Classe V30 / U3 / A2, vitesse lecture 200 Mo/s, vitesse écriture 90 Mo/s, résistante eau/aimant/rayons X.', 2300.00, 'INDISPENSABLE', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(45, 10, 'Module de transmission cellulaire DJI Dongle 4G', 'DJI', 'DJI Mavic 3 / Pro', 'Connexion 4G LTE haut débit stable, basculement automatique en cas de coupure du signal O3/O4, format compact USB.', 6200.00, 'PROMO -5%', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(46, 10, 'Amplificateur de signal d\'antenne 2.4/5.8GHz', 'DJI', 'Radiocommandes DJI', 'Amplification du signal Wi-Fi et OcuSync, gain +6 dBi, compatible bandes 2.4 GHz et 5.8 GHz, fixation universelle.', 3400.00, 'PRO', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(47, 11, 'Chargeur USB-C Rapide 65W GaN', 'DJI', 'Universel', 'Technologie GaN (Nitrure de Gallium), compacité extrême, double port USB-C et USB-A, charge rapide standard PD 3.0.', 2450.00, 'INDISPENSABLE', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(48, 11, 'Station de charge d\'accu portable 100W', 'DJI', 'Universel', 'Batterie haute densité, capacité 26400 mAh, sortie 100 W max, charge simultanée jusqu\'à 3 appareils.', 4100.00, 'STANDARD', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(49, 12, 'Câble de données haute vitesse USB-C 10Gbps', 'DJI', 'Universel', 'Câble blindé haute vitesse, débits jusqu\'à 10 Gbps, gaine tressée en nylon renforcé, connecteurs plaqués or.', 980.00, 'STANDARD', '2026-06-09 16:48:41', '2026-06-09 16:48:41'),
(50, 13, 'Support de montage caméra d\'action sur Mavic', 'Pgytech', 'DJI Mavic 3 Series', 'Fixation sur griffe universelle du drone, compatible GoPro / Insta360 / DJI Action, bras orientable 360°.', 1100.00, 'STANDARD', '2026-06-09 16:48:41', '2026-06-09 16:48:41');

-- --------------------------------------------------------

--
-- Structure de la table `categories_accessoire`
--

DROP TABLE IF EXISTS `categories_accessoire`;
CREATE TABLE IF NOT EXISTS `categories_accessoire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_nom` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Référentiel des catégories d''accessoires de drones';

--
-- Déchargement des données de la table `categories_accessoire`
--

INSERT INTO `categories_accessoire` (`id`, `nom`, `description`) VALUES
(1, 'Batterie', 'Batteries de vol intelligentes, hubs de chargement et alimentations embarquées'),
(2, 'Hélices', 'Hélices de rechange, basse résistance, haute altitude et haute performance'),
(3, 'Filtres', 'Filtres ND, PL, UV, CPL et kits optiques pour nacelles et caméras embarquées'),
(4, 'Transport', 'Valises rigides, sacs à dos, mallettes et étuis de protection pour le transport'),
(5, 'Confort', 'Sangles, pare-soleil, mousses ergonomiques et accessoires de confort opérateur'),
(6, 'Caméra', 'Objectifs, nacelles, caches et accessoires optiques pour caméras embarquées'),
(7, 'Sécurité', 'Protège-hélices, trains d\'atterrissage, anémomètres et équipements de sécurité'),
(8, 'Contrôle', 'Radiocommandes, supports de tablette, sangles et accessoires de pilotage'),
(9, 'Stockage', 'Cartes microSD, SSD et supports de stockage haute vitesse pour enregistrement'),
(10, 'Réseau', 'Modules 4G/LTE, amplificateurs d\'antenne et équipements de transmission longue portée'),
(11, 'Énergie', 'Chargeurs GaN, stations de charge portables et solutions d\'alimentation terrain'),
(12, 'Connectique', 'Câbles USB-C, adaptateurs et connecteurs haute vitesse pour transfert de données'),
(13, 'Extension', 'Supports de montage, bras additionnels et extensions mécaniques pour drones');

-- --------------------------------------------------------

--
-- Structure de la table `drones`
--

DROP TABLE IF EXISTS `drones`;
CREATE TABLE IF NOT EXISTS `drones` (
  `ID` int DEFAULT NULL,
  `Marque` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Modèle` varchar(27) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Catégorie` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Autonomie` int DEFAULT NULL,
  `Spécificité Capteur / Charge` varchar(33) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Portée` int DEFAULT NULL,
  `Nombre d'avis` int DEFAULT NULL,
  `Prix Final (MRU)` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Statut Stock` varchar(19) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Lien_Image` varchar(186) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `drones`
--

INSERT INTO `drones` (`ID`, `Marque`, `Modèle`, `Catégorie`, `Autonomie`, `Spécificité Capteur / Charge`, `Portée`, `Nombre d'avis`, `Prix Final (MRU)`, `Statut Stock`, `Lien_Image`) VALUES
(1, 'DJI', 'Matrice 350 RTK', 'Aérien Pro', 55, 'Nacelle Interchangeable', 20000, 45, '480 000 MRU', 'Sur commande', 'https://www.integraldrones.com.au/wp-content/uploads/2023/05/DJI-Matrice-350-drone-speaker-snow.jpg'),
(2, 'Autel Robotics', 'Evo Max 4T', 'Aérien Pro', 42, '8K Zoom + Thermique', 20000, 22, '178 500 MRU', 'En stock', 'https://cdn.mos.cms.futurecdn.net/7L46BwhU6xxRNAcDJ5CZmR-1200-80.jpg'),
(3, 'DJI', 'Matrice 30T', 'Aérien Pro', 41, '4K + Thermique + Télémètre', 15000, 31, '340 000 MRU', 'Sur commande', 'DJI-Matrice-4T-Drohne-in-der-Frontansicht-Image-Source-DJI.jpg (2200×1238)'),
(4, 'Autel Robotics', 'Evo II Dual 640T V3', 'Aérien Pro', 38, '4K HDR + Thermique', 15000, 19, '195 000 MRU', 'En stock Nouakchott', 'drone_autel_evo2_640t_enterprise_image6.jpg (2600×1625)'),
(5, 'DJI', 'Mavic 3 Thermal (M3T)', 'Aérien Pro', 45, '4K + Thermique 640x512', 32000, 88, '165 000 MRU', 'En stock', 'Mavic-3T-schaut-in-die-Sonne.jpg (2200×1237)'),
(6, 'DJI', 'Mavic 3 Enterprise (M3E)', 'Aérien Pro', 45, '4K / Capteur 20MP Obt. Méca', 32000, 105, '138 000 MRU', 'En stock', 'Gambar-Tampak-Depan-Drone-DJI-Mavic-3-Enterprise-M3E-Indosurta-Group-BG.jpg (1080×1080)'),
(7, 'DJI', 'Mini 4 Pro Fly More', 'Aérien Pro', 34, '4K /60 fps HDR', 18000, 540, '38 000 MRU', 'En stock Nouakchott', 'https://cdn.vox-cdn.com/thumbor/NujOmviRqQcikQgXW9YEFbPfntY=/0x0:2340x1621/1200x628/filters:focal(1170x811:1171x812)/cdn.vox-cdn.com/uploads/chorus_asset/file/24952800/mini_4_pro_dji.jpg'),
(8, 'Quantum Systems', 'Trinity F90+ (VTOL)', 'Aérien Pro', 90, '24MP à 42MP (Cartographie)', 100000, 8, '790 000 MRU', 'Sur commande', 'QuantumSystems-e1587688799605.jpg (1075×969)'),
(9, 'QYSEA', 'FIFISH V6 Expert', 'Sous-marin', 240, '4K UHD /30 fps', 100, 47, '148 000 MRU', 'En stock', 'qysea_yr010bc9400240801_fifish_v6_expert_m200_1865487.jpg (2956×1552)'),
(10, 'Chasing', 'M2 Pro', 'Sous-marin', 240, '4K UHD / 12MP', 150, 29, '195 000 MRU', 'En stock', 'Chasing-M2-underwater-drone-ROV.png (798×775)'),
(11, 'QYSEA', 'FIFISH V-EVO', 'Sous-marin', 240, '4K / 60 fps (Focale 166°)', 100, 15, '58 000 MRU', 'En stock Nouakchott', 'QYSEA-FIFISH-V-EVO-05.jpg (1000×1000)'),
(12, 'Chasing', 'M2 Enterprise', 'Sous-marin', 300, '4K UHD + Bras Robotique', 150, 11, '290 000 MRU', 'Sur commande', 'Chasing+M2+Pro+Max+(6).jpg (1500×1001)'),
(13, 'Chasing', 'Dory', 'Sous-marin', 90, '1080p Full HD', 15, 112, '22 000 MRU', 'En stock', 'dory_banenr_wep_img1.ec9fd9d.jpg (1014×696)'),
(14, 'QYSEA', 'FIFISH W6', 'Sous-marin', 360, 'Double 4K UHD / Sonar', 350, 4, '980 000 MRU', 'Sur commande', 'qysea-fifish-w6-00-1068x740.jpg (1068×740)'),
(15, 'Geneinno', 'T1 Pro', 'Sous-marin', 240, '4K UHD / Phares 3000 lm', 150, 23, '119 000 MRU', 'Sur commande', '90 (2880×1920)'),
(16, 'Deep Trekker', 'DTG3', 'Sous-marin', 720, '4K HD Low Light', 200, 7, '540 000 MRU', 'Sur commande', 'DTG3-Navigator.png (1170×780)'),
(17, 'DJI', 'Mavic 3 Multispectral (M3M)', 'Agriculture', 43, '4K + 4 Caméras G/R/RE/NIR', 32000, 55, '185 000 MRU', 'En stock Nouakchott', 'maxresdefault.jpg (1280×720)'),
(18, 'DJI', 'Agras T40', 'Agriculture', 19, 'Capacité 40L (Génération Préc.)', 12, 110, '536 800 MRU', '3 en stock', ''),
(19, 'DJI', 'Inspire 3', 'Cinéma 8K/4K', 28, '8K ProRes RAW / CinemaDNG', 15, 14, '560 000 MRU', 'Sur commande', ''),
(20, 'DJI', 'Mavic 3 Pro Cine', 'Cinéma 8K/4K', 46, '5.1K Apple ProRes / Tri-Cam', 28000, 312, '92 000 MRU', 'En stock Nouakchott', 'https://se-cdn.djiits.com/tpc/uploads/carousel/image/0f65f523ec36e90fa03792967a85664a@ultra.jpg'),
(21, 'DJI', 'Avata 2 Studio Combo', 'Cinéma 8K/4K', 23, '4K / 100 fps Cinewhoop', 27, 128, '36 500 MRU', 'Précommande', 'https://blog.freewellgear.com/wp-content/uploads/2024/04/Avata-2-Goggles-3-RC-Motion-3-2.jpeg'),
(22, 'DJI', 'Air 3S Cine', 'Cinéma 8K/4K', 45, '4K / 120fps / Capteur 1\" + 1/1.3\"', 32000, 76, '59 000 MRU', 'En stock', ''),
(23, 'Sony', 'Airpeak S1', 'Cinéma 8K/4K', 22, 'Optimisé Plein Format Sony Alpha', 90000, 21, '310 000 MRU', 'Sur commande', ''),
(24, 'DJI', 'Mavic 3 Classic', 'Cinéma 8K/4K', 46, '4K / 120 fps Hasselblad', 32000, 189, '58 000 MRU', 'En stock', ''),
(25, 'DJI', 'Avata Explorer Edition', 'Cinéma 8K/4K', 18, '4K / 60 fps Ultra-stabilisé', 8000, 245, '39 000 MRU', 'En stock', '');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `v_accessoires`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `v_accessoires`;
CREATE TABLE IF NOT EXISTS `v_accessoires` (
`caracteristiques` text
,`categorie` varchar(100)
,`compatibilite` varchar(200)
,`created_at` timestamp
,`id` int
,`id_categorie` int
,`marque` varchar(100)
,`nom` varchar(200)
,`prix_mru` decimal(10,2)
,`statut_stock` varchar(60)
,`updated_at` timestamp
);

-- --------------------------------------------------------

--
-- Structure de la vue `v_accessoires`
--
DROP TABLE IF EXISTS `v_accessoires`;

DROP VIEW IF EXISTS `v_accessoires`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_accessoires`  AS SELECT `a`.`id` AS `id`, `c`.`id` AS `id_categorie`, `c`.`nom` AS `categorie`, `a`.`nom` AS `nom`, `a`.`marque` AS `marque`, `a`.`compatibilite` AS `compatibilite`, `a`.`caracteristiques` AS `caracteristiques`, `a`.`prix_mru` AS `prix_mru`, `a`.`statut_stock` AS `statut_stock`, `a`.`created_at` AS `created_at`, `a`.`updated_at` AS `updated_at` FROM (`accessoires` `a` join `categories_accessoire` `c` on((`a`.`id_categorie` = `c`.`id`))) ;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `accessoires`
--
ALTER TABLE `accessoires`
  ADD CONSTRAINT `fk_acc_categorie` FOREIGN KEY (`id_categorie`) REFERENCES `categories_accessoire` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
