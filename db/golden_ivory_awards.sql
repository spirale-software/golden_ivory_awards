-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 01 Novembre 2016 à 13:21
-- Version du serveur :  10.1.16-MariaDB
-- Version de PHP :  7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `golden_ivory_awards`
--

-- --------------------------------------------------------

--
-- Structure de la table `t_categorie`
--

CREATE TABLE `t_categorie` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `photoID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `t_nomine`
--

CREATE TABLE `t_nomine` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `descriptif` text NOT NULL,
  `actualite` text NOT NULL,
  `categorieID` int(11) NOT NULL,
  `photoID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `t_photo`
--

CREATE TABLE `t_photo` (
  `id` int(11) NOT NULL,
  `id_photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `t_prix`
--

CREATE TABLE `t_prix` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `descriptif` varchar(255) NOT NULL,
  `gagnantID` int(11) DEFAULT NULL,
  `photoID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `t_utilisateur`
--

CREATE TABLE `t_utilisateur` (
  `id` int(11) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `role` enum('ROLE_USR','ROLE_ADMIN','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `t_vote`
--

CREATE TABLE `t_vote` (
  `id` int(11) NOT NULL,
  `nomineID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `t_categorie`
--
ALTER TABLE `t_categorie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photoID` (`photoID`);

--
-- Index pour la table `t_nomine`
--
ALTER TABLE `t_nomine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorieID` (`categorieID`),
  ADD KEY `photoID` (`photoID`);

--
-- Index pour la table `t_photo`
--
ALTER TABLE `t_photo`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_prix`
--
ALTER TABLE `t_prix`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gagnantID` (`gagnantID`),
  ADD KEY `photoID` (`photoID`);

--
-- Index pour la table `t_utilisateur`
--
ALTER TABLE `t_utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_vote`
--
ALTER TABLE `t_vote`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nomine_vote` (`nomineID`),
  ADD KEY `utilisateur_vote` (`userID`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `t_categorie`
--
ALTER TABLE `t_categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `t_nomine`
--
ALTER TABLE `t_nomine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `t_photo`
--
ALTER TABLE `t_photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `t_prix`
--
ALTER TABLE `t_prix`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `t_utilisateur`
--
ALTER TABLE `t_utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `t_vote`
--
ALTER TABLE `t_vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `t_nomine`
--
ALTER TABLE `t_nomine`
  ADD CONSTRAINT `t_nomine_ibfk_1` FOREIGN KEY (`categorieID`) REFERENCES `t_categorie` (`id`),
  ADD CONSTRAINT `t_nomine_ibfk_2` FOREIGN KEY (`photoID`) REFERENCES `t_photo` (`id`);

--
-- Contraintes pour la table `t_prix`
--
ALTER TABLE `t_prix`
  ADD CONSTRAINT `t_prix_ibfk_1` FOREIGN KEY (`gagnantID`) REFERENCES `t_nomine` (`id`),
  ADD CONSTRAINT `t_prix_ibfk_2` FOREIGN KEY (`photoID`) REFERENCES `t_photo` (`id`);

--
-- Contraintes pour la table `t_vote`
--
ALTER TABLE `t_vote`
  ADD CONSTRAINT `t_vote_ibfk_1` FOREIGN KEY (`nomineID`) REFERENCES `t_nomine` (`id`),
  ADD CONSTRAINT `t_vote_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `t_utilisateur` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
