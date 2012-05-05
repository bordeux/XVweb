<?php

class ip_ban_config extends xv_config {}

class ip_ban_config_editor extends  xv_config_editor {
	public function init_fields(){
		return array(
			"theme" => array(
				"caption" => "Theme",
				"desc" => "Theme message",
				"type" => "select",
				"field_data" => array(
				),
				"options" => array(
					"red", "blue", "gray", "green"
				)
			),	
	
		);
	}
	
}
$config = new ip_ban_config_editor(new ip_ban_config());


?>