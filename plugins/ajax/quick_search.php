<?php
class XV_Ajax_quick_search {
	var $Date;
	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	public function run(){
	global $XVwebEngine;
		$RecordsLimit = $XVwebEngine->Config("config")->find('config pagelimit quicksearch')->text();
		$RecordsLimit = is_numeric($RecordsLimit) ? $RecordsLimit : 6;
		$SearchClass = &$XVwebEngine->module('SearchClass', 'SearchClass');
		$SearchClass->set("noContent", true);
		$SearchResult =  $SearchClass->Search($_GET['Search'], ifsetor($_GET['Page'], 0), $RecordsLimit);
		header ("content-type: text/javascript; charset: UTF-8");   
		echo json_encode($SearchResult);
		exit;
	}
}
?>