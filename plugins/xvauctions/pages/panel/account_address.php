<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Authors   :  XVweb team         *************************
****************   All rights reserved             *************************
***************************************************************************/

if(!xv_perm("xva_Buy")){
	header("location: ".$URLS['Script'].'System/Auctions/Auction_permission_sell/');
	exit;
}

$Smarty->assign('Title',  'Adres zamieszkania');

include_once(ROOT_DIR.'core/libraries/arrays/countries.php');
include_once(ROOT_DIR.'core/libraries/formgenerator/formgenerator.php');
include_once(ROOT_DIR.'core/libraries/formgenerator/validators.php');

$user_data_xva  = xvp()->get_user_data($XVauctions, $XVwebEngine->Session->Session('Logged_User') );

$form=new Form();        
$form->set("name", "form_ia");
$form->set("linebreaks", false);                        
$form->set("errorBox", "error");                            
$form->set("sanitize", false);            
$form->set("divs", true);                
$form->set("action", $URLS['AuctionPanel'].'/account_address/');
$form->set("method", "post");
$form->set("submitMessage", "Dane zostały zmienione");

$form->addField("text", "account_Corporation" , "Firma ", false , ifsetor($user_data_xva['Corporation'], ''));
$form->validator("account_Corporation", "regExpValidator", "/^(.){0,50}$/", "Nazwa firmy za krótka");

$form->addField("text", "account_Name" , "Imię", true, ifsetor($user_data_xva['Name'], '') );
$form->validator("account_Name", "regExpValidator", "/^(.){2,50}$/", "Imię za krótkie");

$form->addField("text", "account_Vorname" , "Nazwisko", true , ifsetor($user_data_xva['Vorname'], ''));
$form->validator("account_Vorname", "regExpValidator", "/^(.){2,50}$/", "Nazwisko za krótkie");

$form->addField("text", "account_Street" , "Adres", true , ifsetor($user_data_xva['Street'], ''));
$form->validator("account_Street", "regExpValidator", "/^(.){2,50}$/", "Zły adres");

$form->addField("text", "account_Zip" , "Kod pocztowy/ZIP code", true , ifsetor($user_data_xva['Zip'], ''), ' placeholder="__-___"');
$form->validator("account_Zip", "regExpValidator", "/^((([0-9]){0,2}(\-)([0-9]){3}))$/", "Zły kod pocztowy/ZIP code");

$form->addField("text", "account_City" , "Miejscowość", true , ifsetor($user_data_xva['City'], ''));
$form->validator("account_City", "regExpValidator", "/^(.){2,50}$/", "Miejscowość za krótka");

$form->addField("text", "account_State" , "Stan/Województwo", true , ifsetor($user_data_xva['State'], ''));
$form->validator("account_State", "regExpValidator", "/^(.){2,50}$/", "Nazwa stanu/województwa za krótka");
$form->addField("select", "account_Country", "Kraj", true, ifsetor($user_data_xva['Country'], ''), array_flip($_countries));
$form->JSprotection(uniqid());
$address_form = $form->display("Zmień dane", "ia_submit", false);
$result =(xvp()->getData($form));
if($result){
	$saved = xvp()->save_user_data($XVauctions, $XVwebEngine->Session->Session('Logged_User'), $result );
}
//$XVauctions->

$Smarty->assign('address_form', $address_form);
$Smarty->display('xvauctions_theme/panel_show.tpl');

?>