<?php

class xva_index_page extends xv_config {}

class xva_index_page_editor extends  xv_config_editor {
	public function init_fields(){
		return array(
			"categories" => array(
				"caption" => "Categories",
				"desc" => "Add cats to main page",
				"type" => "cat_editor"
			)
		);
	}
	
}
$config = new xva_index_page_editor(new xva_index_page());


?>