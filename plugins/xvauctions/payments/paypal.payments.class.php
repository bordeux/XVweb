<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

class xva_paypal_config extends xv_config {
	public function init_fields(){
		return array(
			"enabled" => true,
			"email" => "dev@dev.dev",
			"test_mode" =>true,
			"currency" => "USD",
			"provision" => 3.20,
		);
	}
}
class xv_payments_method_paypal extends xv_payments_method {
	var $config_file = "paypal.payments";
	var $Data;

	public function __construct(&$Xvweb) {
		$this->Data['XVweb'] = &$Xvweb;
		$this->config = new xva_paypal_config();
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	
	public function worker(){
		include_once(dirname(__FILE__).'/data/paypal.inc.php');
		$paypal=new paypal();
		$paypal->log=1; 
		$config_provision = $this->config->provision;
		$config_email = $this->config->email;
		$config_currency = $this->config->currency;
		$config_testmode = $this->config->test_mode;
		if($config_testmode)
			$paypal->test_mode();
			if($paypal->validate_ipn()){
				if($paypal->payment_success==1){
				if($paypal->posted_data['receiver_email'] != $config_email){
					exit("Spoofed email");
				}				
				if($paypal->posted_data['mc_currency'] != $config_currency){
					exit("Spoofed currency");
				}
					preg_match("/\|([0-9]{0,})\|/si", $paypal->posted_data['item_name'], $matches);
					if(!isset($matches[1]) || !is_numeric($matches[1])){
						$_POST['error'] = "bad description";
						$this->Data['XVweb']->Log("paypal.com", $_POST);
						exit("bad desc");
					}
					$user_info = $this->Data['XVweb']->DataBase->pquery('SELECT {Users:*} FROM {Users} WHERE {Users:ID} = '.$matches[1].' LIMIT 1')->fetch(PDO::FETCH_ASSOC);
					if(empty($user_info)){
						$_POST['error'] = "User does't exist";
						$this->Data['XVweb']->Log("paypal.com", $_POST);
						exit("user does't exist");
					}
					xvp()->add_transaction(xvp()->InitClass($this->Data['XVweb'], "xvpayments"), $user_info['User'], ($paypal->posted_data['payment_gross']*100*$config_provision), "paypal", "Wpłata poprzez paypal.com" , $_POST, "paypal-".$paypal->posted_data['item_number']);
					
				}else{
					
				}
			}else{
				
			}
		
		exit('TRUE');
	}
	public function form(){
	include_once(dirname(__FILE__).'/data/paypal.inc.php');
	
	$config_email = $this->config->email;
	$config_currency = $this->config->currency;
	$config_testmode = (int) $this->config->test_mode;
	$config_provision =  $this->config->provision;
	if(isset($_POST['amount'])){
		$user_info = $this->Data['XVweb']->DataBase->pquery('SELECT {Users:*} FROM {Users} WHERE {Users:ID} = '.$this->Data['XVweb']->Session->Session("Logged_ID").' LIMIT 1')->fetch(PDO::FETCH_ASSOC);
			if(empty($user_info)){
				exit("Ty nie istniejsz w naszej bazie? Skontaktuj się jak najszybciej z adminem, podaj mu te dane: ". __FILE__ .' oraz id lini '.__LINE__);
			}
		
		$paypal = new paypal();
		if($config_testmode)
			$paypal->test_mode();
			
		$paypal->price=htmlspecialchars($_POST['amount']);
		$paypal->ipn= $GLOBALS['URLS']['AuctionPanel'].'/payment_add/paypal/worker/?type=notify'; //full web address to IPN script
		$paypal->enable_payment();
		$paypal->add('currency_code', $config_currency);
		$paypal->add('business', $config_email);
		$paypal->add('item_name','Doladowanie ID: |'.$user_info['ID'].'|');
		$paypal->add('item_number',uniqid().' ID: |'.$user_info['ID'].'|');
		$paypal->add('quantity',1);
		$paypal->add('return', $GLOBALS['URLS']['Site'].'Page/xvAuctions/Payment_success/?type=paypal');
		$paypal->add('cancel_return', $GLOBALS['URLS']['Site'].'Page/xvAuctions/Payment_error/?type=paypal');
		$paypal->output_form();
		exit;
	}
		
			$result .= '<br />Prowizja: '.((1-$config_provision)*100).'%';
	$result .= '<br />Otrzymana kwota: <span id="result-amount">0.00</span>';

	return "<div>
		<form action='?' method='post'>
			<label for='amount'>Kwota :</label> <input  type='text' id='amount-id' pattern='((([0-9]){0,10})|(([0-9]){0,10}(\.)([0-9]){2}))' name='amount' value='20.00'> ".$config_currency."
				<input type='submit' value='Dalej' />".
				'<br />Prowizja: kwota*'.$config_provision.''.
				'<br />Spodziewana kwota: <span id="result-amount">0.00</span> zł'.
				"
				
		</form>
	</div>".'<script type="text/javascript">
	
	
		$(function(){
					$("#amount-id").keyup(function(){
						var amount = parseFloat($(this).val());
						amount = amount*('.$config_provision.');
						$("#result-amount").text(amount.toFixed(2));
					});
					
			$("transferujpl-form").submit();
		});
	</script>';
	}
	public function button(){
		$config_enabled = $this->config->enabled;
		if(!$config_enabled)
			return null;
			
		$result = '<a href="'.$GLOBALS['URLS']['AuctionPanel'].'/payment_add/paypal/form/" title="płatności internetowe paypal.com"><img src="'.$GLOBALS['URLS']['Site'].'plugins/xvauctions/payments/data/paypal.jpg" style="border:0" alt="Zapłać szybko i wygodnie przez paypal.com" title="Zapłać wygodnie online przez paypal.com" width="139" height="62" /></a> ';
	return $result;
	}
}

	?>