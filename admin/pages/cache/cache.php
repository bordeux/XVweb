<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   default.php       *************************
****************   Start     :   22.05.2007 r.     *************************
****************   License   :   LGPL              *************************
****************   Version   :   1.0               *************************
****************   Authors   :   XVweb team        *************************
*************************XVweb Team*****************************************
				Krzyszof Bednarczyk, meybe you
/////////////////////////////////////////////////////////////////////////////
 Klasa XVweb jest na licencji LGPL v3.0 ( GNU LESSER GENERAL PUBLIC LICENSE)
****************http://www.gnu.org/licenses/lgpl-3.0.txt********************
		Pełna dokumentacja znajduje się na stronie domowej projektu: 
*********************http://www.bordeux.NET/Xvweb***************************
***************************************************************************/
if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}

	class XV_Admin_cache{
		var $style = "width: 200px;  left: 40%; top: 100px;";
		var $contentStyle = "";
		var $URL = "Cache/";
		var $content = "";
		var $id = "cache-window";
		var $Date;
		//var $contentAddClass = " xv-terminal";
		public function __construct(&$XVweb){
		
		
		$CacheInfo = $this->dirSize(Cache_dir);
		$this->content = '
		<div class="xv-cache-result"></div>
		<div style="text-align:center;">
			<a href="'.$GLOBALS['URLS']['Script'].'Administration/Get/Cache/Clear/" class="xv-button-ui xv-bt-green xv-clear-cache" style="width: 112px; text-align: center;">
				<span>Clear cache</span>
			</a>
		</div>
		<div style="margin-top:5px; text-align:center;">
			Cache: <span class="xv-cache-size">'.$this->format_bytes($CacheInfo[0]).'</span>/<span class="xv-cache-cached">'.$CacheInfo[1].'</span> cached</div>
		</div>
		<script type="text/javascript">
			$(".xv-clear-cache").unbind().click(function(){
			 var thandle = this;
				$(thandle).find("span").html("<img src=\'"+URLS.Theme+"img/wait.gif\' alt=\'wait...\' />");
				$.getJSON($(thandle).attr("href"), function(data) {
					$(thandle).find("span").html("Clear cache");
					$(".xv-cache-size").text(data.Size);
					$(".xv-cache-cached").text(data.Cached);
				});
				return false;
			});
		
		</script>
		';
			$this->title = ifsetor($GLOBALS['Language']['Cache'], 'Cache');
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/cache.png';
			
		}

		public function format_bytes($size) {
			$units = array(' B', ' KB', ' MB', ' GB', ' TB');
			for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
			return round($size, 2).$units[$i];
		}
		function dirSize($directory) { 
			$size = 0; 
			$files = 0;
			foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){ 
				$size+=$file->getSize(); 
				$files++;
			} 
			return array($size, $files); 
		} 


	}
	
		class XV_Admin_cache_clear{
			public function __construct(&$XVweb){
			
			
				$Result['Started'] = true;
				$Result['Smarty'] = (bool) !$GLOBALS['Smarty']->clearAllCache();
				$Result['XVweb'] = $XVweb->Cache->clear();
				$Result['Plugins'] = @unlink(ROOT_DIR."config/pluginscompiled.xml");;
				$CacheInfo = XV_Admin_cache::dirSize(Cache_dir);
				$Result['Size'] = XV_Admin_cache::format_bytes($CacheInfo[0]);
				$Result['Cached'] = $CacheInfo[1];
			exit(json_encode($Result));
			}
		}
$CommandSecond = strtolower($XVwebEngine->GetFromURL($PathInfo, 4));
	if (class_exists('XV_Admin_cache_'.$CommandSecond)) {
		$XVClassName = 'XV_Admin_cache_'.$CommandSecond;
	}else
		$XVClassName = "XV_Admin_cache";
?>