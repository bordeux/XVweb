<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   receiver.php      *************************
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
	exit();
}

class cron_config extends  xv_config {
	public function init_fields(){
		return array(
			"password" => '',
			"history" => array(),
		);
	}
}

include_once(dirname(__FILE__).'/cron.class.php');

$xv_cron_config = new cron_config();
$plugins_config = new xv_plugins_config();

$plugins_list = array();
	foreach($plugins_config->get_all() as $val)
			$plugins_list[] = $val["name"];
	
foreach (glob((ROOT_DIR.'plugins/{'.implode(",", $plugins_list).'}/cron/*.cron.class.php'),GLOB_BRACE) as $filename) {
	include_once($filename);
}
$xv_cron_classes = $XVwebEngine->get_classes_by_prefix("xv_cron_");
foreach($xv_cron_classes as $xv_cron_class){
	$xv_cron_item = new $xv_cron_class($XVwebEngine);
	$xv_cron_last_run = isset($xv_cron_config->history[$xv_cron_class]) ? $xv_cron_config->history[$xv_cron_class] :  0;
	$xv_cron_interval = xvp()->get_interval($xv_cron_item, $xv_cron_last_run);
	if((time()-$xv_cron_last_run) > $xv_cron_interval){
		xvp()->run($xv_cron_item);
		$array_history  = $xv_cron_config->history;
		$array_history[$xv_cron_class] = time();
		$xv_cron_config->history = $array_history;
	}
}
echo "{done}";
?>