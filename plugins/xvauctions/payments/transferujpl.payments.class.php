<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/
class xva_transferuj_pl_config extends xv_config {
	public function init_fields(){
		return array(
			"enabled" => true,
			"ips" => "*",
			"seller_id" => 111111,
			"secruity_code" => "aaaaaaaaaaaaaaaaaaaaaaa",
			"provision" => 0.95,
		);
	}
}

class xv_payments_method_transferujpl extends xv_payments_method{
	var $config_file = "transferujpl.payments";
	var $Data;

	public function __construct(&$Xvweb) {
		$this->Data['XVweb'] = &$Xvweb;
		$this->config = new xva_transferuj_pl_config();
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	
	public function worker(){

		if(empty($_POST))
			exit("empty POST data");
		$config_ips = $this->config->ips;
		$config_seller_id = $this->config->seller_id;	
		$config_secruity_code = $this->config->secruity_code;
		$config_provision =$this->config->provision;
		if(trim($config_ips) != "*"){
			if(strpos($config_ips, $_SERVER['REMOTE_ADDR']) == false){
				$_POST['error'] = "hack by ".$_SERVER['REMOTE_ADDR'];
				$this->Data['XVweb']->Log("transferuj.pl", $_POST);
				exit("not allowed from your IP");
			}
		}
				/*
$_POST['id'];
$_POST['tr_status'];
$_POST['tr_id'];
$_POST['tr_amount'];
$_POST['tr_paid'];
$_POST['tr_error'];
$_POST['tr_date'];
$_POST['tr_desc'];
$_POST['tr_crc'];
$_POST['tr_email'];
$_POST['md5sum'];
*/
		if($_POST['tr_status'] !='TRUE' || $_POST['tr_error'] !='none')
		exit('TRUE');
		if($config_seller_id != $_POST['id'])
		exit('bad seller ID');
		$md5_check = md5($_POST['id'].$_POST['tr_id'].$_POST['tr_amount'].$_POST['tr_crc'].$config_secruity_code);
		if($md5_check != $_POST['md5sum'])
		exit('bad md5 SUM');
		preg_match("/\|([0-9]{0,})\|/si", $_POST['tr_desc'], $matches);
		if(!isset($matches[1]) || !is_numeric($matches[1])){
			$_POST['error'] = "bad description";
			$this->Data['XVweb']->Log("transferuj.pl", $_POST);
			exit("bad desc");
		}
		$user_info = $this->Data['XVweb']->DataBase->pquery('SELECT {Users:*} FROM {Users} WHERE {Users:ID} = '.$matches[1].' LIMIT 1')->fetch(PDO::FETCH_ASSOC);
		if(empty($user_info)){
			$_POST['error'] = "User does't exist";
			$this->Data['XVweb']->Log("transferuj.pl", $_POST);
			exit("user does't exist");
		}
		xvp()->add_transaction(xvp()->load_class($this->Data['XVweb'], "xvpayments"), $user_info['User'], ($_POST['tr_amount']*100*$config_provision), "transfeujpl", "Wpłata poprzez transferuj.pl" , $_POST, "trns-".$_POST['tr_id']);
		
		exit('TRUE');
	}
	public function form(){
	
		$config_seller_id = $this->config->seller_id;
		$config_secruity_code = $this->config->secruity_code;
		$config_provision = $this->config->provision;
		
	$user_info = $this->Data['XVweb']->DataBase->pquery('SELECT {Users:*} FROM {Users} WHERE {Users:ID} = '.$this->Data['XVweb']->Session->Session("user_ID").' LIMIT 1')->fetch(PDO::FETCH_ASSOC);
		if(empty($user_info)){
			exit("Ty nie istniejsz w naszej bazie? Skontaktuj się jak najszybciej z adminem, podaj mu te dane: ". __FILE__ .' oraz id lini '.__LINE__);
		}
		
	$result = '<div style="float:left;"><form action="https://secure.transferuj.pl" method="post" class="transferujpl-form">';
	$result .= '<input type="hidden" name="id" value="'.$config_seller_id.'">';
	$result .= '<input type="hidden" name="opis" value="Doladowanie - ID: |'.$user_info['ID'] .'|">';
	$result .= '<input type="hidden" name="email" value="'. $user_info['Mail'] .'">';
	$result .= '<input type="hidden" name="nazwisko" value="'. $user_info['Vorname'] .'">';
	$result .= '<input type="hidden" name="imie" value="'. $user_info['Name'] .'">';
	$result .= '<input type="hidden" name="crc" value="'.uniqid().'">';
	$result .= '<label for="kwota">Kwota :</label> <input id="amonut-transferuj" type="text" pattern="((([0-9]){0,10})|(([0-9]){0,10}(\.)([0-9]){2}))" name="kwota" value="20.00">';
	$result .= '<input type="hidden" name="wyn_url" value="'.$GLOBALS['URLS']['AuctionPanel'].'/payment_add/transferujpl/worker/?type=notify">';
	$result .= '<input type="hidden" name="pow_url" value="'.$GLOBALS['URLS']['Site'].'Page/xvAuctions/Payment_success/?type=transferujpl">';
	$result .= '<input type="hidden" name="pow_url_blad" value="'.$GLOBALS['URLS']['Site'].'Page/xvAuctions/Payment_error/?type=transferujpl">';
	$result .= '<input type="submit" value="Dalej" />';
	$result .= '<br />Prowizja: '.((1-$config_provision)*100).'%';
	$result .= '<br />Otrzymana kwota: <span id="result-amount">0.00</span> zł';
	$result .= '</form></div>';
	$result .= '<div style="float:right; padding-right: 50px;"><a href="http://transferuj.pl/jak-to-dziala.html" target="_blank" title="system płatności internetowych"><img src="http://img.transferuj.pl/platnosci-internetowe/transferuj-full-449x162.png" style="border:0" alt="Płatności internetowe zapewnia serwis Transferuj.pl , dzięki któremu mogą Państwo wybrać jedną z 38 metod płatności" title="Transferuj.pl to szybkie i wygodne płatności internetowe, kliknij aby dowiedzieć się więcej" width="449" height="162" /></a> </div>
	<div style="clear:both;"></div>
	';
	$result .= '<script type="text/javascript">
	
	
		$(function(){
					$("#amonut-transferuj").keyup(function(){
						var amount = parseFloat($(this).val());
						amount = amount*('.$config_provision.');
						$("#result-amount").text(amount.toFixed(2));
					});
		
		});
	</script>';
	
	return $result;
	}
	public function button(){
		$config_enabled = $this->config->enabled;
		if(!$config_enabled)
			return null;
			
		$result = '<a href="'.$GLOBALS['URLS']['AuctionPanel'].'/payment_add/transferujpl/form/" title="płatności internetowe"><img src="'.$GLOBALS['URLS']['Site'].'plugins/xvauctions/payments/data/transferuj.png" style="border:0" alt="Zapłać szybko i wygodnie przez Transferuj.pl" title="Zapłać wygodnie online przez Transferuj.pl" width="139" height="62" /></a> ';
	return $result;
	}
}

	?>