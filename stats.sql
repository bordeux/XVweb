SELECT 
	(SElECT SUM(`views`) FROM `xv_articleindex` WHERE 1) as `ArticlesViews`,
	(SElECT COUNT(1) FROM `xv_articleindex` WHERE 1) as `Articles`,
	(SElECT COUNT(1) FROM `xv_articleindex` WHERE `alias` = 1) as `Alias`,
	(SElECT COUNT(1) FROM `xv_article` WHERE  1) as `Modifitations`,
	(SElECT COUNT(1) FROM `xv_ban` WHERE  1) as `Bans`,
	(SElECT COUNT(1) FROM `xv_bookmarks` WHERE  1) as `Bookmakrs`,
	(SElECT COUNT(1) FROM `xv_comments` WHERE  1) as `Comments`,
	(SElECT COUNT(1) FROM `xv_files` WHERE  1) as `Files`,
	(SElECT SUM(`size`) FROM `xv_files` WHERE  `owner` = 1) as `FilesSize`,
	(SElECT SUM(`size`*`downloads`) FROM `xv_files` WHERE  1) as `FilesBandwidth`,
	(SElECT SUM(`downloads`) FROM `xv_files` WHERE  1) as `FilesFownloads`,
	(SElECT COUNT(1) FROM `xv_messages` WHERE  1) as `Messagess`,
	(SElECT COUNT(1) FROM `xv_users` WHERE  1) as `Users`,
	(SElECT COUNT(1) FROM `xv_votes` WHERE  1) as `Votes`,
	(SElECT COUNT(1) FROM `xv_votes` WHERE   `vote` > 0) as `VotesPlus`,
	(SElECT COUNT(1) FROM `xv_votes` WHERE   `vote` < 0 OR `vote` = 0) as `VotesMinus`,
	(SELECT `user` FROM `xv_users` WHERE 1 ORDER BY `creation` DESC LIMIT 1) as `LastUsers`,
	
	
	/* TABELA Z RANKINKIEM KOMENTYJĄCYCH */
	SELECT `author` AS `Author` , COUNT(`author`) AS `CommentsCount` FROM `xv_comments` GROUP BY `author` ORDER BY `CommentsCount` DESC LIMIT 10
	/* TABELA Z RANKINKIEM OCENIAJACYCH */
	SELECT `user` AS `user` , COUNT(`user`) AS `VotesUserCount` FROM `xv_votes` WHERE `user` NOT LIKE 'NoLoged|%' GROUP BY `user` ORDER BY `VotesUserCount` DESC LIMIT 10	
	/* TABELA Z RANKINKIEM PLIKOW */
	SELECT `userfile` AS `User` , COUNT(`userfile`) AS `FilesUserCount` FROM `xv_files` GROUP BY `userfile` ORDER BY `FilesUserCount` DESC LIMIT 10
	/* TABELA Z RANKINGIEM ILOSCI OGLADAN ARTYKUŁÓW */
	SELECT * FROM `xv_articleindex` ORDER BY `views` DESC LIMIT 10;
	/* TABELA Z RANKINGIEM ILOSCI MODYFIKACJI */
	SELECT `author` AS `Author` , COUNT(`author`) AS `UserArticles` FROM `xv_article` GROUP BY `author` ORDER BY `UserArticles` DESC LIMIT 10
	/* TABELA Z RANKINKIEM DODAJACYCH DO ZAKLADEK */
	SELECT `user` AS `User` , COUNT(`user`) AS `BookmarksUserCount` FROM `xv_bookmarks` GROUP BY `user` ORDER BY `BookmarksUserCount` DESC LIMIT 10
	
	
	