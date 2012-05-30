<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/
class xva_przelewy24_config extends xv_config {
	public function init_fields(){
		return array(
			"enabled" => true,
			"test_mode" => false,
			"seller_id" => 111111,
			"payment_key" => "aaaaaaaaaaaaaaaaaaaaaaa",
			"lang" => "PL",
			"provision" => 0.95,
			"currency" => "PLN",
		);
	}
}

class xv_payments_method_przelewy24 extends xv_payments_method{
	var $config_file = "przelewy24.payments";
	var $Data;

	public function __construct(&$Xvweb) {
		$this->Data['XVweb'] = &$Xvweb;
		$this->config = new xva_przelewy24_config();
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	function p24_weryfikuj($p24_id_sprzedawcy, $p24_session_id, $p24_order_id, $p24_kwota=""){
			$P = array(); $RET = array();
			$url = "https://secure.przelewy24.pl/transakcja.php";
			$P[] = "p24_id_sprzedawcy=".$p24_id_sprzedawcy;
			$P[] = "p24_session_id=".$p24_session_id;
			$P[] = "p24_order_id=".$p24_order_id;
			$P[] = "p24_kwota=".$p24_kwota;
			$P[] = "p24_crc=".md5($p24_session_id."|". $p24_order_id."|". $p24_kwota."|"."abc1def2");
			$user_agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_POST,1);
			if(count($P)) curl_setopt($ch, CURLOPT_POSTFIELDS,join("&",$P));
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			$result=curl_exec ($ch);
			curl_close ($ch);
			$T = explode(chr(13).chr(10),$result);
			$res = false;
			foreach($T as $line){
				$line = str_replace(array("\n", "\r"),"",$line);
				if($line != "RESULT" and !$res) continue;
				if($res) $RET[] = $line;
				else $res = true;
			}
			return $RET;
		}


	public function worker(){
			$config_sellerid = $this->config->seller_id;
			$config_testmode = $this->config->test_mode;
			$config_provision =  $this->config->provision;
			$session_id = $_POST["p24_session_id"];
			$order_id = $_POST["p24_order_id"];
			$id_sprzedawcy = $config_sellerid;
			$kwota = $_GET["amount"];
			$result = $this->p24_weryfikuj($id_sprzedawcy,$session_id, $order_id, $kwota);
			
			$user_info = $this->Data['XVweb']->DataBase->pquery('SELECT {Users:*} FROM {Users} WHERE {Users:ID} = '.((int) $_GET['user_id']).' LIMIT 1')->fetch(PDO::FETCH_ASSOC);
				if(empty($user_info)){
					$_POST['error'] = "User does't exist";
					$this->Data['XVweb']->Log("przelewy24.pl", $_POST);
					exit("user does't exist");
				}
				
			if($result[0] == "TRUE") {
				xvp()->add_transaction(xvp()->load_class($this->Data['XVweb'], "xvpayments"), $user_info['User'], $_GET['amount']*$config_provision, "przelewy24", "Wpłata poprzez przelewy24.pl" , $_POST, "p24-".$session_id);
			
				header('Location: '.$GLOBALS['URLS']['Site'].'Page/xvAuctions/Payment_success/?type=przelewy24');
				exit;
			}else {
				header('Location: '.$GLOBALS['URLS']['Site'].'Page/xvAuctions/Payment_error/?type=przelewy24');
				exit;
			}
			exit("OK");
	}
	public function form(){
	include_once(dirname(__FILE__).'/data/paypal.inc.php');
	
	$config_sellerid = $this->config->seller_id;
	$config_currency = $this->config->currency;
	$config_testmode = $this->config->test_mode;
	$config_provision =  $this->config->provision;
	$config_paymentkey = $this->config->payment_key;
	$config_lang = $this->config->lang;
	$config_testmode = (int) $this->config->test_mode;
	if(isset($_POST['amount'])){
		$user_info = $this->Data['XVweb']->DataBase->pquery('SELECT {Users:*} FROM {Users} WHERE {Users:ID} = '.$this->Data['XVweb']->Session->Session("user_ID").' LIMIT 1')->fetch(PDO::FETCH_ASSOC);
			if(empty($user_info)){
				exit("Ty nie istniejsz w naszej bazie? Skontaktuj się jak najszybciej z adminem, podaj mu te dane: ". __FILE__ .' oraz id lini '.__LINE__);
			}
			
			
			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'
		. '<html xmlns="http://www.w3.org/1999/xhtml"><head><title>Redirecting to przelewy24...</title></head>'
		.'<body onload="document.f.submit();"><h3>Redirecting to przelewy24...</h3>';
		
			echo '<form action="https://secure.przelewy24.pl/index.php" method="post" name="f">
					<input type="hidden" name="p24_session_id" value="'.uniqid().'|'.$user_info['ID'].'|" />
					<input type="hidden" name="p24_id_sprzedawcy" value="'.$config_sellerid.'" />
					<input type="hidden" name="p24_kwota" value="'.($_POST['amount']*100).'" />
					<input type="hidden" name="p24_opis" value="'.($config_testmode ? "TEST_OK": 'Doladowanie ID |'.$user_info['ID'].'|').'" />
					<input type="hidden" name="p24_klient" value="'.$user_info['Name'].' '.$user_info['Vorname'].'" />
					<input type="hidden" name="p24_kraj" value="'.$config_lang.'" />
					<input type="hidden" name="p24_email" value="'.$user_info['Mail'].'" />
					<input type="hidden" name="p24_language" value="'.strtolower($config_lang).'" />
					<input type="hidden" name="p24_return_url_ok" value="'.$GLOBALS['URLS']['AuctionPanel'].'/payment_add/przelewy24/worker/?type=notify&user_id='.$user_info['ID'].'&amount='.($_POST['amount']*100).'" />
					<input type="hidden" name="p24_return_url_error" value="'.$GLOBALS['URLS']['AuctionPanel'].'/payment_add/przelewy24/worker/?type=notify&user_id='.$user_info['ID'].'&error=true" />
					<input name="submit_send" value="Click here if you are not redirected within 10 seconds" type="submit" />
				</form></body></html>';
			exit;
			
	}
		
			$result .= '<br />Prowizja: '.((1-$config_provision)*100).'%';
	$result .= '<br />Otrzymana kwota: <span id="result-amount">0.00</span>';

	return "<div>
		<form action='?' method='post'>
			<label for='amount'>Kwota :</label> <input  type='text' id='amount-id' pattern='((([0-9]){0,10})|(([0-9]){0,10}(\.)([0-9]){2}))' name='amount' value='20.00'> ".$config_currency."
				<input type='submit' value='Dalej' />".
				'<br />Prowizja: '.((1-$config_provision)*100).'%'.
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
		});
	</script>';
	}
	public function button(){
		$config_enabled = $this->config->enabled;
		if(!$config_enabled)
			return null;
			
		$result = '<a href="'.$GLOBALS['URLS']['AuctionPanel'].'/payment_add/przelewy24/form/" title="płatności internetowe"><img src="'.$GLOBALS['URLS']['Site'].'plugins/xvauctions/payments/data/przelewy24.png" style="border:0" alt="Zapłać szybko i wygodnie przez przelewy24.pl" title="Zapłać wygodnie online przez przelewy24.pl" width="139" height="62" /></a> ';
	return $result;
	}
}

	?>