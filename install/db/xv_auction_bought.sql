-- phpMyAdmin SQL Dump
-- version 3.4.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 08, 2012 at 01:45 PM
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
-- Table structure for table `xv_auction_bought`
--

CREATE TABLE IF NOT EXISTS `xv_auction_bought` (
  `bought_id` int(11) NOT NULL AUTO_INCREMENT,
  `bought_auction` int(11) NOT NULL,
  `bought_user` varchar(50) NOT NULL,
  `bought_seller` varchar(50) NOT NULL,
  `bought_title` varchar(255) NOT NULL,
  `bought_cost` decimal(10,2) NOT NULL,
  `bought_type` enum('buynow','auction','both','dutch') NOT NULL,
  `bought_pieces` int(5) NOT NULL,
  `bought_date` datetime NOT NULL,
  `bought_thumbnail` varchar(50) NOT NULL,
  `bought_seller_commented` tinyint(1) NOT NULL DEFAULT '0',
  `bought_buyer_commented` tinyint(1) NOT NULL DEFAULT '0',
  `bought_hidden_for_buyer` tinyint(1) NOT NULL,
  `bought_paid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`bought_id`),
  KEY `bought_user` (`bought_user`),
  KEY `bought_seller` (`bought_seller`),
  KEY `bought_seller_commented` (`bought_seller_commented`,`bought_buyer_commented`),
  KEY `bought_hidden_for_buyer` (`bought_hidden_for_buyer`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
