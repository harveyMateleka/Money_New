-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 15 mai 2021 à 12:11
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `abt_transfert`
--

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(42, '2021_05_06_072418_create_tbl_fonctions_table', 1),
(43, '2021_05_06_074635_create_tbl_viles_table', 1),
(44, '2021_05_06_080132_create_tbl_natures_table', 1),
(45, '2021_05_06_080729_create_tbl_typemvts_table', 1),
(46, '2021_05_06_080858_create_tbl_banques_table', 1),
(47, '2021_05_06_080955_create_tbl_mvtbanques_table', 1),
(48, '2021_05_06_081056_create_tbl_agences_table', 1),
(49, '2021_05_06_081154_create_tbl_devises_table', 1),
(50, '2021_05_06_081312_create_tbl_affectations_table', 1),
(51, '2021_05_06_081341_create_tbl_personnels_table', 1),
(52, '2021_05_06_081423_create_tbl_depots_table', 1),
(53, '2021_05_06_081532_create_tbl_retraits_table', 1),
(54, '2021_05_06_111448_create_tbl_historisations_table', 1),
(55, '2021_05_06_111814_create_users_table', 1),
(56, '2021_05_10_081639_create_tbl_clients_table', 1),
(57, '2021_05_10_082201_create_tbl_typedepenses_table', 1),
(58, '2021_05_10_082434_create_tbl_autorisations_table', 1),
(59, '2021_05_10_082519_create_tbl_depenses_table', 1),
(60, '2021_05_10_082744_create_tbl_typeclients_table', 1),
(61, '2021_05_14_085656_create_tbl_menus_table', 2),
(62, '2021_05_14_085946_create_tbl_sous_menus_table', 2);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_affectations`
--

DROP TABLE IF EXISTS `tbl_affectations`;
CREATE TABLE IF NOT EXISTS `tbl_affectations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `matricule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numagence` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_affectations_matricule_foreign` (`matricule`(250)),
  KEY `tbl_affectations_numagence_foreign` (`numagence`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_agences`
--

DROP TABLE IF EXISTS `tbl_agences`;
CREATE TABLE IF NOT EXISTS `tbl_agences` (
  `numagence` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomagence` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telservice` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_ville` int(10) UNSIGNED NOT NULL,
  `Montcdf` double(10,4) NOT NULL,
  `Montusd` double(7,4) NOT NULL,
  PRIMARY KEY (`numagence`),
  UNIQUE KEY `tbl_agences_telservice_unique` (`telservice`),
  KEY `tbl_agences_id_ville_foreign` (`id_ville`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_autorisations`
--

DROP TABLE IF EXISTS `tbl_autorisations`;
CREATE TABLE IF NOT EXISTS `tbl_autorisations` (
  `id_auto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_auto` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_auto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_banques`
--

DROP TABLE IF EXISTS `tbl_banques`;
CREATE TABLE IF NOT EXISTS `tbl_banques` (
  `id_banq` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero_compte` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `intitulecompte` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Montantcdf` double(15,4) NOT NULL,
  `Montantusd` double(15,4) NOT NULL,
  PRIMARY KEY (`id_banq`),
  UNIQUE KEY `tbl_banques_numero_compte_unique` (`numero_compte`) USING HASH
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_clients`
--

DROP TABLE IF EXISTS `tbl_clients`;
CREATE TABLE IF NOT EXISTS `tbl_clients` (
  `id_client` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomclient` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_type` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_client`),
  UNIQUE KEY `tbl_clients_tel_unique` (`tel`),
  KEY `tbl_clients_id_type_foreign` (`id_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_depenses`
--

DROP TABLE IF EXISTS `tbl_depenses`;
CREATE TABLE IF NOT EXISTS `tbl_depenses` (
  `id_dep` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `motif` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dev` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant` decimal(10,4) NOT NULL,
  `id_typdep` int(10) UNSIGNED NOT NULL,
  `id_auto` int(10) UNSIGNED NOT NULL,
  `matricule` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_dep`),
  KEY `tbl_depenses_matricule_foreign` (`matricule`),
  KEY `tbl_depenses_id_typdep_foreign` (`id_typdep`),
  KEY `tbl_depenses_id_auto_foreign` (`id_auto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_depots`
--

DROP TABLE IF EXISTS `tbl_depots`;
CREATE TABLE IF NOT EXISTS `tbl_depots` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `numdepot` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomexpedit` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telclient` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomben` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `montenvoi` double(15,4) NOT NULL,
  `montpour` double(8,4) NOT NULL,
  `etatservi` int(11) NOT NULL,
  `matricule` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_ville` int(11) NOT NULL,
  `id_devise` int(11) NOT NULL,
  `numagence` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_depots_numdepot_unique` (`numdepot`),
  UNIQUE KEY `tbl_depots_telclient_unique` (`telclient`),
  KEY `tbl_depots_matricule_foreign` (`matricule`),
  KEY `tbl_depots_id_ville_foreign` (`id_ville`),
  KEY `tbl_depots_id_devise_foreign` (`id_devise`),
  KEY `tbl_depots_numagence_foreign` (`numagence`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_devises`
--

DROP TABLE IF EXISTS `tbl_devises`;
CREATE TABLE IF NOT EXISTS `tbl_devises` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `intitule` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_droitacces`
--

DROP TABLE IF EXISTS `tbl_droitacces`;
CREATE TABLE IF NOT EXISTS `tbl_droitacces` (
  `id_droit` int(11) NOT NULL AUTO_INCREMENT,
  `id_fonction` int(11) NOT NULL,
  `id_sous` int(11) NOT NULL,
  `var_lien` varchar(30) NOT NULL,
  PRIMARY KEY (`id_droit`),
  KEY `id_fonction` (`id_fonction`),
  KEY `id_sous` (`id_sous`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_fonctions`
--

DROP TABLE IF EXISTS `tbl_fonctions`;
CREATE TABLE IF NOT EXISTS `tbl_fonctions` (
  `id_fonction` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fonction` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_fonction`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_historisations`
--

DROP TABLE IF EXISTS `tbl_historisations`;
CREATE TABLE IF NOT EXISTS `tbl_historisations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `operation` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_historisations_id_user_foreign` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_menus`
--

DROP TABLE IF EXISTS `tbl_menus`;
CREATE TABLE IF NOT EXISTS `tbl_menus` (
  `id_menu` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_menu` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_mvtbanques`
--

DROP TABLE IF EXISTS `tbl_mvtbanques`;
CREATE TABLE IF NOT EXISTS `tbl_mvtbanques` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_type` int(11) NOT NULL,
  `Montmvt` double(10,4) NOT NULL,
  `matricule` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_banque` int(10) UNSIGNED NOT NULL,
  `observation` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_mvtbanques_matricule_foreign` (`matricule`),
  KEY `tbl_mvtbanques_id_banque_foreign` (`id_banque`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_natures`
--

DROP TABLE IF EXISTS `tbl_natures`;
CREATE TABLE IF NOT EXISTS `tbl_natures` (
  `id_nature` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nature` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_nature`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_personnels`
--

DROP TABLE IF EXISTS `tbl_personnels`;
CREATE TABLE IF NOT EXISTS `tbl_personnels` (
  `matricule` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postnom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_fonction` int(11) NOT NULL,
  PRIMARY KEY (`matricule`),
  KEY `tbl_personnels_id_fonction_foreign` (`id_fonction`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_retraits`
--

DROP TABLE IF EXISTS `tbl_retraits`;
CREATE TABLE IF NOT EXISTS `tbl_retraits` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `matricule` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numagence` int(11) NOT NULL,
  `id_depot` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_retraits_id_depot_foreign` (`id_depot`),
  KEY `tbl_retraits_matricule_foreign` (`matricule`),
  KEY `tbl_retraits_numagence_foreign` (`numagence`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_sous_menus`
--

DROP TABLE IF EXISTS `tbl_sous_menus`;
CREATE TABLE IF NOT EXISTS `tbl_sous_menus` (
  `id_sous` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_sous` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_menu` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_sous`),
  KEY `tbl_sous_menus_id_menu_foreign` (`id_menu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_typeclients`
--

DROP TABLE IF EXISTS `tbl_typeclients`;
CREATE TABLE IF NOT EXISTS `tbl_typeclients` (
  `id_type` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `typr_client` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_typedepenses`
--

DROP TABLE IF EXISTS `tbl_typedepenses`;
CREATE TABLE IF NOT EXISTS `tbl_typedepenses` (
  `id_typdep` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type_dep` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_typdep`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_typemvts`
--

DROP TABLE IF EXISTS `tbl_typemvts`;
CREATE TABLE IF NOT EXISTS `tbl_typemvts` (
  `id_type` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `typemvt` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_viles`
--

DROP TABLE IF EXISTS `tbl_viles`;
CREATE TABLE IF NOT EXISTS `tbl_viles` (
  `id_ville` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ville` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_ville`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tbl_viles`
--

INSERT INTO `tbl_viles` (`id_ville`, `ville`) VALUES
(1, 'Kinshasa'),
(2, 'Lubumbashi'),
(3, 'Kolwezi');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `matricule` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_password_unique` (`password`) USING HASH,
  KEY `users_matricule_foreign` (`matricule`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
