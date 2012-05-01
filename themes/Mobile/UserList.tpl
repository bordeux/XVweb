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
		<a href="{$URLS.Script}{$Value.Url|urlrepair|substr:1}">{$Value.Name}</a> <img src="{$UrlTheme}img/space.gif" />
		{/if}
		{/foreach}
		</div>
<div id="EditPanel">{$EditPanel}</div>
<div id="TextDiv">
<!--text-->
{$Pager.0}
<table class="ZabraCell" summary="History Table" style="width : 100%; text-align: center;">
	<tr class="TableHeaderCell">
		<td> </td>
		<td>{$language.User}</td>
		<td>{$language.CreatedDateAccount}</td>
		<td>{$language.GaduGadu}</td>
	<td>{$language.WhereFrom}</td>

	</tr>
	{foreach from=$UserList item=UserArray}
	<tr class="TableCell">
		<td>
			<a href="{$URLS.Script}Users/{$UserArray.User|urlrepair}"><img src="{$AvantsURL}{if $UserArray.Avant}{$UserArray.User}{/if}_16.jpg" alt="{$UserArray.User}"/></a>
			{if $UserArray.OpenID}<a href="{$UserArray.OpenID}"> <img src="{$UrlTheme}img/icon_openid.gif" /></a>{/if}
		</td>
		<td>
		<a href="{$URLS.Script}Users/{$UserArray.User|urlrepair}">{$UserArray.User}</a>
		</td>
		<td>{$UserArray.Creation}</td>
		<td><a href="gg:{$UserArray.GaduGadu}"><img src="http://status.gadu-gadu.pl/users/status.asp?id={$UserArray.GaduGadu}&amp;styl=0" title="{$UserArray.GaduGadu}" alt="{$UserArray.GaduGadu}" /> {$UserArray.GaduGadu}</a></td>
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