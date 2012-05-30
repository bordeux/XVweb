<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

class xva_dotpay_config extends xv_config {
	public function init_fields(){
		return array(
			"enabled" => true,
			"ips" => "195.150.9.37",
			"seller_id" => 111111,
			"pin" => "0000",
			"provision" => 0.95,
		);
	}
}

class xv_payments_method_dotpay extends xv_payments_method{
	var $config_file = "dotpay.payments";
	var $Data;

	public function __construct(&$Xvweb) {
		$this->Data['XVweb'] = &$Xvweb;
		$this->config = new xva_dotpay_config();
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	
	public function worker(){

		if(empty($_POST))
			exit("empty POST data");
		$config_ips = $this->config->ips;
		$config_seller_id = $this->config->seller_id;	
		$config_provision = $this->config->provision;
		$config_pin = $this->config->pin;
		if(trim($config_ips) != "*"){
			if(strpos($config_ips, $_SERVER['REMOTE_ADDR']) == false){
				$_POST['error'] = "hack by ".$_SERVER['REMOTE_ADDR'];
				$this->Data['XVweb']->Log("dotpay.eu", $_POST);
				exit("not allowed from your IP");
			}
		}

		if($_POST['t_status'] != 2 || $_POST['amount'] =='' || $_POST['control'] =='')
			exit('TRUE');
			
		if($config_seller_id != $_POST['id'])
			exit('bad seller ID');
			
			
		$md5check =	md5($config_pin.':'.$config_seller_id.':'.$_POST['control'].':'.$_POST['t_id'].':'.$_POST['amount'].':'.$_POST['email'].':::::'.$_POST['t_status']);

		if($md5check != $_POST['md5'])
		exit('bad md5 SUM');
		
		preg_match("/\|([0-9]{0,})\|/si", $_POST['control'], $matches);
		if(!isset($matches[1]) || !is_numeric($matches[1])){
			$_POST['error'] = "bad description";
			$this->Data['XVweb']->Log("dotpay.eu", $_POST);
			exit("bad desc");
		}
		$user_info = $this->Data['XVweb']->DataBase->pquery('SELECT {Users:*} FROM {Users} WHERE {Users:ID} = '.$matches[1].' LIMIT 1')->fetch(PDO::FETCH_ASSOC);
		if(empty($user_info)){
			$_POST['error'] = "User does't exist";
			$this->Data['XVweb']->Log("dotpay.eu", $_POST);
			exit("user does't exist");
		}
		xvp()->add_transaction(xvp()->load_class($this->Data['XVweb'], "xvpayments"), $user_info['User'], ($_POST['amount']*100*$config_provision), "dotpay", "Wpłata poprzez dotpay.eu" , $_POST, "dp-".$_POST['t_id']);
		
		exit('OK');
	}
	public function form(){
	
		$config_seller_id = $this->config->seller_id;
		$config_provision = $this->config->provision;
		
	$user_info = $this->Data['XVweb']->DataBase->pquery('SELECT {Users:*} FROM {Users} WHERE {Users:ID} = '.$this->Data['XVweb']->Session->Session("user_ID").' LIMIT 1')->fetch(PDO::FETCH_ASSOC);
		if(empty($user_info)){
			exit("Ty nie istniejsz w naszej bazie? Skontaktuj się jak najszybciej z adminem, podaj mu te dane: ". __FILE__ .' oraz id lini '.__LINE__);
		}
		
	$result = '<div style="float:left;"><form action="https://ssl.dotpay.pl/" method="post">';
	$result .= '<input type="hidden" name="id" value="'.$config_seller_id.'">';
	$result .= '<input type="hidden" name="opis" value="Doladowanie - ID: |'.$user_info['ID'] .'|">';
	$result .= '<input type="hidden" name="control" value="'. uniqid() .'|'.$user_info['ID'] .'|">';

	$result .= '<label for="amount">Kwota :</label> <input id="amonut-dotpay" type="text" pattern="((([0-9]){0,10})|(([0-9]){0,10}(\.)([0-9]){2}))" name="amount" value="20.00">';
	$result .= '<input type="hidden" name="URLC" value="'.$GLOBALS['URLS']['AuctionPanel'].'/payment_add/dotpay/worker/?type=notify">';
	$result .= '<input type="hidden" name="URL" value="'.$GLOBALS['URLS']['Site'].'Page/xvAuctions/Payment_success/?type=dotpay">';
	$result .= '<input type="submit" name="dalej" value="Dalej" />';
	$result .= '<br />Prowizja: '.((1-$config_provision)*100).'%';
	$result .= '<br />Otrzymana kwota: <span id="result-amount">0.00</span> zł';
	$result .= '</form></div>';
	$result .= '<div style="float:right; padding-right: 120px;"><a href="http://dotpay.eu" target="_blank" title="system płatności internetowych"><img src="https://ssl.dotpay.pl/img/aukcja/b1_aukcje_200x100.gif" style="border:0" alt="Płatności internetowe zapewnia serwis dotpay.eu , dzięki któremu mogą Państwo wybrać jedną z 38 metod płatności" title="dotpay.eu to szybkie i wygodne płatności internetowe, kliknij aby dowiedzieć się więcej" /></a> </div>
	<div style="clear:both;"></div>
	';
	$result .= '<script type="text/javascript">
		$(function(){
					$("#amonut-dotpay").keyup(function(){
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
		$config_enabled =  $this->config->enabled;
		if(!$config_enabled)
			return null;
			
		$result = '<a href="'.$GLOBALS['URLS']['AuctionPanel'].'/payment_add/dotpay/form/" title="płatności internetowe"><img src="'.$GLOBALS['URLS']['Site'].'plugins/xvauctions/payments/data/dotpay.gif" style="border:0" alt="Zapłać szybko i wygodnie przez dotpay.eu" title="Zapłać wygodnie online przez dotpay.eu" width="139" height="62" /></a> ';
	return $result;
	}
}

	?>