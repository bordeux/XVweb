
<?php

class PDOError
{
	var $Data = array();
	var $HTML;

	function __construct($PDOError = null) {
	if(is_object($PDOError)){
		$ErrorInfo[] = array("Message"=>"ErrorMessage", "value"=> $PDOError->getMessage());
		$ErrorInfo[] = array("Message"=>"ErrorCode", "value"=> $PDOError->getCode());
		$ErrorInfo[] = array("Message"=>"ErrorFile", "value"=> $PDOError->getFile());
		$ErrorInfo[] = array("Message"=>"ErrorLine", "value"=> $PDOError->getLine());
		$ErrorInfo[] = array("Message"=>"ErrorTime", "value"=> date("y.m.Y H:i:s:u"));
		$ErrorInfo[] = array("Message"=>"ClientIP", "value"=> $_SERVER['REMOTE_ADDR']);
		$ErrorInfo[] = array("Message"=>"ErrorFile", "value"=> $PDOError->getFile());
	}else{
		$ErrorInfo = $PDOError;
	}
	$this->Data['Error'] = $ErrorInfo;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}

	function ErrorInfoToHTML($ErrorInfo = array()){
		$HTML = "";
		foreach ($ErrorInfo as &$values) {
			$HTML .=	'<tr><td class="e">'.$values["Message"].' </td><td class="v">'.$values["value"].' </td></tr>
	';
		}
		return $HTML;
	}
	function getHTML(){
		if(XVweb_DisplayErrors == true)
		return $this->HTML;
		return "";
	}
	function show(&$XVweb){
		if(XVweb_DisplayErrors == true){
			$ErrorPage['URLS'] = $XVweb->Date['URLS'];
			$ErrorPage['Title'] = 'Oops...';
			$ErrorPage['Message'] = "Site is temporarily unavailable. Cross your fingers and try again in a few minutes. We're sorry for the inconvenience.";
			$ErrorPage['Message3'] = print_r($this->Data['Error'], true);
			$XVweb->message($ErrorPage);
		}
	}

}



?>
