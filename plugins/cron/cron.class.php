<?php
class xv_cron {
	var $XVweb = null;
	function __construct(&$XVweb) {
     $this->XVweb = &$XVweb;
   }
	public function run(){
		return true;
	}
	public function get_interval($last_time){
		return 60*30; //seconds
	}
}

?>