{if $ErrorCode == 0}
<script type="text/javascript">
	location.href= rootDir+"System/Register/Success/";
</script>
{elseif  $ErrorCode==1 }
<script type="text/javascript"> 
	$('#ResultRegister').append(" {$language.IssetUser}!<br />");
	$('#ResultRegister').css("border", "1px solid #FF0000");
	document.forms['RegisterForm'].RegLogin.style.border = "2px solid #FF0000";
</script>
{elseif  $ErrorCode==2}
<script type="text/javascript"> 
	$('#ResultRegister').append(" {$language.UserIsBanned|sprintf:$Register}<br />");
	$('#ResultRegister').css("border", "1px solid #FF0000");
	document.forms['RegisterForm'].RegLogin.style.border = "2px solid #FF0000";
</script>
{elseif  $ErrorCode==3}
<script type="text/javascript"> 
	$('#ResultRegister').append(" {$language.BusyMail|sprintf:$Register}<br />");
	$('#ResultRegister').css("border", "1px solid #FF0000");
	document.forms['RegisterForm'].RegMail.style.border = "2px solid #FF0000";
</script>
{elseif  $ErrorCode==4}
<script type="text/javascript"> 
	$('#ResultRegister').append(" {$language.ExtendedError}<br />");
	$('#ResultRegister').css("border", "1px solid #FF0000");
	document.forms['RegisterForm'].RegLogin.style.border = "2px solid #FF0000";
</script>
{elseif  $ErrorCode==5}
<script type="text/javascript"> 
	$('#ResultRegister').append(" {$language.IllegalCharacters}<br />");
	$('#ResultRegister').css("border", "1px solid #FF0000");
	document.forms['RegisterForm'].RegLogin.style.border = "2px solid #FF0000";
</script>
{elseif  $ErrorCode==6}
<script type="text/javascript"> 
	$('#ResultRegister').append(" {$language.BadMail}<br />");
	$('#ResultRegister').css("border", "1px solid #FF0000");
	document.forms['RegisterForm'].RegMail.style.border = "2px solid #FF0000";
</script>
{elseif  $ErrorCode==7}
<script type="text/javascript"> 
	$('#ResultRegister').append(" {$language.BadCaptcha}<br />");
	$('#ResultRegister').css("border", "1px solid #FF0000");
	document.forms['RegisterForm'].captcha.style.border = "2px solid #FF0000";
	ReoladCaptcha();
</script> 
{/if}