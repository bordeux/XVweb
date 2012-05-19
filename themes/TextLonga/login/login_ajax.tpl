<div style=" color: #000; width: 640px; text-align:center; margin:auto;">
	<form action="{$URLS.Script}Login/" method="post">
	<div class="xv-login-content">
		{if "login_message"|xv_lang}
			<div class="xv-info">{"login_message"|xv_lang}</div>
		{/if}
		
		
		{if $login_error}
			<div class="error">{$login_error_msg|xv_lang:$login_error_msg}</div>
		{/if}

		<table style="margin: 20px;">
			<tr>
				<td>{$language.Nick}:</td>
				<td><input {if $login_error && ($login_error_msg == 'invalid_username')}class="xv_login_error"{/if} type="text" value="{$smarty.post.xv_login.nick}" name="xv_login[nick]" placeholder="Your username..."/></td>
				<td style="padding-left: 30px">{$language.Password}:</td>
				<td><input type="password" {if $login_error && ($login_error_msg == 'wrong_password')}class="xv_login_error"{/if}  value="" name="xv_login[password]"/> <input type="checkbox" name="xv_login[remember]" id="xv-login-remember" value="true" title="{"remember_password"|xv_lang}"/></td>
											
			{if $login_config->captcha_protection}
				
					<td>
						<iframe src="{$URLS.Script}Captcha/iframe" style="width: 120px; height:45px;" scrolling="no">
							<a href="{$URLS.Script}Captcha/iframe">Get captcha code without iframe</a>
						</iframe>
					</td>
					<td><span>Captcha:</span><input  type="text" name="xv_captcha" {if $login_error && ($login_error_msg == 'invalid_captcha')}class="xv_login_error"{/if} /> </td>
						
			{/if}
	
				<td><input type="hidden"  name="xv_sid" value="{$JSVars.SIDUser}" /></td>
				<td><input type="submit" name="xv_login[submit]" value="{'Send'|xv_lang}" /></td>
			</tr>
		</table>
	</div>
	</form>
</div>