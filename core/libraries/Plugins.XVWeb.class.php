<?php
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
		/*Prefix*/
			$Prefix = $this->Date['xpath']->query('/plugins/plugin/config/admin/prefix');
			foreach($Prefix as $url)
			$this->Date['Serialize']['AdminPrefix'][strtolower($url->getAttribute("prefix"))] = $url->getAttribute("include");
		/*Prefix*/
		/*Buttons*/
		$buttons = $this->Date['xpath']->query('/plugins/plugin/config/button');
		foreach($buttons as $button)
		$this->Date['Serialize']['buttons'] .= $button->nodeValue;
		/*Buttons*/
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
		
		foreach($this->Date['XVweb']->Config("plugins")->find("plugin") as $valPlugin){
			$filename = ROOT_DIR.'plugins'.DIRECTORY_SEPARATOR.pq($valPlugin)->attr("file");
				if(file_exists($filename)){
				$PluginInit->load($filename);
				$xpath = new DOMXpath($PluginInit);
				foreach($xpath->query('//plugin/*[self::load or self::config]') as $Plug){
					$Plug = $this->Date['doc']->importNode($Plug, true);
					$element = $this->Date['doc']->createElement('plugin');
					$element->appendChild($Plug);
					$this->Date['doc']->getElementsByTagName('plugins')->item(0)->appendChild($element);
				}
			}
			
		}
	}
	
	public function &event($name){
		return $this->Date['Serialize']['ToEval'][strtolower($name)];
	}
	public function &prefix($val){
		return $this->Date['Serialize']['Prefix'][strtolower($val)];
	}
	public function &AdminPrefix($val){
		return $this->Date['Serialize']['AdminPrefix'][strtolower($val)];
	}
	public function &buttons(){
		return $this->Date['Serialize']['buttons'];
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
	
	public function Widget($doc){
		$this->DOM($doc);
		$this->xpath(true);
		$ResultArray = array();
		foreach (($this->xpath()->query('config/window')) as $item) 
		$ResultArray['WindowStyle'] = $item->getAttribute("style");
		foreach (($this->xpath()->query('config/name')) as $item) 
		$ResultArray['name'] = array('lang'=>$item->getAttribute("lang"), 'value'=>$item->nodeValue);
		foreach (($this->xpath()->query('config/width')) as $item) 
		$ResultArray['width'] = $item->nodeValue;
		foreach (($this->xpath()->query('content')) as $item) 
		$ResultArray['content'] = array('lang'=>$item->getAttribute("lang"), 'value'=>$item->nodeValue);
		echo $this->xpath()->query('config/window')->lenght;

		$LoadJS = $this->xpath()->query('config/loadjs');
		foreach($LoadJS as $JSUrl)
		$ResultArray["JSLoad"][] = $JSUrl->nodeValue;
		
		$LoadJS = $this->xpath()->query('config/loadjs');
		foreach($LoadJS as $JSUrl)
		$ResultArray["JSLoad"][] = $JSUrl->nodeValue;
		
		$LoadCSS = $this->xpath()->query('config/loadcss');
		foreach($LoadCSS as $CSSUrl)
		$ResultArray["CSSLoad"][] = $CSSUrl->nodeValue;
		$this->Date['xpath'] = null;

		return $ResultArray;
	}
	
}
?>