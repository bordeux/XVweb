{if $Result == 'Success'}
<center>
<table>
	<tr>
		<td><img src="{$UrlTheme}img/success.png" /></td>
		<td>
		<p align="center">{$language.Success}</p>
		<p align="center"><input type="button" onclick="ThemeClass.Refresh();" value="{$language.Send}" class="StyleForm"/></p>
		</td>
	</tr>
</table></center>
{elseif $Result == 'Failed'}

<center><table border='0'>
	<tr>
	<td><img src='{$UrlTheme}img/cancel.png' /></td>
	<td>
		<p align='center'>{$language.Error}</p>
		<p align="center"><input type="button" onclick="ThemeClass.Refresh();" value="{$language.Send}" class="StyleForm"/></p>
	</td>
	</tr>
</table></center>

{else} {*AccessDenied*}
<center><table border='0'>
	<tr>
	<td><img src='{$UrlTheme}img/cancel.png' /></td>
	<td>
		<p align='center'>{$language.AccessDenied}</p>
		<p align="center"><input type="button" onclick="ThemeClass.Refresh();" value="{$language.Send}" class="StyleForm"/></p>
	</td>
	</tr>
</table></center>

{/if}