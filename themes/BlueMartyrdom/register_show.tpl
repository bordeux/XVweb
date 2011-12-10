{if  isset($Error)}
{if  $Error== "IssetUser"}
<script type="text/javascript"> 
	$('#ResultRegister').append(" {$language.IssetUser}!<br />");
	$('#ResultRegister').css("border", "1px solid #FF0000");
	$('#RegLogin').css("border", "2px solid #FF0000");
</script>
{elseif  $Error== "UserIsBanned"}
<script type="text/javascript"> 
	$('#ResultRegister').append(" {$language.UserIsBanned|sprintf:$Register}<br />");
	$('#ResultRegister').css("border", "1px solid #FF0000");
	$('#RegLogin').css("border", "2px solid #FF0000");
</script>
{elseif  $Error== "MailUsed"}
<script type="text/javascript"> 
	$('#ResultRegister').append(" {$language.BusyMail|sprintf:$Register}<br />");
	$('#ResultRegister').css("border", "1px solid #FF0000");
	$('#RegMail').css("border", "2px solid #FF0000");
</script>
{elseif  $Error== "Error" or  $Error== "SQLError"}
<script type="text/javascript"> 
	$('#ResultRegister').append(" {$language.ExtendedError}<br />");
	$('#ResultRegister').css("border", "1px solid #FF0000");
	$('#RegLogin').css("border", "2px solid #FF0000");
</script>
{elseif  $Error== "IllegalCharacters"}
<script type="text/javascript"> 
	$('#ResultRegister').append(" {$language.IllegalCharacters}<br />");
	$('#ResultRegister').css("border", "1px solid #FF0000");
	$('#RegLogin').css("border", "2px solid #FF0000");
</script>
{elseif  $Error== "BadMail"}
<script type="text/javascript"> 
	$('#ResultRegister').append(" {$language.BadMail}<br />");
	$('#ResultRegister').css("border", "1px solid #FF0000");
	$('#RegMail').css("border", "2px solid #FF0000");
</script>
{elseif  $Error== "BadCaptcha"}
<script type="text/javascript"> 
	$('#ResultRegister').append(" {$language.BadCaptcha}<br />");
	$('#ResultRegister').css("border", "1px solid #FF0000");
	$('#captcha').css("border", "2px solid #FF0000");
	ReoladCaptcha();
</script>
{/if}
{else}
<script type="text/javascript">
	location.href= rootDir+"System/Register/Success/";
</script>
{/if}