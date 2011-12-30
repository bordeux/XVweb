<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   online.php        *************************
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
if(!isset($XVwebEngine))
header("location: http://".$_SERVER['HTTP_HOST']."/");

if(isset($_GET['LogedUsers'])){
	//$load = $XVwebEngine->sys_getloadavg();
	//if ($load[0] > 80)
	//die($Language['ServerBusyForOperation']);
	$XVwebEngine->OnlineInit($_GET['UrlLocation']);
	$XVwebEngine->Date['Online']->GetLogedCount($_GET['UrlLocation']);
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	exit(json_encode($XVwebEngine->Date['Online']->GetLogedCount($_GET['UrlLocation'])));
}


if($_GET['Sort'] =="desc"){
	$SortType = "DESC";
}elseif($_GET['Sort'] =="ASC"){
	$SortType = "ASC";
}

switch (strtolower($_GET['SortBy'])) {
	case "ip":
		$SortBy = "IP";
		break;
	case "user":
		$SortBy = "User";
		break;
	case "url":
		$SortBy = "URL";
		break;
	case "info":
		$SortBy = "Info";
		break;
}


$RecordsLimit = 30;
$OnlineListClass = $XVwebEngine->OnlineList();
$ActualPage = (int) $_GET['Page'];
$OnlineDate = array("ActualPage"=>$ActualPage);
$OnlineList = $OnlineListClass->OnlineUserList();
$Smarty->assign('OnlineList', $OnlineList[0]);

include_once($LocationXVWeb.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
		$pager = pager($RecordsLimit, (int) $OnlineList[1]['count'],  "?".$XVwebEngine->AddGet(array("Page"=>"-npage-id-"), true), $ActualPage);
		
$Smarty->assign('Pager', $pager);

$Smarty->display('online_show.tpl');


?>