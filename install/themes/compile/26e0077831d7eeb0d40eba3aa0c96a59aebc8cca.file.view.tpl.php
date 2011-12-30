<?php /* Smarty version Smarty-3.0.7, created on 2011-12-30 11:21:48
         compiled from "install\themes\view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:70754efd9eccc39204-66836448%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '26e0077831d7eeb0d40eba3aa0c96a59aebc8cca' => 
    array (
      0 => 'install\\themes\\view.tpl',
      1 => 1324329817,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '70754efd9eccc39204-66836448',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include 'D:\wamp\www\XVweb.git\core\libraries\smarty3\plugins\function.html_options.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $_smarty_tpl->getVariable('language')->value['Step'];?>
 <?php echo $_smarty_tpl->getVariable('Step')->value;?>
 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
@import url(themes/style.css);
</style>
<script type="text/javascript" src="themes/js/jquery.js" charset="UTF-8"> </script>  
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
<?php if ($_smarty_tpl->getVariable('Step')->value==1){?>

<h1><?php echo $_smarty_tpl->getVariable('language')->value['Welcome'];?>
</h1> 
<form method="post" action="?Step=<?php echo $_smarty_tpl->getVariable('Step')->value+1;?>
">
<?php echo $_smarty_tpl->getVariable('language')->value['SelectLangMSG'];?>
 : <?php echo smarty_function_html_options(array('name'=>'Lang','options'=>$_smarty_tpl->getVariable('LangList')->value,'selected'=>$_smarty_tpl->getVariable('SelecedLang')->value),$_smarty_tpl);?>
<br />
<div class="ButtonArea">
<input type="submit" value="<?php echo $_smarty_tpl->getVariable('language')->value['Step'];?>
 2 &gt;&gt;" class="StepButton"/>
</div>
</form>
<?php }?>
<?php if ($_smarty_tpl->getVariable('Step')->value==2){?>
<form method="post" action="?Step=<?php echo $_smarty_tpl->getVariable('Step')->value+1;?>
">
<h1><?php echo $_smarty_tpl->getVariable('language')->value['Step'];?>
 <?php echo $_smarty_tpl->getVariable('Step')->value;?>
 - <?php echo $_smarty_tpl->getVariable('language')->value['License'];?>
 </h1> 
<iframe src="license.txt" scrolling="yes" name="License" style="width:100%; height:600px;"></iframe>
<input type="checkbox" name="LicenseAcept" id="LicenseAceptID" value="Acept" /> <label for="LicenseAceptID"><?php echo $_smarty_tpl->getVariable('language')->value['AceptLicenseMSG'];?>
</label>
<div class="ButtonArea">
<input type="button" value="&lt;&lt; <?php echo $_smarty_tpl->getVariable('language')->value['Step'];?>
 <?php echo $_smarty_tpl->getVariable('Step')->value-1;?>
" onclick="location.href='?Step=<?php echo $_smarty_tpl->getVariable('Step')->value-1;?>
';" class="StepButton"/> <input type="submit" value="<?php echo $_smarty_tpl->getVariable('language')->value['Step'];?>
 <?php echo $_smarty_tpl->getVariable('Step')->value+1;?>
 &gt;&gt;" class="StepButton" /> 
</div>
<form>
<?php }?>
<?php if ($_smarty_tpl->getVariable('Step')->value==3){?>
<h1><?php echo $_smarty_tpl->getVariable('language')->value['Step'];?>
 <?php echo $_smarty_tpl->getVariable('Step')->value;?>
 - <?php echo $_smarty_tpl->getVariable('language')->value['CscMSG'];?>
 </h1> 
<div class="tablediv" style="width:500px;">
<?php  $_smarty_tpl->tpl_vars['CheckGrup'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['KeyGrup'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('CheckResult')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['CheckGrup']->key => $_smarty_tpl->tpl_vars['CheckGrup']->value){
 $_smarty_tpl->tpl_vars['KeyGrup']->value = $_smarty_tpl->tpl_vars['CheckGrup']->key;
?>
	<div class="table-row">
		<div class="table-cell"><h1><?php echo $_smarty_tpl->tpl_vars['KeyGrup']->value;?>
</h1></div>
	</div>
	<?php  $_smarty_tpl->tpl_vars['CheckItemGrup'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['KeyItemGrup'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['CheckGrup']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['CheckItemName']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['CheckItemGrup']->key => $_smarty_tpl->tpl_vars['CheckItemGrup']->value){
 $_smarty_tpl->tpl_vars['KeyItemGrup']->value = $_smarty_tpl->tpl_vars['CheckItemGrup']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['CheckItemName']['index']++;
?>
	<div class="table-row" <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['CheckItemName']['index']%2==0){?>style="background:#DFDFDF;"<?php }?>>
		<div class="table-cell"><?php echo $_smarty_tpl->tpl_vars['CheckItemGrup']->value['Name'];?>
</div>
		<div class="table-cell">
		<?php if ($_smarty_tpl->tpl_vars['CheckItemGrup']->value['Result']){?>
		<img src="themes/img/passed.gif" alt="<?php echo $_smarty_tpl->getVariable('language')->value['Passed'];?>
" class="ImgResult<?php echo $_smarty_tpl->tpl_vars['CheckItemGrup']->value['Result'];?>
" />
		<?php }else{ ?>
		<img src="themes/img/failed.gif" alt="<?php echo $_smarty_tpl->getVariable('language')->value['Failed'];?>
" class="ImgResult<?php echo $_smarty_tpl->tpl_vars['CheckItemGrup']->value['Result'];?>
" />
		<?php }?>
		</div>
	</div>
	<?php }} ?>
<?php }} ?>
</div>
<div id="FinallResult"></div>
<div class="ButtonArea">
	<form method="post" action="?Step=<?php echo $_smarty_tpl->getVariable('Step')->value+1;?>
">
		<input type="button" value="&lt;&lt; <?php echo $_smarty_tpl->getVariable('language')->value['Step'];?>
 <?php echo $_smarty_tpl->getVariable('Step')->value-1;?>
" onclick="location.href='?Step=<?php echo $_smarty_tpl->getVariable('Step')->value-1;?>
';" class="StepButton"/> <input type="submit" value="<?php echo $_smarty_tpl->getVariable('language')->value['Step'];?>
 <?php echo $_smarty_tpl->getVariable('Step')->value+1;?>
 &gt;&gt;" id="NextStep" class="StepButton" />
	</form>
</div>


<script type="text/javascript">

$(document).ready(function() {
	if($('.ImgResult').size()){
		$('#FinallResult').addClass("Failed").text("<?php echo $_smarty_tpl->getVariable('language')->value['Failed'];?>
");
		$('#NextStep').attr("disabled", true);
		} else {
		$('#FinallResult').addClass("Passed").text("<?php echo $_smarty_tpl->getVariable('language')->value['Passed'];?>
");
		};
});

</script>

<?php }?>

<?php if ($_smarty_tpl->getVariable('Step')->value==4){?>
<h1><?php echo $_smarty_tpl->getVariable('language')->value['Step'];?>
 <?php echo $_smarty_tpl->getVariable('Step')->value;?>
 - <?php echo $_smarty_tpl->getVariable('language')->value['MySQLConfig'];?>
 </h1> 
<form method="post" action="?Step=<?php echo $_smarty_tpl->getVariable('Step')->value+1;?>
">
<div class="tablediv" style="width:500px;">
	<div class="table-row">
		<div class="table-cell"><h1><?php echo $_smarty_tpl->getVariable('MySQLConfig')->value;?>
</h1></div>
	</div>
	<div class="table-row" style="background:#DFDFDF;">
		<div class="table-cell"><?php echo $_smarty_tpl->getVariable('language')->value['Server'];?>
</div>
		<div class="table-cell"> <input type="text" name="Server" id="ServerID" value="<?php echo (($tmp = @$_SESSION['DataBase']['Server'])===null||$tmp==='' ? 'localhost' : $tmp);?>
"/> </div>
	</div>
	<div class="table-row">
		<div class="table-cell"><?php echo $_smarty_tpl->getVariable('language')->value['DataBase'];?>
</div>
		<div class="table-cell"> <input type="text" name="DataBase"  id="DataBaseID" value="<?php echo $_SESSION['DataBase']['DataBase'];?>
"/> </div>
	</div>
	<div class="table-row" style="background:#DFDFDF;">
		<div class="table-cell"><?php echo $_smarty_tpl->getVariable('language')->value['User'];?>
</div>
		<div class="table-cell"> <input type="text" name="User" id="UserID" value="<?php echo $_SESSION['DataBase']['User'];?>
"/> </div>
	</div>
	<div class="table-row">
		<div class="table-cell"><?php echo $_smarty_tpl->getVariable('language')->value['Password'];?>
</div>
		<div class="table-cell"> <input type="password" name="Password" id="PasswordID" value="<?php echo $_SESSION['DataBase']['Password'];?>
"/> </div>
	</div>
	<div class="table-row" style="background:#DFDFDF;">
		<div class="table-cell"><?php echo $_smarty_tpl->getVariable('language')->value['Prefix'];?>
</div>
		<div class="table-cell"> <input type="text" name="Prefix" value="<?php echo (($tmp = @$_SESSION['DataBase']['Prefix'])===null||$tmp==='' ? 'xv_' : $tmp);?>
" /> </div>
	</div>
	<div class="table-row">
		<div class="table-cell"><input type="button" value="<?php echo $_smarty_tpl->getVariable('language')->value['Check'];?>
" class="StyleForm" id="CheckButton"/></div>
		<div class="table-cell" id="CheckResult">  </div>
	</div>
</div>

<div class="ButtonArea">

		<input type="button" value="&lt;&lt; <?php echo $_smarty_tpl->getVariable('language')->value['Step'];?>
 <?php echo $_smarty_tpl->getVariable('Step')->value-1;?>
" onclick="location.href='?Step=<?php echo $_smarty_tpl->getVariable('Step')->value-1;?>
';" class="StepButton"/> <input type="submit" value="<?php echo $_smarty_tpl->getVariable('language')->value['Step'];?>
 <?php echo $_smarty_tpl->getVariable('Step')->value+1;?>
 &gt;&gt;" id="NextStep" class="StepButton" disabled="disabled" />
</div>
	</form>

<script type="text/javascript">
$(document).ready(function() {
	$("#CheckButton").click(function(){
	$('#CheckResult').html('<img src="themes/img/progress" alt="Wait"');
			$.post("?Step=4&ValidMYSQl=true", { Server: $('#ServerID').val(), DataBase:$('#DataBaseID').val(), User:$('#UserID').val(), Password:$('#PasswordID').val() },
				function(data){
					if(data.Result){
					$('#CheckResult').html('<img src="themes/img/passed.gif" alt="Passed" class="ImgResult1" />');
					$('#NextStep').attr("disabled", false);
					}else{
					$('#CheckResult').html('<img src="themes/img/failed.gif" alt="Failed" class="ImgResult" /><br/>Code: '+data.Code+'<br/>Message: '+data.Message);
					$('#NextStep').attr("disabled", true);
					}
					
				  }, "json");
	
	});
	$("input").change(function(){
	$('#NextStep').attr("disabled", true);
	});
});
</script>

<?php }?>
<?php if ($_smarty_tpl->getVariable('Step')->value==5){?>
<h1><?php echo $_smarty_tpl->getVariable('language')->value['Step'];?>
 <?php echo $_smarty_tpl->getVariable('Step')->value;?>
 - <?php echo $_smarty_tpl->getVariable('language')->value['MySQlResult'];?>
 </h1> 
<?php if ($_smarty_tpl->getVariable('MySQLResult')->value['Result']){?>
<div id="FinallResult" class="Passed"><img src="themes/img/passed.gif" alt="Passed" class="ImgResult1" /> <?php echo $_smarty_tpl->getVariable('language')->value['Passed'];?>
</div>
<?php }else{ ?>
<div id="FinallResult" class="Failed">
<?php echo $_smarty_tpl->getVariable('language')->value['Failed'];?>
<br/>
<span class="NormalSize"><?php echo $_smarty_tpl->getVariable('language')->value['Error'];?>
 : <?php echo $_smarty_tpl->getVariable('MySQLResult')->value['Code'];?>
</span>
<span class="NormalSize"><?php echo $_smarty_tpl->getVariable('language')->value['Message'];?>
 : <?php echo $_smarty_tpl->getVariable('MySQLResult')->value['Message'];?>
</span>
</div>
<?php }?>
<div class="ButtonArea">
	<form method="post" action="?Step=<?php echo $_smarty_tpl->getVariable('Step')->value+1;?>
">
		<input type="button" value="&lt;&lt; <?php echo $_smarty_tpl->getVariable('language')->value['Step'];?>
 <?php echo $_smarty_tpl->getVariable('Step')->value-1;?>
" onclick="location.href='?Step=<?php echo $_smarty_tpl->getVariable('Step')->value-1;?>
';" class="StepButton"/> <input type="submit" value="<?php echo $_smarty_tpl->getVariable('language')->value['Step'];?>
 <?php echo $_smarty_tpl->getVariable('Step')->value+1;?>
 &gt;&gt;" id="NextStep" class="StepButton" <?php if (!$_smarty_tpl->getVariable('MySQLResult')->value['Result']){?>disabled="disabled"<?php }?> />
	</form>
</div>
<?php }?>
<?php if ($_smarty_tpl->getVariable('Step')->value==6){?>
<h1><?php echo $_smarty_tpl->getVariable('language')->value['Step'];?>
 <?php echo $_smarty_tpl->getVariable('Step')->value;?>
 - <?php echo $_smarty_tpl->getVariable('language')->value['Configuration'];?>
 </h1> 
<form method="post" action="?Step=<?php echo $_smarty_tpl->getVariable('Step')->value+1;?>
">
<div class="tablediv" style="width:500px;">
	<div class="table-row">
		<div class="table-cell"><h2><?php echo $_smarty_tpl->getVariable('language')->value['CMSConsts'];?>
</h2></div>
	</div>
	<div class="table-row">
		<div class="table-cell"><?php echo $_smarty_tpl->getVariable('language')->value['Catalog'];?>
</div>
		<div class="table-cell"> <input type="text" name="Catalog"  id="CatalogID" value="<?php echo $_SESSION['Config']['Catalog'];?>
"/> </div>
	</div>
	<div class="table-row">
		<div class="table-cell"><?php echo $_smarty_tpl->getVariable('language')->value['MD5Key'];?>
</div>
		<div class="table-cell"> <input type="text" name="MD5Key"  id="MD5KeyID" value="<?php echo $_SESSION['Config']['MD5Key'];?>
"/> <input type="button" value="<?php echo $_smarty_tpl->getVariable('language')->value['Generate'];?>
" id="GenerateID" class="StyleForm"/></div>
	</div>
	<div class="table-row">
		<div class="table-cell"><?php echo $_smarty_tpl->getVariable('language')->value['SiteName'];?>
</div>
		<div class="table-cell"> <input type="text" name="SiteName"  id="SiteNameID" value="<?php echo $_SESSION['Config']['SiteName'];?>
"/> </div>
	</div>
	<div class="table-row">
		<div class="table-cell"><?php echo $_smarty_tpl->getVariable('language')->value['LanguageWord'];?>
</div>
		<div class="table-cell"> <?php echo smarty_function_html_options(array('name'=>'SiteLang','options'=>$_smarty_tpl->getVariable('Listing')->value['Lang'],'selected'=>$_smarty_tpl->getVariable('language')->value['Lang']),$_smarty_tpl);?>
 </div>
	</div>
	<div class="table-row">
		<div class="table-cell"><h2><?php echo $_smarty_tpl->getVariable('language')->value['Administrator'];?>
</h2></div>
	</div>
	<div class="table-row">
		<div class="table-cell"><?php echo $_smarty_tpl->getVariable('language')->value['Login'];?>
</div>
		<div class="table-cell"> <input type="text" name="Login"  id="LoginID" value="<?php echo $_SESSION['Config']['Login'];?>
"/> </div>
	</div>
	<div class="table-row">
		<div class="table-cell"><?php echo $_smarty_tpl->getVariable('language')->value['Password'];?>
</div>
		<div class="table-cell"> <input type="password" name="LPassword"  id="LoginID" value="<?php echo $_SESSION['Config']['LPassword'];?>
"/> </div>
	</div>
	<div class="table-row">
		<div class="table-cell"><?php echo $_smarty_tpl->getVariable('language')->value['Mail'];?>
</div>
		<div class="table-cell"> <input type="text" name="Mail"  id="MailID" value="<?php echo $_SESSION['Config']['Password'];?>
"/> </div>
	</div>
</div>
<div class="ButtonArea">
		<input type="button" value="&lt;&lt; <?php echo $_smarty_tpl->getVariable('language')->value['Step'];?>
 <?php echo $_smarty_tpl->getVariable('Step')->value-1;?>
" onclick="location.href='?Step=<?php echo $_smarty_tpl->getVariable('Step')->value-1;?>
';" class="StepButton"/><input type="submit" value="<?php echo $_smarty_tpl->getVariable('language')->value['Step'];?>
 <?php echo $_smarty_tpl->getVariable('Step')->value+1;?>
 - <?php echo $_smarty_tpl->getVariable('language')->value['Finish'];?>
 &gt;&gt;" id="NextStep" class="StepButton"  />
</div>
</form>

<script type="text/javascript">
$(document).ready(function() {
$('#CatalogID').val(location.pathname.replace('install/', "").substring(1).replace('index.php', ""));

function randomPassword(length){
   chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
   pass = "";
   for(x=0;x<length;x++)
   {
      i = Math.floor(Math.random() * 62);
      pass += chars.charAt(i);
   }
   return pass;
}
$('#GenerateID').click(function(){
$('#MD5KeyID').val(randomPassword(32));
});
$('#MD5KeyID').val(randomPassword(32));
});
</script>

<?php }?>
<?php if ($_smarty_tpl->getVariable('Step')->value==7){?>
<div id="FinallResult" class="Passed"><img src="themes/img/passed.gif" alt="Passed" class="ImgResult1" /> <?php echo $_smarty_tpl->getVariable('language')->value['Finish'];?>
</div>
<div class="ButtonArea">
	<form method="post" action="?Step=<?php echo $_smarty_tpl->getVariable('Step')->value+1;?>
">
	 <input type="submit" value="<?php echo $_smarty_tpl->getVariable('language')->value['Enter'];?>
" id="NextStep" class="StepButton" />
	</form>
</div>
<?php }?>

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