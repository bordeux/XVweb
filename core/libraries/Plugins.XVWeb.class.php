<?php

class xv_plugins_config extends xv_config {

}

class Plugins
{
	var $Date=array();
	public function __construct(&$XVweb) {
		$this->Date['XVweb'] = &$XVweb;
	}
	public function set($name, $value){
		$this->Date[$name] = $value;
	}
	
	public function &Menager(){
		if(empty($this->Date['Serialize'])){
			if($this->Date['XVweb']->Cache->exist("Plugins", "Array")){
				$this->Date['Serialize'] = $this->Date['XVweb']->Cache->get();
				return $this;
			}
			$this->LoadDom();
			$this->BuildPlugins();
			$this->Date['XVweb']->Cache->put("Plugins", "Array", $this->Date['Serialize']);
		}
		return $this;
	}
	
	public function &LoadDom(){
		$this->Date['doc'] = new DOMDocument();
		$this->Date['doc']->formatOutput = true;
		$this->LoadPlugins();
		$this->Date['xpath'] = new DOMXPath($this->Date['doc']);
		return $this;
	}
	
	public function LoadPlugins(){
		if(file_exists(ROOT_DIR.'config'.DIRECTORY_SEPARATOR.'pluginscompiled.xml'))
		$this->Date['doc']->load(ROOT_DIR.'config'.DIRECTORY_SEPARATOR.'pluginscompiled.xml');
		else{
			$this->BindPlugins();
			file_put_contents(ROOT_DIR.'config'.DIRECTORY_SEPARATOR.'pluginscompiled.xml', ($this->Date['doc']->saveXML()));
		}
	}
	
	public function BuildPlugins(){
		$ToEval ="";
		/*Events*/
		$Events = $this->Date['xpath']->query('/plugins/plugin/load/event');
		foreach($Events as $Event)
		$this->Date['Serialize']['ToEval'][strtolower($Event->getAttribute("name"))] .= $Event->nodeValue;
		/*Events*/
		/*Prefix*/
		$Prefix = $this->Date['xpath']->query('/plugins/plugin/config/prefix');
		foreach($Prefix as $url)
		$this->Date['Serialize']['Prefix'][strtolower($url->getAttribute("prefix"))] = $url->getAttribute("include");
		/*Prefix*/
		/*EngineVars*/
		$EngineVars = $this->Date['xpath']->query('/plugins/plugin/config/vars');
		foreach($EngineVars as $EngineVar){
			if($EngineVar->getAttribute("php") == "true"){
				$this->Date['Serialize']['EngineVars'][$EngineVar->getAttribute("var")] = eval($EngineVar->nodeValue);
			}else
				$this->Date['Serialize']['EngineVars'][$EngineVar->getAttribute("var")] = ($EngineVar->nodeValue);
		}
		/*EngineVars*/
		/*EngineFunctions*/
		$EngineFunctions = $this->Date['xpath']->query('/plugins/plugin/config/parser/function');
		foreach($EngineFunctions as $EngineFunction)
		$this->Date['Serialize']['Functions'][] = array("Tag"=>$EngineFunction->getAttribute("tag"), "Function"=>$EngineFunction->nodeValue);
		/*EngineFunctions*/
	}
	public function BindPlugins(){
		$PluginInit= new DOMDocument();
		$PluginInit->formatOutput = true;
		$this->Date['doc']->appendChild($this->Date['doc']->createElement("plugins", ""));
		$plugins_enabled =  new xv_plugins_config();
		foreach($plugins_enabled->get_all() as $key=>$plugin_info){
			$filename = ROOT_DIR.'plugins'.DIRECTORY_SEPARATOR.$plugin_info['name'].DIRECTORY_SEPARATOR.$plugin_info['name'].'.xml';
				if(file_exists($filename)){
				$PluginInit->load($filename);
				$xpath = new DOMXpath($PluginInit);
				foreach($xpath->query('//plugin/*[self::load or self::config]') as $Plug){
					$Plug = $this->Date['doc']->importNode($Plug, true);
					$element = $this->Date['doc']->createElement('plugin');
					$element->appendChild($Plug);
					$this->Date['doc']->getElementsByTagName('plugins')->item(0)->appendChild($element);
				}
			}else{
				unset($plugins_enabled->{$key});
			}
			
		}
	}
	
	public function &event($name){
		return $this->Date['Serialize']['ToEval'][strtolower($name)];
	}
	public function trigger($name){
		if($XVwebEngine->Plugins()->Menager()->event($name)) {
			extract($_GLOBALS);
			eval($XVwebEngine->Plugins()->Menager()->event($name));
		}
	}
	public function &prefix($val){
		return $this->Date['Serialize']['Prefix'][strtolower($val)];
	}
	public function &enginevars(){
		return $this->Date['Serialize']['EngineVars'];
	}
	public function &enginefunctions(){
		return $this->Date['Serialize']['Functions'];
	}
	public function &DOM($dom = null){
		if(empty($this->Date['DomClass'])){
			$this->Date['DomClass'] = new DOMDocument();
			$this->Date['DomClass']->formatOutput = true;
		}
		if(!is_null($dom))
		$this->Date['DomClass'] = $dom;
		
		return $this->Date['DomClass'];
	}
	public function &xpath($load=false){
		if($load)
		$this->Date['xpath'] = new DOMXPath($this->DOM());
		return $this->Date['xpath'];
	}
	

	
}
?>