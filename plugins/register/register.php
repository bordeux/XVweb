<?php
xv_trigger("register.start");

$command = ($XVwebEngine->GetFromURL($PathInfo, 2));
xv_load_lang("register");

xv_set_title(xv_lang("register_title"));

include_once(dirname(__FILE__).'/config/register_config.xv_config.php');
switch (strtolower($command)) {
    case "activate":
        include(dirname(__FILE__).'/pages/activate.php');
        break;
	default:
        include(dirname(__FILE__).'/pages/register.php');
        break;
}


?>