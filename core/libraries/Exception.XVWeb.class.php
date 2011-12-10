<?php
class XVwebException extends Exception
{
    public function __construct($code = 0) {
	$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'languages'.DIRECTORY_SEPARATOR.'pl.php');
    parent::__construct($XVwebLang[$code].' - Error code:'.$code, $code);
    }
}
?>