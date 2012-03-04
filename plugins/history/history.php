<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   history.php       *************************
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
header("Cache-Control: no-cache, must-revalidate");
if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
}
$ArticleID = $XVwebEngine->GetFromURL($PathInfo, 2);
if(strtolower($ArticleID) =="diff"){
	//URL: /diff{2}/ArticleIndexID{3}/Version1{4}/Version2{5}/
	if(!is_numeric($XVwebEngine->GetFromURL($PathInfo, 3)) or
			!is_numeric($XVwebEngine->GetFromURL($PathInfo, 4)) or
			!is_numeric($XVwebEngine->GetFromURL($PathInfo, 5))){
		header("location: ".$URLS['Script'].'System/InvalidArguments/');
		exit;
	}

	$Smarty->assign(
	'Diff', 
	$XVwebEngine->DiffClass()->DiffArticle($XVwebEngine->GetFromURL($PathInfo, 3), $XVwebEngine->GetFromURL($PathInfo, 4), $XVwebEngine->GetFromURL($PathInfo, 5) )
	);

	/**************************THEME*******************/
	$Smarty->assign('Title', $GLOBALS['Language']['Diff']);
	$Smarty->assign('SiteTopic', $GLOBALS['Language']['Diff']);
	$Smarty->display('diff_show.tpl');




	exit;
}elseif(!is_numeric($ArticleID)){
	header("location: ".$URLS['Script'].'System/InvalidArguments/');
	exit;
}
$GetHistory = $XVwebEngine->GetHisotryAricle($ArticleID);
if($GetHistory['Result'] == false){
	header("location: ".$URLS['Script'].'System/ArticleDoesNotExist/');
	exit;
}
$Smarty->assign('ArticleID', $ArticleID);
$Smarty->assign('History', $GetHistory['Result']);
$Smarty->assign('StructureTable', $GetHistory['StructureTable']);
$Smarty->assign('ArticleURL', $GetHistory['URL']);

/**************************THEME*******************/
$Smarty->assign('Title', $GLOBALS['Language']['History']);
$Smarty->assign('SiteTopic', $GLOBALS['Language']['History']);
$Smarty->display('history_show.tpl');
?>