<?php /* Smarty version 2.6.25-dev, created on 2010-06-15 12:58:59
         compiled from view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'view.tpl', 33, false),array('modifier', 'default', 'view.tpl', 99, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->_tpl_vars['language']['Step']; ?>
 <?php echo $this->_tpl_vars['Step']; ?>
 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
@import url(install/themes/style.css);
</style>
<script type="text/javascript" src="install/themes/js/jquery.js" charset="UTF-8"> </script>  
</head>
<body>

<div id="wrapper">


	<div id="top">
    <div id="top-left">
         <div id="top-right">
              <div id="top-middle"> 
              </div>
         </div>
    </div>
</div>
<div id="frame-left"><div id="frame-right"><div id="content">



<div style="padding-left:72px;">
<?php if ($this->_tpl_vars['Step'] == 1): ?>

<h1><?php echo $this->_tpl_vars['language']['Welcome']; ?>
</h1> 
<form method="post" action="?Step=<?php echo $this->_tpl_vars['Step']+1; ?>
">
<?php echo $this->_tpl_vars['language']['SelectLangMSG']; ?>
 : <?php echo smarty_function_html_options(array('name' => 'Lang','options' => $this->_tpl_vars['LangList'],'selected' => $this->_tpl_vars['SelecedLang']), $this);?>
<br />
<div class="ButtonArea">
<input type="submit" value="<?php echo $this->_tpl_vars['language']['Step']; ?>
 2 &gt;&gt;" class="StepButton"/>
</div>
</form>
<?php elseif ($this->_tpl_vars['Step'] == 2): ?>
<form method="post" action="?Step=<?php echo $this->_tpl_vars['Step']+1; ?>
">
<h1><?php echo $this->_tpl_vars['language']['Step']; ?>
 <?php echo $this->_tpl_vars['Step']; ?>
 - <?php echo $this->_tpl_vars['language']['License']; ?>
 </h1> 
<iframe src="install/license.txt" scrolling="yes" name="License" style="width:100%; height:600px;"></iframe>
<input type="checkbox" name="LicenseAcept" id="LicenseAceptID" value="Acept" /> <label for="LicenseAceptID"><?php echo $this->_tpl_vars['language']['AceptLicenseMSG']; ?>
</label>
<div class="ButtonArea">
<input type="button" value="&lt;&lt; <?php echo $this->_tpl_vars['language']['Step']; ?>
 <?php echo $this->_tpl_vars['Step']-1; ?>
" onclick="location.href='?Step=<?php echo $this->_tpl_vars['Step']-1; ?>
';" class="StepButton"/> <input type="submit" value="<?php echo $this->_tpl_vars['language']['Step']; ?>
 <?php echo $this->_tpl_vars['Step']+1; ?>
 &gt;&gt;" class="StepButton" /> 
</div>
<form>

<?php elseif ($this->_tpl_vars['Step'] == 3): ?>
<h1><?php echo $this->_tpl_vars['language']['Step']; ?>
 <?php echo $this->_tpl_vars['Step']; ?>
 - <?php echo $this->_tpl_vars['language']['CscMSG']; ?>
 </h1> 
<div class="tablediv" style="width:500px;">
<?php $_from = $this->_tpl_vars['CheckResult']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['KeyGrup'] => $this->_tpl_vars['CheckGrup']):
?>
	<div class="table-row">
		<div class="table-cell"><h1><?php echo $this->_tpl_vars['KeyGrup']; ?>
</h1></div>
	</div>
	<?php $_from = $this->_tpl_vars['CheckGrup']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['CheckItemName'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['CheckItemName']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['KeyItemGrup'] => $this->_tpl_vars['CheckItemGrup']):
        $this->_foreach['CheckItemName']['iteration']++;
?>
	<div class="table-row" <?php if (($this->_foreach['CheckItemName']['iteration']-1)%2 == 0): ?>style="background:#DFDFDF;"<?php endif; ?>>
		<div class="table-cell"><?php echo $this->_tpl_vars['CheckItemGrup']['Name']; ?>
</div>
		<div class="table-cell">
		<?php if ($this->_tpl_vars['CheckItemGrup']['Result']): ?>
		<img src="install/themes/img/passed.gif" alt="<?php echo $this->_tpl_vars['language']['Passed']; ?>
" class="ImgResult<?php echo $this->_tpl_vars['CheckItemGrup']['Result']; ?>
" />
		<?php else: ?>
		<img src="install/themes/img/failed.gif" alt="<?php echo $this->_tpl_vars['language']['Failed']; ?>
" class="ImgResult<?php echo $this->_tpl_vars['CheckItemGrup']['Result']; ?>
" />
		<?php endif; ?>
		</div>
	</div>
	<?php endforeach; endif; unset($_from); ?>
<?php endforeach; endif; unset($_from); ?>
</div>
<div id="FinallResult"></div>
<div class="ButtonArea">
	<form method="post" action="?Step=<?php echo $this->_tpl_vars['Step']+1; ?>
">
		<input type="button" value="&lt;&lt; <?php echo $this->_tpl_vars['language']['Step']; ?>
 <?php echo $this->_tpl_vars['Step']-1; ?>
" onclick="location.href='?Step=<?php echo $this->_tpl_vars['Step']-1; ?>
';" class="StepButton"/> <input type="submit" value="<?php echo $this->_tpl_vars['language']['Step']; ?>
 <?php echo $this->_tpl_vars['Step']+1; ?>
 &gt;&gt;" id="NextStep" class="StepButton" />
	</form>
</div>

<?php echo '
<script type="text/javascript">

$(document).ready(function() {
	if($(\'.ImgResult\').size()){
		$(\'#FinallResult\').addClass("Failed").text("'; ?>
<?php echo $this->_tpl_vars['language']['Failed']; ?>
<?php echo '");
		$(\'#NextStep\').attr("disabled", true);
		} else {
		$(\'#FinallResult\').addClass("Passed").text("'; ?>
<?php echo $this->_tpl_vars['language']['Passed']; ?>
<?php echo '");
		};
});

</script>
'; ?>

<?php elseif ($this->_tpl_vars['Step'] == 4): ?>
<h1><?php echo $this->_tpl_vars['language']['Step']; ?>
 <?php echo $this->_tpl_vars['Step']; ?>
 - <?php echo $this->_tpl_vars['language']['MySQLConfig']; ?>
 </h1> 
<form method="post" action="?Step=<?php echo $this->_tpl_vars['Step']+1; ?>
">
<div class="tablediv" style="width:500px;">
	<div class="table-row">
		<div class="table-cell"><h1><?php echo $this->_tpl_vars['MySQLConfig']; ?>
</h1></div>
	</div>
	<div class="table-row" style="background:#DFDFDF;">
		<div class="table-cell"><?php echo $this->_tpl_vars['language']['Server']; ?>
</div>
		<div class="table-cell"> <input type="text" name="Server" id="ServerID" value="<?php echo ((is_array($_tmp=@$_SESSION['DataBase']['Server'])) ? $this->_run_mod_handler('default', true, $_tmp, 'localhost') : smarty_modifier_default($_tmp, 'localhost')); ?>
"/> </div>
	</div>
	<div class="table-row">
		<div class="table-cell"><?php echo $this->_tpl_vars['language']['DataBase']; ?>
</div>
		<div class="table-cell"> <input type="text" name="DataBase"  id="DataBaseID" value="<?php echo $_SESSION['DataBase']['DataBase']; ?>
"/> </div>
	</div>
	<div class="table-row" style="background:#DFDFDF;">
		<div class="table-cell"><?php echo $this->_tpl_vars['language']['User']; ?>
</div>
		<div class="table-cell"> <input type="text" name="User" id="UserID" value="<?php echo $_SESSION['DataBase']['User']; ?>
"/> </div>
	</div>
	<div class="table-row">
		<div class="table-cell"><?php echo $this->_tpl_vars['language']['Password']; ?>
</div>
		<div class="table-cell"> <input type="password" name="Password" id="PasswordID" value="<?php echo $_SESSION['DataBase']['Password']; ?>
"/> </div>
	</div>
	<div class="table-row" style="background:#DFDFDF;">
		<div class="table-cell"><?php echo $this->_tpl_vars['language']['Prefix']; ?>
</div>
		<div class="table-cell"> <input type="text" name="Prefix" value="<?php echo ((is_array($_tmp=@$_SESSION['DataBase']['Prefix'])) ? $this->_run_mod_handler('default', true, $_tmp, 'xv_') : smarty_modifier_default($_tmp, 'xv_')); ?>
" /> </div>
	</div>
	<div class="table-row">
		<div class="table-cell"><input type="button" value="<?php echo $this->_tpl_vars['language']['Check']; ?>
" class="StyleForm" id="CheckButton"/></div>
		<div class="table-cell" id="CheckResult">  </div>
	</div>
</div>

<div class="ButtonArea">

		<input type="button" value="&lt;&lt; <?php echo $this->_tpl_vars['language']['Step']; ?>
 <?php echo $this->_tpl_vars['Step']-1; ?>
" onclick="location.href='?Step=<?php echo $this->_tpl_vars['Step']-1; ?>
';" class="StepButton"/> <input type="submit" value="<?php echo $this->_tpl_vars['language']['Step']; ?>
 <?php echo $this->_tpl_vars['Step']+1; ?>
 &gt;&gt;" id="NextStep" class="StepButton" disabled="disabled" />
</div>
	</form>
<?php echo '
<script type="text/javascript">
$(document).ready(function() {
	$("#CheckButton").click(function(){
	$(\'#CheckResult\').html(\'<img src="install/themes/img/progress" alt="Wait"\');
			$.post("?Step=4&ValidMYSQl=true", { Server: $(\'#ServerID\').val(), DataBase:$(\'#DataBaseID\').val(), User:$(\'#UserID\').val(), Password:$(\'#PasswordID\').val() },
				function(data){
					if(data.Result){
					$(\'#CheckResult\').html(\'<img src="install/themes/img/passed.gif" alt="Passed" class="ImgResult1" />\');
					$(\'#NextStep\').attr("disabled", false);
					}else{
					$(\'#CheckResult\').html(\'<img src="install/themes/img/failed.gif" alt="Failed" class="ImgResult" /><br/>Code: \'+data.Code+\'<br/>Message: \'+data.Message);
					$(\'#NextStep\').attr("disabled", true);
					}
					
				  }, "json");
	
	});
	$("input").change(function(){
	$(\'#NextStep\').attr("disabled", true);
	});
});
</script>
'; ?>

<?php elseif ($this->_tpl_vars['Step'] == 5): ?>
<h1><?php echo $this->_tpl_vars['language']['Step']; ?>
 <?php echo $this->_tpl_vars['Step']; ?>
 - <?php echo $this->_tpl_vars['language']['MySQlResult']; ?>
 </h1> 
<?php if ($this->_tpl_vars['MySQLResult']['Result']): ?>
<div id="FinallResult" class="Passed"><img src="install/themes/img/passed.gif" alt="Passed" class="ImgResult1" /> <?php echo $this->_tpl_vars['language']['Passed']; ?>
</div>
<?php else: ?>
<div id="FinallResult" class="Failed">
<?php echo $this->_tpl_vars['language']['Failed']; ?>
<br/>
<span class="NormalSize"><?php echo $this->_tpl_vars['language']['Error']; ?>
 : <?php echo $this->_tpl_vars['MySQLResult']['Code']; ?>
</span>
<span class="NormalSize"><?php echo $this->_tpl_vars['language']['Message']; ?>
 : <?php echo $this->_tpl_vars['MySQLResult']['Message']; ?>
</span>
</div>
<?php endif; ?>
<div class="ButtonArea">
	<form method="post" action="?Step=<?php echo $this->_tpl_vars['Step']+1; ?>
">
		<input type="button" value="&lt;&lt; <?php echo $this->_tpl_vars['language']['Step']; ?>
 <?php echo $this->_tpl_vars['Step']-1; ?>
" onclick="location.href='?Step=<?php echo $this->_tpl_vars['Step']-1; ?>
';" class="StepButton"/> <input type="submit" value="<?php echo $this->_tpl_vars['language']['Step']; ?>
 <?php echo $this->_tpl_vars['Step']+1; ?>
 &gt;&gt;" id="NextStep" class="StepButton" <?php if (! $this->_tpl_vars['MySQLResult']['Result']): ?>disabled="disabled"<?php endif; ?> />
	</form>
</div>
<?php elseif ($this->_tpl_vars['Step'] == 6): ?>
<h1><?php echo $this->_tpl_vars['language']['Step']; ?>
 <?php echo $this->_tpl_vars['Step']; ?>
 - <?php echo $this->_tpl_vars['language']['Configuration']; ?>
 </h1> 
<form method="post" action="?Step=<?php echo $this->_tpl_vars['Step']+1; ?>
">
<div class="tablediv" style="width:500px;">
	<div class="table-row">
		<div class="table-cell"><h2><?php echo $this->_tpl_vars['language']['CMSConsts']; ?>
</h2></div>
	</div>
	<div class="table-row">
		<div class="table-cell"><?php echo $this->_tpl_vars['language']['Catalog']; ?>
</div>
		<div class="table-cell"> <input type="text" name="Catalog"  id="CatalogID" value="<?php echo $_SESSION['Config']['Catalog']; ?>
"/> </div>
	</div>
	<div class="table-row">
		<div class="table-cell"><?php echo $this->_tpl_vars['language']['MD5Key']; ?>
</div>
		<div class="table-cell"> <input type="text" name="MD5Key"  id="MD5KeyID" value="<?php echo $_SESSION['Config']['MD5Key']; ?>
"/> <input type="button" value="<?php echo $this->_tpl_vars['language']['Generate']; ?>
" id="GenerateID" class="StyleForm"/></div>
	</div>
	<div class="table-row">
		<div class="table-cell"><?php echo $this->_tpl_vars['language']['SiteName']; ?>
</div>
		<div class="table-cell"> <input type="text" name="SiteName"  id="SiteNameID" value="<?php echo $_SESSION['Config']['SiteName']; ?>
"/> </div>
	</div>
	<div class="table-row">
		<div class="table-cell"><?php echo $this->_tpl_vars['language']['LanguageWord']; ?>
</div>
		<div class="table-cell"> <?php echo smarty_function_html_options(array('name' => 'SiteLang','options' => $this->_tpl_vars['Listing']['Lang'],'selected' => $this->_tpl_vars['language']['Lang']), $this);?>
 </div>
	</div>
	<div class="table-row">
		<div class="table-cell"><h2><?php echo $this->_tpl_vars['language']['Administrator']; ?>
</h2></div>
	</div>
	<div class="table-row">
		<div class="table-cell"><?php echo $this->_tpl_vars['language']['Login']; ?>
</div>
		<div class="table-cell"> <input type="text" name="Login"  id="LoginID" value="<?php echo $_SESSION['Config']['Login']; ?>
"/> </div>
	</div>
	<div class="table-row">
		<div class="table-cell"><?php echo $this->_tpl_vars['language']['Password']; ?>
</div>
		<div class="table-cell"> <input type="password" name="LPassword"  id="LoginID" value="<?php echo $_SESSION['Config']['LPassword']; ?>
"/> </div>
	</div>
	<div class="table-row">
		<div class="table-cell"><?php echo $this->_tpl_vars['language']['Mail']; ?>
</div>
		<div class="table-cell"> <input type="text" name="Mail"  id="MailID" value="<?php echo $_SESSION['Config']['Password']; ?>
"/> </div>
	</div>
</div>
<div class="ButtonArea">
		<input type="button" value="&lt;&lt; <?php echo $this->_tpl_vars['language']['Step']; ?>
 <?php echo $this->_tpl_vars['Step']-1; ?>
" onclick="location.href='?Step=<?php echo $this->_tpl_vars['Step']-1; ?>
';" class="StepButton"/><input type="submit" value="<?php echo $this->_tpl_vars['language']['Step']; ?>
 <?php echo $this->_tpl_vars['Step']+1; ?>
 - <?php echo $this->_tpl_vars['language']['Finish']; ?>
 &gt;&gt;" id="NextStep" class="StepButton"  />
</div>
</form>
<?php echo '
<script type="text/javascript">
$(document).ready(function() {
$(\'#CatalogID\').val(location.pathname.replace(\'install/\', "").substring(1).replace(\'index.php\', ""));

function randomPassword(length)
{
   chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
   pass = "";
   for(x=0;x<length;x++)
   {
      i = Math.floor(Math.random() * 62);
      pass += chars.charAt(i);
   }
   return pass;
}
$(\'#GenerateID\').click(function(){
$(\'#MD5KeyID\').val(randomPassword(32));
});
$(\'#MD5KeyID\').val(randomPassword(32));
});
</script>
'; ?>

<?php elseif ($this->_tpl_vars['Step'] == 7): ?>
<div id="FinallResult" class="Passed"><img src="install/themes/img/passed.gif" alt="Passed" class="ImgResult1" /> <?php echo $this->_tpl_vars['language']['Finish']; ?>
</div>
<div class="ButtonArea">
	<form method="post" action="?Step=<?php echo $this->_tpl_vars['Step']+1; ?>
">
	 <input type="submit" value="<?php echo $this->_tpl_vars['language']['Enter']; ?>
" id="NextStep" class="StepButton" />
	</form>
</div>
<?php endif; ?>

</div>

</div></div></div>
	
<div id="bottom">
    <div id="bottom-left">
         <div id="bottom-right">
              <div id="bottom-middle"> 
              </div>
         </div>
    </div>
</div>
	
</div>
</body>
</html>