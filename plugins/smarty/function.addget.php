<?php
function smarty_function_addget($params, $template)
{
	//$smarty->register_function('addget', 'smarty_function_addget');

	if(!isset($params['xhtml']))
	$params['xhtml'] = true; else $params['xhtml']=false;

	if(is_array($params['value']))
	return ($params['xhtml']? str_replace("&", "&amp;",http_build_query(array_merge($GLOBALS['_GET'], $ArrayOrString))) : http_build_query(array_merge($GLOBALS['_GET'], $ArrayOrString)));
	parse_str($params['value'], $output);
	return ($params['xhtml'] ? str_replace("&", "&amp;",http_build_query(array_merge($GLOBALS['_GET'], $output))) : http_build_query(array_merge($GLOBALS['_GET'], $output)));

}


?>
