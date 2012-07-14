<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Authors   :  XVweb team         *************************
****************   All rights reserved             *************************
***************************************************************************/

if(!xv_perm("xva_buy")){
	header("location: ".$URLS['Script'].'Page/xvAuctions/Permission/Sell/');
	exit;
}

$Smarty->assign('Title',  ("Dane kontrahenta"));

include_once(ROOT_DIR.'core/libraries/arrays/countries.php');
$auction_id = ($XVwebEngine->GetFromURL($PathInfo, 3));

$check_perm = xvp()->check_perm_to_get_message($XVauctions, $XVwebEngine->Session->Session('user_name'), $auction_id);

if(!$check_perm){
	header("location: ".$URLS['Script'].'Page/xvAuctions/Permission/get_message/');
	exit;
}
$auction_message = xvp()->get_auction_description($XVauctions, $auction_id, "message");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Message</title>
</head>
<body>
  <?php echo $auction_message; ?>
</body>
</html>
<?php
exit;
?>