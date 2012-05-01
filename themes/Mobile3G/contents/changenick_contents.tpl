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
		{foreach from=$MiniMap item=Value name=minimap}
		{if $smarty.foreach.minimap.last}
		{$Value.Name}
		{else}
		<a href="{$URLS.Script}{$Value.Url|urlrepair|substr:1}">{$Value.Name}</a> <img src="{$UrlTheme}img/space.gif" />
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
			<form action="{$URLS.Script}{$FormPath}" method="post">
				{$language.Nick}:<br/>
				<input type="text" name="changenick[Nick]" value="{$User.Name}" class="StyleForm" style="width:90%;" onchange="ThemeClass.ValidateUser(this)"/>
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