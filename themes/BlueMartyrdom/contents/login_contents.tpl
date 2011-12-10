<!-- Content -->
<div id="Content">
{if $Advertisement}
	<div class="reklamo" id="RTop">
		{$smarty.capture.ADVHeight}
	</div>
{/if}
	<div id="TitleDiv">
		 {$SiteTopic}
	</div>
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
		<div id="MiniMap">
			 {foreach from=$MiniMap item=Value name=minimap} {if $smarty.foreach.minimap.last} {$Value.Name} {else} <a href="{$UrlScript}{$Value.Url|urlrepair|substr:1}">{$Value.Name}</a><img src="{$UrlTheme}img/space.gif" />
			{/if} {/foreach}
		</div>
		<div id="EditPanel">
			 {$EditPanel}
		</div>
		<div id="TextDiv">
			<!-- TEXT -->
			<div id="LoginDiv">
				<div class="LightBulbTip" style="text-align:center;">
					<form id='LoginForm' name='LoginForm' method='post' onsubmit='ThemeClass.SendLoged(); return false;'>
						<br />
						<label for='textinput'>{$language.Nick}:</label>
						<br />
						<input type='text' class='StyleForm' name='LoginLogin' id='LoginLogin' size='12' />
						<br />
						<label for='passwordinput'>{$language.Password}</label>
						<br />
						<input type='password' class='StyleForm' type='text' name='LoginPassword' id='LoginPassword' size='20' />
						<br />
						<input type='checkbox' value='true' name='LoginRemember' id='LoginRememberID' />
						<label for="LoginRememberID">{$language.RememberPassword} </label>
						<br />
						<br />
						<input type='submit' name='ButtonOk' value='{$language.Send}' class='StyleForm' onclick='ThemeClass.SendLoged(); return false;' />
					</form>
				</div>
			</div>
			<!-- TEXT -->
		</div>
	</div>
</div>
<div style="clear:both;">
</div>
<!-- /Content -->