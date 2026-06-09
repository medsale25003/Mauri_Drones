-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 09 juin 2026 à 15:17
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
