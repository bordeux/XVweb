<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

class xva_platnosci_online_config extends xv_config {
	public function init_fields(){
		return array(
			"enabled" => true,
			"ips" => "195.150.9.37",
			"seller_id" => 111111,
			"key" => "aaaaaaaaaaaaaaaaaaaaaaa",
			"provision" => 0.95,
		);
	}
}


class xv_payments_method_platnoscionline extends xv_payments_method {
	var $config_file = "platnoscionline.payments";
	var $Data;

	public function __construct(&$Xvweb) {
		$this->Data['XVweb'] = &$Xvweb;
		$this->config = new xva_platnosci_online_config();
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	public function worker(){
	$config_sellerid = $this->config->seller_id;
	$config_provision =  $this->config->provision;
	$config_key = $this->config->key;
	$bkey = pack('H*' , $config_key);
	$control = urlencode($_POST["control"]);
	$id_transakcji = $_POST["tr_id"];
	$id_transakcji = str_replace('AX-','',$id_transakcji);
	$id_transakcji = str_replace('-PL','',$id_transakcji);
	$amount = urlencode($_POST["amount"]);
	$tr_result = $_POST['tr_result'];
	$checksum = $_POST["checksum"];
	$checksum_control = md5($config_sellerid.'&'.$control.'&'.$amount.'&'.$tr_result.'&'.'AX-'.$id_transakcji.'-PL'.'&'.$bkey);

		if ( $checksum_control == $checksum ){
		echo "OK";
				$checksum_control = md5($posid.'&OK&'.$bkey); // oblicz sumę kontrolną komunikacji
				echo "\n".$checksum_control;
				if ($tr_result=='1') {
				preg_match("/\|([0-9]{0,})\|/si", $_POST["control"], $matches);
				if(!isset($matches[1]) || !is_numeric($matches[1])){
					$_POST['error'] = "bad description";
					$this->Data['XVweb']->Log("przelewyonline", $_POST);
					exit("bad desc");
				}
				$user_info = $this->Data['XVweb']->DataBase->pquery('SELECT {Users:*} FROM {Users} WHERE {Users:ID} = '.$matches[1].' LIMIT 1')->fetch(PDO::FETCH_ASSOC);
				if(empty($user_info)){
					$_POST['error'] = "User does't exist";
					$this->Data['XVweb']->Log("przelewyonline", $_POST);
					exit("user does't exist");
				}
				
				xvp()->add_transaction(xvp()->load_class($this->Data['XVweb'], "xvpayments"), $user_info['User'], ($_POST["amount"]*$config_provision), "przelewyonline", "Wpłata poprzez przelewy-online.pl" , $_POST, "przelew-".$_POST['tr_id']);
			
				}

		}

			exit();
	}
	public function form(){
	include_once(dirname(__FILE__).'/data/paypal.inc.php');
	
	$config_sellerid = $this->config->seller_id;
	$config_provision =  $this->config->provision;
	$config_key = $this->config->key;

	if(isset($_POST['amount'])){
		$user_info = $this->Data['XVweb']->DataBase->pquery('SELECT {Users:*} FROM {Users} WHERE {Users:ID} = '.$this->Data['XVweb']->Session->Session("user_ID").' LIMIT 1')->fetch(PDO::FETCH_ASSOC);
			if(empty($user_info)){
				exit("Ty nie istniejsz w naszej bazie? Skontaktuj się jak najszybciej z adminem, podaj mu te dane: ". __FILE__ .' oraz id lini '.__LINE__);
			}
			
			$description =  urlencode("Doladowanie dla |".$user_info['ID']."|");
			$amount = (intval($_POST['amount']*100));
			$URLC =  urlencode($GLOBALS['URLS']['AuctionPanel'].'/payment_add/platnoscionline/worker/?type=notify');
			$mail =  urlencode($user_info['Mail']);
			$url_return =  urlencode($GLOBALS['URLS']['Site'].'Page/xvAuctions/Payment_success/?type=platnoscionline');
			$control = urlencode(uniqid()."|".$user_info['ID']."|");
			$bkey = pack('H*' , $config_key);
			
			$checksum  = md5($config_sellerid . '&' . $amount. '&' . $description  . '&' . $mail . '&' . $URLC . '&' . $url_return . '&' . $control . '&' . $bkey);
			
			$url = 'https://platnosci-online.pl/payment.php?posid='.$config_sellerid.'&URLC='.$URLC.'&amount='.$amount.'&description='.($description ).'&control='.$control
.'&email='.$mail .'&url_return='.$url_return.'&checksum='.$checksum.'';
			header('Location: '.$url.'');
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
		$config_enabled = ($config_enabled == "true" ? true : false );
		if(!$config_enabled)
			return null;
			
		$result = '<a href="'.$GLOBALS['URLS']['AuctionPanel'].'/payment_add/platnoscionline/form/" title="płatności internetowe"><img src="'.$GLOBALS['URLS']['Site'].'plugins/xvauctions/payments/data/po.jpg" style="border:0" alt="Zapłać szybko i wygodnie przez platnoscionline.pl" title="Zapłać wygodnie online przez platnosci-online.pl" width="139" height="62" /></a> ';
	return $result;
	}
}

	?>