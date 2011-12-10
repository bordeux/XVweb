<?php


class SaveModComment
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	function SaveModificationComment($ID = null, $Comment=null){
		if(!is_null($Comment)){
			$this->Date['XVweb']->SaveModificatio['Comment']= $Comment;
		}
		if(!is_null($ID)){
			$this->Date['XVweb']->SaveModification['IDComment']= $ID;
		}
		if(!is_numeric($this->Date['XVweb']->SaveModification['IDComment'])){
			return false;
		}

		if(!$this->Date['XVweb']->CommentRead(($this->Date['XVweb']->SaveModification['IDComment']))){
			$this->Date['XVweb']->SaveModification['Error']=1; // brak commenta
			return false;
		}

		if(($this->Date['XVweb']->CommentRead['Author']) != $this->Date['XVweb']->Session->Session('Logged_User')){
			if(!$this->Date['XVweb']->permissions('EditCommentOther') && !$this->Date['XVweb']->permissions('EditComment')){
				$this->Date['XVweb']->SaveModification['Error']=2; // brak uprawnien
				return false; 
			}

		}

		if(!is_numeric($this->Date['XVweb']->SaveModification['IDComment'])){
			$this->Date['XVweb']->SaveModification['Error']=3; // brak uprawnien
			return false; 
		}


			$SaveModificationCommentSQL = $this->Date['XVweb']->DataBase->prepare('UPDATE {Comments}  SET  {Comments:Comment} = :CommentComment , {Comments:Parsed} = :ParsedComment , {Comments:ModificationDate} = NOW() WHERE {Comments:ID} = :IDExecute');
			$SaveModificationCommentSQL->execute(
			array(
			':CommentComment' => ($this->Date['XVweb']->SaveModification['Comment']),
			':ParsedComment' => $this->Date['XVweb']->TextParser()->CommentParse($this->Date['XVweb']->SaveModification['Comment']),
			':IDExecute' => $this->Date['XVweb']->SaveModification['IDComment']
			)
			);
		$this->Date['XVweb']->Cache->clear("Comment", $this->Date['XVweb']->CommentRead['IDArticleInSQL']);
		$this->Date['XVweb']->Log("EditComment", serialize(array($this->Date['XVweb']->SaveModification['IDComment'],$this->Date['XVweb']->CommentRead['IDArticleInSQL'])));
		return true;

	}

}

?>