  <!-- Content -->
 <div id="Content">
 <div id="TitleDiv">
 {$SiteTopic}
 </div>
<div id="ContentDiv">
		<div id="MiniMap">
		{foreach from=$MiniMap item=Value name=minimap}
		{if $smarty.foreach.minimap.last}
		{$Value.Name}
		{else}
		<a href="{$UrlScript}{$Value.Url|urlrepair|substr:1}">{$Value.Name}</a> <img src="{$UrlTheme}img/space.gif" />
		{/if}
		{/foreach}
		</div>
<div id="EditPanel">{$EditPanel}</div>
<div id="TextDiv">
<!-- TEXT -->
				<div style="text-align: center;">

	<div style="float:left; padding-top:2%" class="LightBulbTip">
Przykro mi, ale musisz zmienić nick! Być może jest on zajęty,<br /> lub są w nim niedozwolne znaki.
	</div>
				
	<div style="float:left; margin-left:10px; width:200px; height:100px; border: 1px solid #133877;">
		<div style="margin-top:20px;">
			<form action="{$UrlScript}OpenID/NewNick" method="post">
				{$language.Nick}:<br/>
				<input type="text" name="OpenIDNick" value="{$User.Name}" class="StyleForm" style="width:90%;" onchange="ThemeClass.ValidateUser(this)"/>
				<br />
				<input type="submit" class="StyleForm" value="{$language.Send}" style="margin-top:5px;" />
			</form>
		</div>
	</div>
				
				
				<div style="clear:both;"></div>
	</div>
<!-- TEXT -->
</div>

</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->