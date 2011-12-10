<?php

class ReadComment
{	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	function CommentRead($ID=null){
			if(!is_null($ID)){
				$this->Date['XVweb']->CommentRead['ID'] = $ID;
			}

			$CommentRead = $this->Date['XVweb']->DataBase->prepare('SELECT {Comments:*} FROM {Comments} WHERE {Comments:ID} = :IDExecute LIMIT 1');
			$CommentRead->execute(
			array(
				':IDExecute' => ($this->Date['XVweb']->CommentRead['ID'])
			)
			);
			if(!($CommentRead->rowCount())){
				return false;
			}
			
			$this->Date['XVweb']->CommentRead = $CommentRead->fetch();
			
			return true;
	}
}

?>