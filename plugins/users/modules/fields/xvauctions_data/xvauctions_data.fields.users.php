<?php
class xv_users_fields_xvauctions_data extends xv_users_fields {
	var $plg_author = "Krzysztof Bednarczyk";
	var $plg_title = "XVauctions Data";
	var $plg_webiste = "http://bordeux.net/";
	var $plg_description = "XVauctions data changer";
	
	public function field(){
		global $LocationXVWeb, $XVwebEngine, $URLS, $user_data, $user_class;
		
		if($user_data->User != $XVwebEngine->Session->Session('user_name') && !xv_perm("AdminPanel"))
			return '';
			
			
		xv_append_header("
		<style type='text/css' media='all'>
			.xv-user-xvauctions-content {
				margin-top: 10px;
				padding: 15px;
				background: #F2F7FA;
				border: 1px solid #AED0EA;
				-webkit-border-radius: 10px;
				-moz-border-radius: 10px;
				border-radius: 10px;
				padding-left: 50px;
			}
			.xv-user-xvauctions-content .form-row label {
				float:left;
				width: 150px;
			}

		</style>");
	include_once(ROOT_DIR.'core/libraries/arrays/countries.php');
	include_once(ROOT_DIR.'core/libraries/formgenerator/formgenerator.php');
	include_once(ROOT_DIR.'core/libraries/formgenerator/validators.php');
	include_once(ROOT_DIR.'plugins/xvauctions/libs/class.xvauctions.php');
	$XVauctions = &$XVwebEngine->load_class("xvauctions");
	$user_data_xva  = xvp()->get_user_data($XVauctions, $XVwebEngine->Session->Session('user_name') );

	$form=new Form();        
	$form->set("name", "form_ia");
	$form->set("linebreaks", false);                        
	$form->set("errorBox", "error");                            
	$form->set("sanitize", false);            
	$form->set("divs", true);                
	$form->set("action", '?save=true&amp;xvauction_data=true#xvauction-user-data');
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
		$saved = xvp()->save_user_data($XVauctions, $XVwebEngine->Session->Session('user_name'), $result );
	}
		$result = '';
		$result .=
		'<div class="xv-user-xvauctions" id="xvauction-user-data">
		<div class="xv-user-seperate"><span> Adres zamieszkania </span></div>
		<div class="xv-user-xvauctions-content">
		'.(isset($_GET['xva_set_data']) ? '<div class="xv-info">Aby wykonać poprzednią operacje, musisz uzupełnić dane poniżej</div> <br/>': '').'
			'.$address_form.'
		</div>
			<div style="clear: both;" ></div>
		</div>';
		return $result;
	}
}