-- phpMyAdmin SQL Dump
-- version 3.4.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 08, 2012 at 01:42 PM
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
-- Table structure for table `xv_auction_auctions`
--

CREATE TABLE IF NOT EXISTS `xv_auction_auctions` (
  `auctions_id` int(11) NOT NULL AUTO_INCREMENT,
  `auctions_category` varchar(255) NOT NULL,
  `auctions_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `auctions_views` int(11) NOT NULL DEFAULT '0',
  `auctions_title` varchar(255) NOT NULL,
  `auctions_type` enum('buynow','auction','both','dutch') NOT NULL,
  `auctions_buynow` decimal(10,2) NOT NULL,
  `auctions_auction` decimal(10,2) NOT NULL DEFAULT '0.00',
  `auctions_auction_min` decimal(10,2) DEFAULT '0.00',
  `auctions_auctions_count` int(3) NOT NULL,
  `auctions_auction_dutch` decimal(10,2) NOT NULL,
  `auctions_thumbnail` varchar(50) NOT NULL,
  `auctions_start` datetime NOT NULL,
  `auctions_end` datetime NOT NULL,
  `auctions_premium` tinyint(1) NOT NULL DEFAULT '0',
  `auction_seller` varchar(50) NOT NULL,
  `auction_pieces` int(5) NOT NULL DEFAULT '1',
  `auction_hidden_by_seller` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`auctions_id`),
  KEY `auctions_category` (`auctions_category`),
  KEY `auctions_enabled` (`auctions_enabled`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
