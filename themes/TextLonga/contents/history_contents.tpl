<!-- Content -->
 <div id="Content">
 {if $Advertisement}
	<div class="reklamo" id="RTop">
		{$smarty.capture.ADVHeight}
	</div>
{/if}
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
	<div id="EditPanel" class="ui-tabs ui-widget ui-widget-content ui-corner-top">		
		<div class="xv-title-wrapper" style="text-align:center;">
				<div class="xv-link-map" style="float:left; position:absolute;">
				{foreach from=$MiniMap item=Value name=minimap}
					{if $smarty.foreach.minimap.last}
						{$Value.Name}
					{else}
						<a href="{$UrlScript}{$Value.Url|replace:' ':'_'|urlrepair|substr:1}">{$Value.Name}</a> >>
					{/if}
				{/foreach}
			</div>
			
			<h1 class="xv-topic">{$SiteTopic}</h1>
		</div>
	</div>
<div class="xv-text-wrapper xv-table">
<!-- TEXT -->
<table summary="History Table" >
<thead>
	<tr class="TableHeaderCell" style="height : 30px;">
		<td>{$language.Diff}</td>
		<td>{$language.Topic}</td>
		<td>{$language.Date}</td>
		<td>{$language.Version}</td>
		<td>{$language.Author}</td>
		<td>{$language.DescriptionOfChange}</td>
	</tr>
</thead>
<tbody>
	{foreach from=$History item=HistoryArray}
	<tr class="TableCell">
		<td><input type="radio" name="OldVer" value="{$HistoryArray.Version}"/> <input type="radio" name="NewVer" value="{$HistoryArray.Version}"/></td>
		<td>{$HistoryArray.Topic}</td>
		<td><a href="{$UrlScript}{$ArticleURL|substr:1|replace:' ':'_'}?version={$HistoryArray.Version}">{$HistoryArray.Date}</a></td>
		<td>{$HistoryArray.Version}</td>
		<td><a href="{$UrlScript}Users/{$HistoryArray.Author|urlrepair}/">{$HistoryArray.Author}</a></td>
		<td>{$HistoryArray.DescriptionOfChange}</td>
	</tr>
	{/foreach}
</tbody>
	<tr class="TableCell">
		<td><input type="button" value="Porownaj" class="StyleForm" onclick="location.href = URLS.Script+'history/diff/{$ArticleID}/'+$('[name=OldVer]:checked').val()+'/'+$('[name=NewVer]:checked').val()+'/';" /></td>
	</tr>
</table>
<!-- TEXT -->
</div>

</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->