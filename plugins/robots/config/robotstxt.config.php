<?php

class robotstxt extends xv_config {}

class robotstxt_editor extends  xv_config_editor {
	public function init_fields(){
		return array(
			"content" => array(
				"caption" => "Robots.txt",
				"desc" => "Content of robots.txt file",
				"type" => "textarea",
			)
		);
	}
	
}
$config = new robotstxt_editor(new robotstxt());


?>