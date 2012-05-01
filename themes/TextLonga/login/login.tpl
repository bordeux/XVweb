<!-- Content -->
 <div id="Content">
<div id="ContentDiv">
	{if $smarty.get.msg}
		<div class="{if $smarty.get.success}success{else}failed{/if}">
		{if $smarty.get.title}<h2>{$smarty.get.title|escape:"html"}</h2>{/if}
			{$smarty.get.msg|escape:"html"}
			{if $smarty.get.list}
			<ul>
				{foreach from=$smarty.get.list item=Value name=minimap}
				<li>{$Value|escape:"html"}</li>
				{/foreach}
			</ul>
			{/if}
		</div>
	{/if}

<div class="xv-text-wrapper">
{if $login_success}
	<div class="success">{$login_config->login_success_message}</div>
{else}
	<form action="{$URLS.Script}Login/" method="post">
	<div class="xv-login-content">
		{if $login_config->login_message}
			<div class="xv-info">{$login_config->login_message}</div>
		{/if}
		
		
		{if $login_error}
			<div class="error">{$login_error_msg|xv_lang:$login_error_msg}</div>
		{/if}

		<table>
			<tr>
				<td>{$language.Nick}:</td>
				<td><input {if $login_error && ($login_error_msg == 'invalid_username')}class="xv_login_error"{/if} type="text" value="{$smarty.post.xv_login.nick}" name="xv_login[nick]" placeholder="Your username..."/></td>
				<td></td>
			</tr>						
			<tr>
				<td>{$language.Password}:</td>
				<td><input type="password" {if $login_error && ($login_error_msg == 'wrong_password')}class="xv_login_error"{/if}  value="" name="xv_login[password]"/>
				</td>

			</tr>				
			<tr>
				<td style="font-size: 10px;">{"remember_password"|xv_lang}: </td>
				<td><input type="checkbox" name="xv_login[remember]" id="xv-login-remember" value="true" /></td>

			</tr>			
				
			{if $login_config->captcha_protection}
				<tr>
					<td><iframe src="{$URLS.Script}Captcha/iframe" style="width: 120px; height:45px;" scrolling="no">
						<a href="{$URLS.Script}Captcha/iframe">Get captcha code without iframe</a>
					</iframe>
					</td>
					<td><span>Captcha:</span><input  type="text" name="xv_captcha" {if $login_error && ($login_error_msg == 'invalid_captcha')}class="xv_login_error"{/if} /> </td>
				</tr>		
			{/if}
			<tr>
				<td><input type="hidden"  name="xv_sid" value="{$JSVars.SIDUser}" /></td>
				<td><input type="submit" name="xv_login[submit]" value="{'Send'|xv_lang}" /></td>
			</tr>
		</table>
		<div style="float:right;"><a href="{$URLS.Script}Forgot/">{"forgot_password"|xv_lang}</a></div>
	</div>
	</form>
	
	{/if}
	
</div>
		

<!-- TEXT -->
<div style="clear:both;"></div>
</div>

</div>
<div style="clear:both;"></div>
<script type="text/javascript" src="{$URLS.Theme}login/js/login.js" charset="UTF-8"> </script>
 <!-- /Content -->