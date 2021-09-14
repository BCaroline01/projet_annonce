-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 25, 2021 at 11:33 AM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thegoodcorner`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

DROP TABLE IF EXISTS `ads`;
CREATE TABLE IF NOT EXISTS `ads` (
  `idAds` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date` date NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `type` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `idUnique` varchar(255) NOT NULL,
  `idUsers` int(11) NOT NULL,
  PRIMARY KEY (`idAds`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`idAds`, `title`, `content`, `date`, `price`, `type`, `image`, `status`, `idUnique`, `idUsers`) VALUES
(1, 'chaussure Nike ', 'chaussure Nike  taille 38. ', '2021-05-21', '70.00', 'Mode', './medias\\Chaussure.jpg', 1, '2021052160a7a7600de68', 8),
(2, 'BELIER DOCKER HDI 2021', 'LYON SANS PERMIS 0478000555\r\nVOTRE CONCESSIONNAIRE NUMÉRO 1 A LYON 8\r\n\r\nEN EXCLUSIVITÉ\r\nBELLIER DOCKER HDI 2021\r\nBLANC\r\nSUR-ÉQUIPÉE\r\n\r\nNOUVEAU MOTEUR HDI TRÈS FIABLE\r\nGARANTIE 24 MOIS SANS VÉTUSTÉ\r\nSILENCIEUSE ET ÉCONOMIQUE', '2021-05-21', '13490.00', 'Véhicules', './medias\\belier.jpg', 1, '2021052160a7a8d015d17', 9),
(3, 'chaise de bureau', 'chaise de bureau noir bon état', '2021-05-21', '15.00', 'Meubles', './medias\\chaise.jfif', 1, '2021052160a7a924ac26c', 10),
(4, 'Macbook pro 2017', 'ordinateur portable Macbook pro 2017', '2021-05-21', '900.00', 'Multimedia', './medias\\macbook-pro-2017.jpg', 1, '2021052160a7aa731e5d3', 11),
(5, 'Tracteur weelhorse b111', 'Bonjour\r\nJe vend se weelhorse b111 moteur très fatiguée ne démarre plus\r\nJe possède le plateau de coupe 3 lame en bon état\r\nPour toute question', '2021-05-21', '150.00', 'Jardinage', './medias\\agricole.jpg', 1, '2021052160a7aaf135d67', 12),
(6, 'Livre comptines avec piano', 'livre en parfait état, piano également', '2021-05-21', '10.00', 'Loisirs', './medias\\livre.jpg', 1, '2021052160a7ab992f003', 13),
(7, 'Arbre à Chat', 'Arbre à Chat 141 cm MARCEL Griffoir + 1 Cabane + 1 Corde de Jeu + 1 Hamac Gris', '2021-05-21', '45.00', 'Animaux', './medias\\arbre_chat.jpg', 1, '2021052160a7abe105790', 14),
(8, 'Loue tireuse à bière', 'Loue tireuse à bière à la journée ou week-end', '2021-05-21', '25.00', 'Services', './medias\\biere.jpg', 1, '2021052160a7ac46b80ae', 15),
(10, '3 barettes chapeau', '3 barettes chapeau, à venir chercher sur place', '2021-05-21', '5.00', 'Divers', './medias\\barrette.jpg', 1, '2021052160a7ad9247724', 17);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `idUsers` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) NOT NULL,
  PRIMARY KEY (`idUsers`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idUsers`, `mail`) VALUES
(1, 'caroline.webdev@gmail.com'),
(2, 'caroline.webdev@gmail.com'),
(3, 'caroline.webdev@gmail.com'),
(4, 'caroline.webdev@gmail.com'),
(5, 'caroline.webdev@gmail.com'),
(8, 'caroline.webdev@gmail.com'),
(9, 'caroline.webdev@gmail.com'),
(10, 'caroline.webdev@gmail.com'),
(11, 'caroline.webdev@gmail.com'),
(12, 'caroline.webdev@gmail.com'),
(13, 'caroline.webdev@gmail.com'),
(14, 'caroline.webdev@gmail.com'),
(15, 'caroline.webdev@gmail.com'),
(16, 'caroline.webdev@gmail.com'),
(17, 'caroline.webdev@gmail.com'),
(18, 'caroline.webdev@gmail.com'),
(19, 'caroline.webdev@gmail.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
