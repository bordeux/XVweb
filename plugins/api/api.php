<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   receiver.php      *************************
****************   Start     :   22.05.2007 r.     *************************
****************   License   :   LGPL              *************************
****************   Version   :   1.0               *************************
****************   Authors   :   XVweb team        *************************
*************************XVweb Team*****************************************
				Krzyszof Bednarczyk, meybe you
/////////////////////////////////////////////////////////////////////////////
 Klasa XVweb jest na licencji LGPL v3.0 ( GNU LESSER GENERAL PUBLIC LICENSE)
****************http://www.gnu.org/licenses/lgpl-3.0.txt********************
		Pełna dokumentacja znajduje się na stronie domowej projektu: 
*********************http://www.bordeux.NET/Xvweb***************************
***************************************************************************/
header("Cache-Control: no-cache, must-revalidate");
if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit();
}
$soap_url = $URLS['Script'].'api/';
$plugin_name = strtolower($XVwebEngine->GetFromURL($PathInfo, 2));
$class_name = strtolower($XVwebEngine->GetFromURL($PathInfo, 3));
$class_mode = strtolower($XVwebEngine->GetFromURL($PathInfo, 4));
$apis_dir = dirname(__FILE__).'/apis/';
$plugins_config = new xv_plugins_config();
if(empty($plugin_name) || empty($class_name)){
	echo "<h3>APIs</h3>";
	echo "<hr />";
	echo "<ul>";
	$plugins_list = array();
		foreach($plugins_config->get_all() as $val)
				$plugins_list[] = $val["name"];
	
		foreach (glob((ROOT_DIR.'plugins/{'.implode(",", $plugins_list).'}/api/*.api.class.php'),GLOB_BRACE) as $filename) {
			$class_name = basename($filename);
			$plugin_name = basename(realpath(dirname($filename).'/..'));
			$class_name = str_replace('.api.class.php', '', $class_name);
			echo "<li><a href='".$soap_url.$plugin_name.'/'.$class_name."/'>".$plugin_name."/".$class_name."</a></li>";
		}
	echo "</ul>";
	exit;
}
$class_name = strtolower(str_replace(array("." , "/", "\\"),'',$class_name));
$class_file = ROOT_DIR.'plugins/'.$plugin_name.'/api/'.$class_name.'.api.class.php';

if(!file_exists($class_file)){
	header("location: ".$URLS['Script'].'api/');
	exit;
}

if(!isset($plugins_config->{$plugin_name})){
	header("location: ".$URLS['Script'].'api/');
	exit;
}
	
if($class_mode == "soap"){
	$soapClass = "xv_api_".$class_name;
	session_name ($soapClass);
	include_once($class_file);
	$server = new SoapServer(null, array('uri' => $soap_url.$class_name.'/soap/', 'style' => SOAP_DOCUMENT, 'use' => SOAP_LITERAL));
	$server->setClass($soapClass);
	$server->setPersistence(SOAP_PERSISTENCE_SESSION);
	$server->handle();
	exit;
}elseif($class_mode == "wsdl"){
	include_once($class_file);
	include_once(dirname(__FILE__).'/apis_servers/WSDL_Gen.php');
	$wsdlgen = new WSDL_Gen("xv_api_".$class_name, $soap_url.$class_name.'/soap/', "xv_api_".$class_name);
		
	header("Content-Type: text/xml");
	echo $wsdlgen->toXML();
	exit;
}elseif($class_mode == "json" || $class_mode == "serialize" || $class_mode == "xml" || $class_mode == "yaml"){
	$api_input_data = (empty($_POST) ? $_GET : $_POST);
	$class_api_real_name = "xv_api_".$class_name;
	include_once($class_file);
	$class_api_values = $XVwebEngine->Session->Session($class_api_real_name);
	$class_api = new $class_api_real_name();
	if(!empty($class_api_values) && !isset($api_input_data['new_session'])){
		unset($api_input_data['new_session']);
		foreach($class_api_values as $key=>$val){
			if(isset($class_api->{$key}))
				$class_api->{$key} = $val;
		}
	}
	
	$result = array();
	foreach($api_input_data as $function=>$parms){
	if(!is_array($parms)){
		$parms = json_decode($parms);
	}
	if(!is_array($parms))
		$parms = array();
		
		if($parms === null){
			$result[$function] = array("error"=> "Bad parameters to ".$function, "code" => 1200);
		}else{
			if(!method_exists($class_api, $function)){
				$result[$function] = array("error"=> "Bad function - do not exsist", "code" => 1300);
			}else{
			
				$refMethod = new ReflectionMethod($class_api_real_name,  $function); 
				$params = $refMethod->getParameters(); 
				$parameters_count = count($params);
				if(count($parms) < $parameters_count){
					$result[$function] =  array("error"=> "Bad parameters - bad number of parameters, min: {$parameters_count}", "code" => 1400);
				}else{
					$result[$function] = array("result" => call_user_func_array(array($class_api, $function), $parms));
				}
			}
		}
	}

	if($class_mode == "json"){
		header("Content-Type: application/json");
		echo json_encode($result);	
		}elseif($class_mode == "serialize"){
		header('Content-Type: text/plain; charset=utf-8');
		echo serialize($result);	
	}elseif($class_mode == "xml"){
	header("Content-Type: text/xml");
			function assocArrayToXML($root_element_name,$ar) { 
			$xml = new SimpleXMLElement("<?xml version=\"1.0\"?><{$root_element_name}></{$root_element_name}>"); 
			$f = create_function('$f,$c,$a',' 
					foreach($a as $k=>$v) { 
						if(is_array($v)) { 
							$ch=$c->addChild($k); 
							$f($f,$ch,$v); 
						} else { 
							$c->addChild($k, ($v === false ? 0 : $v)); 
						} 
					}'); 
			$f($f,$xml,$ar); 
			return $xml->asXML(); 
		} 
		echo assocArrayToXML("result", $result);
	}elseif($class_mode == "yaml"){
		header('Content-Type: text/plain; charset=utf-8');
		include_once(dirname(__FILE__).'/apis_servers/spyc.php');
		echo Spyc::YAMLDump($result);
	}
	$XVwebEngine->Session->Session($class_api_real_name, (array) $class_api);
	exit;
}
	

include_once($class_file);
include_once(dirname(__FILE__).'/apis_servers/WSDL_Gen.php');
$wsdlgen = new WSDL_Gen("xv_api_".$class_name, $soap_url.$class_name.'/soap/', "xv_api_".$class_name);
	
echo "<table>";
foreach ($wsdlgen->operations as $operName => $oper) {
	echo "<tr>";
	echo "<td>";
	
	// return value
	$retMsg = $oper['output'];
	$retString = 'void';
	if (count($retMsg) > 0) {
		$retString =$retMsg[0]['type']; 
	}
	
	// input parameters
	$paramMsg = $oper['input'];
	$paramString = '';
	if (count($paramMsg) > 0) {
		foreach ($paramMsg as $paramEntry) {
			if (strlen($paramString) > 0) {
				$paramString .= ', ';
			}
			$paramString .= $paramEntry['type'].' $'.$paramEntry['name'];
		}
	}
	echo $retString." ".$operName."(".$paramString.")";
	echo "</td>";
	echo "<td style='white-space: pre;'>".$oper['documentation']."</td>";
	
	echo "</tr>";
}
echo "</table>";


?>