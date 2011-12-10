<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   admin.php         *************************
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
	exit;
}
set_time_limit(0); 
class XVCron
{	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	
	public function &SQLDump(){
		if(empty($this->Date['XVweb']->Date['Classes']['SQLDump'])){
			include_once($GLOBALS['XVwebDir'].DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'SQLDump.XVWeb.class.php');
			$this->Date['XVweb']->Date['Classes']['SQLDump'] = new SQLDump($this->Date['XVweb']);
		}
		return $this->Date['XVweb']->Date['Classes']['SQLDump'];
	}

}
$sql = !isset($_GET['cache']);
	if($XVwebEngine->Plugins()->Menager()->event("pre.cron")) eval($XVwebEngine->Plugins()->Menager()->event("pre.cron"));
	$Smarty->clearAllCache();
		$XVwebEngine->Cache->clear(); // clear all cache
		if($sql){
		$FileName = date('Y-m-d')."-SQLDump.sql";
			$SQLFile = $RootDir.'backups'.DIRECTORY_SEPARATOR.$FileName;
			$XVwebEngine->InitClass("XVCron")->SQLDump()->dump($SQLFile);
			$XVwebEngine->InitClass("XVCron")->SQLDump()->toGZip();
			//**Plugins**/
			if($XVwebEngine->Plugins()->Menager()->event("oncron")) eval($XVwebEngine->Plugins()->Menager()->event("oncron"));
			@unlink($SQLFile);
		}



?>