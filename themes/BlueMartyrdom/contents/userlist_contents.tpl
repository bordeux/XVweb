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
		<a href="{$UrlScript}{$Value.Url|urlrepair|substr:1}">{$Value.Name}</a> <img src="{$UrlTheme}img/space.gif" />
		{/if}
		{/foreach}
		</div>
<div id="EditPanel">{$EditPanel}</div>
<div id="TextDiv">
<!--text-->
{$Pager.0}
<table class="ZabraCell" summary="History Table" style="width : 100%; text-align: center;">
	<tr class="TableHeaderCell">
		<th> </th>
		<th>{$language.User}</th>
		<th>{$language.CreatedDateAccount}</th>
		<th>{$language.GaduGadu}</th>
		<th>{$language.WhereFrom}</th>
	</tr>
	{foreach from=$UserList item=UserArray}
	<tr class="TableCell">
		<td>
			<a href="{$UrlScript}Users/{$UserArray.User|urlrepair}"><img src="{$AvantsURL}{if $UserArray.Avant}{$UserArray.User}{/if}_16.jpg" alt="{$UserArray.User}"/></a>
			{if $UserArray.OpenID}<a href="{$UserArray.OpenID}"> <img src="{$UrlTheme}img/icon_openid.gif" /></a>{/if}
		</td>
		<td>
		<a href="{$UrlScript}Users/{$UserArray.User|urlrepair}">{$UserArray.User}</a>
		</td>
		<td>{$UserArray.Creation}</td>
		<td>{if $UserArray.GaduGadu}<a href="gg:{$UserArray.GaduGadu}"><img src="http://status.gadu-gadu.pl/users/status.asp?id={$UserArray.GaduGadu}&amp;styl=0" title="{$UserArray.GaduGadu}" alt="{$UserArray.GaduGadu}" /> {$UserArray.GaduGadu}</a>{/if}</td>
		<td>{$UserArray.WhereFrom}</td>
	</tr>
	{/foreach}
</table>
{$Pager.1}
</div>
</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->