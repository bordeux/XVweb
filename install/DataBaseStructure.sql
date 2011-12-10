/*
# SQL DUMP: release
# GENERATED: 15.06.2010 12:02:00
*/
/*TABLE STRUCTURE FOR `||Prefix||antyflood */ 

CREATE TABLE `||Prefix||antyflood` (
  `ip` char(100) COLLATE utf8_polish_ci DEFAULT NULL,
  `timeout` char(200) COLLATE utf8_polish_ci DEFAULT NULL,
  `type` char(100) COLLATE utf8_polish_ci DEFAULT NULL,
  KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

/*SQL TABLE RECORDS FOR `||Prefix||antyflood */ 



/*TABLE STRUCTURE FOR `||Prefix||article */ 

CREATE TABLE `||Prefix||article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idarticle` varchar(13) COLLATE utf8_polish_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `topic` char(200) COLLATE utf8_polish_ci DEFAULT NULL,
  `contents` longtext COLLATE utf8_polish_ci,
  `author` char(100) COLLATE utf8_polish_ci DEFAULT NULL,
  `descriptionofchange` char(240) COLLATE utf8_polish_ci DEFAULT NULL,
  `version` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `topic` (`topic`,`contents`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

/*SQL TABLE RECORDS FOR `||Prefix||article */ 


/*TABLE STRUCTURE FOR `||Prefix||articleindex */ 

CREATE TABLE `||Prefix||articleindex` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `url` char(200) COLLATE utf8_polish_ci DEFAULT NULL,
  `topic` char(200) CHARACTER SET utf8 DEFAULT NULL,
  `tags` text CHARACTER SET utf8,
  `category` char(100) CHARACTER SET utf8 DEFAULT NULL,
  `adressinsql` varchar(13) COLLATE utf8_polish_ci DEFAULT NULL,
  `blocked` int(2) NOT NULL,
  `accepted` int(1) NOT NULL DEFAULT '1',
  `options` text COLLATE utf8_polish_ci NOT NULL,
  `alias` tinyint(1) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

/*SQL TABLE RECORDS FOR `||Prefix||articleindex */ 


/*TABLE STRUCTURE FOR `||Prefix||ban */ 

CREATE TABLE `||Prefix||ban` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ban_ip` char(40) COLLATE utf8_polish_ci DEFAULT NULL,
  `ban_email` char(64) COLLATE utf8_polish_ci DEFAULT NULL,
  `ban_timeout` date DEFAULT NULL,
  `message` text COLLATE utf8_polish_ci NOT NULL,
  `byadmin` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ban_ip` (`ban_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

/*SQL TABLE RECORDS FOR `||Prefix||ban */ 



/*TABLE STRUCTURE FOR `||Prefix||bookmarks */ 

CREATE TABLE `||Prefix||bookmarks` (
  `uniq` varchar(11) COLLATE utf8_polish_ci NOT NULL,
  `ids` int(11) NOT NULL,
  `type` varchar(31) COLLATE utf8_polish_ci NOT NULL DEFAULT 'article',
  `observed` tinyint(1) NOT NULL,
  `bookmark` tinyint(1) NOT NULL,
  `user` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  UNIQUE KEY `uniq` (`uniq`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

/*SQL TABLE RECORDS FOR `||Prefix||bookmarks */ 



/*TABLE STRUCTURE FOR `||Prefix||comments */ 

CREATE TABLE `||Prefix||comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` char(100) COLLATE utf8_polish_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `idarticleinsql` char(13) COLLATE utf8_polish_ci DEFAULT NULL,
  `ip` char(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `comment` text COLLATE utf8_polish_ci,
  `parsed` text COLLATE utf8_polish_ci NOT NULL,
  `modification` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

/*SQL TABLE RECORDS FOR `||Prefix||comments */ 



/*TABLE STRUCTURE FOR `||Prefix||counter */ 

CREATE TABLE `||Prefix||counter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_polish_ci NOT NULL DEFAULT '0',
  `datestring` char(70) COLLATE utf8_polish_ci DEFAULT NULL,
  `dateday` date DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `value` char(50) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

/*SQL TABLE RECORDS FOR `||Prefix||counter */ 


/*TABLE STRUCTURE FOR `||Prefix||files */ 

CREATE TABLE `||Prefix||files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `userfile` char(200) COLLATE utf8_polish_ci DEFAULT NULL,
  `filename` char(200) COLLATE utf8_polish_ci DEFAULT NULL,
  `extension` char(10) COLLATE utf8_polish_ci DEFAULT NULL,
  `lastdownload` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` char(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `md5hash` char(32) COLLATE utf8_polish_ci DEFAULT NULL,
  `sha1` char(40) COLLATE utf8_polish_ci DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `owner` tinyint(1) NOT NULL,
  `downloads` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

/*SQL TABLE RECORDS FOR `||Prefix||files */ 



/*TABLE STRUCTURE FOR `||Prefix||log */ 

CREATE TABLE `||Prefix||log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `type` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `who` varchar(200) COLLATE utf8_polish_ci DEFAULT NULL,
  `text` text COLLATE utf8_polish_ci,
  `ip` varchar(34) COLLATE utf8_polish_ci NOT NULL DEFAULT 'localhost',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci CHECKSUM=1;

/*SQL TABLE RECORDS FOR `||Prefix||log */ 

INSERT INTO `||Prefix||log` (`id`, `date`, `type`, `who`, `text`, `ip`) VALUES ('1', '2010-06-15 14:01:57', 'LoggedUser', 'bordeux', 'a:1:{s:4:\"User\";s:7:\"bordeux\";}', '89.25.173.41');


/*TABLE STRUCTURE FOR `||Prefix||messages */ 

CREATE TABLE `||Prefix||messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `topic` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `from` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `to` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `message` text COLLATE utf8_polish_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `read` tinyint(1) NOT NULL DEFAULT '0',
  KEY `id` (`id`),
  KEY `to` (`to`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

/*SQL TABLE RECORDS FOR `||Prefix||messages */ 



/*TABLE STRUCTURE FOR `||Prefix||online */ 

CREATE TABLE `||Prefix||online` (
  `ip` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `location` varchar(250) COLLATE utf8_polish_ci DEFAULT NULL,
  `time` int(11) NOT NULL,
  `browser` varchar(250) COLLATE utf8_polish_ci DEFAULT NULL,
  `userloged` varchar(150) COLLATE utf8_polish_ci DEFAULT NULL,
  `sid` varchar(33) COLLATE utf8_polish_ci DEFAULT NULL,
  KEY `ip` (`ip`),
  KEY `ip_2` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci COMMENT='Online Counter';

/*SQL TABLE RECORDS FOR `||Prefix||online */ 



/*TABLE STRUCTURE FOR `||Prefix||pastcode */ 

CREATE TABLE `||Prefix||pastcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `expired` datetime NOT NULL,
  `user` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `type` char(40) COLLATE utf8_polish_ci NOT NULL,
  `ip` char(50) COLLATE utf8_polish_ci NOT NULL,
  `code` longtext COLLATE utf8_polish_ci NOT NULL,
  `counter` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

/*SQL TABLE RECORDS FOR `||Prefix||pastcode */ 



/*TABLE STRUCTURE FOR `||Prefix||session */ 

CREATE TABLE `||Prefix||session` (
  `sid` varchar(33) COLLATE utf8_polish_ci NOT NULL,
  `ip` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `value` text COLLATE utf8_polish_ci NOT NULL,
  `time` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  KEY `sid` (`sid`,`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

/*SQL TABLE RECORDS FOR `||Prefix||session */ 

/*TABLE STRUCTURE FOR `||Prefix||users */ 

CREATE TABLE `||Prefix||users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` char(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `openid` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `sex` varchar(1) COLLATE utf8_polish_ci NOT NULL,
  `name` char(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `vorname` char(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `password` char(100) COLLATE utf8_polish_ci DEFAULT NULL,
  `mail` char(70) COLLATE utf8_polish_ci DEFAULT NULL,
  `gg` int(11) DEFAULT NULL,
  `icq` char(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `skype` char(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `tlen` char(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `page` char(60) COLLATE utf8_polish_ci DEFAULT NULL,
  `signature` text COLLATE utf8_polish_ci,
  `born` date DEFAULT NULL,
  `creation` datetime DEFAULT NULL,
  `info` text COLLATE utf8_polish_ci,
  `wherefrom` char(200) COLLATE utf8_polish_ci DEFAULT NULL,
  `avant` tinyint(1) DEFAULT NULL,
  `ip` text COLLATE utf8_polish_ci,
  `admin` char(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `theme` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `registercode` char(9) COLLATE utf8_polish_ci DEFAULT '1',
  `languages` char(200) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uzytkownik` (`user`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

/*SQL TABLE RECORDS FOR `||Prefix||users */ 

/*TABLE STRUCTURE FOR `||Prefix||votes */ 

CREATE TABLE `||Prefix||votes` (
  `uniq` varchar(32) COLLATE utf8_polish_ci NOT NULL,
  `sid` int(11) NOT NULL,
  `type` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `ip` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `user` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `vote` int(11) NOT NULL,
  UNIQUE KEY `Unique` (`uniq`),
  KEY `TSidIndex` (`sid`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci COMMENT='Tabela do ocen';

/*SQL TABLE RECORDS FOR `||Prefix||votes */ 


DROP TRIGGER IF EXISTS `onAfterInsertArticle`;
DELIMITER //
CREATE TRIGGER `onAfterInsertArticle` AFTER INSERT ON `||Prefix||article`
 FOR EACH ROW BEGIN
     UPDATE `||Prefix||articleindex`
     SET `actualversion` = NEW.`version`
     WHERE `adressinsql` = NEW.`idarticle`;
 END
//
DELIMITER ;



