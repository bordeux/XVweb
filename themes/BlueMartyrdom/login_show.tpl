{if $action == "signin"}
	{if $LogedReturn}<center>
	<table>
		<tr>
			<td><img src="{$UrlTheme}img/success.png" /></td>
			<td><p align="center"><span style="font-size: 14px;"><b>{$LogedUser|string_format:$language.LogegedSuccessGreeting}</b><br/>
			<br />
			{$language.LogegedSuccessContent}<br/><br/>
			<input type="button" onclick="location.reload(); return false;" value="{$language.Enter}" class="StyleForm" />
	</span></p></td>
		</tr>
	</table></center>
	{else}
	<center><table border='0'>
		<tr>
		<td><img src='{$UrlTheme}img/cancel.png' /></td>
		<td>
			<p align='center'>
			{if $LogedError == 1}
			<span style='color:#FF0000; font-weight:bold;'>{$language.LogegedBadLogin}</span>
			{else}
			<span style='color:#FF0000; font-weight:bold;'>{$language.LogegedBadPassword}</span>
			{/if}
			
			<form id='LoginForm' name='LoginForm' method='post' onsubmit='ThemeClass.SendLoged(); return false;'>
	<br />
	<label for='textinput'>{$language.Nick}:</label>
	<br />
	<input type='text' class='StyleForm' name='LoginLogin' id='LoginLogin' size='12' />
	<br />
	<label for='passwordinput'>{$language.Password}</label>
	<br />
	<input type='password' class='StyleForm' type='text' name='LoginPassword' id='LoginPassword' size='20' />
	<br /><input type='checkbox' value='true' name='LoginRemember' id='LoginRememberID' />
	<label for="LoginRememberID">{$language.RememberPassword} </label>
	<br /><br />
	<input type='submit' name='ButtonOk' value='{$language.Send}' class='StyleForm' onclick='ThemeClass.SendLoged(); return false;' />
	</form>

			</p></td>
		</tr>
	</table></center>
	{/if}
{else}
{$JSBinder[22]="SingIn"}
{include file="header.tpl"}
{include file="menu.tpl"}
{include file="contents/login_contents.tpl"}
{include file="footer.tpl"}
{/if}