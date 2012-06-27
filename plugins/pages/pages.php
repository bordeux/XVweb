<?php

xv_trigger("pages.start");
xv_set_title("--xv-pages-title--");

function xv_set_content($content){
	global $Smarty;
		$Smarty->assign('xv_page_content', $content);
}
xv_set_content("--xv-page-content--");


$Smarty->display('pages/index.tpl');
xv_trigger("pages.end");

?>