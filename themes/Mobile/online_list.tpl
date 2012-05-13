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
{$Pager.0}
<table class="ZabraCell" summary="History Table" style="width : 100%; text-align: center;">
 <tr class="TableHeaderCell">
 
 {if $smarty.get.Sort == "desc"}
{assign var='SmartySort' value='asc'}
 {else}
 {assign var='SmartySort' value='desc'}
 {/if}
 <td><a href='?{add_get_var value="SortBy=IP&Sort=$SmartySort"}'>{$language.AdressIP}</a></td>
 <td><a href='?{add_get_var value="SortBy=User&Sort=$SmartySort"}'>{$language.User}</a></td>
 <td><a href='?{add_get_var value="SortBy=Url&Sort=$SmartySort"}'>{$language.URL}</a></td>
 <td><a href='?{add_get_var value="SortBy=Info&Sort=$SmartySort"}'>{$language.Info}</a></td>

</tr>
{foreach from=$OnlineList item=OnlineArray}
 <tr class="TableCell">
  <td>{$OnlineArray.IP}</td>
  <td><a href="{$URLS.Script}Users/{$OnlineArray.UserLoged|urlrepair}">
	  {$OnlineArray.UserLoged}
	  </a>
   </td>
	  
  <td><a href="{$OnlineArray.UrlLocation}" >{$OnlineArray.UrlLocation}</a></td>
  <td>{$OnlineArray.Browser}</td>

</tr>

{/foreach}



  </table>
{$Pager.1}

</div>
</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->