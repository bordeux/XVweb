-- phpMyAdmin SQL Dump
-- version 3.4.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 08, 2012 at 01:49 PM
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
-- Table structure for table `xv_messages`
--

CREATE TABLE IF NOT EXISTS `xv_messages` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_user` varchar(50) NOT NULL,
  `msg_receiver` varchar(50) NOT NULL,
  `msg_text` text NOT NULL,
  `msg_unread` tinyint(1) NOT NULL DEFAULT '1',
  `msg_date` datetime NOT NULL,
  `msg_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`msg_id`),
  KEY `msg_user` (`msg_user`,`msg_receiver`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
