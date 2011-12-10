<?php
class XV_Ajax_gmap_category_list {
	var $Date;
	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	public function getList(){
			$GetArticles = $this->Date['XVweb']->DataBase->prepare('SELECT {GMap:Category} AS `Category` FROM {GMap} GROUP BY {GMap:Category} ASC;');
			$GetArticles->execute();
			return ($GetArticles->fetchAll(PDO::FETCH_ASSOC));
	}
	public function run(){
	$ListArticles = $this->getList();
	header ("content-type: text/javascript; charset: UTF-8");   
	echo json_encode($ListArticles);
	exit;
	}
}
?>