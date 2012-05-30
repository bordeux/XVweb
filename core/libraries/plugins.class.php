<?php
class xv_plugins {
	var $plugins = array();
	var $plugins_dir = '';
	
	function __construct($dir) {
		$this->plugins_dir = $dir;
	}
	
	public function load_plugin($plg_name, $name){
		$file_loc = $this->plugins_dir.$plg_name.'/xvp/'.$name.'.xv_plugin.php';
		$name_class = "xv_plugin_".$name;
		if(file_exists($file_loc)){
			include_once($file_loc);
			$class_methods = get_class_methods($name_class);
			foreach($class_methods as $method_name){
				if(strstr($method_name, '_', true) != "main"){
					$this->plugins[substr(strstr($method_name, '_'), 1)][strstr($method_name, '_', true)][] =  array(
						"class"=> $name_class,
						"method" => $method_name,
					);
				}
			}
			return true;
		}
	return false;
	}

	public function __call($name, $arguments) {
		$object = $arguments[0];
		$class_name = get_class($object);
		array_shift($arguments);
		$modifier  = isset($this->plugins[$class_name."__".$name]) ? $this->plugins[$class_name."__".$name] : null;
		if(isset($modifier['before'])){
			foreach($modifier['before'] as $modificator){
				$arguments = call_user_func($modificator['class'] .'::'.$modificator['method'], $arguments);
			}
		}
		if(isset($modifier['replace'])){
			$modificator = $modifier['replace'][0];
			$result = call_user_func($modificator['class'] .'::'.$modificator['method'], $arguments);
		}else{
			$result = call_user_func_array(array($object, $name), $arguments);
		}
		if(isset($modifier['after'])){
			foreach($modifier['after'] as $modificator){
				$result = call_user_func($modificator['class'] .'::'.$modificator['method'], $result, $arguments);
			}
		}
		return $result;
	}
	
}

?>