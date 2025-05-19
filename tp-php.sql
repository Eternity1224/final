-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 09 mai 2025 à 07:34
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
-- Base de données : `tp-php`
--

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `id_etu` int(11) NOT NULL,
  `Nom` varchar(20) NOT NULL,
  `Prenom` varchar(25) NOT NULL,
  `Matricule` varchar(60) NOT NULL,
  `Filiere` varchar(200) NOT NULL,
  `Classe` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`id_etu`, `Nom`, `Prenom`, `Matricule`, `Filiere`, `Classe`) VALUES
(1, 'ASSAH', 'Blind', '202501E', 'IRT\r\n', 'L1IRT'),
(2, 'ADJIWA', 'Kevin', '202502E', 'IRT', 'L1IRT'),
(3, 'DAOUDA', 'Wadji', '202503E', 'IRT', 'L1IRT'),
(4, 'TOGBE', 'Godwil', '202504E', 'IRT', 'L1IRT'),
(5, 'MENSOSOU', 'Judicieux', '202505E', 'IRT', 'L1IRT'),
(6, 'OGOUDJOBI', 'Eren', '202506E', 'IRT', 'L1IRT'),
(7, 'DJISOSJO', 'Benito', '202507E', 'IRT', 'L1IRT'),
(8, 'ABIKOU', 'Clemence', '202508E', 'IRT', 'L1IRT'),
(9, 'ZANODJO', 'Emmanuella', '202509E', 'IRT', 'L1IRT'),
(10, 'ZIZOU', 'Stella', '202510E', 'IRT', 'L1IRT');

-- --------------------------------------------------------

--
-- Structure de la table `matiere`
--

CREATE TABLE `matiere` (
  `id_matiere` int(11) NOT NULL,
  `nom_matiere` varchar(60) NOT NULL,
  `coef` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `matiere`
--

INSERT INTO `matiere` (`id_matiere`, `nom_matiere`, `coef`) VALUES
(1, 'Algorithme de Base', 3),
(2, 'Langage C', 2),
(3, 'Maths Discret', 2),
(4, 'Comptabilité Générale', 2),
(5, 'Economie et Management', 2),
(6, 'PHP/MysqL', 2),
(7, 'HTML/CSS/JS', 2),
(8, 'Structure de données', 3);

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `id_note` int(11) NOT NULL,
  `mat_etu` int(15) NOT NULL,
  `id_matiere` int(6) NOT NULL,
  `valeur_note` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`id_etu`);

--
-- Index pour la table `matiere`
--
ALTER TABLE `matiere`
  ADD PRIMARY KEY (`id_matiere`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id_note`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `etudiant`
--
ALTER TABLE `etudiant`
  MODIFY `id_etu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202502;

--
-- AUTO_INCREMENT pour la table `matiere`
--
ALTER TABLE `matiere`
  MODIFY `id_matiere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `note`
--
ALTER TABLE `note`
  MODIFY `id_note` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
