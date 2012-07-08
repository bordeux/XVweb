-- phpMyAdmin SQL Dump
-- version 3.4.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 08, 2012 at 01:50 PM
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
-- Table structure for table `xv_texts`
--

CREATE TABLE IF NOT EXISTS `xv_texts` (
  `texts_id` int(11) NOT NULL AUTO_INCREMENT,
  `texts_ids` int(11) NOT NULL,
  `texts_date` datetime NOT NULL,
  `texts_user` varchar(50) CHARACTER SET utf8 NOT NULL,
  `texts_is_actual` tinyint(4) NOT NULL,
  `texts_content` longtext CHARACTER SET utf8 NOT NULL,
  `texts_changes` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`texts_id`),
  KEY `texts_ids` (`texts_ids`),
  KEY `texts_date` (`texts_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
