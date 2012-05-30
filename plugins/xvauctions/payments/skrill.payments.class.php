<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

class xva_skrill_config extends xv_config {
	public function init_fields(){
		return array(
			"enabled" => true,
			"email" => "dev@dev.dev",
			"secret_word" => "0a0a0a0a",
			"lang" => "EN",
			"logo" => "",
			"provision" => 3.05,
			"currency" => "USD",
		);
	}
}

class xv_payments_method_skrill extends xv_payments_method{
	var $config_file = "skrill.payments";
	var $Data;

	public function __construct(&$Xvweb) {
		$this->Data['XVweb'] = &$Xvweb;
		$this->config = new xva_skrill_config();
		
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	
	public function worker(){

		if(empty($_POST))
			exit("empty POST data");
			
		$config_secretword = $this->config->secret_word;
		$config_email = $this->config->email;

		$concatFields = $_POST['merchant_id']
			.$_POST['transaction_id']
			.strtoupper(md5($config_secretword))
			.$_POST['mb_amount']
			.$_POST['mb_currency']
			.$_POST['status'];
	
			if (strtoupper(md5($concatFields)) == $_POST['md5sig']
				&& $_POST['status'] == 2
				&& $_POST['pay_to_email'] == $config_email)
			{
			preg_match("/\|([0-9]{0,})\|/si", $_POST['tr_desc'], $matches);
			if(!isset($matches[1]) || !is_numeric($matches[1])){
				$_POST['error'] = "bad description";
				$this->Data['XVweb']->Log("skrill.com", $_POST);
				exit("bad desc");
			}
			$user_info = $this->Data['XVweb']->DataBase->pquery('SELECT {Users:*} FROM {Users} WHERE {Users:ID} = '.$matches[1].' LIMIT 1')->fetch(PDO::FETCH_ASSOC);
			if(empty($user_info)){
				$_POST['error'] = "User does't exist";
				$this->Data['XVweb']->Log("skrill.com", $_POST);
				exit("user does't exist");
			}
			xvp()->add_transaction(xvp()->load_class($this->Data['XVweb'], "xvpayments"), $user_info['User'], ($_POST['tr_amount']*100*$config_provision), "transfeujpl", "Wpłata poprzez skrill.com" , $_POST, "trns-".$_POST['tr_id']);
			
			}
			else
			{
				
				exit;
			}


	}
	public function form(){
	
		$config_email = $this->config->email;
		$config_language = $this->config->lang;
		$config_provision = $this->config->provision;
		$config_currency = $this->config->currency;
		$config_logo = $this->config->logo;
		
	$user_info = $this->Data['XVweb']->DataBase->pquery('SELECT {Users:*} FROM {Users} WHERE {Users:ID} = '.$this->Data['XVweb']->Session->Session("user_ID").' LIMIT 1')->fetch(PDO::FETCH_ASSOC);
		if(empty($user_info)){
			exit("Ty nie istniejsz w naszej bazie? Skontaktuj się jak najszybciej z adminem, podaj mu te dane: ". __FILE__ .' oraz id lini '.__LINE__);
		}
		

	$result = '<div style="float:left;"><form action="https://www.moneybookers.com/app/payment.pl" method="post">';
	$result .= '<input type="hidden" name="pay_to_email" value="'.$config_email.'"/>';
	$result .= '<input type="hidden" name="status_url" value="'.$GLOBALS['URLS']['AuctionPanel'].'/payment_add/skrill/worker/?type=notify"/>';
	$result .= '<input type="hidden" name="language" value="'.$config_language.'"/>';
	$result .= '<label for="amount">Kwota :</label> <input type="text" id="amonut-id" pattern="((([0-9]){0,10})|(([0-9]){0,10}(\.)([0-9]){2}))" name="amount" value="20.00"> '.$config_currency;
	$result .= '<input type="hidden" name="currency" value="'.$config_currency.'"/>';
	$result .= '<input type="hidden" name="detail1_description" value="Payments"/>';
	$result .= '<input type="hidden" name="detail1_text" value="Doladowanie - ID: |'.$user_info['ID'] .'|"/>';
	if(!empty($config_logo))
	$result .= '<input type="hidden" name="logo_url" value="'.$config_logo.'"/>';
	
	
	$result .= '<input type="submit" value="Dalej" />';
	$result .= '<br />Prowizja: kwota*'.($config_provision);
	$result .= '<br />Otrzymana kwota: <span id="result-amount">0.00</span> zł';
	$result .= '</form></div>';
	$result .= '<div style="float:right; padding-right: 50px;"></div>
	<div style="clear:both;"></div>
	';
	$result .= '<script type="text/javascript">
	
	
		$(function(){
					$("#amonut-id").keyup(function(){
						var amount = parseFloat($(this).val());
						amount = amount*('.$config_provision.');
						$("#result-amount").text(amount.toFixed(2));
					});
					
			$("transferujpl-form").submit();
		});
	</script>';
	
	return $result;
	}
	public function button(){
		$config_enabled = $this->config->enabled;
		$config_enabled = ($config_enabled == "true" ? true : false);
		if(!$config_enabled)
			return null;
			
		$result = '<a href="'.$GLOBALS['URLS']['AuctionPanel'].'/payment_add/skrill/form/" title="płatności internetowe"><img src="'.$GLOBALS['URLS']['Site'].'plugins/xvauctions/payments/data/skrill.gif" style="border:0" alt="Zapłać szybko i wygodnie przez skrill.com" title="Zapłać wygodnie online przez skrill.com" width="139" height="62" /></a> ';
	return $result;
	}
}

	?>