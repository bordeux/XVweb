<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$language.Step} {$Step} </title>
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
{if $Step == 1}

<h1>{$language.Welcome}</h1> 
<form method="post" action="?Step={$Step+1}">
{$language.SelectLangMSG} : {html_options name=Lang options=$LangList selected=$SelecedLang}<br />
<div class="ButtonArea">
<input type="submit" value="{$language.Step} 2 &gt;&gt;" class="StepButton"/>
</div>
</form>
{/if}
{if $Step ==2}
<form method="post" action="?Step={$Step+1}">
<h1>{$language.Step} {$Step} - {$language.License} </h1> 
<iframe src="license.txt" scrolling="yes" name="License" style="width:100%; height:600px;"></iframe>
<input type="checkbox" name="LicenseAcept" id="LicenseAceptID" value="Acept" /> <label for="LicenseAceptID">{$language.AceptLicenseMSG}</label>
<div class="ButtonArea">
<input type="button" value="&lt;&lt; {$language.Step} {$Step-1}" onclick="location.href='?Step={$Step-1}';" class="StepButton"/> <input type="submit" value="{$language.Step} {$Step+1} &gt;&gt;" class="StepButton" /> 
</div>
<form>
{/if}
{if $Step ==3}
<h1>{$language.Step} {$Step} - {$language.CscMSG} </h1> 
<div class="tablediv" style="width:500px;">
{foreach from=$CheckResult key=KeyGrup item=CheckGrup}
	<div class="table-row">
		<div class="table-cell"><h1>{$KeyGrup}</h1></div>
	</div>
	{foreach from=$CheckGrup key=KeyItemGrup item=CheckItemGrup name=CheckItemName}
	<div class="table-row" {if $smarty.foreach.CheckItemName.index%2 == 0}style="background:#DFDFDF;"{/if}>
		<div class="table-cell">{$CheckItemGrup.Name}</div>
		<div class="table-cell">
		{if $CheckItemGrup.Result}
		<img src="themes/img/passed.gif" alt="{$language.Passed}" class="ImgResult{$CheckItemGrup.Result}" />
		{else}
		<img src="themes/img/failed.gif" alt="{$language.Failed}" class="ImgResult{$CheckItemGrup.Result}" />
		{/if}
		</div>
	</div>
	{/foreach}
{/foreach}
</div>
<div id="FinallResult"></div>
<div class="ButtonArea">
	<form method="post" action="?Step={$Step+1}">
		<input type="button" value="&lt;&lt; {$language.Step} {$Step-1}" onclick="location.href='?Step={$Step-1}';" class="StepButton"/> <input type="submit" value="{$language.Step} {$Step+1} &gt;&gt;" id="NextStep" class="StepButton" />
	</form>
</div>

{literal}
<script type="text/javascript">

$(document).ready(function() {
	if($('.ImgResult').size()){
		$('#FinallResult').addClass("Failed").text("{/literal}{$language.Failed}{literal}");
		$('#NextStep').attr("disabled", true);
		} else {
		$('#FinallResult').addClass("Passed").text("{/literal}{$language.Passed}{literal}");
		};
});

</script>
{/literal}
{/if}

{if $Step == 4}
<h1>{$language.Step} {$Step} - {$language.MySQLConfig} </h1> 
<form method="post" action="?Step={$Step+1}">
<div class="tablediv" style="width:500px;">
	<div class="table-row">
		<div class="table-cell"><h1>{$MySQLConfig}</h1></div>
	</div>
	<div class="table-row" style="background:#DFDFDF;">
		<div class="table-cell">{$language.Server}</div>
		<div class="table-cell"> <input type="text" name="Server" id="ServerID" value="{$smarty.session.DataBase.Server|default:'localhost'}"/> </div>
	</div>
	<div class="table-row">
		<div class="table-cell">{$language.DataBase}</div>
		<div class="table-cell"> <input type="text" name="DataBase"  id="DataBaseID" value="{$smarty.session.DataBase.DataBase}"/> </div>
	</div>
	<div class="table-row" style="background:#DFDFDF;">
		<div class="table-cell">{$language.User}</div>
		<div class="table-cell"> <input type="text" name="User" id="UserID" value="{$smarty.session.DataBase.User}"/> </div>
	</div>
	<div class="table-row">
		<div class="table-cell">{$language.Password}</div>
		<div class="table-cell"> <input type="password" name="Password" id="PasswordID" value="{$smarty.session.DataBase.Password}"/> </div>
	</div>
	<div class="table-row" style="background:#DFDFDF;">
		<div class="table-cell">{$language.Prefix}</div>
		<div class="table-cell"> <input type="text" name="Prefix" value="{$smarty.session.DataBase.Prefix|default:'xv_'}" /> </div>
	</div>
	<div class="table-row">
		<div class="table-cell"><input type="button" value="{$language.Check}" class="StyleForm" id="CheckButton"/></div>
		<div class="table-cell" id="CheckResult">  </div>
	</div>
</div>

<div class="ButtonArea">

		<input type="button" value="&lt;&lt; {$language.Step} {$Step-1}" onclick="location.href='?Step={$Step-1}';" class="StepButton"/> <input type="submit" value="{$language.Step} {$Step+1} &gt;&gt;" id="NextStep" class="StepButton" disabled="disabled" />
</div>
	</form>
{literal}
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
{/literal}
{/if}
{if $Step == 5}
<h1>{$language.Step} {$Step} - {$language.MySQlResult} </h1> 
{if $MySQLResult.Result}
<div id="FinallResult" class="Passed"><img src="themes/img/passed.gif" alt="Passed" class="ImgResult1" /> {$language.Passed}</div>
{else}
<div id="FinallResult" class="Failed">
{$language.Failed}<br/>
<span class="NormalSize">{$language.Error} : {$MySQLResult.Code}</span>
<span class="NormalSize">{$language.Message} : {$MySQLResult.Message}</span>
</div>
{/if}
<div class="ButtonArea">
	<form method="post" action="?Step={$Step+1}">
		<input type="button" value="&lt;&lt; {$language.Step} {$Step-1}" onclick="location.href='?Step={$Step-1}';" class="StepButton"/> <input type="submit" value="{$language.Step} {$Step+1} &gt;&gt;" id="NextStep" class="StepButton" {if !$MySQLResult.Result}disabled="disabled"{/if} />
	</form>
</div>
{/if}
{if $Step == 6}
<h1>{$language.Step} {$Step} - {$language.Configuration} </h1> 
<form method="post" action="?Step={$Step+1}">
<div class="tablediv" style="width:500px;">
	<div class="table-row">
		<div class="table-cell"><h2>{$language.CMSConsts}</h2></div>
	</div>
	<div class="table-row">
		<div class="table-cell">{$language.Catalog}</div>
		<div class="table-cell"> <input type="text" name="Catalog"  id="CatalogID" value="{$smarty.session.Config.Catalog}"/> </div>
	</div>
	<div class="table-row">
		<div class="table-cell">{$language.MD5Key}</div>
		<div class="table-cell"> <input type="text" name="MD5Key"  id="MD5KeyID" value="{$smarty.session.Config.MD5Key}"/> <input type="button" value="{$language.Generate}" id="GenerateID" class="StyleForm"/></div>
	</div>
	<div class="table-row">
		<div class="table-cell">{$language.SiteName}</div>
		<div class="table-cell"> <input type="text" name="SiteName"  id="SiteNameID" value="{$smarty.session.Config.SiteName}"/> </div>
	</div>
	<div class="table-row">
		<div class="table-cell">{$language.LanguageWord}</div>
		<div class="table-cell"> {html_options name=SiteLang options=$Listing.Lang selected=$language.Lang} </div>
	</div>
	<div class="table-row">
		<div class="table-cell"><h2>{$language.Administrator}</h2></div>
	</div>
	<div class="table-row">
		<div class="table-cell">{$language.Login}</div>
		<div class="table-cell"> <input type="text" name="Login"  id="LoginID" value="{$smarty.session.Config.Login}"/> </div>
	</div>
	<div class="table-row">
		<div class="table-cell">{$language.Password}</div>
		<div class="table-cell"> <input type="password" name="LPassword"  id="LoginID" value="{$smarty.session.Config.LPassword}"/> </div>
	</div>
	<div class="table-row">
		<div class="table-cell">{$language.Mail}</div>
		<div class="table-cell"> <input type="text" name="Mail"  id="MailID" value="{$smarty.session.Config.Password}"/> </div>
	</div>
</div>
<div class="ButtonArea">
		<input type="button" value="&lt;&lt; {$language.Step} {$Step-1}" onclick="location.href='?Step={$Step-1}';" class="StepButton"/><input type="submit" value="{$language.Step} {$Step+1} - {$language.Finish} &gt;&gt;" id="NextStep" class="StepButton"  />
</div>
</form>
{literal}
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
{/literal}
{/if}
{if $Step == 7}
<div id="FinallResult" class="Passed"><img src="themes/img/passed.gif" alt="Passed" class="ImgResult1" /> {$language.Finish}</div>
<div class="ButtonArea">
	<form method="post" action="?Step={$Step+1}">
	 <input type="submit" value="{$language.Enter}" id="NextStep" class="StepButton" />
	</form>
</div>
{/if}

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