<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   bans.php          *************************
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


class BansMenager
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	public function GetBans( $ActualPage = 0, $EveryPage =30, $SortBy = "ID", $Desc = "desc"){
			$LLimit = ($ActualPage*$EveryPage);
			$RLimit = $EveryPage;
			
			$ArticleSQL = $this->Date['XVweb']->DataBase->prepare('SELECT SQL_CALC_FOUND_ROWS
			{Bans:*}
	FROM {Bans} ORDER BY '.($this->Date['XVweb']->DataBase->isset_field("Bans", $SortBy) ? '{Bans:'.$SortBy.'}' : '{Bans:ID}').' '.($Desc == "asc" ? "ASC" : "DESC") .' LIMIT '.$LLimit.', '.$RLimit.';
	');
	
			$ArticleSQL->execute();
			$ArrayArticle = $ArticleSQL->fetchAll();
			
			return (object) array("List"=>$ArrayArticle , "BansCount"=>$this->Date['XVweb']->DataBase->pquery('SELECT FOUND_ROWS() AS `BansCount`;')->fetch(PDO::FETCH_OBJ)->BansCount);
	}
	public function AddBan($Ban,$Message, $TimeOut){
	$Ban = trim($Ban);
	if(!$this->checkDateFormat($date))
	$TimeOut = "2099-01-01";
	
		if (preg_match( "/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/", trim($Ban))){
		
				$DeleteSession = $this->Date['XVweb']->DataBase->prepare('DELETE FROM `'.($this->Date['XVweb']->DataBasePrefix).($this->Date['XVweb']->Session->Table['Table']).'` WHERE `'.($this->Date['XVweb']->Session->Table['IP']).'` = :IPExecute ;');
				$DeleteSession->execute(array(":IPExecute" => $Ban));
				
				$Query = 'INSERT INTO {Bans} ( {Bans:IP} , {Bans:TimeOut}, {Bans:Message}, {Bans:ByAdmin} ) VALUES (:Ban,:TimeOut,:Message, :ByAdmin) ON DUPLICATE KEY UPDATE {Bans:TimeOut} = :TimeOut, {Bans:Message} = :Message, {Bans:ByAdmin} = :ByAdmin ;';
			}else{
				$Query = 'INSERT INTO {Bans} ({Bans:Mail},{Bans:TimeOut} , {Bans:Message} , {Bans:ByAdmin} ) VALUES (:Ban,:TimeOut,:Message, :ByAdmin) ON DUPLICATE KEY UPDATE {Bans:TimeOut} = :TimeOut, {Bans:Message} = :Message, {Bans:ByAdmin} = :ByAdmin ;';
			}
			$SQLBan = $this->Date['XVweb']->DataBase->prepare($Query);
			$SQLBan->execute(array(
			":Ban" => $Ban,
			":TimeOut" => $TimeOut,
			":Message" => $Message,
			":ByAdmin" => $this->Date['XVweb']->Session->Session('Logged_User'),
			));
	
	}
	public function checkDateFormat($date){
	  if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts)){
			if(checkdate($parts[2],$parts[3],$parts[1]))
			  return true;
			else
			 return false;
	  }
	  else
		return false;
	}
}
if(isset($_GET['AddBan'])){
$XVwebEngine->InitClass("BansMenager")->AddBan($_GET['AddBan'], ifsetor($_GET['Message'], "none"), ifsetor($_GET['TimeOut'], 0));
}

$RecordsLimit=30;
$ActualPage = (int) ifsetor($_GET['Page'], 0);
$BansList = $XVwebEngine->InitClass("BansMenager")->GetBans($ActualPage,$RecordsLimit, $_GET['SortBy'], $_GET['Sort'] );
$Smarty->assign('BansList', $BansList);
include_once($LocationXVWeb.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
$pager = pager($RecordsLimit, (int) $BansList->BansCount,  "?".$XVwebEngine->AddGet(array("Page"=>"-npage-id-"), true), $ActualPage);
$Smarty->assign('Pager', $pager);


$Smarty->display('admin/bans_show.tpl');

?>