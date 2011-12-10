<?php


class ArticleToPDF
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	public function CreatePDF(){
			if(!isset($this->Date['HTMLtoPDF'])){
				define('_MPDF_URI', $this->Date['XVweb']->Date['URLS']['Site'].'core/libraries/mpdf50/');
				define('_MPDF_TEMP_PATH', $GLOBALS['RootDir'].'tmp/');
				include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'mpdf50'.DIRECTORY_SEPARATOR.'mpdf.php');
				$this->Date['HTMLtoPDF'] = new mPDF(); 
			}
			

			if(is_null($this->Date['XVweb']->ReadArticleOut) or is_null($this->Date['XVweb']->ReadArticleIndexOut)){
				return false;
			}else{
	$this->Date['HTMLtoPDF']->writeHTML(($this->Date['XVweb']->ParseArticleContents()));
	$this->Date['HTMLtoPDF']->Output(($this->Date['XVweb']->ReadArticleIndexOut['Topic']).'.pdf', "I");
			}
	}
}

?>