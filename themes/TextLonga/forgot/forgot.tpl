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
{if $forgot_success}
	<div class="success">{$forgot_config->forgot_success_message}</div>
{else}
	<form action="{$URLS.Script}forgot/" method="post">
	<div class="xv-forgot-content">
		{if $forgot_config->forgot_message}
			<div class="xv-info">{$forgot_config->forgot_message}</div>
		{/if}
		
		
		{if $forgot_error}
			<div class="error">{$forgot_error_msg|xvLang:$forgot_error_msg}</div>
		{/if}
{if $forgot_config->forgot_enabled}
		<table>
			<tr>
				<td>{$language.Nick}:</td>
				<td><input {if $forgot_error && ($forgot_error_msg == 'invalid_username' )}class="xv_forgot_error"{/if} type="text" value="{$smarty.post.xv_forgot.nick}" name="xv_forgot[nick]" placeholder="Your login..."/></td>
				<td></td>
			</tr>						
			{if $forgot_config->captcha_protection}
			<tr>
				<td><iframe src="{$URLS.Script}Captcha/iframe" style="width: 120px; height:45px;" scrolling="no">
					<a href="{$URLS.Script}Captcha/iframe">Get captcha code without iframe</a>
				</iframe>
				</td>
				<td><span>Captcha:</span><input  type="text" name="xv_captcha" {if $forgot_error && ($forgot_error_msg == 'invalid_captcha')}class="xv_forgot_error"{/if} /> </td>
			</tr>		
			{/if}
			<tr>
				<td><input type="hidden"  name="xv_sid" value="{$JSVars.SIDUser}" /></td>
				<td><input type="submit" name="xv_forgot[submit]" value="{$language.Send}" /></td>
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
<script type="text/javascript" src="{$URLS.Theme}forgot/js/jquery.pwdstr-1.0.source.js" charset="UTF-8"> </script>
<script type="text/javascript" src="{$URLS.Theme}forgot/js/forgot.js" charset="UTF-8"> </script>
 <!-- /Content -->