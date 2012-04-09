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
	<form action="{$URLS.Script}Register/" method="post">
	<div class="xv-register-content">
		{if $register_config->register_message}
			<div class="xv-info">{$register_config->register_message}</div>
		{/if}
		<table>
			<tr>
				<td>{$language.Nick}:</td>
				<td><input type="text" name="xv-register[nick]"/></td>
				<td></td>
			</tr>			
			<tr>
				<td>{$language.Mail}:</td>
				<td><input type="email" name="xv-register[email]" /></td>
				<td></td>
			</tr>			
			<tr>
				<td>{$language.Password}:</td>
				<td><input type="password" name="xv-register[password]"/><span class="xv-register-time"></span></td>
				<td></td>
			</tr>			
			<tr>
				<td>{$language.RewritePassword}:</td>
				<td><input type="password" name="xv-register[rpassword]" /></td>
			</tr>		
			<tr>
				<td></td>
				<td><input type="submit" name="xv-register[submit]" value="{$language.Send}" /></td>
			</tr>
		</table>
	</div>
	</div>
</div>
		

<!-- TEXT -->
<div style="clear:both;"></div>
</div>

</div>
<div style="clear:both;"></div>
<script type="text/javascript" src="{$URLS.Theme}register/js/jquery.pwdstr-1.0.source.js" charset="UTF-8"> </script>
<script type="text/javascript" src="{$URLS.Theme}register/js/register.js" charset="UTF-8"> </script>
 <!-- /Content -->