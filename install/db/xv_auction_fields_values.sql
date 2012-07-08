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
-- Table structure for table `xv_auction_fields_values`
--

CREATE TABLE IF NOT EXISTS `xv_auction_fields_values` (
  `fields_values_id` int(11) NOT NULL AUTO_INCREMENT,
  `fields_values_ids` int(11) NOT NULL COMMENT 'ID z tabeli fields - jakiego pola to jest wartosc',
  `fields_values_val` varchar(255) NOT NULL COMMENT 'Wartość pola',
  `fields_values_auction` int(11) NOT NULL COMMENT 'ID aukcji',
  PRIMARY KEY (`fields_values_id`),
  KEY `fields_values_val` (`fields_values_val`),
  KEY `fields_values_auction` (`fields_values_auction`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
