-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 13 mars 2026 à 00:21
-- Version du serveur : 11.8.3-MariaDB-log
-- Version de PHP : 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `u897889904_immo`
--

-- --------------------------------------------------------

--
-- Structure de la table `actions`
--

CREATE TABLE `actions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `commentaire` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type_action_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `actions`
--

INSERT INTO `actions` (`id`, `type`, `commentaire`, `created_at`, `updated_at`, `user_id`, `type_action_id`) VALUES
(1, 'Mise à jour fournisseur', 'L\'administrateur marieme Faye a modifié le fournisseur : .', '2024-11-16 01:57:06', '2024-11-16 01:57:06', 12, NULL),
(2, 'Mise à jour fournisseur', 'L\'administrateur Sean Beier Mr. Alan Kris a modifié le fournisseur : .', '2025-07-06 22:16:12', '2025-07-06 22:16:12', 1, NULL),
(3, 'Mise à jour fournisseur', 'L\'administrateur Sean Beier Mr. Alan Kris a modifié le fournisseur : .', '2025-07-06 22:18:23', '2025-07-06 22:18:23', 1, NULL),
(4, 'Mise à jour fournisseur', 'L\'administrateur Adama Sow a modifié le fournisseur : .', '2025-07-06 22:33:47', '2025-07-06 22:33:47', 3, NULL),
(5, 'Mise à jour fournisseur', 'L\'administrateur AGUIBOU DIALLO a modifié le fournisseur : .', '2025-07-08 00:41:22', '2025-07-08 00:41:22', 11, NULL),
(6, 'Mise à jour fournisseur', 'L\'administrateur AGUIBOU DIALLO a modifié le fournisseur : .', '2025-07-09 23:44:49', '2025-07-09 23:44:49', 11, NULL),
(7, 'Mise à jour fournisseur', 'L\'administrateur Adama Sow a modifié le fournisseur : .', '2025-07-29 15:19:11', '2025-07-29 15:19:11', 3, NULL),
(8, 'Mise à jour fournisseur', 'L\'administrateur Adama Sow a modifié le fournisseur : .', '2025-07-29 15:20:56', '2025-07-29 15:20:56', 3, NULL),
(9, 'Mise à jour fournisseur', 'L\'administrateur Adama Sow a modifié le fournisseur : .', '2025-07-29 15:23:37', '2025-07-29 15:23:37', 3, NULL),
(10, 'Mise à jour fournisseur', 'L\'administrateur Daouda DIALLO a modifié le fournisseur : .', '2025-08-02 18:37:54', '2025-08-02 18:37:54', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `agent_specialisations`
--

CREATE TABLE `agent_specialisations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `specialisation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `fournisseur_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `annonces`
--

CREATE TABLE `annonces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` longtext DEFAULT NULL,
  `adresse` longtext DEFAULT NULL,
  `prix` int(11) NOT NULL,
  `lon` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `pieces` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `is_verify` tinyint(1) NOT NULL DEFAULT 0,
  `immo_id` bigint(20) UNSIGNED DEFAULT NULL,
  `commune_id` bigint(20) UNSIGNED DEFAULT NULL,
  `departement_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type_location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `slug` longtext DEFAULT NULL,
  `is_premium` tinyint(1) NOT NULL DEFAULT 0,
  `type_immo_id` int(11) DEFAULT NULL,
  `superficie` int(11) NOT NULL DEFAULT 0,
  `comodites` longtext DEFAULT NULL,
  `meubles` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1: Oui, 0: Non',
  `chambres` int(11) DEFAULT NULL,
  `toillettes` int(11) DEFAULT NULL,
  `salons` int(11) DEFAULT NULL,
  `cuisines` int(11) DEFAULT NULL,
  `date_disponibilite` date DEFAULT NULL,
  `url_video` longtext DEFAULT NULL,
  `visite_virtuelle` longtext DEFAULT NULL,
  `fournisseur_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `annonces`
--

INSERT INTO `annonces` (`id`, `description`, `adresse`, `prix`, `lon`, `lat`, `pieces`, `created_at`, `updated_at`, `status`, `is_verify`, `immo_id`, `commune_id`, `departement_id`, `name`, `type_location_id`, `slug`, `is_premium`, `type_immo_id`, `superficie`, `comodites`, `meubles`, `chambres`, `toillettes`, `salons`, `cuisines`, `date_disponibilite`, `url_video`, `visite_virtuelle`, `fournisseur_id`) VALUES
(1, NULL, NULL, 750000, '-17.450929', '14.680483', '{\"1\":{\"Chambres\":\"3\"},\"2\":{\"Salons\":\"2\"},\"3\":{\"Toilettes\":\"2\"},\"4\":{\"Cuisines\":\"2\"}}', '2025-01-23 13:00:12', '2025-02-15 13:00:12', 2, 1, 1, 1, NULL, 'Appartement lux', 1, 'appartement-lux1', 0, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Teste modification annonce', 'Ouest Foire, Dakar, Sénégal', 250000, '-17.450929', '14.680487', '{\"1\":{\"Chambres\":\"2\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toillettes\":\"1\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-02-15 13:01:02', '2025-06-29 21:24:14', 2, 1, 2, 1, 1, 'Appartement modification annonce', NULL, 'appartement-modification-annonce-2', 1, 1, 0, '[\"1\",\"6\"]', 0, 2, 1, 1, 1, '2025-07-05', 'https://www.youtube.com/watch?v=2p-XPVZnTTU&list=PLMpyixh28VL8CHD3LaAn4gPBUzu7xEf9y', 'https://www.actual-immo.fr/qr-code-dpe-immobilier-2025/', NULL),
(3, NULL, NULL, 100000, '-17.450929', '14.780487', '{\"1\":{\"Chambres\":\"3\"},\"2\":{\"Salons\":\"3\"},\"3\":{\"Toilettes\":\"3\"},\"4\":{\"Cuisines\":\"2\"}}', '2025-02-15 13:02:02', '2025-02-15 13:02:02', 2, 1, 3, 1, NULL, 'Appartement Normal', 1, 'appartement-normal3', 0, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, NULL, NULL, 300000, '-17.450929', '14.690487', '{\"1\":{\"Chambres\":\"3\"},\"2\":{\"Salons\":\"2\"},\"3\":{\"Toilettes\":\"3\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-02-15 13:03:12', '2025-02-15 13:03:12', 2, 1, 4, 1, NULL, 'Duplex 2', 1, 'duplex-24', 0, 2, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, NULL, NULL, 380000, '-16.450929', '13.780487', '{\"1\":{\"Chambres\":\"2\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toilettes\":\"2\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-02-15 13:04:14', '2025-02-15 13:04:14', 2, 0, 5, 1, NULL, 'studio', 1, 'studio5', 0, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, NULL, NULL, 450000, '-16.450929', '14.780487', '{\"1\":{\"Chambres\":\"5\"},\"2\":{\"Salons\":\"3\"},\"3\":{\"Toilettes\":\"5\"},\"4\":{\"Cuisines\":\"3\"}}', '2025-02-15 13:07:45', '2025-02-15 13:07:45', 2, 0, 6, 2, NULL, 'Villa', 2, 'villa6', 0, 3, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, NULL, NULL, 100000, '-17.450929', '14.880487', '{\"1\":{\"Chambres\":\"1\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toilettes\":\"1\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-02-15 13:25:18', '2025-02-15 13:25:18', 2, 0, 7, 2, NULL, 'Studio', 2, 'studio7', 0, 5, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, NULL, NULL, 175000, '-17.450929', '14.380487', '{\"1\":{\"Chambres\":\"3\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toilettes\":\"2\"},\"4\":{\"Cuisines\":\"2\"}}', '2025-02-15 13:29:47', '2025-02-15 13:29:47', 2, 0, 8, 1, NULL, 'App Luxous', 2, 'app-luxous8', 1, 1, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, NULL, NULL, 375000, '-17.450929', '14.640487', '{\"1\":{\"Chambres\":\"4\"},\"2\":{\"Salons\":\"2\"},\"3\":{\"Toilettes\":\"3\"},\"4\":{\"Cuisines\":\"2\"}}', '2025-02-15 14:06:34', '2025-02-15 14:06:34', 2, 0, 9, 2, NULL, 'Villa', 2, 'villa9', 1, 3, 0, NULL, 1, 4, 3, 3, 2, NULL, NULL, NULL, NULL),
(10, '<p>Je suis un commentaire</p>', NULL, 450000, '-17.450929', '14.680487', '{\"1\":{\"Chambres\":\"2\"},\"2\":{\"Salons\":\"2\"},\"3\":{\"Toilettes\":\"1\"},\"4\":{\"Cuisines\":\"3\"}}', '2025-03-18 23:04:06', '2025-03-18 23:04:06', 2, 0, 21, 1, NULL, 'Villa 221', 2, 'villa-22121', 0, 1, 150, '[\"1\",\"2\",\"3\"]', 1, 2, 1, 2, 3, NULL, NULL, NULL, NULL),
(11, '<p>Appartement &agrave; pokine , pr&ecirc;t de tous les services&nbsp;</p>', NULL, 250000, '-16.450929', '12.656487', '{\"1\":{\"Chambres\":\"0\"},\"2\":{\"Salons\":\"0\"},\"3\":{\"Toilettes\":\"1\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-03-18 23:06:14', '2025-03-18 23:12:42', 1, 0, 22, 2, NULL, 'TEST 2 ANNONCE', 1, 'test-2-annonce22', 1, 1, 150, '[\"2\",\"3\",\"4\",\"5\"]', 1, 0, 1, 0, 1, NULL, NULL, NULL, NULL),
(12, NULL, 'Cité Douane, Dakar, Dakar, Senegal', 710000, '-17.444634', '14.701987', '{\"1\":{\"Chambres\":\"0\"},\"2\":{\"Salons\":\"0\"},\"3\":{\"Toilettes\":\"1\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-04-12 20:38:59', '2025-04-12 20:38:59', 2, 0, 23, 1, 1, 'studio', 2, 'studio23', 0, 1, 150, '[\"1\",\"5\",\"6\",\"7\"]', 1, 2, 2, 4, 2, '2025-04-12', NULL, NULL, NULL),
(13, '<p>Superbe &nbsp;duplex situ&eacute; a proximit&eacute; des plusieurs services publiques&nbsp;</p>', 'Sicap-Liberté, Dakar, Dakar, Senegal', 200000, '-17.461589', '14.722996', '{\"1\":{\"Chambres\":\"2\"},\"2\":{\"Salons\":\"2\"},\"3\":{\"Toillettes\":\"1\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-04-16 17:58:42', '2025-04-16 17:58:42', 2, 0, 24, 1, 1, 'Duplex. - test Aguibou', 1, 'duplex-test-aguibou24', 0, 1, 140, '[\"1\",\"7\"]', 1, 2, 1, 2, 1, '2025-04-17', NULL, NULL, NULL),
(14, 'Publication test', 'Sicap-Liberté, Dakar, Dakar, Senegal', 150000, '-17.461589', '14.722996', '{\"1\":{\"Chambres\":\"1\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toillettes\":\"2\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-04-16 18:16:59', '2025-04-16 18:16:59', 2, 0, 25, 1, 1, 'Test 2 Aguibou', 1, 'test-2-aguibou25', 0, 1, 150, '[\"1\",\"2\",\"3\",\"5\",\"6\",\"7\"]', 1, 1, 2, 1, 1, '2025-04-24', NULL, NULL, NULL),
(15, 'Le lorem ipsum est, en imprimerie, une suite de mots sans signification utilisée à titre provisoire pour calibrer une mise en page, le texte définitif venant remplacer le faux-texte dès qu\'il est prêt ou que la mise en page est achevée. Généralement, on utilise un texte en faux latin, le Lorem ipsum ou Lipsum.', 'Rue 6, Dakar, Sénégal', 130000, '-17.4522252', '14.6773341', '{\"1\":{\"Chambres\":\"0\"},\"2\":{\"Salons\":\"0\"},\"3\":{\"Toillettes\":\"0\"},\"4\":{\"Cuisines\":\"0\"}}', '2025-05-08 22:23:04', '2025-05-08 22:23:04', 2, 0, 26, 1, 1, 'Test', 1, 'test26', 0, 1, 130, '[\"1\",\"5\",\"7\"]', 1, 0, 0, 0, 0, '2025-05-08', NULL, NULL, NULL),
(16, 'test lo', 'Rue YF 564, Dakar, Sénégal', 250000, '-17.4733357', '14.7550293', '{\"1\":{\"Chambres\":\"4\"},\"2\":{\"Salons\":\"2\"},\"3\":{\"Toillettes\":\"4\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-05-10 18:15:33', '2025-05-10 18:15:33', 2, 0, 27, 2, 1, 'test lo', 1, 'test-lo27', 0, 1, 220, '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\"]', 1, 4, 4, 2, 1, '2025-05-11', NULL, NULL, NULL),
(17, 'test for daouda', 'Rue YF 107, Dakar, Sénégal', 1000000, '-17.4869717', '14.7583566', '{\"1\":{\"Chambres\":\"9\"},\"2\":{\"Salons\":\"3\"},\"3\":{\"Toillettes\":\"6\"},\"4\":{\"Cuisines\":\"2\"}}', '2025-05-10 18:19:13', '2025-05-10 18:19:13', 2, 0, 28, 1, 1, 'test pour daouda', 1, 'test-pour-daouda28', 0, 1, 2000, '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\"]', 1, 9, 6, 3, 2, '2025-05-23', NULL, NULL, NULL),
(18, 'Studio meublé situé non de l\'école de la police', 'DAKAR', 25000, NULL, NULL, '{\"1\":{\"Chambres\":\"1\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toillettes\":\"1\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-05-10 19:20:30', '2025-05-10 19:20:30', 2, 0, 29, 1, 1, 'TESTE APPARTE 10/5', 2, 'teste-apparte-10529', 0, 1, 150, '[\"1\",\"4\",\"5\",\"6\"]', 1, 1, 1, 1, 1, '2025-05-13', NULL, NULL, NULL),
(19, 'TEST AGENT LO', 'Rue KD20, Dakar, Sénégal', 1000000, '-17.4565096', '14.7493166', '{\"1\":{\"Chambres\":\"3\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toillettes\":\"3\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-05-10 19:40:45', '2025-05-10 19:40:45', 2, 0, 30, 1, 1, 'TEST AGENT LO', 1, 'test-agent-lo30', 0, 2, 220, '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\"]', 1, 3, 3, 1, 1, '2025-06-01', NULL, NULL, NULL),
(20, 'Appartement meublé situé à la sicap foire pour vos long et court séjour dans la capital sénégalaise', 'Bd GD 01, Dakar, Sénégal', 35000, '-17.4576525', '14.7045834', '{\"1\":{\"Chambres\":\"1\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toillettes\":\"1\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-05-10 19:55:34', '2025-05-10 19:55:34', 2, 0, 31, 1, 1, 'APPARTEMENT MEUBLE SICAP F', 2, 'appartement-meuble-sicap-f31', 0, 1, 155, '[\"1\",\"3\",\"4\",\"5\",\"6\",\"7\"]', 1, 1, 1, 1, 1, '2025-05-20', NULL, NULL, NULL),
(21, 'Appartement haut standing a louer a Ouest foire tout prés de la VDN', 'Ouest Foire, Dakar, Sénégal', 435000, NULL, NULL, '{\"1\":{\"Chambres\":\"2\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toillettes\":\"2\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-05-10 23:25:12', '2025-05-10 23:25:12', 2, 0, 32, 1, 1, 'TESTE APPARTEMENT 10/5/25', 2, 'teste-appartement-1052532', 0, 1, 165, '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\"]', 0, 2, 2, 1, 1, '2025-05-11', NULL, NULL, NULL),
(22, NULL, 'C.I.C.E.S, Dakar, Sénégal', 150000, NULL, NULL, '{\"1\":{\"Chambres\":\"2\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toillettes\":\"1\"},\"4\":{\"Cuisines\":\"0\"}}', '2025-05-11 18:18:53', '2025-05-11 18:20:34', 1, 0, 33, 1, 1, 'Test Abidjan', 2, 'test-abidjan33', 0, 2, 150, '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]', 1, 2, 1, 1, 0, '2025-05-19', NULL, NULL, NULL),
(23, 'Aguibou - test abidjan  appartment à louer', 'C.I.C.E.S, Dakar, Sénégal', 200000, NULL, NULL, '{\"1\":{\"Chambres\":\"1\"},\"2\":{\"Salons\":\"0\"},\"3\":{\"Toillettes\":\"1\"},\"4\":{\"Cuisines\":\"0\"}}', '2025-05-11 18:22:56', '2025-05-11 18:22:56', 2, 0, 34, 1, 1, 'Test Abidjan', 2, 'test-abidjan34', 0, 2, 150, '[\"1\",\"2\",\"3\",\"5\"]', 0, 1, 1, 0, 0, '2025-05-18', NULL, NULL, NULL),
(24, 'Bel appartement moderne a vendre a la Sicap Foire', 'C.I.C.E.S, Dakar, Sénégal', 50000000, '-17.4632496', '14.7437295', '{\"1\":{\"Chambres\":\"3\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toillettes\":\"3\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-05-16 22:29:16', '2025-05-16 22:29:16', 2, 0, 35, 1, 1, 'TESTE APPARTE 15/5', 1, 'teste-apparte-15535', 0, 1, 230, '[\"1\",\"5\",\"6\"]', 0, 3, 3, 1, 1, '2025-05-17', NULL, NULL, NULL),
(25, 'Appartement haut standing  a louer dans l\'un des quartiers le plus classe de Dakar avec vu sur la mere', 'Dakar-Plateau, Dakar, Sénégal', 650000, '-17.4374803', '14.6629438', '{\"1\":{\"Chambres\":\"2\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toillettes\":\"2\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-05-17 19:30:12', '2025-05-17 19:30:12', 2, 0, 36, 1, 1, 'Appartement haut standing', 2, 'appartement-haut-standing36', 0, 1, 235, '[\"1\",\"2\",\"3\",\"4\",\"5\"]', 0, 2, 2, 1, 1, '2025-05-24', NULL, NULL, NULL),
(26, 'Duplex a louer a Ouest Foire vers tally seck', 'Ouest Foire, Dakar, Sénégal', 235000, '-17.4708861', '14.7506311', '{\"1\":{\"Chambres\":\"2\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toillettes\":\"2\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-05-20 21:50:11', '2025-05-20 21:50:11', 2, 0, 37, 1, 1, 'TESTE APPARTE 20/5', 2, 'teste-apparte-20537', 0, 2, 155, '[\"1\",\"2\",\"5\",\"6\"]', 0, 2, 2, 1, 1, '2025-05-23', NULL, NULL, NULL),
(27, 'Jolie apartement en plein coeur d\'almadies', 'Almadies, Sénégal', 400000, '-17.5116542', '14.7434582', '{\"1\":{\"Chambres\":\"1\"},\"2\":{\"Salons\":\"0\"},\"3\":{\"Toillettes\":\"1\"},\"4\":{\"Cuisines\":\"0\"}}', '2025-05-28 21:13:19', '2025-05-28 21:13:19', 2, 0, 40, 1, 1, 'Test  - AGuibou  - 28 mai', 2, 'test-aguibou-28-mai40', 0, 1, 200, '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]', 1, 1, 1, 0, 0, '2025-05-29', NULL, NULL, NULL),
(28, 'Superbe studio a vendre a Ngor Almadie zone de terrassement', 'Route des Almadies, Ngor, Dakar, Sénégal', 25000000, '-17.5188139', '14.7418841', '{\"1\":{\"Chambres\":\"3\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toillettes\":\"2\"},\"4\":{\"Cuisines\":\"2\"}}', '2025-06-11 20:56:13', '2025-06-11 20:56:13', 2, 0, 41, 1, 1, 'DUPLEXE A VENDRE', 1, 'duplexe-a-vendre41', 0, 2, 150, '[\"3\",\"6\"]', 0, 3, 2, 1, 2, '2025-06-21', NULL, NULL, NULL),
(29, NULL, 'Rufisque, Sénégal', 1000000, '-17.270929', '14.71554', '{\"1\":{\"Chambres\":\"2\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toillettes\":\"2\"},\"4\":{\"Cuisines\":\"5\"}}', '2025-06-22 18:32:15', '2025-06-22 18:32:15', 2, 0, 42, 1, 1, 'TEST AGENT LO', NULL, 'test-agent-lo42', 0, 1, 220, '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\"]', 1, 2, 2, 1, 5, '2025-06-01', NULL, NULL, NULL),
(30, 'Test  Aguibou jolie appartement a l\'aéroport', 'C.I.C.E.S, Dakar, Sénégal', 300000, '-17.4632496', '14.7437295', '{\"1\":{\"Chambres\":\"2\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toillettes\":\"1\"},\"4\":{\"Cuisines\":\"0\"}}', '2025-06-22 18:42:42', '2025-06-22 18:42:42', 2, 0, 43, 1, 1, 'Test 22 juin Aguibou map', NULL, 'test-22-juin-aguibou-map43', 0, 2, 150, '[\"1\",\"2\",\"3\",\"4\",\"5\",\"7\"]', 1, 2, 1, 1, 0, '2025-06-22', NULL, NULL, NULL),
(31, 'Un grans magasin a vendre a thiaroye sur sud trés accessible', 'Thiaroye sur Mer, Sénégal', 2500000, '-17.384932', '14.7432123', '{\"1\":{\"Chambres\":\"0\"},\"2\":{\"Salons\":\"0\"},\"3\":{\"Toillettes\":\"0\"},\"4\":{\"Cuisines\":\"0\"}}', '2025-06-22 21:14:00', '2025-06-22 21:14:00', 2, 0, 44, 1, 1, 'Magasin', NULL, 'magasin44', 0, 4, 100, '[]', 0, 0, 0, 0, 0, '2025-06-28', NULL, NULL, NULL),
(32, 'Magasin a louer pikine', 'Pikine, Sénégal', 3000000, '-17.3938538', '14.7546523', '{\"1\":{\"Chambres\":\"0\"},\"2\":{\"Salons\":\"0\"},\"3\":{\"Toillettes\":\"0\"},\"4\":{\"Cuisines\":\"0\"}}', '2025-06-22 21:19:34', '2025-06-22 21:19:34', 2, 0, 45, 1, 1, 'Magasin', NULL, 'magasin45', 0, 3, 100, '[]', 0, 0, 0, 0, 0, '2025-06-29', NULL, NULL, NULL),
(33, 'Un trés grand magasin a louer aux parcelles assainies', 'Parcelles Assainies Unité 26, Dakar, Sénégal', 800000, '-17.4521585', '14.753727', '{\"1\":{\"Chambres\":\"0\"},\"2\":{\"Salons\":\"0\"},\"3\":{\"Toillettes\":\"0\"},\"4\":{\"Cuisines\":\"0\"}}', '2025-06-22 21:36:16', '2025-06-22 21:36:16', 2, 0, 46, 1, 1, 'Magasin 2', NULL, 'magasin-246', 0, 4, 150, '[]', 0, 0, 0, 0, 0, '2025-07-04', NULL, NULL, NULL),
(34, 'Duplex haut standing situé au mariste', 'Hann Maristes 1, Dakar, Sénégal', 25000000, '-17.4248027', '14.7354543', '{\"1\":{\"Chambres\":\"2\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toillettes\":\"2\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-06-28 22:54:17', '2025-06-28 22:54:17', 2, 0, 47, 1, 1, 'Duplexe a vendre', NULL, 'duplexe-a-vendre47', 0, 2, 200, '[\"1\",\"2\",\"6\"]', 0, 2, 2, 1, 1, '2025-07-05', NULL, NULL, NULL),
(35, 'Jolie appartmement dakar plateau / mise a jour', 'Colobane, Dakar, Sénégal', 245001, '-17.4455042', '14.6944952', '{\"1\":{\"Chambres\":\"0\"},\"2\":{\"Salons\":\"0\"},\"3\":{\"Toillettes\":\"0\"},\"4\":{\"Cuisines\":\"0\"}}', '2025-07-06 21:04:06', '2025-07-08 00:28:31', 2, 0, 48, 1, 1, 'Maison test - 6 jullet 2025 / Aguibou update', NULL, 'maison-test-6-jullet-2025-aguibou-update-48', 0, 1, 250, '[\"2\",\"3\",\"7\"]', 0, 0, 0, 0, 0, '2025-07-07', 'https://youtu.be/tsx4TUJw5yA?si=7TecQJXY7DymXqW3', 'https://youtu.be/tsx4TUJw5yA?si=7TecQJXY7DymXqW3', NULL),
(37, 'test 2', 'MGRM+94P, Dakar, Sénégal', 150000, '-17.4533548', '14.6845007', '{\"1\":{\"Chambres\":\"1\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toillettes\":\"1\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-07-06 22:46:37', '2025-07-06 22:46:37', 2, 0, 50, 1, 1, 'Maison test 2  - 6 jullet 2025 / Aguibou', NULL, 'maison-test-2-6-jullet-2025-aguibou50', 0, 1, 350, '[\"1\",\"2\",\"5\",\"6\",\"7\"]', 1, 1, 1, 1, 1, '2025-07-07', NULL, NULL, NULL),
(38, 'Super duplex a louer au point E en face de l\'université ISM', '509 Rue de Kaolack, Dakar, Sénégal', 335000, '-17.4602919', '14.6961653', '{\"1\":{\"Chambres\":\"2\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toillettes\":\"2\"},\"4\":{\"Cuisines\":\"2\"}}', '2025-07-07 20:46:02', '2025-07-07 20:46:02', 2, 0, 51, 1, 1, 'Duplex Point E', NULL, 'duplex-point-e51', 0, 2, 200, '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]', 0, 2, 2, 1, 2, '2025-07-21', 'https://www.youtube.com/watch?v=dncQjT-AGmQ', 'https://www.youtube.com/watch?v=VjU5J0Y-TyE', NULL),
(39, 'Test publication a partir de mon profil. - Agent', 'Ouest Foire, Dakar, Sénégal', 560000, '-17.4708861', '14.7506311', '{\"1\":{\"Chambres\":\"3\"},\"2\":{\"Salons\":\"3\"},\"3\":{\"Toillettes\":\"0\"},\"4\":{\"Cuisines\":\"0\"}}', '2025-07-08 00:44:08', '2025-07-08 00:44:08', 2, 0, 52, 1, 1, 'Ouest foire. - Aguibou  - publication profil agent', NULL, 'ouest-foire-aguibou-publication-profil-agent52', 0, 1, 450, '[\"1\",\"5\",\"6\",\"7\"]', 0, 3, 0, 3, 0, '2025-07-08', NULL, NULL, NULL),
(40, 'tEST EN DATE DU 19 JUILLET  pour tester  capcité à publier une annonce profil agent', 'PFRQ+6C, Dakar, Sénégal', 145000, '-17.5120556', '14.7441621', '{\"1\":{\"Chambres\":\"2\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toillettes\":\"1\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-07-09 23:21:45', '2025-07-09 23:21:45', 2, 0, 53, 1, 1, 'Maison test 1  - 9  jullet 2025 / Aguibou', NULL, 'maison-test-1-9-jullet-2025-aguibou53', 0, 2, 150, '[\"1\",\"2\",\"5\",\"6\"]', 0, 2, 1, 1, 1, '2025-07-16', NULL, NULL, NULL),
(41, '<p>Test 1 : pour tester la possibilit&eacute; de publier une annonce a partir du profil agent&nbsp;</p>', 'Ngor Rue NG - 175, Dakar, Sénégal', 132008, '-17.5120556', '14.7441621', '{\"1\":{\"Chambres\":\"0\"},\"2\":{\"Salons\":\"0\"},\"3\":{\"Toillettes\":\"0\"},\"4\":{\"Cuisines\":\"0\"}}', '2025-07-09 23:36:52', '2025-07-09 23:36:52', 2, 0, 54, 2, 1, 'Ouest foire 9 juillet  - Aguibou  - publication profil agent', NULL, 'ouest-foire-9-juillet-aguibou-publication-profil-agent54', 0, 1, 350, '[\"1\",\"4\",\"5\",\"6\",\"7\"]', 0, 0, 0, 0, 0, '2025-07-11', NULL, NULL, NULL),
(42, 'Bel appartement a vendre situé sur la VDN prés du hypermarché exclusif', 'PGQG+GQF, Dakar, Sénégal', 45000000, '-17.4726112', '14.7390301', '{\"1\":{\"Chambres\":\"2\"},\"2\":{\"Salons\":\"1\"},\"3\":{\"Toillettes\":\"2\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-07-10 14:07:14', '2025-07-10 14:07:14', 2, 0, 55, 1, 1, 'teste 10/07/25 Appartement', NULL, 'teste-100725-appartement55', 0, 1, 150, '[\"1\",\"4\",\"5\",\"6\"]', 0, 2, 2, 1, 1, '2025-07-24', 'https://www.youtube.com/shorts/PMRi9bCHsXE', 'https://www.youtube.com/watch?v=DrSnzZS8qrY', NULL),
(43, 'Magasin a louer au niveau de talib boubess pikine', 'PJX5+X75, Pikine, Sénégal', 300000, '-17.3938335', '14.754658', '{\"1\":{\"Chambres\":\"1\"},\"2\":{\"Salons\":\"0\"},\"3\":{\"Toillettes\":\"1\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-07-22 21:34:24', '2025-07-22 21:34:24', 2, 0, 56, 2, 1, 'Magasin a louer', NULL, 'magasin-a-louer56', 0, 4, 200, '[\"1\",\"3\"]', 0, 1, 1, 0, 1, '2025-08-09', 'https://www.youtube.com/watch?v=EC9iDmChTUY', NULL, NULL),
(44, 'Un grand magasin trés accessible au mamelles en location avec un prix trés abordable', 'Mamelles lot numéro 49, TF 451, Dakar, Sénégal', 235000, '-17.4947922', '14.7367386', '{\"1\":{\"Chambres\":\"1\"},\"2\":{\"Salons\":\"0\"},\"3\":{\"Toillettes\":\"1\"},\"4\":{\"Cuisines\":\"1\"}}', '2025-08-01 22:46:33', '2025-08-01 22:46:33', 2, 0, 57, 1, 1, 'Test 3 Magasin a louer', NULL, 'test-3-magasin-a-louer57', 0, 4, 135, '[\"1\",\"3\"]', 0, 1, 1, 0, 1, '2025-08-08', 'https://www.youtube.com/shorts/2yi1D_cVj2I', NULL, NULL),
(45, NULL, 'MGJP+35P, Rue FN 49, Dakar, Sénégal', 1111111111, '-17.4654678', '14.6810097', '{\"1\":{\"Chambres\":\"0\"},\"2\":{\"Salons\":\"0\"},\"3\":{\"Toillettes\":\"0\"},\"4\":{\"Cuisines\":\"0\"}}', '2025-10-31 19:06:39', '2025-10-31 19:06:39', 2, 0, 62, 1, 1, 'DIMA GROUPE', NULL, 'dima-groupe62', 0, 1, 250, '[\"1\",\"2\",\"5\",\"6\",\"7\"]', 1, 0, 0, 0, 0, '2926-05-01', 'https://my.matterport.com/show/?m=C6eoRKMG7ub', 'https://my.matterport.com/show/?m=C6eoRKMG7ub', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `annonce_prices`
--

CREATE TABLE `annonce_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prix` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `annonce_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `biens`
--

CREATE TABLE `biens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `montant` float NOT NULL,
  `superficie` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `lon` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `commune_id` bigint(20) UNSIGNED NOT NULL,
  `type_bien_id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `fournisseur_id` bigint(20) UNSIGNED DEFAULT NULL,
  `proprietaire_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `biens`
--

INSERT INTO `biens` (`id`, `name`, `montant`, `superficie`, `adresse`, `lon`, `lat`, `status`, `created_at`, `updated_at`, `commune_id`, `type_bien_id`, `type_id`, `fournisseur_id`, `proprietaire_id`) VALUES
(1, 'Immeuble', 4000000, '1000', 'HLM CITE DOUANE', '-17.450951', '14.682200', 1, '2025-02-15 12:58:02', '2025-02-15 12:58:02', 1, 4, 2, NULL, NULL),
(2, 'Maison', 750000, '750', 'VDN, en Face Siege Wave', '-16.2513', '15.6780', 1, '2025-02-15 13:06:27', '2025-02-15 13:06:27', 2, 2, 3, NULL, NULL),
(3, 'Villa', 350000, '150', 'Almadies', '-16.450951', '15.6780', 1, '2025-02-15 13:20:36', '2025-02-15 13:20:36', 1, 2, 3, NULL, NULL),
(4, 'Studios', 10000, '4', 'Grand dakar', '-17.650951', '14.612200', 1, '2025-02-15 13:22:42', '2025-02-15 13:22:42', 2, 5, 5, NULL, NULL),
(5, 'TEST 2 - PIKINE', 150000, '150', 'Pikine', '-17.550951', '14.782200', 1, '2025-03-17 22:50:52', '2025-03-17 22:50:52', 2, 3, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `charges`
--

CREATE TABLE `charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `montant` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type_charge_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `prenom`, `adresse`, `telephone`, `status`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'Aguibou', 'Diallo', 'yoff', '78 461 6398', 1, '2024-11-24 21:42:48', '2024-11-24 21:42:48', 15),
(2, 'Diallo', 'Abdullah', 'Ngor', '+221 77 794 67 57', 1, '2024-11-24 21:44:36', '2024-11-24 21:44:36', 16),
(3, 'Abdoulaye DIALLO', 'Abdoulaye DIALLO', 'Ngor-Almadie', '776625059', 1, '2025-01-23 19:55:44', '2025-01-23 19:55:44', 23),
(4, 'sene', 'badou', NULL, NULL, 1, '2025-05-14 20:18:05', '2025-05-14 20:18:05', 24),
(5, 'dakar', 'immo', NULL, NULL, 1, '2025-05-16 22:22:38', '2025-05-16 22:22:38', 25),
(6, 'DIALLO', 'Daouda', NULL, NULL, 1, '2025-05-20 21:47:05', '2025-05-20 21:47:05', 26);

-- --------------------------------------------------------

--
-- Structure de la table `collaborateurs`
--

CREATE TABLE `collaborateurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `genre` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `collaborateurs`
--

INSERT INTO `collaborateurs` (`id`, `nom`, `prenom`, `photo`, `telephone`, `mobile`, `genre`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'DIALLO', 'Daouda', NULL, '+221781923572', '613993799', 0, '2024-09-28 12:18:40', '2025-07-07 18:51:06', 1);

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fournisseur_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `communes`
--

CREATE TABLE `communes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `departement_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `communes`
--

INSERT INTO `communes` (`id`, `name`, `status`, `created_at`, `updated_at`, `departement_id`) VALUES
(1, 'Medina', 1, '2024-10-02 01:04:57', '2024-10-02 01:04:57', 1),
(2, 'Pikine', 1, '2024-10-02 01:06:04', '2024-10-02 01:06:04', 1);

-- --------------------------------------------------------

--
-- Structure de la table `comodites`
--

CREATE TABLE `comodites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1: interieur 0: exterieur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `comodites`
--

INSERT INTO `comodites` (`id`, `name`, `status`, `created_at`, `updated_at`, `type`) VALUES
(1, 'Wifi', 1, NULL, NULL, 1),
(2, 'Lave vaiselle', 1, NULL, NULL, 1),
(3, 'Systeme dalarme', 1, NULL, NULL, 1),
(4, 'Chauffe Eau', 1, NULL, NULL, 1),
(5, 'Climatisation', 1, NULL, NULL, 1),
(6, 'Salle de sport', 1, NULL, NULL, 0),
(7, 'Piscine', 1, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `departements`
--

CREATE TABLE `departements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `departements`
--

INSERT INTO `departements` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Dakar', 1, '2024-09-30 20:47:55', '2024-09-30 20:48:39'),
(2, 'Thies', 1, '2024-09-30 20:51:08', '2024-09-30 20:51:08'),
(3, 'Louga', 1, '2024-09-30 20:56:09', '2024-09-30 20:56:09'),
(4, 'Ziguinchor', 1, '2024-09-30 20:56:17', '2024-09-30 20:56:17'),
(5, 'Touba', 1, '2024-09-30 20:56:25', '2024-09-30 20:56:25'),
(6, 'Tamba', 1, '2024-09-30 20:56:30', '2024-09-30 20:56:30'),
(7, 'Fatick', 1, '2024-09-30 20:56:39', '2024-09-30 20:56:39'),
(8, 'Saint Louis', 1, '2024-09-30 20:56:53', '2024-09-30 20:56:53'),
(9, 'Fouta', 1, '2024-09-30 20:57:11', '2024-09-30 20:57:11'),
(10, 'Kolda', 1, '2024-09-30 20:57:18', '2024-09-30 20:57:18'),
(11, 'Diourbel', 1, '2024-09-30 20:58:30', '2024-09-30 20:58:30'),
(12, 'Velingara', 1, '2024-09-30 20:59:13', '2024-09-30 20:59:13'),
(13, 'Kedougou', 1, '2024-10-01 12:28:10', '2024-10-01 12:28:10'),
(14, 'Kaffrine', 1, '2024-10-01 12:28:14', '2024-10-01 12:28:14');

-- --------------------------------------------------------

--
-- Structure de la table `depenses`
--

CREATE TABLE `depenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `montant` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `charge_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `reglement_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `factures`
--

CREATE TABLE `factures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref` varchar(255) NOT NULL,
  `montant` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `statut_facture_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

CREATE TABLE `fournisseurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `is_agent` tinyint(1) NOT NULL DEFAULT 0,
  `agents` longtext DEFAULT NULL,
  `ouwner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `links` longtext DEFAULT NULL,
  `is_premium` tinyint(1) NOT NULL DEFAULT 0,
  `description` longtext DEFAULT NULL,
  `site` varchar(255) DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `zones` longtext DEFAULT NULL,
  `bio` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id`, `nom`, `prenom`, `adresse`, `telephone`, `status`, `created_at`, `updated_at`, `user_id`, `is_agent`, `agents`, `ouwner_id`, `links`, `is_premium`, `description`, `site`, `experience`, `name`, `zones`, `bio`) VALUES
(1, 'Sow', 'Adama', 'hlm', '777563', 1, '2024-11-02 00:24:16', '2025-07-29 15:20:56', 3, 0, NULL, NULL, NULL, 0, '<p>Le lorem ipsum est, en imprimerie, une suite de mots sans signification utilis&eacute;e &agrave; titre provisoire pour calibrer une mise en page, le texte d&eacute;finitif venant remplacer le faux-texte d&egrave;s qu&#39;il est pr&ecirc;t ou que la mise en page est achev&eacute;e. G&eacute;n&eacute;ralement, on utilise un texte en faux latin, le Lorem ipsum ou Lipsum.</p>', NULL, '36', NULL, '[\"1\",\"2\"]', 'Le lorem ipsum est, en imprimerie, une suite de mots sans signification utilisée à titre provisoire pour calibrer une mise en page, le texte définitif venant remplacer le faux-texte dès qu\'il est prêt ou que la mise en page est achevée. Généralement, on utilise un texte en faux latin, le Lorem ipsum ou Lipsum.'),
(2, 'Diagne', 'Fatoumata', 'diamaguene', '777', 1, '2024-11-02 00:59:28', '2024-11-02 00:59:28', 4, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Diongue', 'Mamadou', 'thies', '777', 1, '2024-11-02 01:00:11', '2024-11-02 01:00:11', 5, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Laye', 'Demba', 'Dakar', '77888', 1, '2024-11-02 01:00:50', '2024-11-02 01:00:50', 6, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Soumare', 'Amina', 'Pikine', '787999', 1, '2024-11-02 01:01:21', '2024-11-02 01:01:21', 7, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Ndiaye', 'Soukeyna', 'Nord Foire', '777', 1, '2024-11-02 01:02:08', '2024-11-02 01:02:08', 8, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'DIALLO', 'DAOUDA 22', 'OUEST FOIRE', '+221781923572', 1, '2024-11-11 22:02:35', '2025-08-02 18:37:54', 9, 0, NULL, NULL, NULL, 1, NULL, NULL, '36', NULL, NULL, NULL),
(8, 'IBRAHIMA DIALLO', 'IBRAHIMA DIALLO', 'vytimosn@gmail.com', '778765643', 1, '2024-11-12 21:29:14', '2024-11-12 21:29:14', 10, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'DIALLO', 'AGUIBOU', 'YOFF', '+221784516398', 1, '2024-11-12 21:43:28', '2025-07-09 23:44:49', 11, 0, NULL, 8, NULL, 0, '<p>Experimenter depus 12 ans dans la vente et localtion de bien immoblir&nbsp;</p>', NULL, NULL, NULL, NULL, NULL),
(10, 'Faye', 'marieme', 'hlm', '768763456', 1, '2024-11-12 23:54:03', '2024-11-12 23:54:03', 12, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'Diallo', 'Abdullah', 'Ngor', '+221 77 794 67 57', 1, '2024-11-16 15:29:48', '2024-11-16 15:29:48', 13, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'Lind', 'John', '678 Delphia Club Suite 367\nVernontown, GA 70613', '248-342-7855', 1, '2024-11-25 19:17:35', '2024-11-25 19:17:35', 17, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'Aguibou', 'Diallo', '5435 Reilly Passage Suite 958South Hillard, DE 24081-7366', '+15149225218', 1, '2024-11-25 19:21:58', '2025-07-06 22:16:12', 18, 0, NULL, NULL, NULL, 0, '<p>test&nbsp;</p>', NULL, '4', NULL, NULL, NULL),
(14, 'Jacobs', 'Ramiro', '81024 Hintz Crossroad Suite 758\nNorth Cydney, AK 00001', '+18704990976', 1, '2024-11-25 19:23:33', '2024-11-25 19:23:33', 19, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'Monahan', 'Paolo', '20769 Kerluke Motorway Apt. 193\nTillmanport, MS 39403-7898', '(938) 629-1349', 1, '2024-11-25 19:24:00', '2024-11-25 19:24:00', 20, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'Lehner', 'Hildegard', '761 Stokes Rue\nWest Rowlandbury, TX 21448-5053', '423-390-9776', 1, '2024-11-25 19:24:34', '2024-11-25 19:24:34', 21, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'Schmidt', 'Shawna', '3732 Gibson Land\nEast Bettyeshire, AR 88559', '(919) 747-5968', 1, '2024-11-25 19:26:02', '2024-11-25 19:26:02', 22, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'NIANG', 'SALIOU', 'NORD FOIRE', '780143508', 1, '2025-08-02 19:05:14', '2025-08-02 19:05:14', 27, 0, NULL, NULL, NULL, 0, NULL, 'www.niangservices.com', '48', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(255) NOT NULL,
  `imageable_id` varchar(255) NOT NULL,
  `imageable_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`id`, `url`, `imageable_id`, `imageable_type`, `created_at`, `updated_at`) VALUES
(1, 'uploads/annonces/FN3rupload.jpg', '1', 'App\\Models\\Annonce', '2025-02-15 13:00:12', '2025-02-15 13:00:12'),
(2, 'uploads/annonces/qMvlupload.jpg', '1', 'App\\Models\\Annonce', '2025-02-15 13:00:12', '2025-02-15 13:00:12'),
(3, 'uploads/annonces/STytupload.jpg', '1', 'App\\Models\\Annonce', '2025-02-15 13:00:12', '2025-02-15 13:00:12'),
(4, 'uploads/annonces/1KCmupload.jpg', '2', 'App\\Models\\Annonce', '2025-02-15 13:01:02', '2025-02-15 13:01:02'),
(5, 'uploads/annonces/vOD3upload.jpg', '2', 'App\\Models\\Annonce', '2025-02-15 13:01:02', '2025-02-15 13:01:02'),
(6, 'uploads/annonces/ufEBupload.jpg', '2', 'App\\Models\\Annonce', '2025-02-15 13:01:02', '2025-02-15 13:01:02'),
(7, 'uploads/annonces/UZ2vupload.jpg', '3', 'App\\Models\\Annonce', '2025-02-15 13:02:02', '2025-02-15 13:02:02'),
(8, 'uploads/annonces/Eluyupload.jpg', '3', 'App\\Models\\Annonce', '2025-02-15 13:02:02', '2025-02-15 13:02:02'),
(9, 'uploads/annonces/rJT0upload.jpg', '3', 'App\\Models\\Annonce', '2025-02-15 13:02:02', '2025-02-15 13:02:02'),
(10, 'uploads/annonces/WyqGupload.jpg', '4', 'App\\Models\\Annonce', '2025-02-15 13:03:12', '2025-02-15 13:03:12'),
(11, 'uploads/annonces/uFEmupload.jpg', '4', 'App\\Models\\Annonce', '2025-02-15 13:03:12', '2025-02-15 13:03:12'),
(12, 'uploads/annonces/uarHupload.jpg', '4', 'App\\Models\\Annonce', '2025-02-15 13:03:12', '2025-02-15 13:03:12'),
(13, 'uploads/annonces/4X8Eupload.jpg', '5', 'App\\Models\\Annonce', '2025-02-15 13:04:14', '2025-02-15 13:04:14'),
(14, 'uploads/annonces/2G1Kupload.jpg', '5', 'App\\Models\\Annonce', '2025-02-15 13:04:14', '2025-02-15 13:04:14'),
(15, 'uploads/annonces/zrztupload.jpg', '5', 'App\\Models\\Annonce', '2025-02-15 13:04:14', '2025-02-15 13:04:14'),
(16, 'uploads/annonces/mVNcupload.jpg', '6', 'App\\Models\\Annonce', '2025-02-15 13:07:45', '2025-02-15 13:07:45'),
(17, 'uploads/annonces/JTegupload.jpg', '6', 'App\\Models\\Annonce', '2025-02-15 13:07:45', '2025-02-15 13:07:45'),
(18, 'uploads/annonces/6xG4upload.jpg', '6', 'App\\Models\\Annonce', '2025-02-15 13:07:45', '2025-02-15 13:07:45'),
(19, 'uploads/annonces/U6keupload.jpg', '7', 'App\\Models\\Annonce', '2025-02-15 13:25:18', '2025-02-15 13:25:18'),
(20, 'uploads/annonces/A0XGupload.jpg', '7', 'App\\Models\\Annonce', '2025-02-15 13:25:18', '2025-02-15 13:25:18'),
(21, 'uploads/annonces/gtp6upload.jpg', '7', 'App\\Models\\Annonce', '2025-02-15 13:25:18', '2025-02-15 13:25:18'),
(22, 'uploads/annonces/poI0upload.jpg', '8', 'App\\Models\\Annonce', '2025-02-15 13:29:47', '2025-02-15 13:29:47'),
(23, 'uploads/annonces/nzkpupload.jpg', '8', 'App\\Models\\Annonce', '2025-02-15 13:29:47', '2025-02-15 13:29:47'),
(24, 'uploads/annonces/0OSmupload.jpg', '8', 'App\\Models\\Annonce', '2025-02-15 13:29:47', '2025-02-15 13:29:47'),
(25, 'uploads/annonces/YLNdupload.jpg', '9', 'App\\Models\\Annonce', '2025-02-15 14:06:34', '2025-02-15 14:06:34'),
(26, 'uploads/annonces/AQR7upload.jpg', '9', 'App\\Models\\Annonce', '2025-02-15 14:06:34', '2025-02-15 14:06:34'),
(27, 'uploads/annonces/NnBbupload.jpg', '9', 'App\\Models\\Annonce', '2025-02-15 14:06:34', '2025-02-15 14:06:34'),
(28, 'uploads/annonces/Anscupload.png', '10', 'App\\Models\\Annonce', '2025-03-18 23:04:06', '2025-03-18 23:04:06'),
(29, 'uploads/annonces/dngTupload.png', '10', 'App\\Models\\Annonce', '2025-03-18 23:04:06', '2025-03-18 23:04:06'),
(30, 'uploads/annonces/0QSuupload.png', '11', 'App\\Models\\Annonce', '2025-03-18 23:06:14', '2025-03-18 23:06:14'),
(31, 'uploads/annonces/5djFupload.jpg', '12', 'App\\Models\\Annonce', '2025-04-12 20:38:59', '2025-04-12 20:38:59'),
(32, 'uploads/annonces/FxLfupload.png', '13', 'App\\Models\\Annonce', '2025-04-16 17:58:42', '2025-04-16 17:58:42'),
(33, 'uploads/annonces/61Quupload.png', '14', 'App\\Models\\Annonce', '2025-04-16 18:16:59', '2025-04-16 18:16:59'),
(34, 'uploads/annonces/ABTIupload.jpg', '15', 'App\\Models\\Annonce', '2025-05-08 22:23:04', '2025-05-08 22:23:04'),
(35, 'uploads/annonces/GuIgupload.jpg', '15', 'App\\Models\\Annonce', '2025-05-08 22:23:04', '2025-05-08 22:23:04'),
(36, 'uploads/annonces/Rmfdupload.jpg', '16', 'App\\Models\\Annonce', '2025-05-10 18:15:33', '2025-05-10 18:15:33'),
(37, 'uploads/annonces/2fhgupload.jpg', '16', 'App\\Models\\Annonce', '2025-05-10 18:15:33', '2025-05-10 18:15:33'),
(38, 'uploads/annonces/0OBBupload.jpg', '16', 'App\\Models\\Annonce', '2025-05-10 18:15:33', '2025-05-10 18:15:33'),
(39, 'uploads/annonces/7W9Hupload.jpg', '16', 'App\\Models\\Annonce', '2025-05-10 18:15:33', '2025-05-10 18:15:33'),
(40, 'uploads/annonces/WBxsupload.jpg', '17', 'App\\Models\\Annonce', '2025-05-10 18:19:13', '2025-05-10 18:19:13'),
(41, 'uploads/annonces/7MyHupload.jpg', '17', 'App\\Models\\Annonce', '2025-05-10 18:19:13', '2025-05-10 18:19:13'),
(42, 'uploads/annonces/FyB9upload.jpg', '17', 'App\\Models\\Annonce', '2025-05-10 18:19:13', '2025-05-10 18:19:13'),
(43, 'uploads/annonces/CqgAupload.jpg', '17', 'App\\Models\\Annonce', '2025-05-10 18:19:13', '2025-05-10 18:19:13'),
(44, 'uploads/annonces/wHOCupload.png', '18', 'App\\Models\\Annonce', '2025-05-10 19:20:30', '2025-05-10 19:20:30'),
(45, 'uploads/annonces/85GQupload.png', '18', 'App\\Models\\Annonce', '2025-05-10 19:20:32', '2025-05-10 19:20:32'),
(46, 'uploads/annonces/iXCKupload.png', '18', 'App\\Models\\Annonce', '2025-05-10 19:20:32', '2025-05-10 19:20:32'),
(47, 'uploads/annonces/0UBNupload.png', '18', 'App\\Models\\Annonce', '2025-05-10 19:20:32', '2025-05-10 19:20:32'),
(48, 'uploads/profils/Myzbupload.jpg', '8', 'App\\Models\\User', '2025-05-10 19:26:08', '2025-05-10 19:26:08'),
(49, 'uploads/annonces/Inwoupload.jpg', '19', 'App\\Models\\Annonce', '2025-05-10 19:40:45', '2025-05-10 19:40:45'),
(50, 'uploads/annonces/MykGupload.jpg', '19', 'App\\Models\\Annonce', '2025-05-10 19:40:45', '2025-05-10 19:40:45'),
(51, 'uploads/annonces/SIG0upload.jpg', '20', 'App\\Models\\Annonce', '2025-05-10 19:55:34', '2025-05-10 19:55:34'),
(52, 'uploads/annonces/fFlNupload.jpg', '20', 'App\\Models\\Annonce', '2025-05-10 19:55:34', '2025-05-10 19:55:34'),
(53, 'uploads/annonces/FGdhupload.jpg', '20', 'App\\Models\\Annonce', '2025-05-10 19:55:34', '2025-05-10 19:55:34'),
(54, 'uploads/annonces/Fvbsupload.jpg', '20', 'App\\Models\\Annonce', '2025-05-10 19:55:34', '2025-05-10 19:55:34'),
(55, 'uploads/annonces/LS81upload.jpg', '20', 'App\\Models\\Annonce', '2025-05-10 19:55:34', '2025-05-10 19:55:34'),
(56, 'uploads/annonces/P034upload.jpg', '20', 'App\\Models\\Annonce', '2025-05-10 19:55:34', '2025-05-10 19:55:34'),
(57, 'uploads/annonces/jNogupload.jpg', '20', 'App\\Models\\Annonce', '2025-05-10 19:55:34', '2025-05-10 19:55:34'),
(58, 'uploads/annonces/3T3Qupload.jpg', '21', 'App\\Models\\Annonce', '2025-05-10 23:25:12', '2025-05-10 23:25:12'),
(59, 'uploads/annonces/22sNupload.png', '22', 'App\\Models\\Annonce', '2025-05-11 18:18:53', '2025-05-11 18:18:53'),
(60, 'uploads/annonces/sA2yupload.png', '23', 'App\\Models\\Annonce', '2025-05-11 18:22:56', '2025-05-11 18:22:56'),
(61, 'uploads/annonces/4C7oupload.jpg', '24', 'App\\Models\\Annonce', '2025-05-16 22:29:16', '2025-05-16 22:29:16'),
(62, 'uploads/annonces/L9diupload.jpg', '24', 'App\\Models\\Annonce', '2025-05-16 22:29:16', '2025-05-16 22:29:16'),
(63, 'uploads/annonces/9ZIGupload.jpg', '24', 'App\\Models\\Annonce', '2025-05-16 22:29:16', '2025-05-16 22:29:16'),
(64, 'uploads/annonces/28uNupload.jpg', '24', 'App\\Models\\Annonce', '2025-05-16 22:29:16', '2025-05-16 22:29:16'),
(65, 'uploads/annonces/D26Zupload.jpg', '25', 'App\\Models\\Annonce', '2025-05-17 19:30:12', '2025-05-17 19:30:12'),
(66, 'uploads/annonces/3j8oupload.jpg', '25', 'App\\Models\\Annonce', '2025-05-17 19:30:12', '2025-05-17 19:30:12'),
(67, 'uploads/annonces/Mj0Zupload.jpg', '25', 'App\\Models\\Annonce', '2025-05-17 19:30:12', '2025-05-17 19:30:12'),
(68, 'uploads/annonces/xKlDupload.jpg', '25', 'App\\Models\\Annonce', '2025-05-17 19:30:12', '2025-05-17 19:30:12'),
(69, 'uploads/annonces/SkgGupload.png', '26', 'App\\Models\\Annonce', '2025-05-20 21:50:11', '2025-05-20 21:50:11'),
(70, 'uploads/annonces/O4aYupload.jpg', '26', 'App\\Models\\Annonce', '2025-05-20 21:50:11', '2025-05-20 21:50:11'),
(71, 'uploads/annonces/0F2yupload.png', '26', 'App\\Models\\Annonce', '2025-05-20 21:50:11', '2025-05-20 21:50:11'),
(72, 'uploads/annonces/8XMmupload.jpg', '26', 'App\\Models\\Annonce', '2025-05-20 21:50:11', '2025-05-20 21:50:11'),
(73, 'uploads/annonces/RQhXupload.png', '28', 'App\\Models\\Annonce', '2025-06-11 20:56:13', '2025-06-11 20:56:13'),
(74, 'uploads/annonces/REnMupload.jpg', '28', 'App\\Models\\Annonce', '2025-06-11 20:56:13', '2025-06-11 20:56:13'),
(75, 'uploads/annonces/utldupload.jpg', '28', 'App\\Models\\Annonce', '2025-06-11 20:56:13', '2025-06-11 20:56:13'),
(76, 'uploads/annonces/CmMcupload.png', '28', 'App\\Models\\Annonce', '2025-06-11 20:56:13', '2025-06-11 20:56:13'),
(77, 'uploads/annonces/G64Jupload.png', '28', 'App\\Models\\Annonce', '2025-06-11 20:56:13', '2025-06-11 20:56:13'),
(78, 'uploads/annonces/c4gnupload.png', '28', 'App\\Models\\Annonce', '2025-06-11 20:56:13', '2025-06-11 20:56:13'),
(79, 'uploads/annonces/L2iRupload.jpg', '29', 'App\\Models\\Annonce', '2025-06-22 18:32:15', '2025-06-22 18:32:15'),
(80, 'uploads/annonces/TeIoupload.jpg', '29', 'App\\Models\\Annonce', '2025-06-22 18:32:15', '2025-06-22 18:32:15'),
(81, 'uploads/annonces/PJaYupload.jpg', '29', 'App\\Models\\Annonce', '2025-06-22 18:32:15', '2025-06-22 18:32:15'),
(82, 'uploads/annonces/ljO9upload.png', '30', 'App\\Models\\Annonce', '2025-06-22 18:42:42', '2025-06-22 18:42:42'),
(83, 'uploads/annonces/EDWgupload.jpg', '31', 'App\\Models\\Annonce', '2025-06-22 21:14:00', '2025-06-22 21:14:00'),
(84, 'uploads/annonces/uuKcupload.jpg', '31', 'App\\Models\\Annonce', '2025-06-22 21:14:00', '2025-06-22 21:14:00'),
(85, 'uploads/annonces/BSMQupload.png', '32', 'App\\Models\\Annonce', '2025-06-22 21:19:34', '2025-06-22 21:19:34'),
(86, 'uploads/annonces/eQT9upload.png', '32', 'App\\Models\\Annonce', '2025-06-22 21:19:34', '2025-06-22 21:19:34'),
(87, 'uploads/annonces/iwyZupload.png', '32', 'App\\Models\\Annonce', '2025-06-22 21:19:34', '2025-06-22 21:19:34'),
(88, 'uploads/profils/wmiwupload.png', '1', 'App\\Models\\User', '2025-06-22 21:24:18', '2025-08-02 18:37:54'),
(89, 'uploads/annonces/Tprbupload.jpg', '33', 'App\\Models\\Annonce', '2025-06-22 21:36:16', '2025-06-22 21:36:16'),
(90, 'uploads/annonces/fgeLupload.jpg', '33', 'App\\Models\\Annonce', '2025-06-22 21:36:16', '2025-06-22 21:36:16'),
(91, 'uploads/annonces/Pmblupload.jpg', '34', 'App\\Models\\Annonce', '2025-06-28 22:54:17', '2025-06-28 22:54:17'),
(92, 'uploads/annonces/IuiUupload.png', '34', 'App\\Models\\Annonce', '2025-06-28 22:54:17', '2025-06-28 22:54:17'),
(93, 'uploads/annonces/SqJxupload.png', '2', 'App\\Models\\Annonce', '2025-06-29 21:24:14', '2025-06-29 21:24:14'),
(94, 'uploads/annonces/efQYupload.png', '2', 'App\\Models\\Annonce', '2025-06-29 21:24:14', '2025-06-29 21:24:14'),
(96, 'uploads/annonces/bDOrupload.png', '37', 'App\\Models\\Annonce', '2025-07-06 22:46:37', '2025-07-06 22:46:37'),
(97, 'uploads/annonces/rDk3upload.png', '38', 'App\\Models\\Annonce', '2025-07-07 20:46:02', '2025-07-07 20:46:02'),
(98, 'uploads/annonces/MRrvupload.png', '38', 'App\\Models\\Annonce', '2025-07-07 20:46:02', '2025-07-07 20:46:02'),
(99, 'uploads/annonces/fhPKupload.jpg', '38', 'App\\Models\\Annonce', '2025-07-07 20:46:02', '2025-07-07 20:46:02'),
(100, 'uploads/annonces/UYnFupload.png', '35', 'App\\Models\\Annonce', '2025-07-08 00:23:32', '2025-07-08 00:23:32'),
(101, 'uploads/annonces/V7K8upload.png', '35', 'App\\Models\\Annonce', '2025-07-08 00:28:31', '2025-07-08 00:28:31'),
(102, 'uploads/annonces/Q3Tqupload.png', '39', 'App\\Models\\Annonce', '2025-07-08 00:44:08', '2025-07-08 00:44:08'),
(103, 'uploads/annonces/tI73upload.png', '40', 'App\\Models\\Annonce', '2025-07-09 23:21:45', '2025-07-09 23:21:45'),
(104, 'uploads/annonces/nlAbupload.png', '41', 'App\\Models\\Annonce', '2025-07-09 23:36:52', '2025-07-09 23:36:52'),
(105, 'uploads/annonces/qDH8upload.jpg', '42', 'App\\Models\\Annonce', '2025-07-10 14:07:14', '2025-07-10 14:07:14'),
(106, 'uploads/annonces/fNLvupload.jpg', '42', 'App\\Models\\Annonce', '2025-07-10 14:07:14', '2025-07-10 14:07:14'),
(107, 'uploads/annonces/2GVnupload.jpg', '42', 'App\\Models\\Annonce', '2025-07-10 14:07:14', '2025-07-10 14:07:14'),
(108, 'uploads/annonces/gGhmupload.jpg', '42', 'App\\Models\\Annonce', '2025-07-10 14:07:14', '2025-07-10 14:07:14'),
(109, 'uploads/annonces/v1Wlupload.jpg', '42', 'App\\Models\\Annonce', '2025-07-10 14:07:14', '2025-07-10 14:07:14'),
(110, 'uploads/annonces/HGcsupload.jpg', '42', 'App\\Models\\Annonce', '2025-07-10 14:07:14', '2025-07-10 14:07:14'),
(111, 'uploads/annonces/uJkBupload.jpg', '42', 'App\\Models\\Annonce', '2025-07-10 14:07:14', '2025-07-10 14:07:14'),
(112, 'uploads/annonces/wmVWupload.jpg', '43', 'App\\Models\\Annonce', '2025-07-22 21:34:24', '2025-07-22 21:34:24'),
(113, 'uploads/profils/iWIPupload.jpg', '3', 'App\\Models\\User', '2025-07-29 15:23:37', '2025-07-29 15:23:37'),
(114, 'uploads/annonces/BIkLupload.jpg', '44', 'App\\Models\\Annonce', '2025-08-01 22:46:33', '2025-08-01 22:46:33'),
(115, 'uploads/annonces/fCcJupload.jpg', '45', 'App\\Models\\Annonce', '2025-10-31 19:06:39', '2025-10-31 19:06:39'),
(116, 'uploads/annonces/QMYrupload.jpg', '45', 'App\\Models\\Annonce', '2025-10-31 19:06:39', '2025-10-31 19:06:39'),
(117, 'uploads/annonces/pNoDupload.jpg', '45', 'App\\Models\\Annonce', '2025-10-31 19:06:39', '2025-10-31 19:06:39'),
(118, 'uploads/annonces/SPICupload.jpg', '45', 'App\\Models\\Annonce', '2025-10-31 19:06:39', '2025-10-31 19:06:39'),
(119, 'uploads/annonces/eoq7upload.jpg', '45', 'App\\Models\\Annonce', '2025-10-31 19:06:39', '2025-10-31 19:06:39'),
(120, 'uploads/annonces/KpI4upload.jpg', '45', 'App\\Models\\Annonce', '2025-10-31 19:06:39', '2025-10-31 19:06:39'),
(121, 'uploads/annonces/CeLtupload.jpg', '45', 'App\\Models\\Annonce', '2025-10-31 19:06:39', '2025-10-31 19:06:39'),
(122, 'uploads/annonces/uZjMupload.jpg', '45', 'App\\Models\\Annonce', '2025-10-31 19:06:39', '2025-10-31 19:06:39'),
(123, 'uploads/annonces/7TjPupload.jpg', '45', 'App\\Models\\Annonce', '2025-10-31 19:06:39', '2025-10-31 19:06:39');

-- --------------------------------------------------------

--
-- Structure de la table `immos`
--

CREATE TABLE `immos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supercie` varchar(255) DEFAULT NULL,
  `montant` float DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bien_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type_immo_id` bigint(20) UNSIGNED NOT NULL,
  `level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `fournisseur_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `pieces` longtext DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type_location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `commune_id` bigint(20) UNSIGNED DEFAULT NULL,
  `departement_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `immos`
--

INSERT INTO `immos` (`id`, `supercie`, `montant`, `description`, `created_at`, `updated_at`, `bien_id`, `type_immo_id`, `level_id`, `fournisseur_id`, `status`, `pieces`, `name`, `type_location_id`, `agent_id`, `commune_id`, `departement_id`) VALUES
(1, '150', 750000, NULL, '2025-02-15 13:00:12', '2025-02-15 13:00:12', 1, 1, 1, 2, 1, NULL, 'Appartement lux', 2, NULL, NULL, NULL),
(2, '0', 250000, NULL, '2025-02-15 13:01:02', '2025-06-29 21:24:14', 1, 1, 1, 7, 1, NULL, 'Appartement modification annonce', NULL, NULL, NULL, NULL),
(3, '100', 15000, NULL, '2025-02-15 13:02:02', '2025-02-15 13:02:02', 1, 1, 1, 2, 1, NULL, 'Appartement Normal', 1, NULL, NULL, NULL),
(4, '150', 300000, NULL, '2025-02-15 13:03:12', '2025-02-15 13:03:12', 1, 2, 2, 3, 1, NULL, 'Duplex 2', 1, NULL, NULL, NULL),
(5, '100', 150000, NULL, '2025-02-15 13:04:14', '2025-02-15 13:04:14', 1, 1, 3, 2, 1, NULL, 'studio', 1, NULL, NULL, NULL),
(6, '150', 450000, NULL, '2025-02-15 13:07:45', '2025-02-15 13:07:45', 2, 3, 11, 3, 1, NULL, 'Villa', 1, NULL, NULL, NULL),
(7, '10', 10000, NULL, '2025-02-15 13:25:18', '2025-02-15 13:25:18', 4, 5, 11, 11, 1, NULL, 'Studio', 2, NULL, NULL, NULL),
(8, '150', 175000, NULL, '2025-02-15 13:29:47', '2025-02-15 13:29:47', 1, 1, 2, 9, 1, NULL, 'App Luxous', 2, NULL, NULL, NULL),
(9, '200', 375000, NULL, '2025-02-15 14:06:34', '2025-02-15 14:06:34', 2, 3, 2, 2, 1, NULL, 'Villa', 2, NULL, NULL, NULL),
(21, NULL, 150000, NULL, '2025-03-18 23:04:06', '2025-03-18 23:04:06', 1, 1, 1, 12, 1, NULL, 'Villa 221', 2, NULL, NULL, NULL),
(22, NULL, 150000, NULL, '2025-03-18 23:06:14', '2025-03-18 23:06:14', 5, 1, 1, 2, 1, NULL, 'TEST 2 ANNONCE', 1, NULL, NULL, NULL),
(23, '150', 710000, NULL, '2025-04-12 20:38:59', '2025-04-12 20:38:59', NULL, 1, 1, 1, 1, NULL, 'studio', 2, NULL, NULL, NULL),
(24, '140', 200000, NULL, '2025-04-16 17:58:42', '2025-04-16 17:58:42', NULL, 1, 1, NULL, 1, NULL, 'Duplex. - test Aguibou', 1, NULL, NULL, NULL),
(25, '150', 150000, NULL, '2025-04-16 18:16:59', '2025-04-16 18:16:59', NULL, 1, 2, NULL, 1, NULL, 'Test 2 Aguibou', 1, NULL, NULL, NULL),
(26, '130', 130000, NULL, '2025-05-08 22:23:04', '2025-05-08 22:23:04', NULL, 1, 1, 1, 1, NULL, 'Test', 1, NULL, NULL, NULL),
(27, '220', 250000, NULL, '2025-05-10 18:15:33', '2025-05-10 18:15:33', NULL, 1, 1, NULL, 1, NULL, 'test lo', 1, NULL, NULL, NULL),
(28, '2000', 1000000, NULL, '2025-05-10 18:19:13', '2025-05-10 18:19:13', NULL, 1, 2, NULL, 1, NULL, 'test pour daouda', 1, NULL, NULL, NULL),
(29, '150', 25000, NULL, '2025-05-10 19:20:30', '2025-05-10 19:20:30', NULL, 1, 1, NULL, 1, NULL, 'TESTE APPARTE 10/5', 2, NULL, NULL, NULL),
(30, '220', 1000000, NULL, '2025-05-10 19:40:45', '2025-05-10 19:40:45', NULL, 2, 1, 1, 1, NULL, 'TEST AGENT LO', 1, NULL, NULL, NULL),
(31, '155', 35000, NULL, '2025-05-10 19:55:34', '2025-05-10 19:55:34', NULL, 1, 6, NULL, 1, NULL, 'APPARTEMENT MEUBLE SICAP F', 2, NULL, NULL, NULL),
(32, '165', 435000, NULL, '2025-05-10 23:25:12', '2025-05-10 23:25:12', NULL, 1, 1, NULL, 1, NULL, 'TESTE APPARTEMENT 10/5/25', 2, NULL, NULL, NULL),
(33, '150', 150000, NULL, '2025-05-11 18:18:53', '2025-05-11 18:18:53', NULL, 2, 1, NULL, 1, NULL, 'Test Abidjan', 2, NULL, NULL, NULL),
(34, '150', 200000, NULL, '2025-05-11 18:22:56', '2025-05-11 18:22:56', NULL, 2, 1, NULL, 1, NULL, 'Test Abidjan', 2, NULL, NULL, NULL),
(35, '230', 50000000, NULL, '2025-05-16 22:29:16', '2025-05-16 22:29:16', NULL, 1, 1, NULL, 1, NULL, 'TESTE APPARTE 15/5', 1, NULL, NULL, NULL),
(36, '235', 650000, NULL, '2025-05-17 19:30:12', '2025-05-17 19:30:12', NULL, 1, 4, NULL, 1, NULL, 'Appartement haut standing', 2, NULL, NULL, NULL),
(37, '155', 235000, NULL, '2025-05-20 21:50:11', '2025-05-20 21:50:11', NULL, 2, 3, NULL, 1, NULL, 'TESTE APPARTE 20/5', 2, NULL, NULL, NULL),
(40, '200', 400000, NULL, '2025-05-28 21:13:19', '2025-05-28 21:13:19', NULL, 1, 1, NULL, 1, NULL, 'Test  - AGuibou  - 28 mai', 2, NULL, NULL, NULL),
(41, '150', 25000000, NULL, '2025-06-11 20:56:13', '2025-06-11 20:56:13', NULL, 2, 1, NULL, 1, NULL, 'DUPLEXE A VENDRE', 1, NULL, NULL, NULL),
(42, '220', 1000000, NULL, '2025-06-22 18:32:15', '2025-06-22 18:32:15', NULL, 1, 1, 1, 1, NULL, 'TEST AGENT LO', NULL, NULL, NULL, NULL),
(43, '150', 300000, NULL, '2025-06-22 18:42:42', '2025-06-22 18:42:42', NULL, 2, 1, NULL, 1, NULL, 'Test 22 juin Aguibou map', NULL, NULL, NULL, NULL),
(44, '100', 2500000, NULL, '2025-06-22 21:14:00', '2025-06-22 21:14:00', NULL, 4, 11, NULL, 1, NULL, 'Magasin', NULL, NULL, NULL, NULL),
(45, '100', 3000000, NULL, '2025-06-22 21:19:34', '2025-06-22 21:19:34', NULL, 3, 11, NULL, 1, NULL, 'Magasin', NULL, NULL, NULL, NULL),
(46, '150', 800000, NULL, '2025-06-22 21:36:16', '2025-06-22 21:36:16', NULL, 4, 11, NULL, 1, NULL, 'Magasin 2', NULL, NULL, NULL, NULL),
(47, '200', 25000000, NULL, '2025-06-28 22:54:17', '2025-06-28 22:54:17', NULL, 2, 11, NULL, 1, NULL, 'Duplexe a vendre', NULL, NULL, NULL, NULL),
(48, '250', 245001, NULL, '2025-07-06 21:04:06', '2025-07-08 00:23:32', NULL, 1, 1, NULL, 1, NULL, 'Maison test - 6 jullet 2025 / Aguibou update', NULL, NULL, NULL, NULL),
(50, '350', 150000, NULL, '2025-07-06 22:46:37', '2025-07-06 22:46:37', NULL, 1, 1, NULL, 1, NULL, 'Maison test 2  - 6 jullet 2025 / Aguibou', NULL, NULL, NULL, NULL),
(51, '200', 335000, NULL, '2025-07-07 20:46:02', '2025-07-07 20:46:02', NULL, 2, 11, NULL, 1, NULL, 'Duplex Point E', NULL, NULL, NULL, NULL),
(52, '450', 560000, NULL, '2025-07-08 00:44:08', '2025-07-08 00:44:08', NULL, 1, 2, 9, 1, NULL, 'Ouest foire. - Aguibou  - publication profil agent', NULL, NULL, NULL, NULL),
(53, '150', 145000, NULL, '2025-07-09 23:21:45', '2025-07-09 23:21:45', NULL, 2, 1, 9, 1, NULL, 'Maison test 1  - 9  jullet 2025 / Aguibou', NULL, NULL, NULL, NULL),
(54, '350', 132008, NULL, '2025-07-09 23:36:52', '2025-07-09 23:36:52', NULL, 1, 2, 9, 1, NULL, 'Ouest foire 9 juillet  - Aguibou  - publication profil agent', NULL, NULL, NULL, NULL),
(55, '150', 45000000, NULL, '2025-07-10 14:07:14', '2025-07-10 14:07:14', NULL, 1, 1, NULL, 1, NULL, 'teste 10/07/25 Appartement', NULL, NULL, NULL, NULL),
(56, '200', 300000, NULL, '2025-07-22 21:34:24', '2025-07-22 21:34:24', NULL, 4, 11, NULL, 1, NULL, 'Magasin a louer', NULL, NULL, NULL, NULL),
(57, '135', 235000, NULL, '2025-08-01 22:46:33', '2025-08-01 22:46:33', NULL, 4, 11, NULL, 1, NULL, 'Test 3 Magasin a louer', NULL, NULL, NULL, NULL),
(62, '250', 1111110000, NULL, '2025-10-31 19:06:39', '2025-10-31 19:06:39', NULL, 1, 1, NULL, 1, NULL, 'DIMA GROUPE', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `levels`
--

CREATE TABLE `levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `levels`
--

INSERT INTO `levels` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, '1ere etage', 1, NULL, NULL),
(2, '2ieme etage', 1, NULL, NULL),
(3, '3ieme etage', 1, NULL, NULL),
(4, '4ieme etage', 1, NULL, NULL),
(5, '5ieme etage', 1, NULL, NULL),
(6, '6ieme etage', 1, NULL, NULL),
(7, '7ieme etage', 1, NULL, NULL),
(8, '8ieme etage', 1, NULL, NULL),
(9, '9ieme etage', 1, NULL, NULL),
(10, '10ieme etage', 1, NULL, NULL),
(11, 'ré de chaussée', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `line_factures`
--

CREATE TABLE `line_factures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `montant` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `immo_id` bigint(20) UNSIGNED NOT NULL,
  `facture_id` bigint(20) UNSIGNED NOT NULL,
  `reglement_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date_entree` date DEFAULT NULL,
  `date_sortie` date DEFAULT NULL,
  `caution` double(8,2) DEFAULT NULL,
  `bien_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `type_immo_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2020_08_04_162636_create_collaborateurs_table', 1),
(6, '2022_03_30_154153_create_profils_table', 1),
(7, '2022_03_30_154414_create_roles_table', 1),
(8, '2023_01_11_105048_create_type_actions_table', 1),
(9, '2023_01_11_105049_create_actions_table', 1),
(10, '2023_02_16_235007_create_reglements_table', 1),
(11, '2023_06_16_201936_create_jobs_table', 1),
(12, '2023_08_31_003727_create_clients_table', 1),
(13, '2023_08_31_003727_create_fournisseurs_table', 1),
(14, '2023_09_02_234433_create_statut_factures_table', 1),
(15, '2023_09_26_153155_create_table_levels', 1),
(16, '2023_11_09_153732_create_type_biens_table', 1),
(17, '2023_11_09_153732_create_type_charges_table', 1),
(18, '2023_11_09_153732_create_type_immos_table', 1),
(19, '2023_11_09_153743_create_charges_table', 1),
(20, '2023_11_09_153806_create_depenses_table', 1),
(21, '2024_08_26_153605_create_table_proprietaires', 1),
(22, '2024_09_02_234446_create_factures_table', 1),
(23, '2024_09_26_152456_create_table_departements', 1),
(24, '2024_09_26_152532_create_table_communes', 1),
(25, '2024_09_26_153306_create_table_types', 1),
(26, '2024_09_26_153415_create_biens_table', 1),
(27, '2024_09_26_160120_create_type_locations_table', 1),
(28, '2024_09_26_160156_create_type_contrats', 1),
(29, '2024_09_26_160258_create_locations_table', 1),
(30, '2024_09_26_164532_create_immos_table', 1),
(31, '2024_09_26_234501_create_line_factures_table', 1),
(32, '2024_10_04_120504_create_pieces_table', 2),
(33, '2024_10_04_130001_create_statut_annonces_table', 2),
(34, '2024_10_04_145737_add_statuts_immos_to_table_immos', 2),
(35, '2024_10_04_145937_create_annonces_table', 2),
(36, '2024_10_04_150749_create_annonce_prices_table', 2),
(37, '2024_10_05_120019_create_images_table', 2),
(38, '2024_10_05_122512_add_elts_immos_to_table_immos', 2),
(39, '2024_10_10_115251_add_type_locations_to_annonces', 3),
(40, '2024_10_16_131846_add_elts_to_fournisseurs', 4),
(41, '2024_10_24_234318_add_agent_id_to_immos', 5),
(42, '2024_10_25_064927_add_agents_to_fournisseurs', 6),
(43, '2024_11_02_122306_add_slug_to_annonces', 7),
(44, '2024_11_11_231521_add_is_premium_to_fournisseurs', 8),
(45, '2024_11_13_184623_add_communes_to_immos', 9),
(46, '2024_11_15_205504_add_premium_to_annonces', 10),
(47, '2024_11_25_204924_add_type_immos_to_annonces', 11),
(48, '2025_02_15_135632_add_is_verify_to_annonces', 12),
(49, '2025_02_26_220915_create_table_comodites', 13),
(50, '2025_02_26_222113_create_comodites_table', 14),
(51, '2025_03_13_104352_add_comodites_to_annonces', 15),
(52, '2025_03_14_155858_add_elts_to_annonces', 15),
(53, '2025_03_14_221806_create_specialisations_table', 16),
(54, '2025_03_14_221954_create_agent_specialisations_table', 16),
(55, '2025_03_23_125600_add_type_comodites', 17),
(56, '2025_03_23_125830_add_date_disponibilite_annonces', 17),
(57, '2025_04_02_213515_add_elts_to_agents', 18),
(58, '2025_04_22_160609_add_infos_to_fournisseurs', 19),
(59, '2025_06_29_123546_add_url_video_to_annonces', 20),
(60, '2025_07_26_130855_create_commentaires_table', 21),
(61, '2025_07_26_140635_add_fournisseur_id_to_annonces', 21),
(62, '2025_07_27_201319_add_bio_to_fournisseurs', 22);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('aguibou.diallo91@gmail.com', '$2y$10$g6GDWH8COSm6eG../vKLWuoUa1aX246g7BX5sQ0RC1xGacKxq.IsC', '2025-05-11 19:34:02'),
('aguibou.diallo90@gmail.com', '$2y$10$Mx211f9ghOayMAQ8YTYg7Om92FLBng6jY7lXxEfK3/OfYgXd3lT7m', '2025-05-11 19:39:40');

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pieces`
--

CREATE TABLE `pieces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `pieces`
--

INSERT INTO `pieces` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Chambres', 1, NULL, NULL),
(2, 'Salons', 1, NULL, NULL),
(3, 'Toillettes', 1, NULL, NULL),
(4, 'Cuisines', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `profils`
--

CREATE TABLE `profils` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `statut` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `profils`
--

INSERT INTO `profils` (`id`, `name`, `description`, `statut`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, 1, NULL, NULL),
(2, 'fournisseur', NULL, 1, NULL, NULL),
(3, 'client', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `proprietaires`
--

CREATE TABLE `proprietaires` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reglements`
--

CREATE TABLE `reglements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `profil_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `status`, `user_id`, `profil_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, NULL),
(2, 1, 3, 2, '2024-11-02 00:24:16', '2024-11-02 00:24:16'),
(3, 1, 4, 2, '2024-11-02 00:59:28', '2024-11-02 00:59:28'),
(4, 1, 5, 2, '2024-11-02 01:00:11', '2024-11-02 01:00:11'),
(5, 1, 6, 2, '2024-11-02 01:00:50', '2024-11-02 01:00:50'),
(6, 1, 7, 2, '2024-11-02 01:01:21', '2024-11-02 01:01:21'),
(7, 1, 8, 2, '2024-11-02 01:02:08', '2024-11-02 01:02:08'),
(8, 1, 9, 2, '2024-11-11 22:02:35', '2024-11-11 22:02:35'),
(9, 1, 10, 2, '2024-11-12 21:29:14', '2024-11-12 21:29:14'),
(10, 1, 11, 2, '2024-11-12 21:43:28', '2024-11-12 21:43:28'),
(11, 1, 12, 2, '2024-11-12 23:54:03', '2024-11-12 23:54:03'),
(12, 1, 13, 2, '2024-11-16 15:29:48', '2024-11-16 15:29:48'),
(13, 1, 15, 3, '2024-11-24 21:42:48', '2024-11-24 21:42:48'),
(14, 1, 16, 3, '2024-11-24 21:44:36', '2024-11-24 21:44:36'),
(15, 1, 17, 2, '2024-11-25 19:17:56', '2024-11-25 19:17:56'),
(16, 1, 18, 2, '2024-11-25 19:22:12', '2024-11-25 19:22:12'),
(17, 1, 19, 2, '2024-11-25 19:23:54', '2024-11-25 19:23:54'),
(18, 1, 20, 2, '2024-11-25 19:24:13', '2024-11-25 19:24:13'),
(19, 1, 21, 2, '2024-11-25 19:25:38', '2024-11-25 19:25:38'),
(20, 1, 22, 2, '2024-11-25 19:26:23', '2024-11-25 19:26:23'),
(21, 1, 23, 3, '2025-01-23 19:55:44', '2025-01-23 19:55:44'),
(22, 1, 24, 3, '2025-05-14 20:18:05', '2025-05-14 20:18:05'),
(23, 1, 25, 3, '2025-05-16 22:22:38', '2025-05-16 22:22:38'),
(24, 1, 26, 3, '2025-05-20 21:47:05', '2025-05-20 21:47:05'),
(25, 1, 27, 2, '2025-08-02 19:05:14', '2025-08-02 19:05:14');

-- --------------------------------------------------------

--
-- Structure de la table `specialisations`
--

CREATE TABLE `specialisations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `specialisations`
--

INSERT INTO `specialisations` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Agent Achat', 0, NULL, NULL),
(2, 'Co propietaire', 0, NULL, NULL),
(3, 'Agent Vente', 0, NULL, NULL),
(4, 'Investissement ', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `statut_annonces`
--

CREATE TABLE `statut_annonces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `statut_factures`
--

CREATE TABLE `statut_factures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `table_comodites`
--

CREATE TABLE `table_comodites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `types`
--

CREATE TABLE `types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `types`
--

INSERT INTO `types` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Residence', 1, '2024-09-29 13:35:12', '2024-09-29 13:35:12'),
(2, 'Immeuble', 1, '2024-09-29 13:37:44', '2024-09-29 13:37:44'),
(3, 'Maison', 1, '2024-09-29 13:37:48', '2024-09-29 13:37:48'),
(4, 'Appartements', 1, '2024-09-29 13:37:54', '2024-09-29 13:37:54'),
(5, 'Studios', 1, '2024-09-30 20:45:16', '2024-10-11 14:53:41');

-- --------------------------------------------------------

--
-- Structure de la table `type_actions`
--

CREATE TABLE `type_actions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type_biens`
--

CREATE TABLE `type_biens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `type_biens`
--

INSERT INTO `type_biens` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'F2', 1, '2024-09-29 13:45:48', '2024-09-29 13:45:48'),
(2, 'F3', 1, '2024-09-29 13:46:05', '2024-09-29 13:46:05'),
(3, 'F4', 1, '2024-09-29 13:46:09', '2024-09-29 13:55:48'),
(4, 'F5', 1, '2024-09-29 13:46:21', '2024-09-29 13:46:21'),
(5, 'Studios', 1, '2024-09-29 13:46:27', '2024-09-29 13:46:27');

-- --------------------------------------------------------

--
-- Structure de la table `type_charges`
--

CREATE TABLE `type_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type_contrats`
--

CREATE TABLE `type_contrats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type_immos`
--

CREATE TABLE `type_immos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `type_immos`
--

INSERT INTO `type_immos` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Appartements', 1, '2024-09-30 00:50:29', '2024-09-30 00:50:29'),
(2, 'Duplex', 1, '2024-09-30 00:51:04', '2024-09-30 00:51:04'),
(3, 'Maisons', 1, '2024-09-30 00:51:18', '2024-09-30 00:51:18'),
(4, 'Magasins', 1, '2024-09-30 00:51:23', '2024-09-30 00:51:23'),
(5, 'Bureaux', 1, '2024-09-30 00:51:37', '2024-09-30 00:51:37'),
(6, 'Studio', 1, '2025-05-12 12:30:25', '2025-05-12 12:30:25');

-- --------------------------------------------------------

--
-- Structure de la table `type_locations`
--

CREATE TABLE `type_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL COMMENT 'bailleur',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `type_locations`
--

INSERT INTO `type_locations` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'A vendre', 1, '2024-09-30 15:19:50', '2024-09-30 15:19:50'),
(2, 'A louer', 1, '2024-09-30 15:20:01', '2024-09-30 15:20:01');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `date_expiration_token` timestamp NULL DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `code`, `token`, `date_expiration_token`, `email`, `is_admin`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, 'admin@test.com', 0, 1, '2024-09-28 12:18:40', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0gHMyi9SOxWPJu9dtIxfOV52K1IKX9NFj1wA06QgdPu8X4FuTP8U7GNK5SJB', '2024-09-28 12:18:40', '2024-09-28 12:18:40'),
(3, NULL, NULL, NULL, NULL, 'adama@test.com', 0, 1, NULL, '$2y$10$fsh40xLiSHPjoV7ytdtrqePzPb1yXLfPSyzVYOvb6fnmkiXcGmBBa', NULL, '2024-11-02 00:24:16', '2024-11-02 00:24:16'),
(4, NULL, NULL, NULL, NULL, 'fatou@gmail.com', 0, 1, NULL, '$2y$10$nKcbWtgt5yjrxYChDyYDuep6AqokYKgIaRDZbkietAW.semXZw7UG', NULL, '2024-11-02 00:59:28', '2024-11-02 00:59:28'),
(5, NULL, NULL, NULL, NULL, 'modou@gmail.com', 0, 1, NULL, '$2y$10$jbQ1ccs3gl6zt4jU.ToZl./9DY.0FMKYSNOeOcwPvau5pT3f832wK', NULL, '2024-11-02 01:00:11', '2024-11-02 01:00:11'),
(6, NULL, NULL, NULL, NULL, 'demba@gmail.com', 0, 1, NULL, '$2y$10$BVAd5PDXoj1vq/kHhxbmSuVIPAASqtSXcJtq8urkYYmTUck/fWR0G', NULL, '2024-11-02 01:00:50', '2024-11-02 01:00:50'),
(7, NULL, NULL, NULL, NULL, 'mya@gmail.com', 0, 1, NULL, '$2y$10$Uj/MBjbjJJZCISoyepbhheHkidDzu5eKfAqyMo/lo5Q0Nc/H7xVRq', NULL, '2024-11-02 01:01:21', '2024-11-02 01:01:21'),
(8, NULL, NULL, NULL, NULL, 'souka@hotmail.com', 0, 1, NULL, '$2y$10$On199teWLN5rnvSsLDBZMuvqB6zlbgB6J08KRGAkO9RSRCknQ41bS', NULL, '2024-11-02 01:02:08', '2024-11-02 01:02:08'),
(9, NULL, NULL, NULL, NULL, 'daouda.fiscaliste17@gmail.com', 0, 1, NULL, '$2y$10$Km9TpnOEdbc2SgjS0iCzluwRv9aJVUp9Rt/SwOz71iQvCLPoZNnWq', 'kdm4AK1LxEguzHdByyiCNhhM2xsjztT0Xx0hNyYRfgOsYksARSq9XJGrDpZD', '2024-11-11 22:02:35', '2024-11-11 22:02:35'),
(10, NULL, NULL, NULL, NULL, 'vytimosn@gmail.com', 0, 1, NULL, '$2y$10$jKk3wxG9yMWBbjPaPa5JFucLQ3ilBzMbRRtX9tBcEwabIY6vz.mom', 'ebpDOmMTwE24uLGi6d4D33rkjWb5YAIbJ7W7fsr13tQae0Ab4ozjemUSp3g1', '2024-11-12 21:29:14', '2024-11-12 21:29:14'),
(11, NULL, NULL, NULL, NULL, 'aguibou.diallo90@gmail.com', 0, 1, NULL, '$2y$10$PjPTGqz0XBnkBRmg25OopuQBj9Rbho1J52EfuWdA6Xhd2K7EEPzhi', NULL, '2024-11-12 21:43:28', '2024-11-12 21:43:28'),
(12, NULL, NULL, NULL, NULL, 'rima@test.com', 0, 1, NULL, '$2y$10$eypFqZL.t.njztkZ91OOseR85eg4WIqT.5DcGLc49Vg.Te/Rx0qT6', NULL, '2024-11-12 23:54:03', '2024-11-12 23:54:03'),
(13, NULL, NULL, NULL, NULL, 'diabdullah112@gmail.com', 0, 1, NULL, '$2y$10$RE1Xbcb6lRBd8S8byqEFjO3LYY4jxYBoVZNszeHGxdobQbfq4eLJa', NULL, '2024-11-16 15:29:48', '2024-11-16 15:29:48'),
(14, NULL, NULL, NULL, NULL, 'diabdullah113@gmail.com', 0, 1, NULL, '$2y$10$4kKIdPPbwZdtyzVyfD6dK.58Akkc312EyVnkmLDo4yM747mS3gZHS', NULL, '2024-11-16 15:32:48', '2024-11-16 15:32:48'),
(15, NULL, NULL, NULL, NULL, 'aguibou.diallo91@gmail.com', 0, 1, NULL, '$2y$10$TZaQGkmEszmb7Lh.i5Bs8OhkaY5JaZ/8jqsIB4ddEJXp6U1MR1aHS', NULL, '2024-11-24 21:42:48', '2024-11-24 21:42:48'),
(16, NULL, NULL, NULL, NULL, 'diabdullah118@gmail.com', 0, 1, NULL, '$2y$10$HAZ4qiOgY5btmVpXwFB8V.IzNvMBj/E8wetmQ.8qpYTOmy23WNrnK', NULL, '2024-11-24 21:44:36', '2024-11-24 21:44:36'),
(17, NULL, NULL, NULL, NULL, 'fannie34@example.org', 0, 1, '2024-11-25 19:17:35', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'HG8AW8o8UA', '2024-11-25 19:17:35', '2024-11-25 19:17:35'),
(18, NULL, NULL, NULL, NULL, 'greenfelder.marilie@example.com', 0, 1, '2024-11-25 19:21:58', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '6X2qeCSYdc', '2024-11-25 19:21:58', '2024-11-25 19:21:58'),
(19, NULL, NULL, NULL, NULL, 'cthiel@example.com', 1, 1, '2024-11-25 19:23:33', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'aKze37UEu8', '2024-11-25 19:23:33', '2024-11-25 19:23:33'),
(20, NULL, NULL, NULL, NULL, 'murray.amely@example.com', 1, 1, '2024-11-25 19:24:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2gnN4xNkNC', '2024-11-25 19:24:00', '2024-11-25 19:24:00'),
(21, NULL, NULL, NULL, NULL, 'trinity29@example.org', 0, 1, '2024-11-25 19:24:34', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'VNWU48wIgh', '2024-11-25 19:24:34', '2024-11-25 19:24:34'),
(22, NULL, NULL, NULL, NULL, 'cormier.millie@example.org', 1, 1, '2024-11-25 19:26:02', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'FEAa16Xsid', '2024-11-25 19:26:02', '2024-11-25 19:26:02'),
(23, NULL, NULL, NULL, NULL, 'diabdullah114@gmail.com', 0, 1, NULL, '$2y$10$c2JM9smEPhYs6SS99o4i/OJtfmFbdoK2cQA7n5o8NgueXprR8l34G', 'DMcBomNFmnTfGIUpW9hx0aJWNXtzOOhJj5YiqUE6z1RfvbjU63uDMT16JIsn', '2025-01-23 19:55:44', '2025-01-23 19:55:44'),
(24, NULL, NULL, NULL, NULL, 'abnsndoye@gmail.com', 0, 1, NULL, '$2y$10$aP5nK7a8gcYzeX6ED6oW5.g3JOQtfK62Wn.swh39c9w0KnRsNjEqi', NULL, '2025-05-14 20:18:05', '2025-05-14 20:18:05'),
(25, NULL, NULL, NULL, NULL, 'dakarimmo7@gmail.com', 0, 1, NULL, '$2y$10$MR3LhlsvRqiUP./l6U.GuuV559FTEy0M2FS8R8LxYGlSRtrqskmUO', NULL, '2025-05-16 22:22:38', '2025-05-16 22:22:38'),
(26, NULL, NULL, NULL, NULL, 'daoudafiscaliste9@gmail.com', 0, 1, NULL, '$2y$10$Z4IO1A7F7MvHXo1eV7B1u.vnAELWnarWtqDH7ujJzE7vT/mTMSN/S', NULL, '2025-05-20 21:47:05', '2025-05-20 21:47:05'),
(27, NULL, NULL, NULL, NULL, 'niangcourtierfoire@gmail.com', 0, 1, NULL, '$2y$10$usImrnn8Zf935hbUrjnGIOlGf/cpKkQnZDTe.D0A5jvl2lWD/nAHG', NULL, '2025-08-02 19:05:14', '2025-08-02 19:05:14');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actions_type_action_id_foreign` (`type_action_id`),
  ADD KEY `actions_user_id_foreign` (`user_id`);

--
-- Index pour la table `agent_specialisations`
--
ALTER TABLE `agent_specialisations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_specialisations_fournisseur_id_foreign` (`fournisseur_id`),
  ADD KEY `agent_specialisations_specialisation_id_foreign` (`specialisation_id`);

--
-- Index pour la table `annonces`
--
ALTER TABLE `annonces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `annonces_immo_id_foreign` (`immo_id`),
  ADD KEY `annonces_commune_id_foreign` (`commune_id`),
  ADD KEY `annonces_departement_id_foreign` (`departement_id`),
  ADD KEY `annonces_type_location_id_foreign` (`type_location_id`);

--
-- Index pour la table `annonce_prices`
--
ALTER TABLE `annonce_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `annonce_prices_annonce_id_foreign` (`annonce_id`);

--
-- Index pour la table `biens`
--
ALTER TABLE `biens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `biens_proprietaire_id_foreign` (`proprietaire_id`),
  ADD KEY `biens_fournisseur_id_foreign` (`fournisseur_id`),
  ADD KEY `biens_commune_id_foreign` (`commune_id`),
  ADD KEY `biens_type_bien_id_foreign` (`type_bien_id`),
  ADD KEY `biens_type_id_foreign` (`type_id`);

--
-- Index pour la table `charges`
--
ALTER TABLE `charges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `charges_type_charge_id_foreign` (`type_charge_id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clients_user_id_foreign` (`user_id`);

--
-- Index pour la table `collaborateurs`
--
ALTER TABLE `collaborateurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collaborateurs_user_id_foreign` (`user_id`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commentaires_fournisseur_id_foreign` (`fournisseur_id`);

--
-- Index pour la table `communes`
--
ALTER TABLE `communes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `communes_departement_id_foreign` (`departement_id`);

--
-- Index pour la table `comodites`
--
ALTER TABLE `comodites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `departements`
--
ALTER TABLE `departements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `depenses`
--
ALTER TABLE `depenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depenses_reglement_id_foreign` (`reglement_id`),
  ADD KEY `depenses_charge_id_foreign` (`charge_id`),
  ADD KEY `depenses_user_id_foreign` (`user_id`);

--
-- Index pour la table `factures`
--
ALTER TABLE `factures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `factures_ref_unique` (`ref`),
  ADD KEY `factures_client_id_foreign` (`client_id`),
  ADD KEY `factures_statut_facture_id_foreign` (`statut_facture_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fournisseurs_user_id_foreign` (`user_id`),
  ADD KEY `fournisseurs_ouwner_id_foreign` (`ouwner_id`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `immos`
--
ALTER TABLE `immos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `immos_fournisseur_id_foreign` (`fournisseur_id`),
  ADD KEY `immos_bien_id_foreign` (`bien_id`),
  ADD KEY `immos_type_immo_id_foreign` (`type_immo_id`),
  ADD KEY `immos_level_id_foreign` (`level_id`),
  ADD KEY `immos_type_location_id_foreign` (`type_location_id`),
  ADD KEY `immos_agent_id_foreign` (`agent_id`),
  ADD KEY `immos_departement_id_foreign` (`departement_id`),
  ADD KEY `immos_commune_id_foreign` (`commune_id`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `line_factures`
--
ALTER TABLE `line_factures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `line_factures_client_id_foreign` (`client_id`),
  ADD KEY `line_factures_immo_id_foreign` (`immo_id`),
  ADD KEY `line_factures_facture_id_foreign` (`facture_id`),
  ADD KEY `line_factures_reglement_id_foreign` (`reglement_id`);

--
-- Index pour la table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `locations_bien_id_foreign` (`bien_id`),
  ADD KEY `locations_client_id_foreign` (`client_id`),
  ADD KEY `locations_type_immo_id_foreign` (`type_immo_id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `pieces`
--
ALTER TABLE `pieces`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `profils`
--
ALTER TABLE `profils`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `proprietaires`
--
ALTER TABLE `proprietaires`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reglements`
--
ALTER TABLE `reglements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roles_user_id_foreign` (`user_id`),
  ADD KEY `roles_profil_id_foreign` (`profil_id`);

--
-- Index pour la table `specialisations`
--
ALTER TABLE `specialisations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `statut_annonces`
--
ALTER TABLE `statut_annonces`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `statut_factures`
--
ALTER TABLE `statut_factures`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `table_comodites`
--
ALTER TABLE `table_comodites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_actions`
--
ALTER TABLE `type_actions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_biens`
--
ALTER TABLE `type_biens`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_charges`
--
ALTER TABLE `type_charges`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_contrats`
--
ALTER TABLE `type_contrats`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_immos`
--
ALTER TABLE `type_immos`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_locations`
--
ALTER TABLE `type_locations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `actions`
--
ALTER TABLE `actions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `agent_specialisations`
--
ALTER TABLE `agent_specialisations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `annonces`
--
ALTER TABLE `annonces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `annonce_prices`
--
ALTER TABLE `annonce_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `biens`
--
ALTER TABLE `biens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `charges`
--
ALTER TABLE `charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `collaborateurs`
--
ALTER TABLE `collaborateurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `communes`
--
ALTER TABLE `communes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `comodites`
--
ALTER TABLE `comodites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `departements`
--
ALTER TABLE `departements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `depenses`
--
ALTER TABLE `depenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `factures`
--
ALTER TABLE `factures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT pour la table `immos`
--
ALTER TABLE `immos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `line_factures`
--
ALTER TABLE `line_factures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pieces`
--
ALTER TABLE `pieces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `profils`
--
ALTER TABLE `profils`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `proprietaires`
--
ALTER TABLE `proprietaires`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reglements`
--
ALTER TABLE `reglements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `specialisations`
--
ALTER TABLE `specialisations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `statut_annonces`
--
ALTER TABLE `statut_annonces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `statut_factures`
--
ALTER TABLE `statut_factures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `table_comodites`
--
ALTER TABLE `table_comodites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `types`
--
ALTER TABLE `types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `type_actions`
--
ALTER TABLE `type_actions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type_biens`
--
ALTER TABLE `type_biens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `type_charges`
--
ALTER TABLE `type_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type_contrats`
--
ALTER TABLE `type_contrats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type_immos`
--
ALTER TABLE `type_immos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `type_locations`
--
ALTER TABLE `type_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `actions`
--
ALTER TABLE `actions`
  ADD CONSTRAINT `actions_type_action_id_foreign` FOREIGN KEY (`type_action_id`) REFERENCES `type_actions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `actions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `agent_specialisations`
--
ALTER TABLE `agent_specialisations`
  ADD CONSTRAINT `agent_specialisations_fournisseur_id_foreign` FOREIGN KEY (`fournisseur_id`) REFERENCES `fournisseurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `agent_specialisations_specialisation_id_foreign` FOREIGN KEY (`specialisation_id`) REFERENCES `specialisations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `annonces`
--
ALTER TABLE `annonces`
  ADD CONSTRAINT `annonces_commune_id_foreign` FOREIGN KEY (`commune_id`) REFERENCES `communes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `annonces_departement_id_foreign` FOREIGN KEY (`departement_id`) REFERENCES `departements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `annonces_immo_id_foreign` FOREIGN KEY (`immo_id`) REFERENCES `immos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `annonces_type_location_id_foreign` FOREIGN KEY (`type_location_id`) REFERENCES `type_locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `annonce_prices`
--
ALTER TABLE `annonce_prices`
  ADD CONSTRAINT `annonce_prices_annonce_id_foreign` FOREIGN KEY (`annonce_id`) REFERENCES `annonces` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `biens`
--
ALTER TABLE `biens`
  ADD CONSTRAINT `biens_commune_id_foreign` FOREIGN KEY (`commune_id`) REFERENCES `communes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `biens_fournisseur_id_foreign` FOREIGN KEY (`fournisseur_id`) REFERENCES `fournisseurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `biens_proprietaire_id_foreign` FOREIGN KEY (`proprietaire_id`) REFERENCES `proprietaires` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `biens_type_bien_id_foreign` FOREIGN KEY (`type_bien_id`) REFERENCES `type_biens` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `biens_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `charges`
--
ALTER TABLE `charges`
  ADD CONSTRAINT `charges_type_charge_id_foreign` FOREIGN KEY (`type_charge_id`) REFERENCES `type_charges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `collaborateurs`
--
ALTER TABLE `collaborateurs`
  ADD CONSTRAINT `collaborateurs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_fournisseur_id_foreign` FOREIGN KEY (`fournisseur_id`) REFERENCES `fournisseurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `communes`
--
ALTER TABLE `communes`
  ADD CONSTRAINT `communes_departement_id_foreign` FOREIGN KEY (`departement_id`) REFERENCES `departements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `depenses`
--
ALTER TABLE `depenses`
  ADD CONSTRAINT `depenses_charge_id_foreign` FOREIGN KEY (`charge_id`) REFERENCES `charges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `depenses_reglement_id_foreign` FOREIGN KEY (`reglement_id`) REFERENCES `reglements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `depenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `factures`
--
ALTER TABLE `factures`
  ADD CONSTRAINT `factures_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `factures_statut_facture_id_foreign` FOREIGN KEY (`statut_facture_id`) REFERENCES `statut_factures` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD CONSTRAINT `fournisseurs_ouwner_id_foreign` FOREIGN KEY (`ouwner_id`) REFERENCES `fournisseurs` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fournisseurs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `immos`
--
ALTER TABLE `immos`
  ADD CONSTRAINT `immos_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `fournisseurs` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `immos_bien_id_foreign` FOREIGN KEY (`bien_id`) REFERENCES `biens` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `immos_commune_id_foreign` FOREIGN KEY (`commune_id`) REFERENCES `communes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `immos_departement_id_foreign` FOREIGN KEY (`departement_id`) REFERENCES `departements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `immos_fournisseur_id_foreign` FOREIGN KEY (`fournisseur_id`) REFERENCES `fournisseurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `immos_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `immos_type_immo_id_foreign` FOREIGN KEY (`type_immo_id`) REFERENCES `type_biens` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `immos_type_location_id_foreign` FOREIGN KEY (`type_location_id`) REFERENCES `type_locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `line_factures`
--
ALTER TABLE `line_factures`
  ADD CONSTRAINT `line_factures_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `line_factures_facture_id_foreign` FOREIGN KEY (`facture_id`) REFERENCES `factures` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `line_factures_immo_id_foreign` FOREIGN KEY (`immo_id`) REFERENCES `immos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `line_factures_reglement_id_foreign` FOREIGN KEY (`reglement_id`) REFERENCES `reglements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_bien_id_foreign` FOREIGN KEY (`bien_id`) REFERENCES `biens` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `locations_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `locations_type_immo_id_foreign` FOREIGN KEY (`type_immo_id`) REFERENCES `type_immos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_profil_id_foreign` FOREIGN KEY (`profil_id`) REFERENCES `profils` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
