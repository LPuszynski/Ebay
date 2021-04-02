-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 30 mars 2021 à 20:15
-- Version du serveur :  10.3.20-MariaDB
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
-- Base de données :  `ebay`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrator`
--

DROP TABLE IF EXISTS `administrator`;
CREATE TABLE IF NOT EXISTS `administrator` (
  `id` int(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `auctions`
--

DROP TABLE IF EXISTS `auctions`;
CREATE TABLE IF NOT EXISTS `auctions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_seller` int(10) DEFAULT NULL,
  `price1` int(100) DEFAULT NULL,
  `price2` int(100) DEFAULT NULL,
  `id_item` int(10) DEFAULT NULL,
  `timeStart` time DEFAULT NULL,
  `timeEnd` time DEFAULT NULL,
  `dateStart` date DEFAULT NULL,
  `dateEnd` date DEFAULT NULL,
  `id_buyer` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `auctions`
--

INSERT INTO `auctions` (`id`, `id_seller`, `price1`, `price2`, `id_item`, `timeStart`, `timeEnd`, `dateStart`, `dateEnd`, `id_buyer`) VALUES
(1, 3, 181, 200, 1, '20:00:00', '22:00:00', '2021-03-29', '2021-03-29', 17),
(2, 3, 201, 201, 12, '14:30:00', '14:45:00', '2021-03-30', '2021-03-30', 13);

-- --------------------------------------------------------

--
-- Structure de la table `bestoffer`
--

DROP TABLE IF EXISTS `bestoffer`;
CREATE TABLE IF NOT EXISTS `bestoffer` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_item` int(10) DEFAULT NULL,
  `id_seller` int(10) DEFAULT NULL,
  `price` int(100) DEFAULT NULL,
  `id_customer` int(10) DEFAULT NULL,
  `state` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bestoffer`
--

INSERT INTO `bestoffer` (`id`, `id_item`, `id_seller`, `price`, `id_customer`, `state`) VALUES
(3, 2, 3, 150, 13, 1),
(4, 6, 3, 70, 13, 1);

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `idCustomer` int(10) DEFAULT NULL,
  `idItem` int(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `auction` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cart`
--

INSERT INTO `cart` (`idCustomer`, `idItem`, `date`, `time`, `id`, `auction`) VALUES
(13, 12, '2021-03-30', '14:40:00', 28, 1);

-- --------------------------------------------------------

--
-- Structure de la table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `telephone` int(15) DEFAULT NULL,
  `adress_line1` varchar(200) DEFAULT NULL,
  `adress_line2` varchar(200) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `postal_code` int(20) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `cardnumber` varchar(25) DEFAULT NULL,
  `expiration_date` varchar(255) DEFAULT NULL,
  `cvc` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `customer`
--

INSERT INTO `customer` (`id`, `email`, `password`, `lastname`, `firstname`, `telephone`, `adress_line1`, `adress_line2`, `city`, `postal_code`, `country`, `fullname`, `cardnumber`, `expiration_date`, `cvc`) VALUES
(17, 'lois.puszynski@gmail.com', 'loislebg', 'Puszynski', 'Lois', NULL, '8 Rue Boileau', NULL, 'Velizy', 78140, NULL, 'Lois PUSZYNSKI', '343284932874', '1203', 123),
(13, 'a', 'a', 'a', 'a', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'lois.puszynski@gmail.com', 'lololeplusbgdela6t', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'z', 'z', 'z', 'z', NULL, 'z', NULL, 'z', 1, NULL, 'z', '1', 'z', 1);

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `photos` varchar(150) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `price` int(10) DEFAULT NULL,
  `category` varchar(20) DEFAULT NULL,
  `BuyNow` int(1) DEFAULT NULL,
  `idseller` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`id`, `name`, `photos`, `description`, `price`, `category`, `BuyNow`, `idseller`) VALUES
(1, 'ze', 'C:wamp64wwwGitHubEbayCigars_picturescohiba_club.PNG', 'ze', 128, 'Cigars', 0, 3),
(2, 'e', 'C:wamp64wwwGitHubEbayCigars_picturescohiba_club.PNG', 'z', 178, 'Cigars', 1, 3),
(3, 'a', 'C:wamp64wwwGitHubEbayCigars_picturescohiba-robusto.jpg', 'a', 199, 'Cigars', 0, 3),
(4, 'zeaeza', 'C:wamp64wwwGitHubEbayCigars_picturesmontecristo.PNG', 'eazeazeazez', 1212, 'Cigars', 0, 3),
(5, 'adofnnof', 'C:wamp64wwwGitHubEbayCigars_picturesmontecristo_no5.PNG', 'sfoiihzeoifoze', 102, 'Cigars', 0, 3),
(6, 'nouveau cigare', 'C:wamp64wwwGitHubEbayCigars_picturesmontecristo_no5.PNG', 'vraiment dÃ©licieux miam', 100, 'Cigars', 1, 3),
(8, 'MiamMiam', 'C:wamp64wwwGitHubEbayCigars_picturesmontecristo.PNG', 'Comme je viens de le dire c\'est miamMiam', 123, 'Cigars', 1, 3),
(9, 'AAAAAAAAAAAA', 'C:wamp64wwwGitHubEbayCigars_picturescohiba_club.PNG', 'A', 20, 'Cigars', 0, 3),
(11, 'swag', 'C:wamp64wwwGitHubEbayCigars_picturesmontecristo_no5.PNG', 'drip', 123, 'Cigars', 0, 3),
(12, 'swag', 'C:wamp64wwwGitHubEbayCigars_picturesmontecristo_no5.PNG', 'drip', 201, 'Cigars', 0, 3);

-- --------------------------------------------------------

--
-- Structure de la table `orderbuynow`
--

DROP TABLE IF EXISTS `orderbuynow`;
CREATE TABLE IF NOT EXISTS `orderbuynow` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `id_item` int(20) DEFAULT NULL,
  `id_customer` int(20) DEFAULT NULL,
  `id_seller` int(20) DEFAULT NULL,
  `price` int(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `orderbuynow`
--

INSERT INTO `orderbuynow` (`id`, `id_item`, `id_customer`, `id_seller`, `price`, `date`, `time`) VALUES
(1, 0, 0, 0, 0, NULL, NULL),
(2, 2, NULL, NULL, NULL, NULL, NULL),
(3, 2, 17, NULL, NULL, NULL, NULL),
(4, 2, 17, 3, 178, NULL, NULL),
(5, 2, 17, 3, 178, '2021-03-27', '10:29:00'),
(6, 2, 17, 3, 178, '2021-03-28', '12:32:00'),
(7, 2, 17, 3, 178, '2021-03-28', '12:50:00'),
(8, 2, 17, 3, 178, '2021-03-28', '12:52:00'),
(9, 2, 17, 3, 178, '2021-03-28', '12:52:00'),
(10, 2, 17, 3, 178, '2021-03-28', '12:52:00'),
(11, 2, 17, 3, 178, '2021-03-28', '12:52:00'),
(12, 2, 17, 3, 178, '2021-03-28', '12:53:00'),
(13, 2, 17, 3, 178, '2021-03-28', '12:53:00'),
(14, 2, 17, 3, 178, '2021-03-28', '12:53:00'),
(15, 2, 17, 3, 178, '2021-03-28', '12:53:00'),
(16, 2, 17, 3, 178, '2021-03-28', '12:54:00'),
(17, 2, 17, 3, 178, '2021-03-28', '12:54:00'),
(18, 7, 17, 3, 25, '2021-03-28', '16:05:00'),
(19, 2, 17, 3, 178, '2021-03-28', '16:06:00'),
(20, 6, 17, 3, 100, '2021-03-28', '17:40:00'),
(21, 6, 17, 3, 100, '2021-03-28', '17:49:00'),
(22, 6, 17, 3, 100, '2021-03-28', '17:52:00'),
(23, 8, 17, 3, 123, '2021-03-29', '15:35:00'),
(24, 8, 17, 3, 123, '2021-03-29', '15:35:00');

-- --------------------------------------------------------

--
-- Structure de la table `seller`
--

DROP TABLE IF EXISTS `seller`;
CREATE TABLE IF NOT EXISTS `seller` (
  `email` varchar(50) DEFAULT NULL,
  `photo` int(11) DEFAULT NULL,
  `favourite_background` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(100) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `seller`
--

INSERT INTO `seller` (`email`, `photo`, `favourite_background`, `password`, `id`, `lastname`, `firstname`) VALUES
('doublegangdripsku', NULL, NULL, 'lolo', 1, NULL, NULL),
('slt', NULL, NULL, 'slt', 3, 'slt', 'slt');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
