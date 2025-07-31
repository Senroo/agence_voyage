-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 31 juil. 2025 à 19:28
-- Version du serveur : 5.7.17
-- Version de PHP : 8.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `agence_voyage`
--

-- --------------------------------------------------------

--
-- Structure de la table `certification_avis`
--

CREATE TABLE `certification_avis` (
  `avisID` int(11) NOT NULL,
  `avis` text NOT NULL,
  `voyageID` int(11) NOT NULL,
  `clientID` int(11) NOT NULL,
  `toID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `certification_avis`
--

INSERT INTO `certification_avis` (`avisID`, `avis`, `voyageID`, `clientID`, `toID`) VALUES
(1, 'avis 1', 1, 1, 1),
(2, 'avis 2', 2, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `certification_client`
--

CREATE TABLE `certification_client` (
  `clientID` int(11) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `toID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `certification_client`
--

INSERT INTO `certification_client` (`clientID`, `prenom`, `nom`, `email`, `toID`) VALUES
(1, 'prénom 1', 'nom 1', 'email1@mail.com', 1),
(2, 'prénom 2', 'nom 2', 'email2@mail.com', 1),
(3, 'John', 'Doe', 'John.Doe@gmail.com', 1);

-- --------------------------------------------------------

--
-- Structure de la table `certification_touroperator`
--

CREATE TABLE `certification_touroperator` (
  `toID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `certification_touroperator`
--

INSERT INTO `certification_touroperator` (`toID`, `name`) VALUES
(1, 'tour operator 1');

-- --------------------------------------------------------

--
-- Structure de la table `certification_voyage`
--

CREATE TABLE `certification_voyage` (
  `voyageID` int(11) NOT NULL,
  `titre` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `toID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `certification_voyage`
--

INSERT INTO `certification_voyage` (`voyageID`, `titre`, `description`, `toID`) VALUES
(1, 'voyage 1', 'description du voyage 1', 1),
(2, 'voyage 2', 'description du voyage 2', 1),
(3, 'teste', 'Description du voyage', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `certification_avis`
--
ALTER TABLE `certification_avis`
  ADD PRIMARY KEY (`avisID`),
  ADD KEY `voyageID` (`voyageID`),
  ADD KEY `clientID` (`clientID`),
  ADD KEY `toID` (`toID`);

--
-- Index pour la table `certification_client`
--
ALTER TABLE `certification_client`
  ADD PRIMARY KEY (`clientID`),
  ADD KEY `toID` (`toID`);

--
-- Index pour la table `certification_touroperator`
--
ALTER TABLE `certification_touroperator`
  ADD PRIMARY KEY (`toID`);

--
-- Index pour la table `certification_voyage`
--
ALTER TABLE `certification_voyage`
  ADD PRIMARY KEY (`voyageID`),
  ADD KEY `toID` (`toID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `certification_avis`
--
ALTER TABLE `certification_avis`
  MODIFY `avisID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `certification_client`
--
ALTER TABLE `certification_client`
  MODIFY `clientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `certification_touroperator`
--
ALTER TABLE `certification_touroperator`
  MODIFY `toID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `certification_voyage`
--
ALTER TABLE `certification_voyage`
  MODIFY `voyageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `certification_avis`
--
ALTER TABLE `certification_avis`
  ADD CONSTRAINT `certification_avis_ibfk_1` FOREIGN KEY (`voyageID`) REFERENCES `certification_voyage` (`voyageID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `certification_avis_ibfk_2` FOREIGN KEY (`clientID`) REFERENCES `certification_client` (`clientID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `certification_avis_ibfk_3` FOREIGN KEY (`toID`) REFERENCES `certification_touroperator` (`toID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `certification_client`
--
ALTER TABLE `certification_client`
  ADD CONSTRAINT `certification_client_ibfk_1` FOREIGN KEY (`toID`) REFERENCES `certification_touroperator` (`toID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `certification_voyage`
--
ALTER TABLE `certification_voyage`
  ADD CONSTRAINT `certification_voyage_ibfk_1` FOREIGN KEY (`toID`) REFERENCES `certification_touroperator` (`toID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
