<?php
xv_trigger("forgot.start");

$command = ($XVwebEngine->GetFromURL($PathInfo, 2));
xv_load_lang("forgot");
include_once(dirname(__FILE__).'/config/forgot_config.xv_config.php');
switch (strtolower($command)) {
    case "reset":
        include(dirname(__FILE__).'/pages/reset.php');
        break;
	default:
        include(dirname(__FILE__).'/pages/forgot.php');
        break;
}


?>