<?php
$command = ($XVwebEngine->GetFromURL($PathInfo, 2));
LoadLang("reg");
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