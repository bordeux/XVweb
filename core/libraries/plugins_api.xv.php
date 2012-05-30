<?php

function xv_append_js($file, $num = null){
	global $Smarty;
		$myVar = (array) $Smarty->getTemplateVars('JSLoad');
		if(is_null($num))
		$myVar[] = $file; else $myVar[$num] = $file;
		$Smarty->assign('JSLoad', $myVar); 
	return null;
}
function xv_append_footer($text, $num = null){
	global $Smarty;
		$myVar = (array) $Smarty->getTemplateVars('footer');
		if(is_null($num))
		$myVar[] = $text; else $myVar[$num] = $text;
		$Smarty->assign('footer', $myVar); 
	return null;
}
function xv_append_css($file, $num = null){
	global $Smarty;
		$myVar = (array) $Smarty->getTemplateVars('CCSLoad');
		if(is_null($num))
		$myVar[] = $file; else $myVar[$num] = $file;
		$Smarty->assign('CCSLoad', $myVar); 
	return null;
}
function xv_append_header($string, $num = null){
	global $Smarty;
		$myVar = (array) $Smarty->getTemplateVars('xv_append_header');
		if(is_null($num))
		$myVar[] = $string; else $myVar[$num] = $string;
		$Smarty->assign('xv_append_header', $myVar); 
	return null;
}
function xv_set_title($title){
		global $Smarty;
		$Smarty->assign('xv_title', $title);
	return null;
}
function xv_trigger($event_name){
global $XVwebEngine;
	if(isset($XVwebEngine)){
		$event_val = ($XVwebEngine->Plugins()->Menager()->event($event_name));
		if(!empty($event_val)) eval($event_val);
	}
	return null;
}

function xv_lang($var, $var2 =null){
	global $Language;
return ifsetor($Language[$var],(is_null($var) ? $var : $var2));
}
function xv_perm($perm){
	global $XVwebEngine;
	return $XVwebEngine->permissions($perm);
}
function smarty_modifier_perm($perm){ //for smarty
	global $XVwebEngine;
	return $XVwebEngine->permissions($perm);
}


function xv_append_meta($name, $content){
		xv_append_header("<meta http-equiv='{$name}' content='{$content}' />");
		return true;
}
