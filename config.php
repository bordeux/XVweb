<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   Start     :   22.05.2007 r.     *************************
****************   License   :   LGPL              *************************
****************   Version   :   1.0               *************************
****************   Authors   :   XVweb team        *************************
*************************XVweb Team*****************************************
				Krzyszof Bednarczyk, meybe you
/////////////////////////////////////////////////////////////////////////////
 Klasa XVweb jest na licencji LGPL v3.0 ( GNU LESSER GENERAL PUBLIC LICENSE)
****************http://www.gnu.org/licenses/lgpl-3.0.txt********************
		Pełna dokumentacja znajduje się na stronie domowej projektu: 
*********************http://www.bordeux.NET/Xvweb***************************
***************************************************************************/
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
//error_reporting(E_ALL);
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors',0);

DEFINE('XVweb_DisplayErrors', true, true); 
DEFINE('MD5Key', 'PDjh6ljRaURd8Vr7HpjLpG7UabAzjb8Q', true); 
DEFINE('HASH_SALT', 'nh`m46ORJBolcwD>eKyVgXMAMAuIkRbMexaqA.MZnZZdYbqirnRf', true); 
$UploadDir = ROOT_DIR.'files'.DIRECTORY_SEPARATOR;
date_default_timezone_set('Europe/Warsaw');

?>