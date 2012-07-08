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
-- Table structure for table `xv_groups`
--

CREATE TABLE IF NOT EXISTS `xv_groups` (
  `groups_id` int(11) NOT NULL AUTO_INCREMENT,
  `groups_name` varchar(32) NOT NULL,
  `groups_permission` varchar(64) NOT NULL,
  `groups_options` text NOT NULL,
  PRIMARY KEY (`groups_id`),
  KEY `groups_name` (`groups_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=664 ;

--
-- Dumping data for table `xv_groups`
--

INSERT INTO `xv_groups` (`groups_id`, `groups_name`, `groups_permission`, `groups_options`) VALUES
(537, 'user', 'xva_API', ''),
(538, 'user', 'ViewArticle', ''),
(539, 'user', 'vide_can_play', ''),
(540, 'user', 'xva_payments', ''),
(541, 'user', 'xva_sell', ''),
(542, 'user', 'texts_view_page', ''),
(543, 'user', 'xva_view_auction_items', ''),
(544, 'user', 'xva_buy', ''),
(545, 'user', 'xva_view_auction', ''),
(546, 'user', 'xv_msg_access', ''),
(547, 'user', 'xv_api', ''),
(548, 'user', 'xv_msg_send', ''),
(549, 'anonymous', 'xva_view_auction', ''),
(550, 'anonymous', 'vide_can_play', ''),
(551, 'anonymous', 'ViewArticle', ''),
(552, 'anonymous', 'xv_api', ''),
(553, 'anonymous', 'texts_view_page', ''),
(554, 'anonymous', 'xva_view_auction_items', ''),
(647, 'admin', 'ip_ban_add_bans', ''),
(648, 'admin', 'xv_api', ''),
(649, 'admin', 'xva_API', ''),
(650, 'admin', 'texts_edit_page', ''),
(651, 'admin', 'texts_set_version', ''),
(652, 'admin', 'texts_view_page', ''),
(653, 'admin', 'texts_block_page', ''),
(654, 'admin', 'texts_create_page', ''),
(655, 'admin', 'xva_buy', ''),
(656, 'admin', 'xva_view_auction', ''),
(657, 'admin', 'xva_sell', ''),
(658, 'admin', 'xva_view_auction_items', ''),
(659, 'admin', 'vide_can_play', ''),
(660, 'admin', 'AdminPanel', ''),
(661, 'admin', 'xv_msg_access', ''),
(662, 'admin', 'xv_msg_send', ''),
(663, 'admin', 'xva_payments', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
