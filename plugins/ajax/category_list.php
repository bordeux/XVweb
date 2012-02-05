<?php
class XV_Ajax_category_list {
	var $Date;
	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	public function getList($URL){
			$GetArticles = $this->Date['XVweb']->DataBase->prepare('SELECT {Text_Index:URL} AS `URL` FROM {Text_Index} WHERE {Text_Index:URL} LIKE :URLSearch ORDER BY {Text_Index:URL} ASC LIMIT 30');
			$GetArticles->execute(array(':URLSearch' => '%'.($URL).'%'));
			return ($GetArticles->fetchAll(PDO::FETCH_ASSOC));
	}
	public function run(){
	$Text_Index = $this->getList($_GET['url']);
	header ("content-type: text/javascript; charset: UTF-8");   
	echo json_encode($Text_Index);
	exit;
	}
}
?>