<?php
class XV_Ajax_category_list {
	var $Date;
	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	public function getList($URL){
			$GetArticles = $this->Date['XVweb']->DataBase->prepare('SELECT {ListArticles:URL} AS `URL` FROM {ListArticles} WHERE {ListArticles:URL} LIKE :URLSearch ORDER BY {ListArticles:URL} ASC LIMIT 30');
			$GetArticles->execute(array(':URLSearch' => '%'.($URL).'%'));
			return ($GetArticles->fetchAll(PDO::FETCH_ASSOC));
	}
	public function run(){
	$ListArticles = $this->getList($_GET['url']);
	header ("content-type: text/javascript; charset: UTF-8");   
	echo json_encode($ListArticles);
	exit;
	}
}
?>