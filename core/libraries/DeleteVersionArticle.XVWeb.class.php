<?php


class DeleteVersionArticleClass
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}

	public function DeleteLastVersion($IDarticle){
			if(!is_numeric($IDarticle))
			return false;
			$this->Date['XVweb']->ArticleFooIDinArticleIndex = $IDarticle;
			if(!$this->Date['XVweb']->ReadArticle())
			return false;
			if(($this->Date['XVweb']->ReadArticleOut['Version'])==1){
				if(!$this->Date['XVweb']->permissions('DeleteArticle'))
				return false;
				
				$this->Date['XVweb']->EditArticle()->DeleteArticle($this->Date['XVweb']->ReadArticleIndexOut['ID']);
				return true;
			}else{
				if(!$this->Date['XVweb']->permissions('DeleteVersion'))
				return false;
				$DeleteLastVersion = $this->Date['XVweb']->DataBase->prepare('
DELETE FROM {Articles} WHERE {Articles:ID} = :IDVerExecute ;');
				$DeleteLastVersion->execute(array(
					":IDVerExecute"=>$this->Date['XVweb']->ReadArticleOut['ID']
				));
				return true;
			}
	}
	
	public function DLVwithID($IDarticle, $Version){
		if(!$this->Date['XVweb']->permissions('DeleteVersion'))
				return false;
			$VersionCount = $this->Date['XVweb']->DataBase->prepare('SELECT count(*) AS `Count`, {Articles:AdressInSQL} AS `AdressInSQL` FROM {Articles} S WHERE {Articles:AdressInSQL} = (SELECT {Text_Index:AdressInSQL} FROM {Text_Index} WHERE {Text_Index:ID} = :IDAIExecute  LIMIT 1) LIMIT 1;');
			$VersionCount->execute(array(
			":IDAIExecute" => $IDarticle
			));
			$VersionCount = $VersionCount->fetch();
			$VersionInSQL= $VersionCount['AdressInSQL'];
			$VersionCount = $VersionCount['Count'];
			if($VersionCount == $Version)
				return $this->DeleteLastVersion($IDarticle);
			

			if($VersionCount > $Version){
				$VersionDelUpd = $this->Date['XVweb']->DataBase->prepare('DELETE FROM {Articles} WHERE {Articles:Version} = :VersionExec AND {Articles:AdressInSQL} = :AdressSQLExec ;
UPDATE {Articles} SET  {Articles:Version} = {Articles:Version}-1 WHERE {Articles:Version} > :VersionExec AND {Articles:AdressInSQL} = :AdressSQLExec ;');

				$VersionDelUpd->execute(array(
				":VersionExec"=>$Version,
				":AdressSQLExec" => $VersionInSQL
				));
				$this->Date['XVweb']->Log("DeleteVArticle", serialize(array($Version, $VersionInSQL)));
				return true;
			}
	}
	

	

}

?>