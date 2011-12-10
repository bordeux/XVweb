<?php
class XV_Ajax_get_tags {
	var $Date;
	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	public function run(){
		global $XVwebEngine;
			header ("content-type: text/javascript; charset: UTF-8");   
			echo json_encode(array("ids"=> htmlspecialchars($_GET['ids']), "tags"=>$XVwebEngine->EditArticle()->GetTags($_GET['ids'])));
			exit;
	}
}
?>