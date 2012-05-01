<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   messages.php      *************************
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
	exit;
	}
if(!($XVwebEngine->Session->Session('Logged_Logged'))){ // przekierowanie, jak nie zalogowany
	header("location: ".$URLS['Script'].'System/LogIn/');
	exit;
	}
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
xv_load_lang('user');

$IDMessage = strtolower($XVwebEngine->GetFromURL($PathInfo, 2));
$ActualPage = (int) ifsetor($_GET['Page'], 0);
$RecordsLimit=30;

if(isset($_GET['Delete']) && isset($_POST['DeleteMSG']) && is_array($_POST['DeleteMSG']))
	$XVwebEngine->Messages()->Delete($_POST['DeleteMSG']);
if(isset($_GET['Trash']) && isset($_POST['DeleteMSG']) && is_array($_POST['DeleteMSG']))
	$XVwebEngine->Messages()->Trash($_POST['DeleteMSG']);

if(!empty($IDMessage) && is_numeric($IDMessage)){
	$Smarty->assign('Page', "message");
	$Message = $XVwebEngine->Messages()->Get($IDMessage);
	if(!$Message){
		header("location: ".$URLS['Script'].'System/Error/');
	exit;
	}
	$Smarty->assign('Message', $Message);
}else{

	switch($IDMessage)
	{
		case 'write':
		$Smarty->assign('Page', "write");
		 if(isset($_GET['Send']) && isset($_POST['To']) && isset($_POST['Topic']) &&  isset($_POST['Message'])){
			$Smarty->assign('Result', $XVwebEngine->Messages()->Send($_POST['To'], $_POST['Message'], $_POST['Topic']));;
		 }
		break;
	   case 'sent':
		 $ListMessages = $XVwebEngine->Messages()->GetList(array(
			"ActualPage"=>$ActualPage, 
			"EveryPage"=>$RecordsLimit,
			"SortBy" => (isset($_GET['SortBy']) ?  $_GET['SortBy'] : "ID"),
			"Desc"=>(isset($_GET['Sort']) ?  $_GET['Sort'] : "desc"),
			"AvantFrom"=>"To",
			"Where"=> array(
				"From"=> $XVwebEngine->Session->Session('Logged_User'),
				"Deleted"=> 0,
			)
			));
			$Smarty->assign('Page', "sent");
			
		  break;
	case 'trash':
		 $ListMessages = $XVwebEngine->Messages()->GetList(array(
			"ActualPage"=>$ActualPage, 
			"EveryPage"=>$RecordsLimit,
			"SortBy" => (isset($_GET['SortBy']) ?  $_GET['SortBy'] : "ID"),
			"Desc"=>(isset($_GET['Sort']) ?  $_GET['Sort'] : "desc"),
			"Where"=> array(
				"To"=> $XVwebEngine->Session->Session('Logged_User'),
				"Deleted"=> 1,
			)
			));
			$Smarty->assign('Page', "trash");
		  break;
	   default:
		 $ListMessages = $XVwebEngine->Messages()->GetList(array(
			"ActualPage"=>$ActualPage, 
			"EveryPage"=>$RecordsLimit,
			"SortBy" => (isset($_GET['SortBy']) ?  $_GET['SortBy'] : "ID"),
			"Desc"=>(isset($_GET['Sort']) ?  $_GET['Sort'] : "desc"),
			"Where"=> array(
				"To"=> $XVwebEngine->Session->Session('Logged_User'),
				"Deleted"=> 0,
			)
			));
		$Smarty->assign('Page', "inbox");
	}
$Smarty->assign('MessagesList', $ListMessages);
include_once($LocationXVWeb.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
$pager = pager($RecordsLimit, (int) $ListMessages->Count,  "?".$XVwebEngine->AddGet(array("Page"=>"-npage-id-"), true), $ActualPage);
$Smarty->assign('Pager', $pager);

}
$Smarty->display('messages_view.tpl');
