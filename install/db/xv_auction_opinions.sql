-- phpMyAdmin SQL Dump
-- version 3.4.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 08, 2012 at 01:47 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xvweb2`
--

-- --------------------------------------------------------

--
-- Table structure for table `xv_auction_opinions`
--

CREATE TABLE IF NOT EXISTS `xv_auction_opinions` (
  `opinions_id` int(11) NOT NULL AUTO_INCREMENT,
  `opinions_auction` int(11) NOT NULL,
  `opinions_date` datetime NOT NULL,
  `opinions_type` enum('positive','negative','neutral') NOT NULL,
  `opinions_opinion` varchar(255) NOT NULL,
  `opinions_compatibility` tinyint(1) NOT NULL,
  `opinions_contact` tinyint(1) NOT NULL,
  `opinions_realization` tinyint(1) NOT NULL,
  `opinions_shipping` tinyint(1) NOT NULL,
  `opinions_seller` varchar(50) NOT NULL,
  `opinions_buyer` varchar(50) NOT NULL,
  `opinions_user` varchar(50) NOT NULL,
  PRIMARY KEY (`opinions_id`),
  KEY `opinions_seller` (`opinions_seller`),
  KEY `opinions_client` (`opinions_buyer`),
  KEY `opinions_auction` (`opinions_auction`),
  KEY `opinions_user` (`opinions_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
