<?php
function ifsetor(&$val, $default = null)
{
	return isset($val) ? $val : $default;
}
function LogMode($name){
	$LogFile = 'E:\wamp\www\Xvweb\log.txt';
	file_put_contents($LogFile, file_get_contents($LogFile).$name.chr(13));
}

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


	public function CryptPassword( $str ) {
		return md5(MD5Key.$str);
		$temp = '';
		$result = null;
		for ( $i = 0; $i < strlen( $str ); ++$i) {
			$temp = ord( $str[$i] );
			$temp = dechex( $temp );
			$temp = str_pad( $temp, 2, '0', STR_PAD_LEFT );
			$result .= $temp;
		}
		return $result;
	}
	public function DecryptPassword( $str ) {
		$temp = '';
		$result = null;
		for ( $i = 0; $i < strlen( $str ); $i = $i + 2 ) {
			$temp = $str[$i] . $str[$i+1];
			$temp = hexdec( $temp );
			$temp = chr( $temp );
			$result .= $temp;
		}
		return $result;
	}
	public function checkValidIp($cidr) {
		if(!eregi("EXPR", $cidr)) {
			$return = FALSE;
		} else {
			$return = TRUE;
		}
		if ( $return == TRUE ) {
			$parts = explode("/", $cidr);
			$ip = $parts[0];
			$netmask = $parts[1];
			$octets = explode(".", $ip);
			foreach ( $octets AS $octet ) {
				if ( $octet > 255 ) {
					$return = FALSE;
				}
			}
			if ( ( $netmask != "" ) && ( $netmask > 32 ) ) {
				$return = FALSE;
			}
		}
		return $return;
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


	public function GeneratePassword($LengthPassword = 5)
	{
		$CharPack = "abcdefghijklmnpqrstuvwxyz123456789";
		srand((double)microtime() * 1000000);

		while(strlen($haslo) < $LengthPassword)
		{
			$znak = $CharPack[rand(0, strlen($CharPack) - 1)];
			if(!is_integer(strpos($haslo, $znak))) $haslo .= $znak;
		}
		return $haslo;
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

	public function AddSlashesStartAndEnd($string){
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
		$str = $this->AddSlashesStartAndEnd($str);
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


	public function ReadPrefix($str, $index=1){
		$str = $this->AddSlashesStartAndEnd($str);
		$str = explode("/", $str);
		return $str[$index];
	}


	public function ReadTopicArticleFromUrl($str){
		$str = $this->AddSlashesStartAndEnd($str);
		$str = explode("/", $str);
		return $str[count($str)-2];
	}

	public function LightText($text){
		$text = str_replace(chr(13), "", $text);
		$text = str_replace('"', "", $text);
		$text = str_replace("'", "", $text);
		$text = str_replace("/", "", $text);
		$text = str_replace("\\", "", $text);
		return $text;
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
	public function AddGet($ArrayOrString, $XHTML=false){
		if(is_array($ArrayOrString))
		return ($XHTML ? str_replace("&", "&amp;",http_build_query(array_merge($GLOBALS['_GET'], $ArrayOrString))) : http_build_query(array_merge($GLOBALS['_GET'], $ArrayOrString)));
		parse_str($ArrayOrString, $output);
		return ($XHTML ? str_replace("&", "&amp;",http_build_query(array_merge($GLOBALS['_GET'], $output))) : http_build_query(array_merge($GLOBALS['_GET'], $output)));
	}
	public function GetFromURL($url, $int =1, $Char = "/"){
		$url = $this->AddSlashesStartAndEnd($url);
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
	public function SortArrayByOrder($array, $Order){
		$NewArray = array();
		foreach ($Order as $valueOrder) {
			if(isset($array[$valueOrder])){
				$NewArray[] = array($valueOrder => $array[$valueOrder]);
				unset($array[$valueOrder]);
			}
		}
		foreach ($array as $key=> $valueOrder) {
			$NewArray[] = array($key => $valueOrder);
		}
		unset($array);
		return $NewArray;
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
	function SelectImplode($array, $prefix=""){
		$Return = array();
		foreach($array as $key=>$val)
		$Return[] = $prefix."`".$val."` AS `".$key."`";
		return implode(" ,", $Return);
	}
	public function SortDivisions($Divisions){
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
					$MenuResult[$MenuName][$SubMenuID]['url'] = $this->Date['URLS']['Script'].$this->URLRepair($SubMenuPQ->attr("link"));
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
								$MenuResult[$MenuName][$SubMenuID]['links'][$LinkID]['url'] = $this->Date['URLS']['Script'].$this->URLRepair($UrlLinkPQ->attr("link"));	
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
		return $MenuResult;
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



class Cache
{
	var $Date;
	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$this->Date['DefaultTime'] = 600;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
		
		$this->Date['Times'] = array();
		foreach($this->Date['XVweb']->Config("config")->find('config cachelimit') as $time)
			$this->Date['Times'][strtolower($time->tagName)] = $time->nodeValue;
		
	}
	function exist($Category, $Handle, $CacheTime = null) {
		if(ifsetor($this->Date['Disable'], false)==true)
		return false;
		$Handle = strtolower($Handle).".tmp";
		$Category = strtolower($Category);
		$HandleMD5 = md5(MD5Key.$Handle).".tmp";
		$CategoryMD5 = md5(MD5Key.$Category);
		if(is_null($CacheTime)){
			//$ConfigInfo = $this->Date['XVweb']->Config("config")->find(' config cachelimit '.($Category));
			$CacheTime = (int) ( isset($this->Date['Times'][$Category]) ? $this->Date['Times'][$Category] : $this->Date['DefaultTime']);
		}
		if($CacheTime == 0){
			$GLOBALS['Debug']['Cache']['NoCached'][] = array($Category, $Handle, $CacheTime); //!Debug
			return false;
		}
		if (file_exists(Cache_dir.$CategoryMD5.DIRECTORY_SEPARATOR.$HandleMD5)) {
			if((date("Ymdgis") - date("Ymdgis", filemtime(Cache_dir.$CategoryMD5.DIRECTORY_SEPARATOR.$HandleMD5))) > $CacheTime){
				@unlink(Cache_dir.$CategoryMD5.DIRECTORY_SEPARATOR.$HandleMD5);
				return false;
			}
			$this->Date['Result'] = unserialize(file_get_contents(Cache_dir.$CategoryMD5.DIRECTORY_SEPARATOR.$HandleMD5));
			$GLOBALS['Debug']['Cache']['Cached'][] = array($Category, $Handle, $CacheTime);//!Debug
			return true;
		}else{
			$GLOBALS['Debug']['Cache']['NoCached'][] = array($Category, $Handle, $CacheTime); //!Debug
			return false;
		}
	}
	public function get(){
		return $this->Date['Result'];
	}
	
	function &put($Category, $Handle, $Variable=null, $CacheTime = null) {
		//LogMode($Category." = ".$Handle);
		if(ifsetor($this->Date['Disable'], false) == true)
		return $Variable;
		$Handle = strtolower($Handle).".tmp";
		$Category = strtolower($Category);
		$HandleMD5 = md5(MD5Key.$Handle).".tmp";
		$CategoryMD5 = md5(MD5Key.$Category);
		if(is_null($CacheTime)){
			$ConfigInfo = $this->Date['XVweb']->Config("config")->find('config cachelimit '.($Category));
			$CacheTime = (int) ( $ConfigInfo->length ? $ConfigInfo->text() : $this->Date['DefaultTime']);
		}
		if($CacheTime == 0)
		return $Variable;
		if(!is_dir(Cache_dir.$CategoryMD5)){
			mkdir(Cache_dir.$CategoryMD5, 0700);
		}
		file_put_contents(Cache_dir.$CategoryMD5.DIRECTORY_SEPARATOR.$HandleMD5, serialize($Variable));
		$GLOBALS['Debug']['Cache']['Put'][] = array($Category, $Handle, $CacheTime); //!Debug
		return $Variable;
	}
	public function clear($category=null,$Handle=null) {
		if(is_null($Handle)){
			if(is_null($category)){
				$this->Date['XVweb']->delete_dir(Cache_dir,false);
				return true;
			}
			$category = strtolower($category);
			$this->Date['XVweb']->delete_dir(Cache_dir.md5(MD5Key.$category),false);
			return true;
		}
		$category = strtolower($category);
		$Handle = strtolower($Handle).".tmp";
		$HandleMD5 = md5(MD5Key.$Handle).".tmp";
		@unlink(Cache_dir.md5(MD5Key.$category).DIRECTORY_SEPARATOR.$HandleMD5);
		return true;
	}
	public function disable(){
		$this->Date['Disable'] = true;
	}
	public function enable(){
		$this->Date['Disable'] = false;
	}
}
class BanClass
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = &$Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	public function CheckBanned($email=null, $ip=null){
		$SQLDate[':IPExecute'] = is_null($ip) ?  $_SERVER['REMOTE_ADDR'] : $ip;
		if(!is_null($email))
		$SQLDate[':EmailExecute'] = $email;
		$CheckBan = $this->Date['XVweb']->DataBase->prepare('SELECT {Bans:*} FROM {Bans} WHERE  '.(is_null($email) ? "" : '{Bans:Mail} = :EmailExecute OR ').' {Bans:IP} = :IPExecute  AND {Bans:TimeOut} > NOW() LIMIT 1');
		$CheckBan->execute($SQLDate);
		return $CheckBan->fetch(PDO::FETCH_ASSOC);
	}
}


?>