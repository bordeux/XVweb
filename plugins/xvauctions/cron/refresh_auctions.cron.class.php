<?php
class xv_cron_refresh_auctions extends xv_cron{
	public function run(){
			include_once(dirname(__FILE__).'/../libs/class.xvauctions.php');
			$XVauctions = $this->XVweb->InitClass("xvauctions");
			$XVauctions->refresh_auctions();
			$XVauctions->update_dutch_auctions();
		return true;
	}
	public function get_interval($last_time){
		return 20; 
	}
}

?>