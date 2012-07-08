-- phpMyAdmin SQL Dump
-- version 3.4.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 08, 2012 at 01:52 PM
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
-- Table structure for table `xv_users`
--

CREATE TABLE IF NOT EXISTS `xv_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(50) NOT NULL DEFAULT '' COMMENT 'Nick danego użytkownika - Kluczowy',
  `password` blob COMMENT 'Password hash',
  `mail` varchar(70) DEFAULT NULL COMMENT 'Adres Email',
  `config` text COMMENT 'User config in serialized object',
  `creation` datetime DEFAULT NULL COMMENT 'Data utworzenia konta',
  `info` text,
  `avant` tinyint(1) DEFAULT NULL COMMENT 'Avant - 1 - tak, 0 nie',
  `ip` text,
  `theme` varchar(50) DEFAULT NULL,
  `registercode` varchar(17) DEFAULT '1' COMMENT 'Kod podczas rejestracji - 1 oznacz ze user jest aktywowany',
  `views` int(11) NOT NULL DEFAULT '1' COMMENT 'Ilość wyświetleń profilu',
  `logincount` int(11) NOT NULL DEFAULT '1' COMMENT 'Ilość zalogowań do serwisu',
  `lastlogin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Data ostaniego zalogowania',
  `users_group` varchar(32) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`,`user`),
  KEY `uzytkownik` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `xv_users`
--

INSERT INTO `xv_users` (`id`, `user`, `password`, `mail`, `config`, `creation`, `info`, `avant`, `ip`, `theme`, `registercode`, `views`, `logincount`, `lastlogin`, `users_group`) VALUES
(1, 'admin', 0x37316266613438386262633633333161313164393036636361343262393037373230616461643230343664376336306639363134316464393561323538346431, 'xvwebcms@bordeux.net', 'a:1:{s:14:"administration";a:2:{s:10:"background";s:79:"url(http://titek.pl/XVweb.git/admin/data/themes/default/backgrounds/tiesto.jpg)";s:7:"widgets";a:2:{s:10:"wg-3290896";a:4:{s:3:"top";s:5:"376px";s:4:"left";s:6:"1116px";s:4:"name";s:6:"status";s:3:"wid";s:10:"wg-3290896";}s:10:"wg-7621760";a:4:{s:3:"top";s:4:"53px";s:4:"left";s:6:"1116px";s:4:"name";s:4:"note";s:3:"wid";s:10:"wg-7621760";}}}}', '2012-01-11 05:20:20', NULL, 1, '89.25.173.41, host892517341.alltex.3s.pl, Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.162 Safari/535.19', NULL, '1', 709, 72, '2012-04-23 20:51:17', 'admin'),
(5, 'user', 0x61616430643865353861343034333237343565653037633132373265383564653830356461313537376537343835326337326364633735306561643163316530, 'user@user.com', NULL, '2012-05-20 22:49:00', NULL, 1, NULL, NULL, '1', 1, 1, '0000-00-00 00:00:00', 'user');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
