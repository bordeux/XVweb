<?php
class xv_cron_clear_cache extends xv_cron {
	public function recursiveDelete($str, $delete_self = false){
        if(is_file($str)){
            return @unlink($str);
        }
        elseif(is_dir($str)){
            $scan = glob(rtrim($str,'/').'/*');
            foreach($scan as $index=>$path){
                $this->recursiveDelete($path, true);
            }
			if($delete_self)
				return @rmdir($str);
        }
    }
	public function run(){
			$this-> recursiveDelete(ROOT_DIR.'tmp/', false);
		return true;
	}
	public function get_interval($last_time){
		return 60*60; 
	}
}

?>