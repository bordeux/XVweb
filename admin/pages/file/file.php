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
include_once(ROOT_DIR.'config'.DIRECTORY_SEPARATOR.'files.config.php');

	class XV_Admin_file{
		var $style = "height: 500px; width: 90%;";
		var $contentStyle = "overflow-y:scroll; padding-bottom:10px;";
		var $URL = "File/";
		var $content = "test";
		var $id = "file-window";
		var $Date;
		//var $contentAddClass = " xv-terminal";
		public function __construct(&$XVweb){
		
			if(isset($_GET['Sort']) && $_GET['Sort'] == "desc")
				$SortByP = 'asc'; else
				$SortByP = 'desc';
				
				
			$RecordsLimit=ifsetor($_GET['xv-limit'], 30);
			$ActualPage = (int) ifsetor($_GET['Page'], 0);
			$FilesList =	$this->GetFiles($XVweb, $ActualPage,$RecordsLimit, $_GET['SortBy'], $SortByP );
			include_once($GLOBALS['LocationXVWeb'].DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
			$pager = pager($RecordsLimit, (int) $FilesList->Count,  "?".$XVweb->AddGet(array("Page"=>"-npage-id-"), true), $ActualPage);
			

 
		$this->content = '	<div class="xv-table">
			<table style="width : 100%; text-align: center;">
				<caption>'.$pager[0].'</caption>
				<thead> 
					<tr class="xv-pager">
						<th><a href="?'.$XVweb->AddGet('SortBy=ID&Sort='.$SortByP, true).'">'.xvLang('ID').'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=Date&Sort='.$SortByP, true).'">'.xvLang('Date').'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=UserFile&Sort='.$SortByP, true).'">'.xvLang('User').'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=FileName&Sort='.$SortByP, true).'">'.xvLang("FileName").'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=Extension&Sort='.$SortByP, true).'">'.xvLang("Extension").'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=LastDownload&Sort='.$SortByP, true).'">'.xvLang("LastDownload").'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=IP&Sort='.$SortByP, true).'">'.xvLang("IP").'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=FileSize&Sort='.$SortByP, true).'">'.xvLang("FileSize").'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=Downloads&Sort='.$SortByP, true).'">'.xvLang("Downloads").'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=Bandwidth&Sort='.$SortByP, true).'">'.xvLang("Bandwidth").'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=Score&Sort='.$SortByP, true).'">'.xvLang("Score").'</a></th>
						<th><a href="?'.$XVweb->AddGet('SortBy=Server&Sort='.$SortByP, true).'">'.xvLang("Server").'</a></th>
						<th></th>
					</tr>
				</thead> 
				<tbody>';
				
			
		$ServersSelect = '';
		
				foreach($this->get_declared_classes_by_prefix("XV_Files_") as $val)
					$ServersSelect .= '<option value="'.substr($val, 9).'">'.substr($val, 9).'</option>'.chr(13);
					
		foreach($FilesList->List as $FileInfo){
				$this->content .= '
				<tr class="xv-file-row xv-file-'.$FileInfo['ID'].'">
						<td>'.$FileInfo['ID'].' <a href="'.$GLOBALS['URLS']['Script'].'File/'.($FileInfo['ID']).'/" target="_blank">[link]</a></td>
						<td>'.$FileInfo['Date'].'</td>
						<td>'.$FileInfo['UserFile'].' <a href="'.$GLOBALS['URLS']['Script'].'Users/'.rawurlencode($FileInfo['UserFile']).'/" target="_blank">[link]</a></td>
						<td>'.$FileInfo['FileName'].' <a href="'.$GLOBALS['URLS']['Script'].'File/'.($FileInfo['ID']).'/'.rawurlencode($FileInfo['FileName'].'.'.$FileInfo['Extension']).'/" target="_blank">[link]</a></td>
						<td>'.$FileInfo['Extension'].'</td>
						<td>'.$FileInfo['LastDownload'].'</td>
						<td>'.$FileInfo['IP'].'</td>
						<td>'.$this->size_comp($FileInfo['FileSize']).'</td>
						<td>'.$FileInfo['Downloads'].'</td>
						<td>'.$this->size_comp($FileInfo['Bandwidth']).'</td>
						<td>'.$FileInfo['Score'].'</td>
						<td id="file-'.$FileInfo['ID'].'">
							<form action="'.$GLOBALS['URLS']['Script'].'Administration/get/File/ChangeServer/" method="post" class="xv-form xv-change-server-form" data-xv-result="#file-'.$FileInfo['ID'].'">
								<select name="xv-file-server['.$FileInfo['ID'].']" class="xv-file-server-select">
									<option value="'.$FileInfo['Server'].'">'.$FileInfo['Server'].'</option>
									<option>----------</option>
									'.$ServersSelect.'
								</select>
							</form>
						</td>
						<td> <a href="'.$GLOBALS['URLS']['Script'].'Administration/File/Delete/?file='.$FileInfo['ID'].'&name='.urlencode($FileInfo['FileName']).urlencode(".".$FileInfo['Extension']).'" date-file-id="'.$FileInfo['ID'].'" class="xv-get-window xv-bt-delete"></a> </td>
				</tr>';
			}
			
				$this->content .= '</tbody> 
				</table>
				<div style="float:left;"><a href="#All" class="xv-file-select-button">All/None</a></div>
				<div class="xv-table-pager">
				'.$pager[1].'
				</div>
				
				<fieldset style="margin-bottom: 30px;">
					<legend>Zaznaczone</legend>
						<form action="?" method="post" class="xv-server-all">
							<label for="xv-change-all-server-name">Zmień server : </label>	<select name="xv-change-all-server-name" class="xv-change-all-server">
									<option>----------</option>
									'.$ServersSelect.'
								</select>
								<input type="submit" value="Zmień" />
							</form>
				</fieldset>
			</div>
			<script type="text/javascript">
			if(typeof fileLoaded == "undefined"){
				var fileLoaded =  true;
				$(function(){
					$(".xv-file-server-select").live("change", function(){
						$(this).parents("form").submit();
					});
					$(".xv-file-select-button").live("click", function(){
							$(".xv-file-row").toggleClass("xv-table-select");
						return false;
					})
					$(".xv-file-row").live("click", function(event){
					if($(event.target).is("tr, td"))
							$(this).toggleClass("xv-table-select");
						return true;
					});
					$(".xv-server-status-show").live("click", function(){
						$(this).parent().find(".xv-server-status").show("slow");
						return false;
					});
					$(".xv-server-all").live("submit", function(){
							$(".xv-table-select .xv-file-server-select option:selected").removeAttr("selected");
							$(".xv-table-select .xv-file-server-select option[value=\'"+$(".xv-change-all-server").val()+"\']").attr("selected", "selected");
							$(".xv-table-select .xv-change-server-form").submit();
						return false;
					});
				});
			}
			</script>';
			
			$this->title = $GLOBALS['Language']['Files'];
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/files.png';
			
		}
		public function get_declared_classes_by_prefix($prefix = ""){
			$result = array();
			foreach(get_declared_classes() as $class)
				if($prefix == substr($class, 0, strlen($prefix)))
					$result[] = $class;		
			return $result;
		}
		public function GetFiles(&$XVweb, $ActualPage = 0, $EveryPage =30, $SortBy = "ID", $Desc = "desc"){
				$LLimit = ($ActualPage*$EveryPage);
				$RLimit = $EveryPage;
			
				$FilesSQL = $XVweb->DataBase->prepare('SELECT SQL_CALC_FOUND_ROWS
				{Files:*},
				({Files:Downloads}/DATEDIFF(NOW(),{Files:Date})) AS `Score`,
				({Files:Downloads} * {Files:FileSize}) AS `Bandwidth`
		FROM {Files} ORDER BY '.($XVweb->DataBase->isset_field("Files", $SortBy) ? "{Files:".$SortBy."}" : (empty($SortBy) ? "{Files:ID}" : "`".$SortBy."`")).' '.($Desc == "asc" ? "ASC" : "DESC") .' LIMIT '.$LLimit.', '.$RLimit.';
		');
		
				$FilesSQL->execute();
				$ArrayArticle = $FilesSQL->fetchAll();
				
				return (object) array("List"=>$ArrayArticle , "Count"=>$XVweb->DataBase->pquery('SELECT FOUND_ROWS() AS `FilesCount`;')->fetch(PDO::FETCH_OBJ)->FilesCount);
		}
		public function size_comp($size, $retstring = null) {
			$sizes = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
			if ($retstring === null) { $retstring = '%01.2f %s'; }
			$lastsizestring = end($sizes);
			foreach ($sizes as $sizestring) {
				if ($size < 1024) { break; }
				if ($sizestring != $lastsizestring) { $size /= 1024; }
			}
			if ($sizestring == $sizes[0]) { $retstring = '%01d %s'; }
			return sprintf($retstring, $size, $sizestring);
		}
	}
		class XV_Admin_file_changeserver{
			public function __construct(&$XVweb){
			$Result = array();
			if(!is_array($_POST['xv-file-server']))
				exit("Invalid input data! - must be array like xv-file-server[FileID] = 'Server' ");
				
			foreach($_POST['xv-file-server'] as $key=>$server){
			$NameClassFile = 'XV_Files_'.$server;
			
					if(!class_exists($NameClassFile)){
						$Result[$key][] = ("Server not found: ".$server. ' . Please add in config.php '.$NameClassFile.' class');
					}else{
						$FileSQL = $XVweb->DataBase->prepare('SELECT SQL_CALC_FOUND_ROWS
						{Files:*}
							FROM {Files} WHERE {Files:ID} = :FileID ;   ');
						$FileSQL->execute(array(
							":FileID" => $key,
						));
						$FileInfo = $FileSQL->fetchObject();
						
						if(!$FileInfo){
							$Result[$key][] = ("File not found in database");
						}else{
						
							if($FileInfo->Server == $server){
								$Result[$key][] = ("Server no changed");
							}else{
							$FileNameTMP = $FileInfo->MD5File.$FileInfo->SHA1File;
								$FileSQL = $XVweb->DataBase->prepare('UPDATE {Files} SET {Files:Server} = :SeverExec WHERE {Files:MD5File} = :MD5File AND {Files:SHA1File} = :SHA1File ;   ');
								$ClassFile = new $NameClassFile;
								$NameClassFile2 = 'XV_Files_'.$FileInfo->Server;
								$ClassFile2 = new $NameClassFile2;
								
								if($ClassFile->upload($ClassFile2->download($FileNameTMP),$FileNameTMP)){
									$FileSQL->execute(array(
										":SeverExec" => $server,
										":MD5File" => $FileInfo->MD5File,
										":SHA1File" => $FileInfo->SHA1File,
									));
									$XVweb->Cache->clear("File",  $FileInfo->ID);
									$ClassFile2->delete($FileNameTMP);
									
									$Result[$key][] = ("Changed server with ".$FileInfo->Server." to ".$server);
								}else{
									$Result[$key][] = ("Problem to change server with ".$FileInfo->Server." to ".$server);
								}
							}
						
						
						}
					
					}
					
					$Result[$key][] = ("-----------");
				}
				echo "<a href='#' class='xv-server-status-show'>Done</a> <pre class='xv-server-status' style='display:none'>";
				print_r($Result);
				echo "</pre>";
				exit;
			}
		}
	// Delete Files //
	class XV_Admin_file_delete{
		var $style = "max-height: 200px; width: 250px; left: 40%; top: 100px;";
		public function __construct(&$XVweb){
			$this->URL = "File/Delete/?file=".urlencode($_GET['file']).'&name='.urlencode($_GET['name']);
			$this->id = "xv-file-d-".substr(md5($_GET['file']), 28);
			$this->title = "Delete ".basename($_GET['name']);
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/trash.png';
	
			$this->content = '
				<form action="'.$GLOBALS['URLS']['Script'].'Administration/Get/File/ConfirmDelete/" method="post" class="xv-form" data-xv-result=".content">
						<input type="hidden" value="'.htmlspecialchars($_GET['file']).'" name="xv-file" />
						<input type="hidden" value="'.htmlspecialchars($XVweb->Session->GetSID()).'" name="xv-sid" />
					<div style="text-align:center;">Do you want delete <span style="color: #BA0000;">'.basename($_GET['name']).'</span> ?</div>
					<table style="border:none; width:200px; margin:auto;">
						<tr>
							<td><input type="submit" value="Tak" /></td>
							<td><input type="button" value="Nie" class="xv-window-close" /></td>
						</tr>
					</table>
				</form>
			';
		}
	}	
	
	// Delete Files //
	class XV_Admin_file_confirmdelete{
		public function __construct(&$XVweb){

			if($XVweb->Session->GetSID() == $_POST['xv-sid']){
				$XVweb->FilesClass()->DeleteFile($_POST['xv-file']);
				echo "<div class='success'>Plik/Folder usunięto</div>
					<script type='text/javascript'>
						$('.xv-file-{$_POST['xv-file']}').hide('slow', function(){
							$(this).remove();
						});
					</script>
					";
			}else{
				echo "<div class='failed'>Błąd : Zły SID</div>";
			}
			exit;
		}
	}
	

	$CommandSecond = strtolower($XVwebEngine->GetFromURL($PathInfo, 4));
	if (class_exists('XV_Admin_file_'.$CommandSecond)) {
		$XVClassName = 'XV_Admin_file_'.$CommandSecond;
	}else
		$XVClassName = "XV_Admin_file";
		

?>