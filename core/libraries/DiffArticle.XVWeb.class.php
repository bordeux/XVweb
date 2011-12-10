<?php
class DiffArticleClass
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}

	function DiffArticle($ArticleID, $Ver1, $Ver2){
		$CacheID = md5(serialize(func_get_args()));
			if($this->Date['XVweb']->Cache->exist("DiffArticle", $CacheID))
				return $this->Date['XVweb']->Cache->get();
	
			$this->Date['XVweb']->ArticleFooIDinArticleIndex = $ArticleID;
			
			$this->Date['XVweb']->ArticleFooVersion = $Ver1;
			if(!$this->Date['XVweb']->ReadArticle()){
			$this->Date['XVweb']->LoadException();
			throw new XVwebException(5);
			return false;
			}
			$VersionFirst  = $this->Date['XVweb']->ReadArticleOut;
			
			$this->Date['XVweb']->ArticleFooVersion = $Ver2;
			if(!$this->Date['XVweb']->ReadArticle()){
			$this->Date['XVweb']->LoadException();
			throw new XVwebException(5);
			return false;
			}
			$VersionSecond = $this->Date['XVweb']->ReadArticleOut;
		
		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'diff'.DIRECTORY_SEPARATOR.'difflib.php');
		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'diff'.DIRECTORY_SEPARATOR.'diffhtml.php');
		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'diff'.DIRECTORY_SEPARATOR.'difftableformatter.php');
		
			$diff = new Diff(explode("\n",$VersionFirst['Contents']),explode("\n",$VersionSecond['Contents']));
            $fmt = new HtmlTableDiffFormatter($Ver1,$Ver2,"sidebyside");

				return $this->Date['XVweb']->Cache->put("DiffArticle", $CacheID, (array('Result'=>$fmt->format($diff), 'First'=>$VersionFirst, 'Second'=>$VersionSecond)));
	}

}

?>