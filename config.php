<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   config.php        *************************
****************   Start     :   22.05.2007 r.     *************************
****************   License   :   LGPL              *************************
****************   Version   :   1.0               *************************
****************   Authors   :   XVweb team        *************************
****************   Last edit :   $Date: 2011-08-29 14:22:50 +0200 (Pn) $            *************************
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
DEFINE('BdServer', 'localhost', true);
DEFINE('BdServer_User', 'xvweb', true);
DEFINE('BdServer_Password', 'xvweb', true);
DEFINE('BdServer_Base', 'xvweb', true);
DEFINE('BdServer_prefix', 'xv_', true);
DEFINE('PHP_PathInfo', 'PATH_INFO', true);
DEFINE('Debug_Enabled', false, true); 
DEFINE('XVweb_DisplayErrors', true, true); 
DEFINE('MD5Key', 'PDjh6ljRaURd8Vr7HpjLpG7UabAzjb8Q', true); 
$UploadDir = dirname(__FILE__).DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR;
//$URLS['Avants']    = 'http://'.$_SERVER['HTTP_HOST'].'.nyud.net/xvweb/files/avants/';
//$URLS['ThemeCatalog'] = 'http://'.$_SERVER['HTTP_HOST'].'.nyud.net/xvweb/themes/'
//$URLS['JSCatalog'] = 'http://'.$_SERVER['HTTP_HOST'].'.nyud.net/themes/';
?>