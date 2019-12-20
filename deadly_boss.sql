-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 08 Mai 2017 à 21:37
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `deadly_boss`
--

-- --------------------------------------------------------

--
-- Structure de la table `action`
--

CREATE TABLE IF NOT EXISTS `action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `win_gold` int(11) NOT NULL,
  `win_vie` int(11) NOT NULL,
  `win_attaque` int(11) NOT NULL,
  `win_defense` int(11) NOT NULL,
  `win_mana` int(11) NOT NULL,
  `win_score` int(11) NOT NULL,
  `vie_monstre` int(11) NOT NULL,
  `attaque_monstre` int(11) NOT NULL,
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=37 ;

--
-- Contenu de la table `action`
--

INSERT INTO `action` (`id`, `nom`, `win_gold`, `win_vie`, `win_attaque`, `win_defense`, `win_mana`, `win_score`, `vie_monstre`, `attaque_monstre`, `type`) VALUES
(1, 'Tuer des loups - level 1', 10, 5, 5, 5, -15, 15, 330, 60, 'global'),
(2, 'Assassiner un chef de bande - level 1', 10, 5, 5, 5, -10, 20, 450, 80, 'global'),
(3, 'Tuer le Dragon noir de l’apocalypse bardé de fer - level 1', 60, 10, 10, 8, -95, 60, 2300, 580, 'global'),
(4, 'Terrassez les pirates des mers - level 1', 15, 5, 5, 5, -15, 20, 480, 95, 'global'),
(5, 'Chassez des Ombres - level 1', 10, 8, 6, 5, -15, 25, 650, 120, 'global'),
(7, 'S''alimenter en mana/ Achat d''une petite potion d''énergie', -10, 0, 0, 0, 20, 0, 0, 0, 'epuisé'),
(8, 'S''alimenter en mana/ Achat d''une grand potion d’énergie (De Guerre)', -100, 0, 0, 0, 60, 0, 0, 0, 'epuisé'),
(9, 'Réparer son armure / Achat d''une nouvelle', -30, 0, 0, 20, 0, 0, 0, 0, 'epuisé'),
(10, 'Réparer et améliorer son armure en Légendaire', -120, 0, 0, 90, 0, 0, 0, 0, 'epuisé'),
(11, 'Terrassez le dieu de la destruction Beerus - level 1 ', 100, 25, 25, 20, -100, 150, 8800, 880, 'Hautlevel'),
(33, 'Terrassez Le roi des enfers Lucifer', 100, 28, 28, 24, -105, 170, 9700, 935, 'Hautlevel'),
(34, 'Tuer le monstre des profondeurs du roche noire - level 3', 45, 12, 11, 8, -18, 30, 1035, 218, 'améliorer'),
(36, 'Assassiner un chef de bande - level 2', 15, 7, 7, 5, -10, 11, 880, 95, 'améliorer');

-- --------------------------------------------------------

--
-- Structure de la table `boite_mail`
--

CREATE TABLE IF NOT EXISTS `boite_mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_expediteur` int(11) NOT NULL,
  `id_destinataire` int(11) NOT NULL,
  `pseudo_destinataire` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `date_message` datetime NOT NULL,
  `lu` tinyint(1) NOT NULL,
  `objet` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Contenu de la table `boite_mail`
--

INSERT INTO `boite_mail` (`id`, `id_expediteur`, `id_destinataire`, `pseudo_destinataire`, `date_message`, `lu`, `objet`, `message`) VALUES
(4, 31, 31, 'oussama', '2017-05-08 21:27:03', 1, '1er message', 'Test Message test test');

-- --------------------------------------------------------

--
-- Structure de la table `joueurs`
--

CREATE TABLE IF NOT EXISTS `joueurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` datetime NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nb_personnage` int(11) NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Contenu de la table `joueurs`
--

INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `mail`, `birthday`, `password`, `nb_personnage`, `avatar`) VALUES
(1, 'Oussama', 'Aouessar', 'oussama--93@live.fr', '1993-09-03 00:00:00', '$2y$13$N.sBhpeJCYdNMB9Wq1YeS.NV2/PBhO5RKW7KCqy3cAhn8r5FL9Dsa', 6, 'f3143d3100da77dd1be6439594ee3e10.png'),
(11, 'Mike', 'Arezes', 'mike@msn.com', '1991-08-20 00:00:00', '$2y$13$19aCrD0NF5.Gcv04o/Em1OpscOix8lcD6NDwM35AOOL8MOqqSENqu', 2, 'b51a7f5cc51c352e94f37b93841b6567.png');

-- --------------------------------------------------------

--
-- Structure de la table `personnages`
--

CREATE TABLE IF NOT EXISTS `personnages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `joueur` int(11) NOT NULL,
  `gold` int(11) NOT NULL,
  `vie` int(11) NOT NULL,
  `attaque` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `mana` int(11) NOT NULL,
  `classe` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=37 ;

--
-- Contenu de la table `personnages`
--

INSERT INTO `personnages` (`id`, `pseudo`, `joueur`, `gold`, `vie`, `attaque`, `defense`, `mana`, `classe`, `score`) VALUES
(12, 'geygey', 1, 50, 350, 150, 100, 0, 'Humain', 25),
(13, 'manassé', 1, 75, 341, 140, 88, 5, 'Humain', 80),
(31, 'oussama', 1, 10, 400, 50, 100, 0, 'Dwarf', 0),
(32, 'Yolo', 1, 10, 200, 200, 50, 0, 'Orc', 0),
(33, 'Claoss', 1, 10, 100, 300, 0, 50, 'Elfe', 0),
(34, 'Wryn', 1, 10, 200, 200, 50, 0, 'Orc', 0),
(35, 'Miky', 11, 10, 100, 300, 0, 50, 'Elfe', 0),
(36, 'barbe noir', 11, 10, 400, 50, 100, 0, 'Dwarf', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
