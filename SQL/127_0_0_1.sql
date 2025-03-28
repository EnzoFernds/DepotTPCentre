-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 28 mars 2025 à 11:12
-- Version du serveur :  5.7.17
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `artiste`
--
CREATE DATABASE IF NOT EXISTS `artiste` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `artiste`;

-- --------------------------------------------------------

--
-- Structure de la table `artiste`
--

CREATE TABLE `artiste` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `dateNaissance` varchar(50) NOT NULL,
  `specialite` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `artiste`
--
ALTER TABLE `artiste`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `artiste`
--
ALTER TABLE `artiste`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;--
-- Base de données :  `centre_convalescense`
--
CREATE DATABASE IF NOT EXISTS `centre_convalescense` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `centre_convalescense`;

-- --------------------------------------------------------

--
-- Structure de la table `centreconvalescence`
--

CREATE TABLE `centreconvalescence` (
  `id_centre` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `centreconvalescence`
--

INSERT INTO `centreconvalescence` (`id_centre`, `nom`, `adresse`) VALUES
(42190, 'UnPetitTrucEn+', '44 rue anne frank');

-- --------------------------------------------------------

--
-- Structure de la table `chambre`
--

CREATE TABLE `chambre` (
  `id_chambre` int(11) NOT NULL,
  `numero_chambre` int(11) NOT NULL,
  `classe` int(11) NOT NULL,
  `nombreLits` int(11) NOT NULL,
  `litsOccupes` int(11) DEFAULT '0',
  `id_etage` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `chambre`
--

INSERT INTO `chambre` (`id_chambre`, `numero_chambre`, `classe`, `nombreLits`, `litsOccupes`, `id_etage`) VALUES
(1, 1001, 1, 3, 1, 1),
(2, 1002, 2, 3, 0, 1),
(3, 1003, 3, 3, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `etage`
--

CREATE TABLE `etage` (
  `id_etage` int(11) NOT NULL,
  `id_centre` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `etage`
--

INSERT INTO `etage` (`id_etage`, `id_centre`) VALUES
(1, 42190),
(2, 42190),
(3, 42190);

-- --------------------------------------------------------

--
-- Structure de la table `lit`
--

CREATE TABLE `lit` (
  `id_lit` int(11) NOT NULL,
  `estOccupe` tinyint(1) DEFAULT '0',
  `id_chambre` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `lit`
--

INSERT INTO `lit` (`id_lit`, `estOccupe`, `id_chambre`) VALUES
(1, 1, 1),
(2, 0, 1),
(3, 0, 1),
(4, 0, 2),
(5, 0, 2);

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE `patient` (
  `id_patient` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `classe` int(11) DEFAULT NULL,
  `id_lit` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`id_patient`, `nom`, `age`, `classe`, `id_lit`) VALUES
(1, 'Fernandes Enzo', 18, 1, 1);

--
-- Déclencheurs `patient`
--
DELIMITER $$
CREATE TRIGGER `TAD_litLiberer` AFTER DELETE ON `patient` FOR EACH ROW BEGIN
  UPDATE lit
  SET estOccupe = 0
  WHERE id_lit = OLD.id_lit;

  UPDATE chambre
  SET litsOccupes = litsOccupes - 1
  WHERE id_chambre = (
    SELECT id_chambre
    FROM lit
    WHERE id_lit = OLD.id_lit
  );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TAI_listOccuper` AFTER INSERT ON `patient` FOR EACH ROW BEGIN

  UPDATE lit
  SET estOccupe = 1
  WHERE id_lit = NEW.id_lit;

  UPDATE chambre
  SET litsOccupes = litsOccupes + 1
  WHERE id_chambre = (
    SELECT id_chambre
    FROM lit
    WHERE id_lit = NEW.id_lit
  );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TBI_verifClasse` BEFORE INSERT ON `patient` FOR EACH ROW BEGIN
  DECLARE classe_chambre INT;

  SELECT chambre.classe INTO classe_chambre
  FROM lit
  JOIN chambre ON lit.id_chambre = chambre.id_chambre
  WHERE lit.id_lit = NEW.id_lit;

  IF NEW.classe != classe_chambre THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'Classe du patient incompatible avec la classe de la chambre.';
  END IF;
END
$$
DELIMITER ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `centreconvalescence`
--
ALTER TABLE `centreconvalescence`
  ADD PRIMARY KEY (`id_centre`);

--
-- Index pour la table `chambre`
--
ALTER TABLE `chambre`
  ADD PRIMARY KEY (`id_chambre`),
  ADD KEY `id_etage` (`id_etage`);

--
-- Index pour la table `etage`
--
ALTER TABLE `etage`
  ADD PRIMARY KEY (`id_etage`),
  ADD KEY `id_centre` (`id_centre`);

--
-- Index pour la table `lit`
--
ALTER TABLE `lit`
  ADD PRIMARY KEY (`id_lit`),
  ADD KEY `id_chambre` (`id_chambre`);

--
-- Index pour la table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id_patient`),
  ADD UNIQUE KEY `id_lit` (`id_lit`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `centreconvalescence`
--
ALTER TABLE `centreconvalescence`
  MODIFY `id_centre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42191;
--
-- AUTO_INCREMENT pour la table `chambre`
--
ALTER TABLE `chambre`
  MODIFY `id_chambre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `etage`
--
ALTER TABLE `etage`
  MODIFY `id_etage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `lit`
--
ALTER TABLE `lit`
  MODIFY `id_lit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `id_patient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;--
-- Base de données :  `ecole`
--
CREATE DATABASE IF NOT EXISTS `ecole` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ecole`;

-- --------------------------------------------------------

--
-- Structure de la table `contenu`
--

CREATE TABLE `contenu` (
  `IDD` int(11) NOT NULL,
  `IDEX` int(11) NOT NULL,
  `BAREME` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `contenu`
--

INSERT INTO `contenu` (`IDD`, `IDEX`, `BAREME`) VALUES
(1, 1, 6),
(1, 3, 4),
(2, 2, 5),
(2, 4, 2),
(3, 6, 3),
(3, 7, 4),
(3, 8, 3),
(4, 1, 1),
(4, 5, 2),
(4, 9, 1),
(5, 1, 2),
(5, 2, 3),
(5, 3, 5),
(5, 6, 5),
(5, 11, 5),
(6, 1, 3),
(6, 2, 6),
(6, 4, 5),
(6, 8, 2),
(7, 2, 3),
(7, 5, 2),
(8, 2, 2),
(8, 5, 2),
(8, 6, 2),
(8, 7, 2),
(8, 11, 2),
(9, 2, 2),
(9, 4, 2),
(9, 8, 2),
(9, 11, 4),
(10, 1, 2),
(10, 3, 2),
(10, 4, 2),
(10, 6, 2),
(10, 9, 2),
(10, 10, 2);

-- --------------------------------------------------------

--
-- Structure de la table `devoir`
--

CREATE TABLE `devoir` (
  `IDD` int(11) NOT NULL,
  `DATE_CREATION` date DEFAULT NULL,
  `PROF_CREATEUR` int(11) NOT NULL,
  `NIVEAU` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `devoir`
--

INSERT INTO `devoir` (`IDD`, `DATE_CREATION`, `PROF_CREATEUR`, `NIVEAU`) VALUES
(1, '2021-02-14', 1, '6eme'),
(2, '2021-02-17', 1, '5eme'),
(3, '2021-02-17', 2, '4eme'),
(4, '2021-02-18', 1, '6eme'),
(5, '2021-02-20', 2, '5eme'),
(6, '2021-02-21', 3, '4eme'),
(7, '2021-02-21', 8, '4eme'),
(8, '2021-02-26', 4, '3eme'),
(9, '2021-02-28', 2, '3eme'),
(10, '2021-02-28', 5, '3eme');

-- --------------------------------------------------------

--
-- Structure de la table `eleve`
--

CREATE TABLE `eleve` (
  `IDEL` int(11) NOT NULL,
  `NOM` varchar(50) NOT NULL,
  `PRENOM` varchar(30) DEFAULT NULL,
  `COLLEGE` varchar(8) DEFAULT NULL,
  `NIVEAU` varchar(4) DEFAULT NULL,
  `DATENAIS` date NOT NULL,
  `moyenne` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `eleve`
--

INSERT INTO `eleve` (`IDEL`, `NOM`, `PRENOM`, `COLLEGE`, `NIVEAU`, `DATENAIS`, `moyenne`) VALUES
(1, 'RAMI', 'ALEXANDRE', '0341278E', '6eme', '2010-08-04', 8),
(2, 'DUPONT', 'MAXIME', '0340008Z', '4eme', '2008-05-13', NULL),
(3, 'DUPONT', 'ARNAUD', '0341278E', '6eme', '2010-03-04', NULL),
(4, 'VIGROS', 'HELENE', '0341278E', '6eme', '2010-10-25', NULL),
(5, 'GOMAZ', 'GILLE', '0341280G', '5eme', '2009-06-27', NULL),
(6, 'CHOUMIN', 'KHALIL', '0340008Z', '4eme', '2008-12-28', NULL),
(7, 'MONTEO', 'ILONA', '0340008Z', '3eme', '2007-01-29', NULL),
(8, 'MONTEO', 'MILAN', '0340008Z', '5eme', '2009-09-07', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `etablissement`
--

CREATE TABLE `etablissement` (
  `RNE` varchar(8) NOT NULL,
  `NOM` varchar(50) NOT NULL,
  `LOCALITE` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `etablissement`
--

INSERT INTO `etablissement` (`RNE`, `NOM`, `LOCALITE`) VALUES
('0301094B', 'College Diderot', 'Mably'),
('0340008Z', 'College Victor Hugo', 'Roanne'),
('0341278E', 'College Arthur Rimbaud', 'Renaison'),
('0341280G', 'College Les Pins', 'Roanne');

-- --------------------------------------------------------

--
-- Structure de la table `exercice`
--

CREATE TABLE `exercice` (
  `IDEX` int(11) NOT NULL,
  `CONTENU` varchar(250) DEFAULT NULL,
  `NIVEAU` varchar(4) DEFAULT NULL,
  `PROPRIETAIRE` int(11) DEFAULT NULL,
  `DATE_CREATION` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `exercice`
--

INSERT INTO `exercice` (`IDEX`, `CONTENU`, `NIVEAU`, `PROPRIETAIRE`, `DATE_CREATION`) VALUES
(1, 'Calculer 2+3', '6eme', 2, '2019-02-08'),
(2, 'Developper 2(3x+5)', '5eme', 1, '2019-01-07'),
(3, 'Calculer (-3)-(2)', '5eme', 2, '2019-01-10'),
(4, 'Calculer la médiane de la série suivante : 12 - 14 - 15 - 19 -22 -25', '5eme', 1, '2019-02-08'),
(5, 'Tracer un triangle equilatéral de 6 cm de côte', '6eme', 3, '2018-10-08'),
(6, 'Calculer la longueur du segment [AB]', '4eme', 2, '2018-11-10'),
(7, 'Tracer l\'image de A par la translation qui transforme B en C', '4eme', 2, '2018-11-10'),
(8, 'Simplifier l\'expression suivante puis exprimer son double en fonction de x', '4eme', 2, '2018-11-10'),
(9, 'Calculer le triple de 9', '6eme', 2, '2019-01-12'),
(10, 'Effectuer les calculs suivants : 8 + 3 * 5 ; 17 - 3*2', '6eme', 5, '2019-01-14'),
(11, 'Developper l\'expression suivante : (2x-5)²', '3eme', 5, '2019-01-19');

-- --------------------------------------------------------

--
-- Structure de la table `niveau`
--

CREATE TABLE `niveau` (
  `NIVEAU` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `niveau`
--

INSERT INTO `niveau` (`NIVEAU`) VALUES
('3eme'),
('4eme'),
('5eme'),
('6eme');

-- --------------------------------------------------------

--
-- Structure de la table `notion`
--

CREATE TABLE `notion` (
  `IDEXO` int(11) NOT NULL,
  `NOTION` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `notion`
--

INSERT INTO `notion` (`IDEXO`, `NOTION`) VALUES
(1, 'calcul numerique'),
(2, 'calcul litteral'),
(3, 'calcul numerique'),
(4, 'calcul litteral'),
(5, 'geometrie'),
(6, 'geometrie'),
(7, 'geometrie'),
(8, 'calcul litteral'),
(9, 'calcul numerique'),
(10, 'calcul numerique'),
(11, 'calcul litteral');

-- --------------------------------------------------------

--
-- Structure de la table `passage`
--

CREATE TABLE `passage` (
  `IDD` int(11) NOT NULL,
  `IDEL` int(11) NOT NULL,
  `DATE_PASSAGE` date NOT NULL,
  `NOTE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `passage`
--

INSERT INTO `passage` (`IDD`, `IDEL`, `DATE_PASSAGE`, `NOTE`) VALUES
(1, 1, '2021-02-15', 5),
(1, 1, '2025-02-12', 7),
(1, 1, '2025-02-13', 10),
(1, 3, '2021-02-15', 6),
(1, 4, '2021-02-15', 4),
(2, 2, '2021-02-18', 6),
(2, 5, '2021-02-18', 5),
(3, 1, '2021-02-20', 8),
(3, 2, '2021-02-20', 8),
(3, 6, '2021-02-20', 7),
(4, 3, '2021-02-23', 3),
(5, 5, '2021-02-26', 14),
(6, 4, '2021-02-28', 11),
(7, 3, '2021-02-22', 3),
(8, 4, '2021-02-27', 11),
(9, 4, '2021-03-01', 11),
(10, 3, '2019-02-28', 11);

--
-- Déclencheurs `passage`
--
DELIMITER $$
CREATE TRIGGER `tai_updatemoyenne` AFTER INSERT ON `passage` FOR EACH ROW BEGIN
    CALL UpdateMoyenneEleve(NEW.IDEL);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tbi_NoteMax` BEFORE INSERT ON `passage` FOR EACH ROW BEGIN
    DECLARE NoteMAx INT;

    SET NoteMax = PointsTotal(NEW.IDD);
    
    IF (NEW.NOTE > NoteMAx) THEN
       SET NEW.NOTE = NoteMAx;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `prof`
--

CREATE TABLE `prof` (
  `IDP` int(11) NOT NULL,
  `NOM` varchar(20) NOT NULL,
  `ANNEE_NAISSANCE` int(11) DEFAULT NULL,
  `RNE` varchar(8) DEFAULT NULL,
  `VILLE` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `prof`
--

INSERT INTO `prof` (`IDP`, `NOM`, `ANNEE_NAISSANCE`, `RNE`, `VILLE`) VALUES
(1, 'BLONDEAU', 1982, '0341278E', 'Mably'),
(2, 'MANEREAU', 1980, '0341278E', 'Le Coteau'),
(3, 'SOULIER', 1978, '0341280G', 'Roanne'),
(4, 'BARROUD', 1982, '0340008Z', 'Feurs'),
(5, 'HULLMAN', 1979, '0340008Z', 'Montbrison'),
(6, 'VISCONTI', 1993, '0341280G', 'Montbrison'),
(7, 'TOURNIER', 1984, '0340008Z', 'Renaison'),
(8, 'GAMBIER', 1992, '0340008Z', 'Roanne');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `contenu`
--
ALTER TABLE `contenu`
  ADD PRIMARY KEY (`IDD`,`IDEX`),
  ADD KEY `IDEX` (`IDEX`);

--
-- Index pour la table `devoir`
--
ALTER TABLE `devoir`
  ADD PRIMARY KEY (`IDD`),
  ADD KEY `ce1_devoir` (`PROF_CREATEUR`),
  ADD KEY `ce2_devoir` (`NIVEAU`);

--
-- Index pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD PRIMARY KEY (`IDEL`),
  ADD KEY `ce1_eleve` (`COLLEGE`),
  ADD KEY `ce2_eleve` (`NIVEAU`);

--
-- Index pour la table `etablissement`
--
ALTER TABLE `etablissement`
  ADD PRIMARY KEY (`RNE`);

--
-- Index pour la table `exercice`
--
ALTER TABLE `exercice`
  ADD PRIMARY KEY (`IDEX`),
  ADD KEY `ce1_exercice` (`NIVEAU`),
  ADD KEY `ce2_exercice` (`PROPRIETAIRE`);

--
-- Index pour la table `niveau`
--
ALTER TABLE `niveau`
  ADD PRIMARY KEY (`NIVEAU`);

--
-- Index pour la table `notion`
--
ALTER TABLE `notion`
  ADD PRIMARY KEY (`IDEXO`);

--
-- Index pour la table `passage`
--
ALTER TABLE `passage`
  ADD PRIMARY KEY (`IDD`,`IDEL`,`DATE_PASSAGE`),
  ADD KEY `IDEL` (`IDEL`);

--
-- Index pour la table `prof`
--
ALTER TABLE `prof`
  ADD PRIMARY KEY (`IDP`),
  ADD KEY `ce_prof` (`RNE`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contenu`
--
ALTER TABLE `contenu`
  ADD CONSTRAINT `contenu_ibfk_1` FOREIGN KEY (`IDEX`) REFERENCES `exercice` (`IDEX`),
  ADD CONSTRAINT `contenu_ibfk_2` FOREIGN KEY (`IDD`) REFERENCES `devoir` (`IDD`);

--
-- Contraintes pour la table `devoir`
--
ALTER TABLE `devoir`
  ADD CONSTRAINT `devoir_ibfk_1` FOREIGN KEY (`NIVEAU`) REFERENCES `niveau` (`NIVEAU`),
  ADD CONSTRAINT `devoir_ibfk_2` FOREIGN KEY (`PROF_CREATEUR`) REFERENCES `prof` (`IDP`),
  ADD CONSTRAINT `devoir_ibfk_3` FOREIGN KEY (`IDD`) REFERENCES `passage` (`IDD`);

--
-- Contraintes pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD CONSTRAINT `eleve_ibfk_1` FOREIGN KEY (`NIVEAU`) REFERENCES `niveau` (`NIVEAU`);

--
-- Contraintes pour la table `exercice`
--
ALTER TABLE `exercice`
  ADD CONSTRAINT `exercice_ibfk_1` FOREIGN KEY (`NIVEAU`) REFERENCES `niveau` (`NIVEAU`);

--
-- Contraintes pour la table `passage`
--
ALTER TABLE `passage`
  ADD CONSTRAINT `passage_ibfk_2` FOREIGN KEY (`IDEL`) REFERENCES `eleve` (`IDEL`);

--
-- Contraintes pour la table `prof`
--
ALTER TABLE `prof`
  ADD CONSTRAINT `prof_ibfk_1` FOREIGN KEY (`RNE`) REFERENCES `etablissement` (`RNE`);
--
-- Base de données :  `mission`
--
CREATE DATABASE IF NOT EXISTS `mission` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `mission`;

-- --------------------------------------------------------

--
-- Structure de la table `dept`
--

CREATE TABLE `dept` (
  `numero` int(11) NOT NULL,
  `service` varchar(20) NOT NULL,
  `ville` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `dept`
--

INSERT INTO `dept` (`numero`, `service`, `ville`) VALUES
(10, 'COMPTABILITE', 'PARIS'),
(20, 'RECHERCHE', 'GRENOBLE'),
(30, 'VENTES', 'LYON'),
(40, 'PRODUCTION', 'ROANNE');

-- --------------------------------------------------------

--
-- Structure de la table `emp`
--

CREATE TABLE `emp` (
  `matricule` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `emploi` varchar(20) DEFAULT NULL,
  `suph` int(11) DEFAULT NULL,
  `datemb` datetime NOT NULL,
  `sal` decimal(10,0) DEFAULT NULL,
  `comm` decimal(10,0) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `nbmissions` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `emp`
--

INSERT INTO `emp` (`matricule`, `nom`, `emploi`, `suph`, `datemb`, `sal`, `comm`, `numero`, `nbmissions`) VALUES
(7369, 'SUREL', 'COMPTABLE', 7902, '2015-12-17 00:00:00', '800', NULL, 20, 1),
(7499, 'ALLIX', 'VENDEUR', 7698, '2010-02-20 00:00:00', '1600', '300', 30, 1),
(7521, 'VIARD', 'VENDEUR', 7698, '2015-02-22 00:00:00', '1250', '500', 30, 0),
(7566, 'JAUDE', 'DIRECTEUR', 7839, '2017-04-02 00:00:00', '2975', NULL, 20, 0),
(7654, 'MARTIN', 'VENDEUR', 7698, '2016-09-28 00:00:00', '1250', '1400', 30, 1),
(7698, 'BRAQUE', 'DIRECTEUR', 7839, '2017-05-02 00:00:00', '2850', NULL, 30, 2),
(7782, 'LECLERC', 'DIRECTEUR', 7839, '2006-06-09 00:00:00', '2450', NULL, 10, 1),
(7788, 'LESCAUT', 'ANALYSTE', 7566, '2016-09-11 00:00:00', '3000', NULL, 20, 0),
(7839, 'LEROY', 'PRESIDENT', NULL, '2015-11-17 00:00:00', '5000', NULL, 10, 0),
(7844, 'TOURNIER', 'VENDEUR', 7698, '2018-09-08 00:00:00', '1500', NULL, 30, 0),
(7876, 'ADAM', 'COMPTABLE', 7788, '2015-09-23 00:00:00', '1100', NULL, 20, 0),
(7900, 'JAMOT', 'COMPTABLE', 7698, '2009-12-03 00:00:00', '950', NULL, 30, 1),
(7902, 'FAURE', 'ANALYSTE', 7566, '2010-12-03 00:00:00', '3000', NULL, 20, 1),
(7934, 'MILLARD', 'COMPTABLE', 7782, '2007-01-23 00:00:00', '1300', NULL, 10, 0);

-- --------------------------------------------------------

--
-- Structure de la table `mission`
--

CREATE TABLE `mission` (
  `no_mission` int(11) NOT NULL,
  `date_mission` datetime NOT NULL,
  `entreprise` varchar(20) NOT NULL,
  `lieu_mission` varchar(20) DEFAULT NULL,
  `matricule` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `mission`
--

INSERT INTO `mission` (`no_mission`, `date_mission`, `entreprise`, `lieu_mission`, `matricule`) VALUES
(209, '2022-09-02 00:00:00', 'Renault', 'Lyon', 7654),
(212, '2022-04-03 00:00:00', 'Casino', 'Paris', 7698),
(213, '2022-11-04 00:00:00', 'Oracle', 'Grenoble', 7902),
(214, '2022-07-06 00:00:00', 'Fiducière', 'Roanne', 7900),
(216, '2022-09-02 00:00:00', 'BNP', 'Lyon', 7698),
(218, '2022-12-24 00:00:00', 'Décathlon', 'Grenoble', 7499),
(219, '2022-08-16 00:00:00', 'Renault', 'Lyon', 7782),
(234, '2025-06-03 00:00:00', 'COUCOU', 'Roanne', 7369);

--
-- Déclencheurs `mission`
--
DELIMITER $$
CREATE TRIGGER `tai_mission2` AFTER INSERT ON `mission` FOR EACH ROW UPDATE emp
SET Nbmissions = Nbmissions+1
WHERE matricule=New.matricule
$$
DELIMITER ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `dept`
--
ALTER TABLE `dept`
  ADD PRIMARY KEY (`numero`);

--
-- Index pour la table `emp`
--
ALTER TABLE `emp`
  ADD PRIMARY KEY (`matricule`),
  ADD KEY `EMP_FK` (`numero`);

--
-- Index pour la table `mission`
--
ALTER TABLE `mission`
  ADD PRIMARY KEY (`no_mission`),
  ADD KEY `FKmission` (`matricule`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `emp`
--
ALTER TABLE `emp`
  ADD CONSTRAINT `FKemp` FOREIGN KEY (`numero`) REFERENCES `dept` (`numero`);

--
-- Contraintes pour la table `mission`
--
ALTER TABLE `mission`
  ADD CONSTRAINT `FKmission` FOREIGN KEY (`matricule`) REFERENCES `emp` (`matricule`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
