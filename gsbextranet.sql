-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 01 déc. 2022 à 16:23
-- Version du serveur : 5.7.36
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET GLOBAL FOREIGN_KEY_CHECKS = 0;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gsbextranet`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `idAvis` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `valider` tinyint(1) NOT NULL,
  PRIMARY KEY (`idAvis`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`idAvis`, `description`, `valider`) VALUES
(1, 'très bonne visio !', 1),
(2, 'On apprend beaucoup de chose !', 1),
(3, 'Visioconférences hors sujet à mon goût... Perte de temps total ! C\'est inadmissible ! ', 0);

-- --------------------------------------------------------

--
-- Structure de la table `avisvisio`
--

DROP TABLE IF EXISTS `avisvisio`;
CREATE TABLE IF NOT EXISTS `avisvisio` (
  `idAvis` int(11) NOT NULL,
  `idVisio` int(11) NOT NULL,
  PRIMARY KEY (`idAvis`,`idVisio`),
  KEY `idVisio` (`idVisio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `avisvisio`
--

INSERT INTO `avisvisio` (`idAvis`, `idVisio`) VALUES
(1, 3),
(2, 3),
(3, 5);

-- --------------------------------------------------------

--
-- Structure de la table `droit`
--

DROP TABLE IF EXISTS `droit`;
CREATE TABLE IF NOT EXISTS `droit` (
  `idDroit` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(20) NOT NULL,
  PRIMARY KEY (`idDroit`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `droit`
--

INSERT INTO `droit` (`idDroit`, `libelle`) VALUES
(1, 'medecin'),
(2, 'chefProd'),
(3, 'validateur'),
(4, 'moderateur'),
(5, 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `historiqueconnexion`
--

DROP TABLE IF EXISTS `historiqueconnexion`;
CREATE TABLE IF NOT EXISTS `historiqueconnexion` (
  `idMedecin` int(11) NOT NULL,
  `dateDebutLog` datetime NOT NULL,
  `dateFinLog` datetime DEFAULT NULL,
  PRIMARY KEY (`idMedecin`,`dateDebutLog`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `historiqueconnexion`
--

INSERT INTO `historiqueconnexion` (`idMedecin`, `dateDebutLog`, `dateFinLog`) VALUES
(1, '2022-09-15 16:44:14', '2022-09-15 16:44:14'),
(1, '2022-09-22 16:01:11', '2022-09-22 16:01:11'),
(3, '2022-09-22 16:02:10', '2022-09-22 16:02:10'),
(4, '2022-11-10 15:28:49', '2022-11-10 15:28:49'),
(5, '2022-11-10 15:33:59', '2022-11-10 15:33:59'),
(5, '2022-11-10 15:34:52', '2022-11-10 15:34:52'),
(7, '2022-11-10 15:14:37', '2022-11-10 15:14:37'),
(7, '2022-11-10 15:41:22', '2022-11-10 15:41:22'),
(8, '2022-11-10 15:21:45', '2022-11-10 15:21:45'),
(8, '2022-11-10 15:49:56', '2022-11-10 15:49:56'),
(9, '2022-11-10 15:23:18', '2022-11-10 15:23:18'),
(9, '2022-11-10 15:52:26', '2022-11-10 15:52:26'),
(10, '2022-11-10 15:53:46', '2022-11-10 15:53:46'),
(11, '2022-11-10 15:54:49', '2022-11-10 15:54:49'),
(12, '2022-11-10 15:56:02', '2022-11-10 15:56:02'),
(13, '2022-11-10 15:57:48', '2022-11-10 15:57:48'),
(14, '2022-11-10 15:59:09', '2022-11-10 15:59:09'),
(15, '2022-11-10 15:59:37', '2022-11-10 15:59:37'),
(16, '2022-11-10 16:03:30', '2022-11-10 16:03:30'),
(20, '2022-12-01 16:40:48', '2022-12-01 16:40:48'),
(21, '2022-12-01 17:02:24', '2022-12-01 17:02:24'),
(22, '2022-12-01 17:13:09', '2022-12-01 17:13:09'),
(23, '2022-12-01 17:19:36', '2022-12-01 17:19:36');

-- --------------------------------------------------------

--
-- Structure de la table `maintenance`
--

DROP TABLE IF EXISTS `maintenance`;
CREATE TABLE IF NOT EXISTS `maintenance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maintenance` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `maintenance`
--

INSERT INTO `maintenance` (`id`, `maintenance`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `medecin`
--

DROP TABLE IF EXISTS `medecin`;
CREATE TABLE IF NOT EXISTS `medecin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(40) DEFAULT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `dateNaissance` date DEFAULT NULL,
  `motDePasse` varchar(30) DEFAULT NULL,
  `dateCreation` datetime DEFAULT NULL,
  `rpps` varchar(25) DEFAULT NULL,
  `dateDiplome` date DEFAULT NULL,
  `dateConsentement` date DEFAULT NULL,
  `valideCompte` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `medecin`
--

INSERT INTO `medecin` (`id`, `nom`, `prenom`, `mail`, `dateNaissance`, `motDePasse`, `dateCreation`, `rpps`, `dateDiplome`, `dateConsentement`, `valideCompte`) VALUES
(1, 'bob', 'alice', 'test@test.fr', NULL, 'Azerty@123456789', '2022-09-15 16:44:14', NULL, NULL, '2022-09-15', 1),
(3, 'admin', 'alice', 'admin@admin.fr', NULL, 'Azerty@123456789', '2022-09-22 16:02:10', NULL, NULL, '2022-09-22', 1),
(17, 'chef', NULL, 'chef@prod.fr', NULL, 'Azerty@123456789', '2022-11-10 16:25:17', NULL, NULL, NULL, 1),
(18, 'valid', NULL, 'valid@valid.fr', NULL, 'Azerty@123456789', '2022-11-10 16:25:17', NULL, NULL, NULL, 1),
(19, 'mod', NULL, 'moderateur@moderateur.fr', NULL, 'Azerty@123456789', '2022-11-10 16:25:38', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `medecinproduit`
--

DROP TABLE IF EXISTS `medecinproduit`;
CREATE TABLE IF NOT EXISTS `medecinproduit` (
  `idMedecin` int(11) NOT NULL,
  `idProduit` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Heure` time NOT NULL,
  PRIMARY KEY (`idMedecin`,`idProduit`,`Date`,`Heure`),
  KEY `idProduit` (`idProduit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `medecinvisio`
--

DROP TABLE IF EXISTS `medecinvisio`;
CREATE TABLE IF NOT EXISTS `medecinvisio` (
  `idMedecin` int(11) NOT NULL,
  `idVisio` int(11) NOT NULL,
  `dateInscription` date NOT NULL,
  PRIMARY KEY (`idMedecin`,`idVisio`),
  KEY `idVisio` (`idVisio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `medecinvisio`
--

INSERT INTO `medecinvisio` (`idMedecin`, `idVisio`, `dateInscription`) VALUES
(1, 3, '2022-11-12'),
(1, 5, '2022-11-12'),
(1, 7, '2022-11-12');

-- --------------------------------------------------------

--
-- Structure de la table `niveaudecompte`
--

DROP TABLE IF EXISTS `niveaudecompte`;
CREATE TABLE IF NOT EXISTS `niveaudecompte` (
  `idDroit` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  PRIMARY KEY (`idDroit`,`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `niveaudecompte`
--

INSERT INTO `niveaudecompte` (`idDroit`, `id`) VALUES
(1, 1),
(5, 3),
(2, 17),
(3, 18),
(4, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int(11) NOT NULL,
  `nom` varchar(60) NOT NULL,
  `objectif` mediumtext NOT NULL,
  `information` mediumtext NOT NULL,
  `effetIndesirable` mediumtext NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `idChefProd` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idChefProd` (`idChefProd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `nom`, `objectif`, `information`, `effetIndesirable`, `image`, `idChefProd`) VALUES
(1, 'Doliprane ', 'soigner ', 'paracetamol', 'aucun', 'doliprane.png', 17),
(2, 'Dafalgan', 'soin', 'paracétamol', 'douleur et fiere', 'dafalgan.png', 19);

-- --------------------------------------------------------

--
-- Structure de la table `token`
--

DROP TABLE IF EXISTS `token`;
CREATE TABLE IF NOT EXISTS `token` (
  `idmedecin` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  `datecreation` datetime NOT NULL,
  PRIMARY KEY (`idmedecin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `visioconference`
--

DROP TABLE IF EXISTS `visioconference`;
CREATE TABLE IF NOT EXISTS `visioconference` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomVisio` varchar(100) DEFAULT NULL,
  `objectif` text,
  `url` varchar(100) DEFAULT NULL,
  `dateVisio` date NOT NULL,
  `idChefProd` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idChefProd` (`idChefProd`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `visioconference`
--

INSERT INTO `visioconference` (`id`, `nomVisio`, `objectif`, `url`, `dateVisio`, `idChefProd`) VALUES
(3, 'Les risque du doliprane.', 'découvrir les risques encouru par la consommation abusive de doliprane.', 'https://www.youtube.com/watch?v=y1DfZSKcY-o', '2022-11-22', 17),
(4, 'Le microbiote, le médicament de demain ?', 'Découverte du microbiote et ses bienfait révolutionnaire !', 'https://www.youtube.com/watch?v=wslOLBAVGFg', '2023-03-21', 17),
(5, 'Tout savoir sur le cycle de vie d\'un médicament', 'Cette conférence vous propose de reprendre les bases du médicament: de sa fabrication à son utilisation afin de les utiliser au meilleur de leur efficacité.', 'https://www.happyvisio.com/conference/tout-savoir-sur-le-cycle-de-vie-dun-medicament', '2023-05-13', 17),
(7, 'Conférence : « La cellule médicament »', 'La conférence décrira les nouveaux défis que sont les médicaments de thérapie innovante. Il s’agit de décrire les progrès récents réalisés par la thérapie génique, les réparations tissulaires par les cellules souches transformées, la transplantation de cellules souches, l’utilisation des cellules lymphocytaires transformées (CAR-T cells) et la transplantation de cellules souches autologues dans des pathologies non hématologiques', 'https://medecine-reparatrice.univ-poitiers.fr/conference-la-cellule-medicament/', '2023-01-13', 17);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avisvisio`
--
ALTER TABLE `avisvisio`
  ADD CONSTRAINT `avisvisio_ibfk_1` FOREIGN KEY (`idAvis`) REFERENCES `avis` (`idAvis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `avisvisio_ibfk_2` FOREIGN KEY (`idVisio`) REFERENCES `visioconference` (`id`);

--
-- Contraintes pour la table `medecin`
--
-- Contraintes pour la table `medecinvisio`
--
ALTER TABLE `medecinvisio`
  ADD CONSTRAINT `medecinvisio_ibfk_1` FOREIGN KEY (`idMedecin`) REFERENCES `medecin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medecinvisio_ibfk_2` FOREIGN KEY (`idVisio`) REFERENCES `visioconference` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `niveaudecompte`
--
ALTER TABLE `niveaudecompte`
  ADD CONSTRAINT `niveaudecompte_ibfk_1` FOREIGN KEY (`id`) REFERENCES `medecin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `niveaudecompte_ibfk_2` FOREIGN KEY (`idDroit`) REFERENCES `droit` (`idDroit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `token_ibfk_1` FOREIGN KEY (`idmedecin`) REFERENCES `medecin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `visioconference`
--
ALTER TABLE `visioconference`
  ADD CONSTRAINT `visioconference_ibfk_1` FOREIGN KEY (`idChefProd`) REFERENCES `medecin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Évènements
--
DROP EVENT IF EXISTS `token24h`$$
CREATE DEFINER=`root`@`localhost` EVENT `token24h` ON SCHEDULE EVERY 5 SECOND STARTS '2022-12-01 16:50:16' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
DELETE FROM medecin WHERE id IN (SELECT idMedecin FROM token WHERE timestampdiff(HOUR, NOW(), datecreation) > 24);

DELETE FROM token WHERE timestampdiff(HOUR, NOW(), datecreation) > 24;
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
