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
-- Table structure for table `xv_auction_users`
--

CREATE TABLE IF NOT EXISTS `xv_auction_users` (
  `users_id` int(11) NOT NULL AUTO_INCREMENT,
  `users_user` varchar(50) NOT NULL,
  `users_name` varchar(50) NOT NULL,
  `users_vorname` varchar(50) NOT NULL,
  `users_country` varchar(50) NOT NULL,
  `users_state` varchar(50) DEFAULT NULL,
  `users_city` varchar(50) NOT NULL,
  `users_zip` varchar(7) NOT NULL,
  `users_street` varchar(50) NOT NULL,
  `users_corporation` varchar(50) DEFAULT NULL,
  `users_phone` int(11) DEFAULT NULL,
  `users_date` datetime NOT NULL,
  `users_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`users_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `xv_auction_users`
--

INSERT INTO `xv_auction_users` (`users_id`, `users_user`, `users_name`, `users_vorname`, `users_country`, `users_state`, `users_city`, `users_zip`, `users_street`, `users_corporation`, `users_phone`, `users_date`, `users_confirmed`) VALUES
(3, 'user', 'user', 'user', 'GB', 'asda', 'user', '41-444', 'user', 'user', NULL, '2012-06-22 19:34:15', 0),
(4, 'admin', 'Admin', 'admin', 'PL', 'admin', 'admin', '66-666', 'admin', 'Admin', NULL, '2012-06-28 21:06:24', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
