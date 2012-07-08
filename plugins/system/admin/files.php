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

//TODO ?dir=../ problem

if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}

if(!xv_perm("xv_ftp_online")){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}

	class xv_admin_files{
		var $style = "height: 400px; width: 100%;";
		var $title = "Files Menager";
		var $URL = "Files/";
		var $content = "";
		var $id = "xv-file-menager";
		var $contentAddClass = " xv-files";
		public function __construct(&$XVweb){
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/files.png';
			$this->content = get_include_contents(dirname(__FILE__).'/includes/load_module.php');
		}
	}
	class xv_admin_files_dir{
		public function __construct(&$XVweb){
			include(dirname(__FILE__).'/includes/dir.php');
	}
	}
		class xv_admin_files_upload{
			function fixFilesArray(&$files){
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

			public function __construct(&$XVweb){

			$this->fixFilesArray($_FILES['filemenager']);
					 $root = ROOT_DIR;
					 $_GET['dir'] = preg_replace('/\w+\/\.\.\//', '', $_GET['dir']);
					$_GET['dir'] = urldecode($_GET['dir']);
					$RealPath = realpath($root . $_GET['dir']);
					
					if( file_exists($RealPath) ) {
					$FilesArray = array();
					foreach($_FILES['filemenager'] as $FileSave){
						$FilesArray[basename($FileSave['name'])] = false;
							if(move_uploaded_file($FileSave['tmp_name'], $RealPath.DIRECTORY_SEPARATOR.basename($FileSave['name']))){
								$FilesArray[basename($FileSave['name'])] = true;
							}
						}	
					}
					
			exit(json_encode($FilesArray));
			}
		
		}
	
	class xv_admin_files_rename{
		var $style = "max-height: 200px; width: 250px";
		public function __construct(&$XVweb){
			$this->URL = "Files/Rename/?file=".urlencode($_GET['file']);
			$this->id = "xv-file-r-".substr(md5($_GET['file']), 28);
			$this->title = "Rename ".basename($_GET['file']);
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/trash.png';
			$this->style = "left: 40%; top: 100px; ";
			
			if(isset( $_POST['xv-sid']) && $XVweb->Session->get_sid() == $_POST['xv-sid']){
				if(@rename ($_POST['xv-file'], $_POST['xv-new-name'])){
					echo("<div class='success'>File name changed</div>");
				}else{
					echo("<div class='failed'>Error: Wrong new file name</div>");
				}
				exit("
					<script type='text/javascript'>
						ThemeClass.LoadDir($('#xv-file-menager').data('xv-current-dir'));
					</script>");
			}
			$this->content = '
				<form action="'.$GLOBALS['URLS']['Script'].'Administration/Get/Files/Rename/" method="post" class="xv-form" data-xv-result=".content">
						<input type="hidden" value="'.htmlspecialchars($_GET['file']).'" name="xv-file" />
						<input type="hidden" value="'.htmlspecialchars($XVweb->Session->get_sid()).'" name="xv-sid" />
					<div style="text-align:center;">
					<input type="text" name="xv-new-name" value="'.htmlspecialchars(basename($_GET['file'])).'" /></div>
					<table style="border:none; width:200px; margin:auto;">
						<tr>
							<td><input type="submit" value="Zmień nazwę" /></td>
							<td><input type="button" value="Anuluj" class="xv-window-close" /></td>
						</tr>
					</table>
				</form>
			';
		}
	}
	class xv_admin_files_newdir{
		var $style = "max-height: 200px; width: 250px";
		public function __construct(&$XVweb){
			$this->URL = "Files/NewDir/?file=".urlencode($_GET['file']);
			$this->id = "xv-file-nd-".substr(md5($_GET['file']), 28);
			$this->title = "NewDir";
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/files.png';
			$this->style = "left: 40%; top: 100px; ";
			if(isset( $_POST['xv-sid']) && $XVweb->Session->get_sid() == $_POST['xv-sid']){
				if(@mkdir(dirname($_POST['xv-file']).'/'.$_POST['xv-dir-name'])){
					echo("<div class='success'>Created dir</div>");
				}else{
					echo("<div class='failed'>Error: I cant create new folder</div>");
				}
				exit("
					<script type='text/javascript'>
						ThemeClass.LoadDir($('#xv-file-menager').data('xv-current-dir'));
					</script>");
			}
			$this->content = '
				<form action="'.$GLOBALS['URLS']['Script'].'Administration/Get/Files/NewDir/" method="post" class="xv-form" data-xv-result=".content">
						<input type="hidden" value="'.htmlspecialchars($_GET['file']).'" name="xv-file" />
						<input type="hidden" value="'.htmlspecialchars($XVweb->Session->get_sid()).'" name="xv-sid" />
					<div style="text-align:center;">
					<input type="text" name="xv-dir-name" value="FolderName" /></div>
					<table style="border:none; width:200px; margin:auto;">
						<tr>
							<td><input type="submit" value="Add dir" /></td>
							<td><input type="button" value="Cancel" class="xv-window-close" /></td>
						</tr>
					</table>
				</form>
			';
		}
	}
	
	
	class xv_admin_files_chmod{
		var $style = "max-height: 200px; width: 250px";
		public function __construct(&$XVweb){
			$this->URL = "Files/Chmod/?file=".urlencode($_GET['file']);
			$this->id = "xv-file-nd-".substr(md5($_GET['file']), 28);
			$this->title = "Chmod ".basename($_GET['file']);
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/files.png';
			$this->style = "left: 40%; top: 100px; ";
			if(isset( $_POST['xv-sid']) && $XVweb->Session->get_sid() == $_POST['xv-sid']){
				if(@chmod($_POST['xv-file'], $_POST['xv-chmod'])){
					echo("<div class='success'>CHMOD changed</div>");
				}else{
					echo("<div class='failed'>Error: I cant change chmod</div>");
				}
				exit("
					<script type='text/javascript'>
						ThemeClass.LoadDir($('#xv-file-menager').data('xv-current-dir'));
					</script>");
			}
			$this->content = '
				<form action="'.$GLOBALS['URLS']['Script'].'Administration/Get/Files/Chmod/" method="post" class="xv-form" data-xv-result=".content">
						<input type="hidden" value="'.htmlspecialchars($_GET['file']).'" name="xv-file" />
						<input type="hidden" value="'.htmlspecialchars($XVweb->Session->get_sid()).'" name="xv-sid" />
					<div style="text-align:center;">
					<input type="text" name="xv-chmod" value="'.@fileperms($_GET['file']).'" /></div>
					<table style="border:none; width:200px; margin:auto;">
						<tr>
							<td><input type="submit" value="Change CHMOD" /></td>
							<td><input type="button" value="Cancel" class="xv-window-close" /></td>
						</tr>
					</table>
				</form>
			';
		}
	}
	
	
	// Delete Files //
	class xv_admin_files_delete{
		var $style = "max-height: 200px; width: 250px; left: 40%; top: 100px;";
		public function __construct(&$XVweb){
			$this->URL = "Files/Delete/?file=".urlencode($_GET['file']);
			$this->id = "xv-file-d-".substr(md5($_GET['file']), 28);
			$this->title = "Delete ".basename($_GET['file']);
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/trash.png';
	
			$this->content = '
				<form action="'.$GLOBALS['URLS']['Script'].'Administration/Get/Files/ConfirmDelete/" method="post" class="xv-form" data-xv-result=".content">
						<input type="hidden" value="'.htmlspecialchars($_GET['file']).'" name="xv-file" />
						<input type="hidden" value="'.htmlspecialchars($XVweb->Session->get_sid()).'" name="xv-sid" />
					<div style="text-align:center;">Do you want delete <span style="color: #BA0000;">'.basename($_GET['file']).'</span> ?</div>
					<table style="border:none; width:200px; margin:auto;">
						<tr>
							<td><input type="submit" value="Yes" /></td>
							<td><input type="button" value="No" class="xv-window-close" /></td>
						</tr>
					</table>
				</form>
			';
		}
	}

	class xv_admin_files_paste{
		var $style = "max-height: 200px; width: 250px; left: 40%; top: 100px;"; 
		public function __construct(&$XVweb){
			$this->URL = "Files/Paste/?file=".urlencode($_GET['file']).'&destination='.urlencode($_GET['destination']).'&operation='.urlencode($_GET['operation']);
			$this->id = "xv-file-p-".substr(md5($_GET['file']), 28);
			$this->title = "Paste ".basename($_GET['file']);
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/trash.png';
			$_GET['destination'] = ($_GET['destination']);
			$this->content = '
				<form action="'.$GLOBALS['URLS']['Script'].'Administration/Get/Files/ConfirmPaste/" method="post" class="xv-form" data-xv-result=".content">
						<input type="hidden" value="'.htmlspecialchars($_GET['file']).'" name="xv-file" />
						<input type="hidden" value="'.htmlspecialchars($_GET['destination']).'" name="xv-destination" />
						<input type="hidden" value="'.htmlspecialchars($_GET['operation']).'" name="xv-operation" />
						<input type="hidden" value="'.htmlspecialchars($XVweb->Session->get_sid()).'" name="xv-sid" />
					<div style="text-align:center;">Do you want '.htmlspecialchars($_GET['operation']).' <span style="font-weight:bold;">'.basename($_GET['file']).'</span>  to <span style="font-weight:bold;">'.htmlspecialchars($_GET['destination']).'</span> dir ?</div>
					<table style="border:none; width:200px; margin:auto;">
						<tr>
							<td><input type="submit" value="Yes" /></td>
							<td><input type="button" value="No" class="xv-window-close" /></td>
						</tr>
					</table>
				</form>
			';
		}
	}
	
	
	class xv_admin_files_confirmpaste{
		public function __construct(&$XVweb){
		
		$FileLoc = ROOT_DIR.$_POST['xv-file'];
		$FileDest = ROOT_DIR.$_POST['xv-destination'];
			if(is_dir($FileLoc))
				$FileLoc = substr($FileLoc, 0, -1);
		
			if($XVweb->Session->get_sid() == $_POST['xv-sid']){
				if(file_exists($FileLoc) && file_exists($FileDest)){
					if(isset($_POST['xv-operation']) && (($_POST['xv-operation'] == "copy" && $this->smartCopy(($FileLoc), ($FileDest.'/'))) OR ($_POST['xv-operation'] == "cut" && rename(($FileLoc), ($FileDest.'/').basename($FileLoc)))))
					echo "<div class='success'>File/dir moved/copied.</div>
					<script type='text/javascript'>
						ThemeClass.LoadDir($('#xv-file-menager').data('xv-current-dir'));
					</script>
					"; else
					echo "<div class='failed'>Error : I cant move this dir/file</div>";
				}else{
					echo "<div class='failed'>Error: This file not exist or new destination not exsist</div>";
				}
			}else{
				echo "<div class='failed'>Error: Wrong SID</div>";
			}

			exit;
		}
		
	/** 
     * Copy file or folder from source to destination, it can do 
     * recursive copy as well and is very smart 
     * It recursively creates the dest file or directory path if there weren't exists 
     * Situtaions : 
     * - Src:/home/test/file.txt ,Dst:/home/test/b ,Result:/home/test/b -> If source was file copy file.txt name with b as name to destination 
     * - Src:/home/test/file.txt ,Dst:/home/test/b/ ,Result:/home/test/b/file.txt -> If source was file Creates b directory if does not exsits and copy file.txt into it 
     * - Src:/home/test ,Dst:/home/ ,Result:/home/test/** -> If source was directory copy test directory and all of its content into dest      
     * - Src:/home/test/ ,Dst:/home/ ,Result:/home/**-> if source was direcotry copy its content to dest 
     * - Src:/home/test ,Dst:/home/test2 ,Result:/home/test2/** -> if source was directoy copy it and its content to dest with test2 as name 
     * - Src:/home/test/ ,Dst:/home/test2 ,Result:->/home/test2/** if source was directoy copy it and its content to dest with test2 as name 
     * @todo 
     *     - Should have rollback technique so it can undo the copy when it wasn't successful 
     *  - Auto destination technique should be possible to turn off 
     *  - Supporting callback function 
     *  - May prevent some issues on shared enviroments : http://us3.php.net/umask 
     * @param $source //file or folder 
     * @param $dest ///file or folder 
     * @param $options //folderPermission,filePermission 
     * @return boolean 
     */ 
    public function smartCopy($source, $dest, $options=array('folderPermission'=>0755,'filePermission'=>0755)) 
    { 
        $result=false; 
        
        if (is_file($source)) { 
            if ($dest[strlen($dest)-1]=='/') { 
                if (!file_exists($dest)) { 
                    cmfcDirectory::makeAll($dest,$options['folderPermission'],true); 
                } 
                $__dest=$dest."/".basename($source); 
            } else { 
                $__dest=$dest; 
            } 
            $result=copy($source, $__dest); 
            chmod($__dest,$options['filePermission']); 
            
        } elseif(is_dir($source)) { 
            if ($dest[strlen($dest)-1]=='/') { 
                if ($source[strlen($source)-1]=='/') { 
                    //Copy only contents 
                } else { 
                    //Change parent itself and its contents 
                    $dest=$dest.basename($source); 
                    @mkdir($dest); 
                    chmod($dest,$options['filePermission']); 
                } 
            } else { 
                if ($source[strlen($source)-1]=='/') { 
                    //Copy parent directory with new name and all its content 
                    @mkdir($dest,$options['folderPermission']); 
                    chmod($dest,$options['filePermission']); 
                } else { 
                    //Copy parent directory with new name and all its content 
                    @mkdir($dest,$options['folderPermission']); 
                    chmod($dest,$options['filePermission']); 
                } 
            } 

            $dirHandle=opendir($source); 
            while($file=readdir($dirHandle)) 
            { 
                if($file!="." && $file!="..") 
                { 
                     if(!is_dir($source."/".$file)) { 
                        $__dest=$dest."/".$file; 
                    } else { 
                        $__dest=$dest."/".$file; 
                    } 
                    //echo "$source/$file ||| $__dest<br />"; 
                    $result= $this->smartCopy($source."/".$file, $__dest, $options); 
                } 
            } 
            closedir($dirHandle); 
            
        } else { 
            $result=false; 
        } 
        return $result; 
    } 
	
	}
	class xv_admin_files_confirmdelete{
		public function __construct(&$XVweb){
		
		$FileLoc = ROOT_DIR.$_POST['xv-file'];
		function SureRemoveDir($dir, $DeleteMe) {
			if(!$dh = @opendir($dir)) return;
			while (($obj = readdir($dh))) {
				if($obj=='.' || $obj=='..') continue;
				if (!@unlink($dir.'/'.$obj)) SureRemoveDir($dir.'/'.$obj, true);
			}
			if ($DeleteMe){
				closedir($dh);
				@rmdir($dir);
			}
			return true;
		}
		
			if($XVweb->Session->get_sid() == $_POST['xv-sid']){
				if(file_exists($FileLoc)){
					if(( is_file($FileLoc) && @unlink($FileLoc)) or (is_dir($FileLoc) && SureRemoveDir($FileLoc, true)))
					echo "<div class='success'>File/Dir deleted</div>
					<script type='text/javascript'>
						ThemeClass.LoadDir($('#xv-file-menager').data('xv-current-dir'));
					</script>
					"; else
					echo "<div class='failed'>Error : I cant delete this file</div>";
				}else{
					echo "<div class='failed'>Error: This element is not file or dir</div>";
				}
			}else{
				echo "<div class='failed'>Error: Wrong SID</div>";
			}

			exit;
		}
	}
	// Delete Files //
	class xv_admin_files_info{
		public function __construct(&$XVweb){
		$FileDir = ROOT_DIR.$_POST['filedir'];
		$TableInfo = array();
		
					$prems = @fileperms($FileDir);
			/* PREMISIONS */
			if (($perms & 0xC000) == 0xC000) {
    // Socket
    $info = 's';
} elseif (($perms & 0xA000) == 0xA000) {
    // Symbolic Link
    $info = 'l';
} elseif (($perms & 0x8000) == 0x8000) {
    // Regular
    $info = '-';
} elseif (($perms & 0x6000) == 0x6000) {
    // Block special
    $info = 'b';
} elseif (($perms & 0x4000) == 0x4000) {
    // Directory
    $info = 'd';
} elseif (($perms & 0x2000) == 0x2000) {
    // Character special
    $info = 'c';
} elseif (($perms & 0x1000) == 0x1000) {
    // FIFO pipe
    $info = 'p';
} else {
    // Unknown
    $info = 'u';
}

// Owner
$info .= (($perms & 0x0100) ? 'r' : '-');
$info .= (($perms & 0x0080) ? 'w' : '-');
$info .= (($perms & 0x0040) ?
            (($perms & 0x0800) ? 's' : 'x' ) :
            (($perms & 0x0800) ? 'S' : '-'));

// Group
$info .= (($perms & 0x0020) ? 'r' : '-');
$info .= (($perms & 0x0010) ? 'w' : '-');
$info .= (($perms & 0x0008) ?
            (($perms & 0x0400) ? 's' : 'x' ) :
            (($perms & 0x0400) ? 'S' : '-'));

// World
$info .= (($perms & 0x0004) ? 'r' : '-');
$info .= (($perms & 0x0002) ? 'w' : '-');
$info .= (($perms & 0x0001) ?
            (($perms & 0x0200) ? 't' : 'x' ) :
            (($perms & 0x0200) ? 'T' : '-'));
			/* PREMS */
			if(is_dir($FileDir)){
			$FileDir = realpath($FileDir);
			$TableInfo[] = array(
				"Lang"=>"Nazwa",
				"Info"=> basename($FileDir),
			);
			$TableInfo[] = array(
				"Lang"=>"Ilość plików",
				"Info"=> count(glob($FileDir . "/*")),
			);
			$TableInfo[] = array(
				"Lang"=>"Chmod",
				"Info"=> $info,
			);
			}elseif(is_file($FileDir)){
			
			function size_comp($size, $retstring = null) {
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
	
	
			$TableInfo[] = array(
				"Lang"=>"Nazwa",
				"Info"=> basename($FileDir),
			);
			$TableInfo[] = array(
				"Lang"=>"Chmod",
				"Info"=> $info,
			);
			$TableInfo[] = array(
				"Lang"=>"Rozmiar",
				"Info"=> "<span title='".filesize($FileDir)." B'>".size_comp(filesize($FileDir)).'</span>',
			);
			$TableInfo[] = array(
				"Lang"=>"Data modyfikacji",
				"Info"=> "<span title='".filemtime($FileDir)." B'>".date ("Y-m-d H:i:s", filemtime($FileDir)).'</span>',
			);
			}

			 ?>
			<div class="xv-table">
			
			<table style="width : 100%; text-align: center;">
				<caption><a href="<?php echo $GLOBALS['URLS']['Site'].$_POST['filedir']; ?>"><?php echo htmlspecialchars(basename($_POST['filedir'])); ?></a>  [<a href="<?php echo $GLOBALS['URLS']['Script']; ?>Administration/Get/Files/Download/?file=<?php echo urlencode($_POST['filedir']); ?>">Download</a>]</caption>
				<tbody>
				<?php
				foreach($TableInfo as $Info){
				?>
				<tr>
					<td><?php echo $Info['Lang']; ?></td>
					<td><?php echo $Info['Info']; ?></td>
				</tr>
				<?php
				}
				?>
				</tbody> 
				</table>
				
			</div>
			<?php
			exit;
		}
	}
	class Zipper extends ZipArchive { 
		public function addDir($path) { 
		$path = substr($path, 0, -1);
			$this->addEmptyDir($path); 
			$nodes = glob($path . '/*'); 
			foreach ($nodes as $node) { 
				if (is_dir($node)) { 
					$this->addDir($node); 
				} else if (is_file($node))  { 
					$this->addFile($node); 
				} 
			} 
		} 
			
		}
	class xv_admin_files_download{
		var $style = "max-height: 200px; width: 250px";
		public function __construct(&$XVweb){
		$FileLoc = ROOT_DIR.$_GET['file'];
			$this->dl_file($FileLoc);
		}
		public function dl_file($file){
		$IsDir = false;
			//First, see if the file exists
			if (!file_exists($file)) { die("<b>404 File not found!</b>"); }
			if(is_dir($file)){
				$file = $this->DirToZip($file);
				$IsDir = true;
			}
			//Gather relevent info about file
			$len = filesize($file);
			$filename = basename($file);
			$file_extension = strtolower(substr(strrchr($filename,"."),1));

			//This will set the Content-Type to the appropriate setting for the file
			switch( $file_extension ) {
			  case "pdf": $ctype="application/pdf"; break;
			  case "exe": $ctype="application/octet-stream"; break;
			  case "zip": $ctype="application/zip"; break;
			  case "doc": $ctype="application/msword"; break;
			  case "xls": $ctype="application/vnd.ms-excel"; break;
			  case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
			  case "gif": $ctype="image/gif"; break;
			  case "png": $ctype="image/png"; break;
			  case "jpeg":
			  case "jpg": $ctype="image/jpg"; break;
			  case "mp3": $ctype="audio/mpeg"; break;
			  case "wav": $ctype="audio/x-wav"; break;
			  case "mpeg":
			  case "mpg":
			  case "mpe": $ctype="video/mpeg"; break;
			  case "mov": $ctype="video/quicktime"; break;
			  case "avi": $ctype="video/x-msvideo"; break;

			  default: $ctype="application/force-download";
			}


			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: public"); 
			header("Content-Description: File Transfer");
			header("Content-Type: $ctype");

			//Force the download
			$header="Content-Disposition: attachment; filename=".$filename.";";
			header($header );
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".$len);
			@readfile($file);
			if($IsDir){
				@unlink($file);
			}
			exit;
		}
		public function DirToZip($dir){
			$zip = new Zipper;
			$zip->open( Cache_dir . basename($dir).'.zip', ZipArchive::CREATE); 
			$zip->addDir($dir);
			$zip->close();
			return Cache_dir . basename($dir).'.zip';
		}
	}
	class xv_admin_files_view{
		var $style = " width: 95%";
		public function __construct(&$XVweb){
			$this->URL = "Files/View/?file=".urlencode($_GET['file']);
			$this->id = "xv-file-vw-".substr(md5($_GET['file']), 28);
			$this->title = "View ".basename($_GET['file']);
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/trash.png';
		if(isset( $_POST['xv-sid']) && $XVweb->Session->get_sid() == $_POST['xv-sid']){
				if(file_put_contents($_POST['xv-file'], $_POST['xv-content'])){
					echo "<div class='success'>File was saved</div>";
				
				}else{
					echo "<div class='failed'>Error : I cant save this file</div>";
				}
				exit("
					<script type='text/javascript'>
						ThemeClass.LoadDir($('#xv-file-menager').data('xv-current-dir'));
					</script>");
			}
			
			
			$this->content = '<div>
					<div style="clear:both; padding-right:20px; background:rgb(254, 252, 245);">
						<div class="xv-edit-result"></div>
						<form action="'.$GLOBALS['URLS']['Script'].'Administration/Get/Files/View/" method="post" class="xv-form" data-xv-result=".xv-edit-result" >
							<input type="hidden" value="'.htmlspecialchars($_GET['file']).'" name="xv-file" />
							<input type="hidden" value="'.htmlspecialchars($XVweb->Session->get_sid()).'" name="xv-sid" />
							<textarea id="CodeEditorJS" style="width:100%; height:100%;" name="xv-content" class="xv-editor">'.htmlspecialchars( file_get_contents($_GET['file']) ).'</textarea>
							<input type="submit" value="'.$GLOBALS['Language']['Save'].'" />
						</form>
					</div>
				</div>
					<link rel="stylesheet" href="'.$GLOBALS['URLS']['JSCatalog'].'js/cm2.0/lib/codemirror.css"> 
					<link rel="stylesheet" href="'.$GLOBALS['URLS']['JSCatalog'].'js/cm2.0/mode/xml/xml.css"> 
					<link rel="stylesheet" href="'.$GLOBALS['URLS']['JSCatalog'].'js/cm2.0/mode/javascript/javascript.css"> 
					<link rel="stylesheet" href="'.$GLOBALS['URLS']['JSCatalog'].'js/cm2.0/mode/css/css.css"> 
					<link rel="stylesheet" href="'.$GLOBALS['URLS']['JSCatalog'].'js/cm2.0/mode/clike/clike.css"> 
					<script src="'.$GLOBALS['URLS']['JSCatalog'].'js/cm2.0/lib/codemirror.js"></script> 
					<script src="'.$GLOBALS['URLS']['JSCatalog'].'js/cm2.0/mode/php/php.js"></script>  
					<script src="'.$GLOBALS['URLS']['JSCatalog'].'js/cm2.0/mode/javascript/javascript.js"></script>  
					<script src="'.$GLOBALS['URLS']['JSCatalog'].'js/cm2.0/mode/clike/clike.js"></script>  
					<script src="'.$GLOBALS['URLS']['JSCatalog'].'js/cm2.0/mode/xml/xml.js"></script>  
			<script type="text/javascript">
			$(function() {
						$(".xv-editor").each(function(){
								  var editor = CodeMirror.fromTextArea(this, {
								  lineNumbers: true ,
								  mode: "application/x-httpd-php"
								  });

							});	
			});
			</script>';
		}
	}
	
	
	$CommandSecond = strtolower($XVwebEngine->GetFromURL($PathInfo, 4));
	if (class_exists('xv_admin_files_'.$CommandSecond)) {
		$xv_admin_class_name = 'xv_admin_files_'.$CommandSecond;
	}else
		$xv_admin_class_name = "xv_admin_files";
		

?>