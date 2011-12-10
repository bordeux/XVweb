<?php


class EditArticle
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	function EditTagArticle($ArticleID, $Tags){
		if(!$this->Date['XVweb']->permissions('EditTag')){
			$this->Date['XVweb']->LoadException();
			throw new XVwebException(123);
			return false;
		}
			if(!is_numeric($ArticleID)){
				return false;
			}

			$Tags =  $this->Date['XVweb']->LightText($Tags);

			$EditTags = $this->Date['XVweb']->DataBase->prepare('UPDATE {ListArticles} SET {ListArticles:Tag} = :TagsExecute WHERE {ListArticles:ID} = :IDExecute');
			$EditTagsReturn = $EditTags->execute(
			array(
			':TagsExecute' => $Tags,
			':IDExecute' => $ArticleID 
			)
			);
			if($EditTagsReturn){

				$IDtoURLTmp = $this->Date['XVweb']->IDtoURL($ArticleID);
				$this->Date['XVweb']->Cache->clear("ArticleBlockedURL", $IDtoURLTmp);
				$this->Date['XVweb']->Cache->clear("Article", $IDtoURLTmp);
				$this->Date['XVweb']->Cache->clear("Article-Include", $IDtoURLTmp);
				$this->Date['XVweb']->Cache->clear("ArticleBlocked", $ArticleID);
				$this->Date['XVweb']->Log("EditTags", array("ArticleURL"=>$IDtoURLTmp, "ArticleID"=>$ArticleID));
				return true;
			} else
			return false;
	}

}

?>