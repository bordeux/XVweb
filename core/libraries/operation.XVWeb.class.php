<?php
function ifsetor(&$val, $default = null){return isset($val) ? $val : $default;}

class OperationXVWeb
{
	var $GenStart = 0;
	var $GenStop = 0;


	public function __construct() {
		$this->GenStart =  $this->gen_start();
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	} 
	function get_classes_by_prefix($prefix){
		$result = array();

		$className = strtolower( $prefix );
		$PrefixLen = strlen($prefix);
		foreach ( get_declared_classes() as $c ) {
			if ( $className == substr(strtolower($c), 0, $PrefixLen) ) {
				$result[] = $c;   
			}
		}

		return $result;
	}
	public function gen_start()
	{
		$time = explode(" ", microtime());
		$usec = (double)$time[0];
		$sec = (double)$time[1];
		return $sec + $usec;
	}

	public function gen_stop($Carefully = 5)
	{
		$this->GenStop = $this->gen_start();
		$run = $this->GenStop - $this->GenStart;
		return substr($run, 0, $Carefully);
	}


	public function get_size( $path )
	{
		$size = 0;
		if (is_dir($path))
		{
			if ($dh = opendir($path))
			{
				while (($file = readdir($dh)) !== false)
				{
					if ($file != '.' && $file != '..')
					{
						if (is_dir($path.$file))
						{
							$size+= get_size($path.$file.'/');
						}
						else
						{
							$size+= filesize($path.$file);
						}
					}
				}
				closedir($dh);
			}
			return $size;
		}
		else
		{
			return filesize($path);
		}
	}


	public function URLRepair($url) {
		$arr = explode ('/', $url);
		$counter = 0;
		$return = '';
		foreach ($arr as $explodeArr) {
			++$counter;
			if ($counter == 1) {
				$return = rawurlencode($explodeArr);
			}else {
				$return .= "/".rawurlencode($explodeArr);}
		}
		return $return;
	}

	public function add_path_slashes($string){
		$last = $string{strlen($string)-1};
		if ($last != "/"){
			$string .= '/';
		}
		if ($string{0} != "/"){
			$string = '/'.$string;
		}
		return $string;
	}


	public function ReadCategoryArticle($str, $Slash= false){
		$str = $this->add_path_slashes($str);
		preg_match("/(.*)\/(.*)\//",$str, $matches);
		return $matches[1].'/';

		$str = explode("/", $str);
		while ($i <= (count($str)-3)) {
			$return .=$str[++$i]."/";
		}
		if($Slash){
			if($return=="/")
			return "";
		}
		return $return;
	}


	public function read_prefix_from_url($str, $index=1){
		$str = $this->add_path_slashes($str);
		$str = explode("/", $str);
		return $str[$index];
	}


	public function read_sufix_from_url($str){
		$str = $this->add_path_slashes($str);
		$str = explode("/", $str);
		return $str[count($str)-2];
	}

	public function delete_dir( $dir , $DeleteMatrix=true){
		$files = glob( $dir . '*', GLOB_MARK ); 
		foreach( $files as $file ){ 
			if( substr( $file, -1 ) == '/' or substr( $file, -1 ) == '\\'  ) 
			$this->delete_dir( $file ); 
			else 
			unlink( $file ); 
		} 
		if ($DeleteMatrix) rmdir( $dir ); 
	}
	public function add_get_var($ArrayOrString, $XHTML=false){
		if(is_array($ArrayOrString))
		return ($XHTML ? str_replace("&", "&amp;",http_build_query(array_merge($GLOBALS['_GET'], $ArrayOrString))) : http_build_query(array_merge($GLOBALS['_GET'], $ArrayOrString)));
		parse_str($ArrayOrString, $output);
		return ($XHTML ? str_replace("&", "&amp;",http_build_query(array_merge($GLOBALS['_GET'], $output))) : http_build_query(array_merge($GLOBALS['_GET'], $output)));
	}
	public function GetFromURL($url, $int =1, $Char = "/"){
		$url = $this->add_path_slashes($url);
		$return = explode($Char, $url);
		return (isset($return[$int]) ? $return[$int] : null);
	}

	public function array_change_key_name( $orig, $new, &$array )
	{
		if ( isset( $array[$orig] ) )
		{
			$array[$new] = $array[$orig];
			unset( $array[$orig] );
		}
		return $array;
	}
	function url_explode($string)
	{
		$a = explode('/', $string);                
		$result = array();
		for ($i = 2; $i < count($a); ++$i)        
		{
			$result[$i -2]['Url'] = $a[0];
			$result[$i -2]['Name'] = $a[$i-1];
			for ($j = 1; $j < $i; ++$j)
			$result[$i -2]['Url'] .= '/' . $a[$j];
			
			$result[$i -2]['Url'] .= '/';
		}
		return $result;
	}
	
	var $Cookies;
	public function setcookie($name, $value, $expire=0, $path='', $domain='',  $secure=false, $httponly=false){
		if (headers_sent($filename, $linenum)){
			$this->Cookies[$name] = $value;
		}else{
			if(!setcookie($name, $value, $expire, $path, $domain,  $secure, $httponly))
			$this->Cookies[$name] = $value;
		}
	}
	public function sys_getloadavg(){
		if (function_exists('sys_getloadavg'))
		return sys_getloadavg();
		if (@file_exists('/proc/loadavg') && is_readable('/proc/loadavg'))
		{
			$fh = @fopen('/proc/loadavg', 'r');
			$load_averages = @fread($fh, 64);
			@fclose($fh);

			$load_averages = @explode(' ', $load_averages);
			return isset($load_averages[2]) ? $load_averages[0].' '.$load_averages[1].' '.$load_averages[2] : 'Not available';
		}
		else if (!in_array(PHP_OS, array('WINNT', 'WIN32')) && preg_match('/averages?: ([0-9\.]+),[\s]+([0-9\.]+),[\s]+([0-9\.]+)/i', @exec('uptime'), $load_averages))
		return $load_averages[1].' '.$load_averages[2].' '.$load_averages[3];
		else
		return array(0,0,0);
	}
	public function EvalHTML($Source){
		ob_start();
		eval("?>" . $Source );
		$Result = ob_get_contents();
		ob_end_clean();
		return $Result;
	}
	public function partition( $list, $p =2 ) {
		$listlen = count( $list );
		$partlen = floor( $listlen / $p );
		$partrem = $listlen % $p;
		$partition = array();
		$mark = 0;
		for ($px = 0; $px < $p; $px++) {
			$incr = ($px < $partrem) ? $partlen + 1 : $partlen;
			$partition[$px] = array_slice( $list, $mark, $incr );
			$mark += $incr;
		}
		return $partition;
	}

	public function sort_divisions($Divisions){
		$DivisionsReturn = "";
		$DivisionsReturn = "<div id='divisions'>";
		$Char = "";
		$Start = null;
		$SortedBy = array();

		foreach ($Divisions as $value) {
			$FirstChar = strtoupper($value['Topic'][0]);
			if(!ctype_alnum($FirstChar))
			$FirstChar = "...";
			$SortedBy[$FirstChar][] = $value;
		}
		return $SortedBy;
	}

	public function stritr($string, $one = NULL, $two = NULL){
		if(  is_string( $one )  ){
			$two = strval( $two );
			$one = substr(  $one, 0, min( strlen($one), strlen($two) )  );
			$two = substr(  $two, 0, min( strlen($one), strlen($two) )  );
			$product = strtr(  $string, ( strtoupper($one) . strtolower($one) ), ( $two . $two )  );
			return $product;
		}
		else if(  is_array( $one )  ){
			$pos1 = 0;
			$product = $string;
			while(  count( $one ) > 0  ){
				$positions = array();
				foreach(  $one as $from => $to  ){
					if(   (  $pos2 = stripos( $product, $from, $pos1 )  ) === FALSE   ){
						unset(  $one[ $from ]  );
					}
					else{
						$positions[ $from ] = $pos2;
					}
				}
				if(  count( $one ) <= 0  )break;
				$winner = min( $positions );
				$key = array_search(  $winner, $positions  );
				$product = (   substr(  $product, 0, $winner  ) . $one[$key] . substr(  $product, ( $winner + strlen($key) )  )   );
				$pos1 = (  $winner + strlen( $one[$key] )  );
			}
			return $product;
		}
		else{
			return $string;
		}
	}/* endfunction stritr */
	
	
	public function genMenu(){
		if($this->Cache->exist("menu","menu"))
			return  $this->Cache->get();
		$MenuResult = array();
		foreach($this->Config('menu')->find("menu > *") as $item){
			$MenuName = $item->tagName;
			foreach(pq($item)->find("submenu") as $SubMenu){
			$SubMenuPQ = pq($SubMenu);
				$SubMenuID = sizeof($MenuResult[$MenuName]);
				$SubContinue = false;
				switch($SubMenu){
				case $SubMenuPQ->attr("loged") == "true" && !$this->Session->Session("Logged_Logged"):
					break;
				case $SubMenuPQ->attr("rank") && !$this->permissions($SubMenuPQ->attr("rank")) :
					break;
				case $SubMenuPQ->attr("link") != "":
					$MenuResult[$MenuName][$SubMenuID]['url'] = $this->Data['URLS']['Script'].$this->URLRepair($SubMenuPQ->attr("link"));
				default:
					$SubContinue = true;
					break;
				}
				if($SubContinue){
					$MenuResult[$MenuName][$SubMenuID]['title'] = $SubMenuPQ->attr("title");
					
					foreach($SubMenuPQ->find("url") as $UrlLink){
					$UrlLinkPQ = pq($UrlLink);
						$LinkID = sizeof($MenuResult[$MenuName][$SubMenuID]['links']);
						switch($UrlLink){
							case $UrlLinkPQ->attr("loged") == "true" && !$this->Session->Session("Logged_Logged"):
								break;
							case $UrlLinkPQ->attr("rank") && !$this->permissions($UrlLinkPQ->attr("rank")):
								break;
							case $UrlLinkPQ->attr("link") !="":
								$MenuResult[$MenuName][$SubMenuID]['links'][$LinkID]['url'] = $this->Data['URLS']['Script'].$this->URLRepair($UrlLinkPQ->attr("link"));	
							default:
								$URLContinue = true;
								break;
						}
						if($URLContinue){
							$MenuResult[$MenuName][$SubMenuID]['links'][$LinkID]['title'] = $UrlLinkPQ->text();
						}
						
					}
				}
				
			}
		}
		return $this->Cache->put("menu", "menu", $MenuResult);
		
	}

	public function array_merge_recursive_distinct () {
		$arrays = func_get_args();
		$base = array_shift($arrays);
		if(!is_array($base)) $base = empty($base) ? array() : array($base);
		foreach($arrays as $append) {
			if(!is_array($append)) $append = array($append);
			foreach($append as $key => $value) {
				if(!array_key_exists($key, $base) and !is_numeric($key)) {
					$base[$key] = $append[$key];
					continue;
				}
				if(is_array($value) or is_array($base[$key])) {
					$base[$key] = $this->array_merge_recursive_distinct($base[$key], $append[$key]);
				} else if(is_numeric($key)) {
					if(!in_array($value, $base)) $base[] = $value;
				} else {
					$base[$key] = $value;
				}
			}
		}
		return $base;
	}


	function fixFilesArray(&$files)
	{
		$names = array( 'name' => 1, 'type' => 1, 'tmp_name' => 1, 'error' => 1, 'size' => 1);

		foreach ($files as $key => $part) {
			// only deal with valid keys and multiple files
			$key = (string) $key;
			if (isset($names[$key]) && is_array($part)) {
				foreach ($part as $position => $value) {
					$files[$position][$key] = $value;
				}
				// remove old key reference
				unset($files[$key]);
			}
		}
	}


}


class cache_config extends  xv_config {
	public function init_fields(){
		return array(
			"expires" => array(),
			"default_time" => 600
		);
	}
}

class xv_cache {
	var $Data;
	public function __construct(&$Xvweb) {
		$this->Data['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
		
		$this->Data['Times'] = array();
		$cache_expires  = new cache_config();
		$this->Data['Times'] = $cache_expires->expires;
		$this->Data['DefaultTime'] = $cache_expires->default_time;
		
		
	}
	function exist($Category, $Handle, $CacheTime = null) {
		if(ifsetor($this->Data['Disable'], false)==true)
		return false;
		$Handle = strtolower($Handle).".tmp";
		$Category = strtolower($Category);
		$md5_handle = md5(MD5Key.$Handle).".tmp";
		$md5_category = md5(MD5Key.$Category);
		if(is_null($CacheTime)){
			//$ConfigInfo = $this->Data['XVweb']->Config("config")->find(' config cachelimit '.($Category));
			$CacheTime = (int) ( isset($this->Data['Times'][$Category]) ? $this->Data['Times'][$Category] : $this->Data['DefaultTime']);
		}
		if($CacheTime == 0){
			$GLOBALS['Debug']['Cache']['NoCached'][] = array($Category, $Handle, $CacheTime); //!Debug
			return false;
		}
		if (file_exists(Cache_dir.$md5_category.DIRECTORY_SEPARATOR.$md5_handle)) {
			if((date("Ymdgis") - date("Ymdgis", filemtime(Cache_dir.$md5_category.DIRECTORY_SEPARATOR.$md5_handle))) > $CacheTime){
				@unlink(Cache_dir.$md5_category.DIRECTORY_SEPARATOR.$md5_handle);
				return false;
			}
			$this->Data['Result'] = unserialize(file_get_contents(Cache_dir.$md5_category.DIRECTORY_SEPARATOR.$md5_handle));
			$GLOBALS['Debug']['Cache']['Cached'][] = array($Category, $Handle, $CacheTime);//!Debug
			return true;
		}else{
			$GLOBALS['Debug']['Cache']['NoCached'][] = array($Category, $Handle, $CacheTime); //!Debug
			return false;
		}
	}
	public function get(){
		return $this->Data['Result'];
	}
	
	function &put($Category, $Handle, $Variable=null, $CacheTime = null) {
		if(ifsetor($this->Data['Disable'], false) == true)
		return $Variable;
		$Handle = strtolower($Handle).".tmp";
		$Category = strtolower($Category);
		$md5_handle = md5(MD5Key.$Handle).".tmp";
		$md5_category = md5(MD5Key.$Category);
		if(is_null($CacheTime)){
			$CacheTime = (int) ( isset($this->Data['Times'][$Category]) ? $this->Data['Times'][$Category] : $this->Data['DefaultTime']);
		}
		if($CacheTime == 0)
		return $Variable;
		if(!is_dir(Cache_dir.$md5_category)){
			mkdir(Cache_dir.$md5_category, 0700);
		}
		file_put_contents(Cache_dir.$md5_category.DIRECTORY_SEPARATOR.$md5_handle, serialize($Variable));
		$GLOBALS['Debug']['Cache']['Put'][] = array($Category, $Handle, $CacheTime); //!Debug
		return $Variable;
	}
	public function clear($category=null,$Handle=null) {
		if(is_null($Handle)){
			if(is_null($category)){
				$this->Data['XVweb']->delete_dir(Cache_dir,false);
				return true;
			}
			$category = strtolower($category);
			$this->Data['XVweb']->delete_dir(Cache_dir.md5(MD5Key.$category),false);
			return true;
		}
		$category = strtolower($category);
		$Handle = strtolower($Handle).".tmp";
		$md5_handle = md5(MD5Key.$Handle).".tmp";
		@unlink(Cache_dir.md5(MD5Key.$category).DIRECTORY_SEPARATOR.$md5_handle);
		return true;
	}
	public function disable(){
		$this->Data['Disable'] = true;
	}
	public function enable(){
		$this->Data['Disable'] = false;
	}
}

?>