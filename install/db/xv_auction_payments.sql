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
-- Table structure for table `xv_auction_payments`
--

CREATE TABLE IF NOT EXISTS `xv_auction_payments` (
  `payments_id` int(11) NOT NULL AUTO_INCREMENT,
  `payments_title` varchar(255) NOT NULL,
  `payments_amount` int(11) NOT NULL,
  `payments_type` varchar(32) NOT NULL,
  `payments_user` varchar(50) NOT NULL,
  `payments_date` datetime NOT NULL,
  `payments_info` text NOT NULL,
  `payments_auction` int(11) DEFAULT NULL,
  `payments_uniqid` varchar(32) NOT NULL,
  PRIMARY KEY (`payments_id`),
  UNIQUE KEY `payments_uniqid` (`payments_uniqid`),
  KEY `payments_type` (`payments_type`),
  KEY `payments_user` (`payments_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
