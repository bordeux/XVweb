<?php
class xv_config {
	private  $__changed_value = false;
	private  $__extension = ".config";
	private  $__config_dir = "/";
	private  $__data = array();
	function __construct($dir = null) {
		if(!is_null($dir)){
			$this->__config_dir = $dir;
		}elseif(defined('XV_CONFIG_DIR')){
			$this->__config_dir = XV_CONFIG_DIR;
		}
		
		$class_name = get_class($this);
		$actual_config = array();
		if (file_exists($this->__config_dir.$class_name.$this->__extension)) {
			$actual_config = file_get_contents($this->__config_dir.$class_name.$this->__extension);
			$actual_config = json_decode($actual_config, true);
			if(json_last_error() != JSON_ERROR_NONE) {
				$actual_config = array();
				$this->__changed_value = true;
			}
		}else{
			$this->__changed_value = true;
		}
		$this->__data = $actual_config;
		if(empty($this->__data))
			$this->__data = array();
		foreach($this->init_fields() as $key=>$val){
			if(!isset($this->__data[$key]))
				$this->__data[$key] = $val;
		}
	}
	public function init_fields(){
		return array();
	}
	public function __set($name, $val){
		$this->save();
		$this->__data[$name] = $val;
		return $val;
	}
	
	public function __get($name){
		return isset($this->__data[$name]) ? $this->__data[$name] : null;
	}
	public function __unset($name){
		$this->__changed_value = true;
		unset($this->__data[$name]);
	}
	public function save(){
		$this->__changed_value = true;
		$this->__destruct();
	}
	public function __isset($name){
        return isset($this->__data[$name]);
    }	
	public function get_all(){
		return $this->__data;
	}
	function __destruct() {
		if($this->__changed_value){
			$class_name = get_class($this);
			file_put_contents($this->__config_dir.$class_name.$this->__extension, json_encode($this->__data, (defined('JSON_PRETTY_PRINT') ? JSON_PRETTY_PRINT : 0 ))); // HSON_PRETTY_PRINT for PHP5.4
		}
	}
}

