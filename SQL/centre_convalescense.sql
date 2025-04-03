-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 03 avr. 2025 à 17:45
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
-- Base de données :  `centre_convalescense`
--

DELIMITER $$
--
-- Fonctions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `taux_occupation_globale_par_classe` (`classe_pat` INT) RETURNS DECIMAL(5,2) BEGIN
  DECLARE total_occupe INT DEFAULT 0;
  DECLARE total_par_classe INT DEFAULT 0;
  DECLARE taux DECIMAL(5,2);

    SELECT COUNT(*) INTO total_occupe
  FROM lit
  WHERE estOccupe = 1;

    SELECT COUNT(*) INTO total_par_classe
  FROM patient
  WHERE classe = classe_pat;

    IF total_occupe = 0 THEN
    SET taux = 0.00;
  ELSE
    SET taux = (total_par_classe / total_occupe) * 100;
  END IF;

  RETURN taux;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `taux_remplissage` () RETURNS DECIMAL(5,2) BEGIN
  DECLARE nb_occupe INT;
  DECLARE nb_total INT;
  DECLARE taux DECIMAL(5,2);

    SELECT COUNT(*) INTO nb_total FROM lit;

    SELECT COUNT(*) INTO nb_occupe FROM lit WHERE estOccupe = 1;

    IF nb_total = 0 THEN
    SET taux = 0.00;
  ELSE
    SET taux = (nb_occupe / nb_total) * 100;
  END IF;

  RETURN taux;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `taux_remplissage_etage` (`etage_id` INT) RETURNS DECIMAL(5,2) BEGIN
  DECLARE nb_total INT;
  DECLARE nb_occupe INT;
  DECLARE taux DECIMAL(5,2);

    SELECT COUNT(*)
  INTO nb_total
  FROM lit
  JOIN chambre ON lit.id_chambre = chambre.id_chambre
  WHERE chambre.id_etage = etage_id;

    SELECT COUNT(*)
  INTO nb_occupe
  FROM lit
  JOIN chambre ON lit.id_chambre = chambre.id_chambre
  WHERE chambre.id_etage = etage_id AND lit.estOccupe = 1;

    IF nb_total = 0 THEN
    SET taux = 0.00;
  ELSE
    SET taux = (nb_occupe / nb_total) * 100;
  END IF;

  RETURN taux;
END$$

DELIMITER ;

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
(2, 1002, 2, 3, 1, 1),
(3, 1003, 3, 3, 0, 1),
(4, 2001, 1, 3, 1, 2),
(5, 3001, 1, 3, 1, 3);

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
(4, 1, 2),
(5, 0, 2),
(6, 1, 4),
(7, 0, 4),
(8, 0, 4),
(9, 1, 5),
(10, 0, 5),
(11, 0, 5);

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
(1, 'Fernandes Enzo', 18, 1, 1),
(3, 'test1', 18, 1, 6),
(4, 'test2', 47, 1, 9),
(5, 'test3', 75, 2, 4);

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
  MODIFY `id_chambre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `etage`
--
ALTER TABLE `etage`
  MODIFY `id_etage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `lit`
--
ALTER TABLE `lit`
  MODIFY `id_lit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `id_patient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
