<?php
 header('HTTP/1.0 404 Not Found');
xv_load_lang('404');
xv_set_title(xv_lang("404_title"));
xv_set_content("
	<div class='error'>".xv_lang("404_message")."</div>
");

?>