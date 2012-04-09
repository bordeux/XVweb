{if  isset($Error)}
	$('.xvlogin-register-result').show("slow");
		{if  $Error== "IssetUser"}
			$('.xvlogin-register-result').append(" {$language.IssetUser}!<br />");
			$('.xvlogin-register-result').css("border", "1px solid #FF0000");
			$('[name="register[User]"]').css("border", "2px solid #FF0000");

		{elseif  $Error== "UserIsBanned"}

			$('.xvlogin-register-result').append(" {$language.UserIsBanned|sprintf:$Register}<br />");
			$('.xvlogin-register-result').css("border", "1px solid #FF0000");
			$('[name="register[User]"]').css("border", "2px solid #FF0000");

		{elseif  $Error== "MailUsed"}

			$('.xvlogin-register-result').append(" {$language.BusyMail|sprintf:$Register}<br />");
			$('.xvlogin-register-result').css("border", "1px solid #FF0000");
			$('[name="register[Mail]"]').css("border", "2px solid #FF0000");

		{elseif  $Error== "Error" or  $Error== "SQLError"}

			$('.xvlogin-register-result').append(" {$language.ExtendedError}<br />");
			$('.xvlogin-register-result').css("border", "1px solid #FF0000");
			$('[name="register[User]"]').css("border", "2px solid #FF0000");

		{elseif  $Error== "IllegalCharacters"}

			$('.xvlogin-register-result').append(" {$language.IllegalCharacters}<br />");
			$('.xvlogin-register-result').css("border", "1px solid #FF0000");
			$('[name="register[User]"]').css("border", "2px solid #FF0000");

		{elseif  $Error== "BadMail"}

			$('.xvlogin-register-result').append(" {$language.BadMail}<br />");
			$('.xvlogin-register-result').css("border", "1px solid #FF0000");
			$('[name="register[Mail]"]').css("border", "2px solid #FF0000");

		{elseif  $Error== "BadCaptcha"}

			$('.xvlogin-register-result').append(" {$language.BadCaptcha}<br />");
			$('.xvlogin-register-result').css("border", "1px solid #FF0000");
			$('[name="register[Captcha]"]').css("border", "2px solid #FF0000");
			ReoladCaptcha();

		{/if}
		{else}
			location.href= rootDir+"System/Registration/Email_sent/";
	{/if}