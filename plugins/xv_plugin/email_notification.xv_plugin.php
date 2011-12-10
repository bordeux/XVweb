<?php
class xv_plugin_email_notification {

	public function before_xvpayments__get_payments($args){
		return $args;
	}	
	public function after_xvpayments__get_payments($result,$args){
		return $result;
	}
	
}

?>