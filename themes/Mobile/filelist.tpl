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
<!-- TEXT -->
{$Pager.0}
<table class="ZabraCell" summary="History Table" style="width : 100%; text-align: center;">
 <tr class="TableHeaderCell">
 <td>{$language.IDFile}</td>
 <td>{$language.FileName}</td>
 <td>{$language.AddedDate}</td>
 <td>{$language.Downloads}</td>
 <td>{$language.OwnerFile}</td>
 {if $ViewCode}
 <td>{$language.CodeToArticle}</td>
 {/if}
</tr>
{foreach from=$FileList item=FileArray}
 <tr class="TableCell">
	<td>{$FileArray.ID}</td>
	<td><a href="{$URLS.Script}File/{$FileArray.ID}">{$FileArray.FileName}.{$FileArray.Extension}</a></td>
	<td>{$FileArray.Date}</td>
	<td>{$FileArray.Downloads}</td>
	<td><a href="{$URLS.Script}Users/{$FileArray.UserFile|escape:'url'}/" >{$FileArray.UserFile}</a></td>
 {if $ViewCode}
	<td><input type="text" value="{$smarty.ldelim}{$smarty.ldelim}File:{$FileArray.ID}{$smarty.rdelim}{$smarty.rdelim}" /></td>
 {/if}
</tr>

{/foreach}



  </table>
{$Pager.1}
<!-- TEXT -->
</div>
</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->