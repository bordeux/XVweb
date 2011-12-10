<?php


class HistoryArticle
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}

	function GetHisotryAricle($ID){
			if($this->Date['XVweb']->Cache->exist("ArticleHistory", $ID))
				return $this->Date['XVweb']->Cache->get();

			$this->Date['XVweb']->ArticleFooIDinArticleIndex = $ID;
			if(!$this->Date['XVweb']->ReadArticle()){
				return false;
			}

			$ReadArticleSQL = $this->Date['XVweb']->DataBase->prepare('SELECT {Articles:*} FROM {Articles} WHERE {Articles:AdressInSQL} = :AddressInSQLExecute  ORDER BY {Articles:Version} DESC');
			$ReadArticleSQL->execute(array(
			':AddressInSQLExecute' => ($this->Date['XVweb']->ReadArticleIndexOut['LocationInSQL'])
			));
			$ResultSQL = $ReadArticleSQL->fetchAll();
			
			/*
			foreach ( $ResultSQL  as $KeyHistory => $ValueHistory){
				foreach ( $this->Date['XVweb']->DataBaseArticle  as $KeyArticle=> $ValueArticle)
				$this->Date['XVweb']->array_change_key_name($ValueArticle,$KeyArticle, $ResultSQL[$KeyHistory]);

			}
			*/

			return $this->Date['XVweb']->Cache->put("ArticleHistory", $ID, (array('Result'=>$ResultSQL, 'URL'=>$this->Date['XVweb']->URLRepair($this->Date['XVweb']->ReadArticleIndexOut['URL']))));
	}

}

?>