<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   users.php         *************************
****************   Start     :   22.05.2007 r.     *************************
****************   License   :   LGPL              *************************
****************   Version   :   1.0               *************************
****************   Authors   :   XVweb team        *************************
*************************XVweb Team*****************************************
				Krzyszof Bednarczyk, meybe you
/////////////////////////////////////////////////////////////////////////////
Klasa XVweb jest na licencji LGPL v3.0 ( GNU LESSER GENERAL PUBLIC LICENSE)
****************http://www.gnu.org/licenses/lgpl-3.0.txt********************
		Pełna dokumentacja znajduje się na stronie domowej projektu: 
*********************http://www.bordeux.NET/Xvweb***************************
***************************************************************************/
if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
}
set_time_limit(0); 
class MConfig {
	var $dbtype = 'mysql';
	var $host = 'localhost';
	var $user = 'root';
	var $db = 'movies';
	var $password = 'polska';
}

$Config = new MConfig;

try {
	$dbh2 = new PDO('mysql:host='.$Config->host.';dbname='.$Config->db, $Config->user, $Config->password);
	$dbh2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbh2->setAttribute(PDO::ATTR_PERSISTENT, true);
	$dbh2->setAttribute(PDO::MYSQL_ATTR_DIRECT_QUERY, 1);
	$dbh2->query("SET NAMES 'utf8' COLLATE 'utf8_bin'");
} catch (PDOException $e) {
	var_dump( $e);
	exit;
}


$categories = array();
function setcategory($category){
	global $categories, $XVwebEngine;
	if(!isset($categories[$category])){
		$XVwebEngine->EditArticle()->Add("/Filmy/Online/".$category."/", "", "bordeux", $category, "/Filmy/Online/");
		$categories[$category] = true;
	}
	return "/Filmy/Online/".$category."/";
}

foreach($dbh2->query("SELECT * FROM  `filmy` WHERE `added` <> 1 ") as $Movie){
	//$Movie['id']
	//$Movie['title']
	//$Movie['thumbnail']
	//$Movie['kino5url']
	//$Movie['megavideo']
	//$Movie['description']
	//$Movie['embed']
	//$Movie['categories'] // explode("|", $Movie['categories'])
	//$Movie['tags']
	//$Movie['added']
	$TitleMovie = trim(str_replace(array("/", "&", "?"),array("-", "and", ""), $Movie['title']));
	$CategoriesMovie = explode("|", $Movie['categories']);
	$TagsMovie = explode("|", $Movie['tags']);

	$LastID = true;
	foreach($CategoriesMovie as $Category){
		if($LastID === true){
			$XVwebEngine->EditArticle()->Add(setcategory(($Category)).$TitleMovie."/", "
	<nobr all='true' />
	<table id='MegaVideoTable'>
		<tr>
			<td><img src='".$Movie['thumbnail']."' /></td>
			<td style='padding-left:10px'><info name='description'>".trim($Movie['description'])."</info></td>
		</tr>
		<tr>
	</table>
	
	<center><megavideo>http://www.megavideo.com/?v=".trim($Movie['megavideo'])."</megavideo></center> <br />
		<info name='kino5url' hidden='true'>".$Movie['kino5url']."</info>
		<info name='categories' hidden='true'>".trim($Movie['categories'])."</info>
		<info name='tags' hidden='true'>".trim($Movie['tags'])."</info>
		<info name='megavideo' hidden='true'>".$Movie['megavideo']."</info>
		<info name='thumbnail' hidden='true'>".$Movie['thumbnail']."</info>
	", "bordeux", $TitleMovie, setcategory($Category));
			$LastID = $XVwebEngine->DataBase->query('SELECT max(`id`)  AS `LastID` FROM `xv_articleindex`;')->fetch(PDO::FETCH_OBJ)->LastID;
		}else{
			$XVwebEngine->EditArticle()->AddAlias(setcategory($Category).$TitleMovie."/", $LastID);
		}


	}
	$dbh2->query("UPDATE `filmy` SET `added` = 1 WHERE `id` =  '".$Movie['id']."' LIMIT 1;");
}
//AddAlias($url, $IDArticle)
//$XVwebEngine->->Admin['AutoAccept'] = 1;
//var_dump($XVwebEngine->EditArticle()->Add("/te5st224sf/", "asdasdasdas", "bordeux", "tesmat", "/"));
exit;
?>