<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   users.php         *************************
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
header("Cache-Control: no-cache, must-revalidate");
if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
}
xv_trigger("users.profile.about.start");
	$Smarty->assign('profile', $user_data);
	
	$xv_user_about = xvp()->get_user_about($user_class, $user_data->User);
	
	$Smarty->assign('xv_user_about',  $xv_user_about);
	$Smarty->assign('users_mode',  "about");
	$Smarty->display('users/index.tpl');
?>