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
{if $register_success}
	<div class="success">{$register_config->register_success_message}</div>
{else}
	<form action="{$URLS.Script}Register/" method="post">
	<div class="xv-register-content">
		{if $register_config->register_message}
			<div class="xv-info">{$register_config->register_message}</div>
		{/if}
		
		
		{if $register_error}
			<div class="error">{$register_error_msg|xv_lang:$register_error_msg}</div>
		{/if}
{if $register_config->register_enabled}
		<table>
			<tr>
				<td>{$language.Nick}:</td>
				<td><input {if $register_error && ($register_error_msg == 'invalid_username' || $register_error_msg == "username_exsist")}class="xv_register_error"{/if} type="text" value="{$smarty.post.xv_register.nick}" name="xv_register[nick]" placeholder="Your login..."/></td>
				<td></td>
			</tr>			
			<tr>
				<td>{$language.Mail}:</td>
				<td><input type="email" {if $register_error && ($register_error_msg == 'wrong_email')}class="xv_register_error"{/if} name="xv_register[email]" value="{$smarty.post.xv_register.email}" placeholder="sample@abc.com"/></td>
				<td></td>
			</tr>			
			<tr>
				<td>{$language.Password}:</td>
				<td><input type="password" {if $register_error && ($register_error_msg == 'password_too_short')}class="xv_register_error"{/if}  value="{$smarty.post.xv_register.password}" name="xv_register[password]"/><span class="xv-register-time"></span></td>
				<td></td>
			</tr>			
			<tr>
				<td>{$language.RewritePassword}:</td>
				<td><input type="password" name="xv_register[rpassword]"  value="{$smarty.post.xv_register.rpassword}" /></td>
			</tr>			
			{if $register_config->captcha_protection}
			<tr>
				<td><iframe src="{$URLS.Script}Captcha/iframe" style="width: 120px; height:45px;" scrolling="no">
					<a href="{$URLS.Script}Captcha/iframe">Get captcha code without iframe</a>
				</iframe>
				</td>
				<td><span>Captcha:</span><input  type="text" name="xv_captcha" {if $register_error && ($register_error_msg == 'invalid_captcha')}class="xv_register_error"{/if} /> </td>
			</tr>		
			{/if}
			<tr>
				<td><input type="hidden"  name="xv_sid" value="{$JSVars.SIDUser}" /></td>
				<td><input type="submit" name="xv_register[submit]" value="{$language.Send}" /></td>
			</tr>
		</table>
		{/if}
	</div>
	</form>
	{/if}
</div>
		

<!-- TEXT -->
<div style="clear:both;"></div>
</div>

</div>
<div style="clear:both;"></div>
<script type="text/javascript" src="{$URLS.Theme}register/js/jquery.pwdstr-1.0.source.js" charset="UTF-8"> </script>
<script type="text/javascript" src="{$URLS.Theme}register/js/register.js" charset="UTF-8"> </script>
 <!-- /Content -->