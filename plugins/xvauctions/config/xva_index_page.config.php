<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE application!   *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

class xva_index_page extends xv_config {}

class xva_index_page_editor extends  xv_config_editor {
	public function init_fields(){
		return array(
			"categories" => array(
				"caption" => "Categories",
				"desc" => "Add cats to main page",
				"type" => "categories"
			),
			"template" => 	array(
				"caption" => "Template",
				"desc" => "Select your index page template",
				"type" => "select",
				"options" => array(
					"top" => "top",
					"right" => "right"
				),
				"save" => array(

				),
				"field_data" => array(
				
				)
			)
		);
	}

	public function element_categories($val,$key, $data){
		$item_theme = new xv_config_editor_theme;
		if(isset($this->valid_errors[$key]))
			$item_theme->set_error($this->valid_errors[$key]);
			
		$item_theme->set_caption($data['caption']);
		$item_theme->set_desc($data['desc']);
		$content  = '<div class="xv-config-editor-categories">';
		
		$this->header_js("categories", '
		$(function() {
			$( ".xv-config-editor-categories" ).sortable({
				
				});
			});
		');		
		
		$this->header_css("categories", '
			.xv-config-editor-categories-tbl {
				margin: 15px;
				border:1px solid #00AFC9;
				background: rgba(204, 248, 255, 0.6);
				width: 400px;
			}
		');
		
		foreach($val as $val_i){
			$content .= 
		"
			<table class='xv-config-editor-categories-tbl'>
				<tr>
					<td>Title:</td>
					<td><input type='text' name='{$this->get_input_name(array($key))}[title][]' value='{$val_i['title']}' /></td>
				<tr/>		
				<tr>
					<td>Description:</td>
					<td><input type='text' name='{$this->get_input_name(array($key))}[desc][]' value='{$val_i['desc']}' /></td>
				<tr/>				
				<tr>
					<td>Link:</td>
					<td><input type='text' name='{$this->get_input_name(array($key))}[link][]' value='{$val_i['link']}' /></td>
				<tr/>		
				<tr>
					<td>Icon:</td>
					<td><input type='text' name='{$this->get_input_name(array($key))}[icon][]' value='{$val_i['icon']}' /></td>
				<tr/>			
				<tr>
					<td>Selected:</td>
					<td><select name='{$this->get_input_name(array($key))}[checkbox][]'>
						<option>false</option>
						<option ".(isset($val_i['selected']) && $val_i['selected'] ? "selected='selected'" : '')." >true</option>
					</select></td>
				<tr/>
			</table>
		";
		}
		$content .= 
		"
			<table class='xv-config-editor-categories-tbl'>
				<tr>
					<td>Title:</td>
					<td><input type='text' name='{$this->get_input_name(array($key))}[title][]' value='' /></td>
				<tr/>		
				<tr>
					<td>Description:</td>
					<td><input type='text' name='{$this->get_input_name(array($key))}[desc][]' value='' /></td>
				<tr/>				
				<tr>
					<td>Link:</td>
					<td><input type='text' name='{$this->get_input_name(array($key))}[link][]' value='' /></td>
				<tr/>		
				<tr>
					<td>Icon:</td>
					<td><input type='text' name='{$this->get_input_name(array($key))}[icon][]' value='' /></td>
				<tr/>			
				<tr>
					<td>Selected:</td>
					<td><select name='{$this->get_input_name(array($key))}[checkbox][]'>
						<option>false</option>
						<option>true</option>
					</select></td>
				<tr/>
			</table>
		";
		$content .= "</div>";
		$item_theme->set_content($content);

		return $item_theme;
	
	}
	public function save_categories($keys, $val){
		$val_field = $_POST[$this->field_name][$keys];
		$result = array();
		foreach($val_field['title'] as $key=>$t_val){
		if(!empty($val_field['title'][$key]) || !empty($val_field['link'][$key])){
			$result[] = array(
				'title'=> $val_field['title'][$key],
				'desc'=> $val_field['desc'][$key],
				'link'=> $val_field['link'][$key],
				'icon'=> $val_field['icon'][$key],
				'selected'=> ($val_field['checkbox'][$key] == "true" ? true : false),
			);
		}
		
		}
		$this->config->{$keys} =  $result;
		return true;
	}
}
$config = new xva_index_page_editor(new xva_index_page());


?>