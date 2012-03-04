<?php
/*********************************************************

* DO NOT REMOVE *

Project: PHP PayPal Class 1.0
Url: http://phpweby.com
Copyright: (C) 2009 Blagoj Janevski - bl@blagoj.com
Project Manager: Blagoj Janevski

For help, comments, feedback, discussion ... please join our
Webmaster forums - http://forums.phpweby.com

License------------------------------------------------:
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
End License----------------------------------------------

*********************************************************/

class paypal
{
	var $logfile='ipnlog.txt';
	var $form=array();
	var $log=0;
	var $form_action='https://www.paypal.com/cgi-bin/webscr';
	var $paypalurl='www.paypal.com';
	var $type='payment';
	var $posted_data=array();
	var $action='';
	var $error='';
	var $ipn='';
	var $price=0;
	var $payment_success=0;
	var $ignore_type=array();


	function paypal($price_item=0)
	{
		$this->price=$price_item;
	}
	function validate_post($url_, $postFields_){
		//setting the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url_);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);

		//turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);

		//setting the nvpreq as POST FIELD to curl
		curl_setopt($ch,CURLOPT_POSTFIELDS,$postFields_);

		//getting response from server
		$httpResponse = curl_exec($ch);
	
			file_put_contents('payresul.txt', print_r($httpResponse,true), FILE_APPEND | LOCK_EX);

		
		if(!$httpResponse) {
			return array("status" => false, "error_msg" => curl_error($ch), "error_no" => curl_errno($ch));
		}
		if(strpos($httpResponse,"VERIFIED") === false){
			return array("status" => false, "error_msg" => "Invalid post data");
		}
	
		return array("status" => true, "httpResponse" => $httpResponse);
	}
	
	function validate_ipn(){
		if(empty($_POST))
			return 0;
			
	$this->posted_data = $_POST;

		$ppResponseAr = $this->validate_post("https://".$this->paypalurl."/cgi-bin/webscr", http_build_query(array_merge($_POST, array("cmd" => "_notify-validate"))), false);

		if(!$ppResponseAr["status"]) {
			return 0;
		}

			$this->price=$this->posted_data['mc_amount3'];
			$this->payment_success=1;
			
		return true;
						
			
	}

	function add($name,$value)
	{
		$this->form[$name]=$value;
	}

	function remove($name)
	{
		unset($this->form[$name]);
	}

	function enable_recurring()
	{
		$this->type='subscription';
		$this->add('src','1');
		$this->add('sra','1');
		$this->add('cmd','_xclick-subscriptions');
		$this->remove('amount');
		$this->add('no_note',1);
		$this->add('no_shipping',1);
		$this->add('currency_code','USD');
		$this->add('a3',$this->price);
		$this->add('notify_url',$this->ipn);

	}

	function recurring_year($num)
	{
		$this->enable_recurring();
		$this->add('t3','Y');
		$this->add('p3',$num);
	}

	function recurring_month($num)
	{
		$this->enable_recurring();
		$this->add('t3','M');
		$this->add('p3',$num);
	}

	function recurring_day($num)
	{
		$this->enable_recurring();
		$this->add('t3','D');
		$this->add('p3',$num);
	}


	function enable_payment()
	{
		$this->type='payment';
		$this->remove('t3');
		$this->remove('p3');
		$this->remove('a3');
		$this->remove('src');
		$this->remove('sra');
		$this->add('amount',$this->price);
		$this->add('cmd','_xclick');
		$this->add('no_note',1);
		$this->add('no_shipping',1);
		$this->add('currency_code','USD');
		$this->add('notify_url',$this->ipn);
	}
	function output_form()
	{

		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'
		. '<html xmlns="http://www.w3.org/1999/xhtml"><head><title>Redirecting to PayPal...</title></head>'
		.'<body onload="document.f.submit();"><h3>Redirecting to PayPal...</h3>'
		. '<form name="f" action="'.$this->form_action.'" method="post">';

		foreach($this->form as $k=>$v)
		{
			echo '<input type="hidden" name="' . $k . '" value="' . $v . '" />';
		}

		echo '<input type="submit" value="Click here if you are not redirected within 10 seconds" /></form></body></html>';


	}

	function reset_form()
	{
		$this->form=array();
	}

	function log_results($var)
	{
		$fp=@ fopen($this->logfile,'a');
		$data=date('m/d/Y g:i A');
		if($var==1)
		{
			$str="\nIPN PAYPAL TRANSACTION ID: " . $this->posted_data['txn_id'] ."\n";
			$str.="SUCCESS\n";
			$str.="DATE: ". $data . "\n";
			$str.="PAYER EMAIL: " . $this->posted_data['payer_email']. "\n";
			$str.="NAME: " . $this->posted_data['last_name']." ".$this->posted_data['first_name']. "\n";
			$str.="LINK ID: ". $this->posted_data['item_number']. "\n";
			$str.="QUANTITY: ". $this->posted_data['quantity']. "\n";
			$str.="TOTAL: "   . $this->posted_data['mc_gross']. "\n\n\n";
			$str.="OTHER: "   . print_r($this->posted_data, true). "\n\n\n";
		}
		else
		{
			$str="\nIPN PAYPAL TRANSACTION ID:\n";
			$str.="INVALID\n";
			$str.="REMOTE IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
			$str.="ERROR: ". $this->posted_data['error'] . "\n";
			$str.="DATE: ". $data . "\n";
			$str.="PAYER EMAIL: " . $this->posted_data['payer_email']. "\n";
			$str.="NAME: " . $this->posted_data['last_name']." ".$this->posted_data['first_name']. "\n";
			$str.="LINK ID: ". $this->posted_data['item_number']. "\n";
			$str.="QUANTITY: ". $this->posted_data['quantity']. "\n";
			$str.="TOTAL: "   . $this->posted_data['mc_gross']. "\n\n\n";
			$str.="OTHER: "   . print_r($this->posted_data, true). "\n\n\n";
		}
		if($fp)
		@ fputs($fp,$str);

		@ fclose($fp);
	}
	function test_mode(){
		$this->form_action='https://sandbox.paypal.com/cgi-bin/webscr';
		$this->paypalurl='sandbox.paypal.com';
	}

	function headers_nocache()
	{
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: pre-check=0, post-check=0, max-age=0');
		header('Pragma: no-cache');
	}


}
