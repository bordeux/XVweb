-- phpMyAdmin SQL Dump
-- version 3.4.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 08, 2012 at 01:46 PM
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
-- Table structure for table `xv_auction_offers`
--

CREATE TABLE IF NOT EXISTS `xv_auction_offers` (
  `offers_id` int(11) NOT NULL AUTO_INCREMENT,
  `offers_auction` int(11) NOT NULL,
  `offers_user` varchar(50) NOT NULL,
  `offers_type` enum('auction','buynow') CHARACTER SET utf8 NOT NULL,
  `offers_date` datetime NOT NULL,
  `offers_cost` decimal(10,2) NOT NULL,
  `offers_pieces` int(5) NOT NULL,
  PRIMARY KEY (`offers_id`),
  KEY `offers_auction` (`offers_auction`),
  KEY `offers_type` (`offers_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
