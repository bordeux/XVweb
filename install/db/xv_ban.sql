-- phpMyAdmin SQL Dump
-- version 3.4.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 08, 2012 at 01:48 PM
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
-- Table structure for table `xv_ban`
--

CREATE TABLE IF NOT EXISTS `xv_ban` (
  `ban_id` int(11) NOT NULL AUTO_INCREMENT,
  `ban_ip` varchar(50) NOT NULL DEFAULT '',
  `ban_filter_type` tinyint(1) NOT NULL DEFAULT '1',
  `ban_expire` datetime DEFAULT NULL,
  `ban_message` text NOT NULL,
  `ban_by` varchar(100) NOT NULL,
  PRIMARY KEY (`ban_id`,`ban_ip`),
  UNIQUE KEY `ban_ip` (`ban_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
