<?php

class xv_config_editor_theme {
	var $data = array();
	var $result_inputs;
	public function set_caption($caption){
		$this->data['caption'] = $caption;
	}
	public function set_desc($desc){
		$this->data['desc'] = $desc;
	}	
	public function set_content($desc){
		$this->data['content'] = $desc;
	}	
	public function set_error($val){
		$this->data['error'] = $val;
	}

	public function get_html(){
		$html = '
			<div class="xv-config-item'.(isset($this->data['error']) && $this->data['error'] ? ' xv-config-error' :'').'">
					'.(isset($this->data['error']) && $this->data['error'] ? '<div class="xv-config-error-msg">'.$this->data['error'].'</div>' :'').'
				<div class="xv-config-caption">'.$this->data['caption'].'</div>
				<div class="xv-config-content">
					'.$this->data['content'].'
					
					<div class="xv-config-desc">'.$this->data['desc'].'</div>
				</div>
				<div class="xv-config-clear"></div>
			</div>
		';
		
		return $html;
	}
	public function __toString(){
		return $this->get_html();
	}
}


class xv_config_editor {
	var $field_name = "xv-config";
	var $errors = array();
	var $config = null;
	var $submit_val = "Save";
	var $save_url = "?save=true";
	var $headers = array();
	var $csrf = '';
	var $valid_errors = array();
	var $form_attr = '';
	function __construct($config) {
		$this->config = $config;
	}
	public function data_sent(){
		if(isset($_POST[$this->field_name]))
			return true;
		return false;
	}
	public function get_input_name($map){
		$input_name = $this->field_name;
		foreach($map as $val){
			$input_name .= '['.$val.']';
		}
		return $input_name;
	}
	
	public function log_error($error){
		$this->errors[] = $error;
	}	
	public function set_valid_error($key, $msg){
		$this->valid_errors[$key] = $msg;
	}	
	public function set_url($url){
		$this->save_url = $url;
	}	
	public function set_form_attr($attr){
		$this->form_attr = $attr;
	}	
	var $form_class = array();
	public function add_form_class($class){
		$this->form_class[$class] = $class;
	}
	public function set_csrf($string){
		$this->csrf = $string;
	}
	
	public function get_headers_html(){
		$result_html = '';
		if(empty($this->headers))
			return '';
			
		if(is_array($this->headers['css_link'])){
			foreach($this->headers['css_link'] as $link){
				$result_html .= '<link rel="stylesheet" type="text/css"  href="'.$link.'" />';
			}
		}		
		if(is_array($this->headers['css'])){
			$result_html .= '<style type="text/css" media="all">';
			foreach($this->headers['css'] as $css){
				$result_html .= $css."\n";
			}
			$result_html .= '</style>';
		}
		if(is_array($this->headers['js_link'])){
			foreach($this->headers['js_link'] as $link){
				$result_html .= '<script type="text/javascript" src="'.$link.'"></script>';
			}
		}		
		if(is_array($this->headers['js'])){
			$result_html .= '<script type="text/javascript">';
			foreach($this->headers['js'] as $js){
				$result_html .=  $js."\n";
			}
			$result_html .= '</script>';
		}	
		return $result_html;
	}
	/****************** HEADER*******************************/
	public function header_css($name, $css){
		$this->headers['css'][$name] = $css;
	}	
	public function header_css_link($name, $url){
		$this->headers['css_link'][$name] = $url;
	}
	public function header_js($name, $js){
		$this->headers['js'][$name] = $js;
	}
	public function header_js_link($name, $url){
		$this->headers['js_link'][$name] = $url;
	}
	/***************** /HEADER*******************************/


	/****************** CONTROL******************************/
	
	public function control_textarea($map, $val){
		return "<textarea name='".$this->get_input_name($map)."'>".htmlspecialchars($val)."</textarea>";
	}
	public function control_text($map, $val, $data){
		return "<input type='".(isset($data['field_data']['type']) ? $data['field_data']['type'] : 'text')."' name='".$this->get_input_name($map)."'  value='".htmlspecialchars($val)."' />";
	}	

	public function control_select($map, $val, $select = array()){
		$result = '<select name="'.$this->get_input_name($map).'">';
		foreach($select as $s_val)	
			$result .= '<option value="'.$s_val.'" '.($s_val == $val ? 'selected="selected"': '').'>'.$s_val.'</option>';
		
		  $result .= '</select>';
		return  $result;
	}
	/***************** /CONTROL******************************/
	
	/***************** ELEMENTS *****************************/
	public function element_text($val,$key, $data){
		$item_theme = new xv_config_editor_theme;
		if(isset($this->valid_errors[$key]))
			$item_theme->set_error($this->valid_errors[$key]);
			
		$item_theme->set_caption($data['caption']);
		$item_theme->set_desc($data['desc']);
		$item_theme->set_content($this->control_text(array($key), $val, $data));

		return $item_theme;
	
	}		
	
	public function element_boolean($val,$key, $data){
		$item_theme = new xv_config_editor_theme;
		if(isset($this->valid_errors[$key]))
			$item_theme->set_error($this->valid_errors[$key]);
			
		$item_theme->set_caption($data['caption']);
		$item_theme->set_desc($data['desc']);
		$item_theme->set_content($this->control_select(array($key), ($val ? "true" : "false"), array("true", "false")));

		return $item_theme;
	
	}	
	public function element_textarea($val,$key, $data){
		$item_theme = new xv_config_editor_theme;
		if(isset($this->valid_errors[$key]))
			$item_theme->set_error($this->valid_errors[$key]);
			
		$item_theme->set_caption($data['caption']);
		$item_theme->set_desc($data['desc']);
		$item_theme->set_content($this->control_textarea(array($key), $val));

		return $item_theme;
	
	}
	/***************** /ELEMENTS ****************************/
	/***************** /SAVE ****************************/
	public function save_text($key, $val){
		$val_field = $_POST[$this->field_name][$key];
		if(isset($val['field_data']['type']) && $val['field_data']['type'] == "number")
			$val_field = (int) $val_field;

		$this->config->{$key} =  $val_field;
		return true;
	}
	public function save_boolean($key, $val){
		$val_field = $_POST[$this->field_name][$key];

		$this->config->{$key} =  ($val_field == "true" ? true : false);
		return true;
	}
	/*****************  SAVE ****************************/
	
	public function init_fields(){
		return array();
	}
	public function generate(){
	$this->result_inputs = array();
		foreach($this->init_fields() as $key=>$val){
			if(method_exists($this,'element_'.$val['type'])){
				$this->result_inputs[] = call_user_func_array(array($this, 'element_'.$val['type']), array(
					isset($this->config->{$key}) ? $this->config->{$key} : $val['default'],
					$key,
					$val
				));
			}
		}
	
	}
	public function get_html(){
		$result = '<form class="xv-config-form '.implode(" ", $this->form_class).'" action="'.$this->save_url.'" method="post" '.$this->form_attr.' enctype="multipart/form-data">';
		$result .= implode(" ", $this->result_inputs);
		$result .= '
			<input type="hidden" name="xv-config-csrf" value="'.$this->csrf.'" />
			<div class="xv-config-submit"><input type="submit" value="'.$this->submit_val.'" /> </div>
		</form>';
		return $result;
	}
	
	public function save($data){
		if($data['xv-config-csrf'] == $this->csrf){
			foreach($this->init_fields() as $key=>$val){
				if(isset($val['save']) && is_array($val['save']) && method_exists($this,'save_'.$val['save']['name'])){
					$result = call_user_func_array(array($this, 'save_'.$val['save']['name']), array($key, $val));
				}elseif(method_exists($this,'save_'.$val['type'])){
					$result = call_user_func_array(array($this, 'save_'.$val['type']), array($key, $val));
				}else{
					$result = call_user_func_array(array($this, 'save_text'), array($key, $val));
				}
				if($result !== true){
					$this->set_valid_error($key, $result);
				}
			}
		}else{
			//wrong CSRF code
		}
	}
	
	public function __toString(){
		return $this->get_html();
	}
	
}


?>