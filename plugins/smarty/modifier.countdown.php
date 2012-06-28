<?php 
/** 
 * Smarty plugin 
 * @package Smarty 
 * @subpackage plugins 
 */ 



function smarty_modifier_countdown($data, $now){ 
try {
    $dt = new DateTime($data);
    $dt2 = new DateTime($now);
}
catch(Exception $e) {
    return "Error: bad date. You need run in your server DateTime class in php.ini. More info: ".$e->getMessage();
}

      $seconds = $dt->getTimestamp()-$dt2->getTimestamp();
      $minutes = floor($seconds/60);
      $hours = floor($seconds/(60*60));
      $days = floor($seconds/(60*60*24));
      $months = floor($seconds/(60*60*24*31));
      $years = floor($seconds/(60*60*24*31*12));
      $msg = '';
      if(substr($minutes, 0, 1) >= 0)
         $msg = '<span class="auction-time-k">'.xv_lang("xca_end").'</span>';      
		 
      if(substr($minutes, 0, 1) > 0 AND $minutes < (60*60)) {
            if(substr($minutes, 1, 1) < 5) {
               if($minutes == '1')
                  $msg = '<span class="auction-time-b">'.xv_lang("xca_countdown_minute").'</span>';
               else
                  $msg = '<span class="auction-time-ca">'.$minutes.' '.xv_lang("xca_countdown_minute2").'</span>';
                  
               if($minutes >= '10' AND $minutes <= '59')
                  $msg = '<span class="auction-time-c">'.$minutes.' '.xv_lang("xca_countdown_minute2").'</span>';
            } else
               $msg = '<span class="auction-time-c">'.$minutes.' '.xv_lang("xca_countdown_minute2").'</span>';
      }
      if(substr($hours, 0, 1) > 0 AND $hours < 1)
         $msg = '<span class="auction-time-d">1 '.xv_lang("xca_countdown_hour").'</span>';
      if(substr($hours, 0, 1) > 0 AND $hours < (60*60))
         $msg = '<span class="auction-time-e">'.$hours.' '.xv_lang("xca_countdown_hours").'</span>';
      if(substr($days, 0, 1) > 0 AND $days < 1)
         $msg = '<span class="auction-time-f">1 '.xv_lang("xca_countdown_day").'</span>';
      if(substr($days, 0, 1) > 0 AND $days < (60*60*24))
         $msg = '<span class="auction-time-g">'.$days.' '.xv_lang("xca_countdown_days").'</span>';
      if(substr($months, 0, 1) > 0 AND $months < 1)
         $msg = '<span class="auction-time-h">1 '.xv_lang("xca_countdown_month").'</span>';
      if(substr($months, 0, 1) > 0 AND $months < (60*60*24*31))
         $msg = '<span class="auction-time-i">'.$months.' '.xv_lang("xca_countdown_months").'</span>';
      if(substr($months, 0, 1) > 0 AND $months > (60*60*24*31))
         $msg = '<span class="auction-time-j">1 '.xv_lang("xca_countdown_year").'</span>';
 
	  return $msg;
} 

/* vim: set expandtab: */ 

?>