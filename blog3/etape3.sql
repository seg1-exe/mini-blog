-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 25 nov. 2025 à 14:04
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(10) UNSIGNED NOT NULL,
  `auteur` varchar(50) DEFAULT NULL,
  `titre` varchar(150) NOT NULL,
  `texte` mediumtext NOT NULL,
  `date` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `auteur`, `titre`, `texte`, `date`) VALUES
(3, 'Arthur', 'Jul est-il visionnaire ?', 'Oui vous avez bien lu, Jul est visionnaire.', 1763745769),
(4, 'Arthur le faux', 'J\'aime pas Jul', 'j\'préfère diams', 1763745802),
(5, 'PasArthur', 'Ceci n\'est pas le titre', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Id vitae quod cumque, ullam obcaecati in amet a aliquam quos quo quidem atque, voluptatum quis culpa repellendus sequi nobis corporis tempore.\r\nLorem ipsum dolor sit amet consectetur adipisicing elit. Id vitae quod cumque, ullam obcaecati in amet a aliquam quos quo quidem atque, voluptatum quis culpa repellendus sequi nobis corporis tempore.\r\nLorem ipsum dolor sit amet consectetur adipisicing elit. Id vitae quod cumque, ullam obcaecati in amet a aliquam quos quo quidem atque, voluptatum quis culpa repellendus sequi nobis corporis tempore.\r\n', 1763748555);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
