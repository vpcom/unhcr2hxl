-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 26, 2012 at 09:41 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `unhcr`
--

-- --------------------------------------------------------

--
-- Table structure for table `countrypcode`
--

CREATE TABLE IF NOT EXISTS `countrypcode` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Pcode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=221 ;

--
-- Dumping data for table `countrypcode`
--

INSERT INTO `countrypcode` (`Id`, `Pcode`) VALUES
(26, 'BFA'),
(87, 'GUI'),
(132, 'MAU'),
(139, 'MAL'),
(157, 'NGR'),
(220, 'TOG');

-- --------------------------------------------------------

--
-- Table structure for table `settlementpcode`
--

CREATE TABLE IF NOT EXISTS `settlementpcode` (
  `id` int(11) NOT NULL,
  `pcode` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settlementpcode`
--

INSERT INTO `settlementpcode` (`id`, `pcode`) VALUES
(55, 'Elkhalil'),
(56, 'FassalaNere'),
(61, 'Abala'),
(62, 'Miel'),
(63, 'Chinegodrar'),
(64, 'MangaizeCamp'),
(65, 'Gaoudel'),
(82, 'Kizamou'),
(83, 'Tigzefan'),
(86, 'Mbera'),
(88, 'Tankademi'),
(89, 'Inabao'),
(90, 'Mentao'),
(91, 'Ouagadougou'),
(92, 'Mbeidoun'),
(93, 'BoboDjoulasssou'),
(100, 'Tombouctou'),
(101, 'Kidal'),
(103, 'Menaka'),
(105, 'Tessalit'),
(106, 'Lere'),
(107, 'Niafounke'),
(108, 'KolokoSegou'),
(109, 'KolokoKoulikoro'),
(112, 'Tina'),
(113, 'IntillitGao'),
(114, 'IntillitKidal'),
(115, 'Anderamboukane'),
(118, 'Bassikounou'),
(119, 'Nema'),
(121, 'Siguiri'),
(128, 'Dibissi'),
(129, 'Deou'),
(130, 'Gandafabou Kelwele'),
(131, 'Gountoure Gnegne'),
(132, 'Goudoubo'),
(133, 'OudalanAutresSites'),
(134, 'Damba'),
(135, 'Koutougou'),
(136, 'Nassoumbo'),
(137, 'KossiAutresSites'),
(138, 'SourouAutresSites'),
(139, 'Fererio'),
(140, 'AbalaCamp'),
(141, 'Djibo'),
(143, 'Chigoumar'),
(144, 'Chinwaren'),
(145, 'Tichachite'),
(146, 'Agando'),
(148, 'Barani'),
(149, 'Sabressoro'),
(150, 'Tougan'),
(151, 'Tin-Hedja'),
(152, 'Ntapdabdab'),
(153, 'Tinfagat'),
(154, 'KadiogoAutre'),
(155, 'SoumAutres'),
(156, 'HouetAutres'),
(157, 'OursiAutres'),
(158, 'SourouAutre'),
(159, 'Somgande'),
(160, 'Intadabdab'),
(161, 'Tibirgalene'),
(162, 'Banibangou'),
(163, 'Niamey'),
(164, 'TabareybareyCamp'),
(165, 'Guinea'),
(166, 'Togo'),
(168, 'Gorom-GoromUrbain');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
