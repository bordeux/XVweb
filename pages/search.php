<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   search.php        *************************
****************   Start     :   22.05.2007 r.     *************************
****************   License   :   LGPL              *************************
****************   Version   :   1.0                *************************
****************   Authors   :   XVweb team         *************************
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

if($_GET['LogOut']=="true"){
	$XVwebEngine->LogOut();
	header("location: ?");
	exit;
}


//Funckcje Search

//Koniec
$RecordsLimit = ifsetor($XVwebEngine->Config("config")->find('config pagelimit search')->text(), 30);

$SearchKeyword = $_GET['Search'];
if(!isset($_GET['Search']))
$SearchKeyword = $XVwebEngine->GetFromURL($PathInfo, 2);

if(ifsetor($_GET['AllVersion'], "false") == "true")
	$XVwebEngine->SearchInVersion = true;

$ActualPage = 0;

if(is_numeric($_GET['Page']))
$ActualPage = $_GET['Page'];

$Smarty->assign('ContextEdit',  "Search");

$Smarty->assign('SiteTopic',  xvLang("Search")." : ". htmlspecialchars($SearchKeyword));

include_once($LocationXVWeb.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');

$Smarty->assign('SearchArray',  $XVwebEngine->Search($SearchKeyword, $ActualPage, $RecordsLimit));
$pager = pager($RecordsLimit, (int) $XVwebEngine->Date['SearchResultCount'],  "?".$XVwebEngine->AddGet(array("Page"=>"-npage-id-"), true), $ActualPage);
$Smarty->assign('Pager',        $pager);
$Smarty->assign('ActualPage',   $ActualPage);


/**************************THEME*******************/
$Smarty->display('search_show.tpl');
eval($XVwebEngine->Plugins()->Menager()->event("endload"));
?>