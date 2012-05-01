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
		<a href="{$URLS.Script}{$Value.Url|replace:' ':'_'|urlrepair|substr:1}">{$Value.Name}</a> <img src="{$UrlTheme}img/space.gif" />
		{/if}
		{/foreach}
		</div>
<div id="EditPanel">{$EditPanel}</div>
<div id="TextDiv">
<!-- TEXT -->
<table id="HistoryTable" class="ZabraCell" summary="History Table" style="width : 100%; text-align: center;">
 <tr class="TableHeaderCell" style="height : 30px;">
<td>{$language.Diff}</td>
<td>{$language.Topic}</td>
 <td>{$language.Date}</td>
  <td>{$language.Version}</td>
 <td>{$language.Author}</td>
  <td>{$language.DescriptionOfChange}</td>
</tr>
{foreach from=$History item=HistoryArray}
 <tr class="TableCell">
 <td><input type="radio" name="OldVer" value="{$HistoryArray.Version}"/> <input type="radio" name="NewVer" value="{$HistoryArray.Version}"/></td>
      <td>{$HistoryArray.Topic}</td>
 <td><a href="{$URLS.Script}{$ArticleURL|substr:1|replace:' ':'_'}?version={$HistoryArray.Version}">{$HistoryArray.Date}</a></td>
  <td>{$HistoryArray.Version}</td>
 <td><a href="{$URLS.Script}Users/{$HistoryArray.Author|urlrepair}/">{$HistoryArray.Author}</a></td>
  <td>{$HistoryArray.DescriptionOfChange}</td>
</tr>
{/foreach}
 <tr class="TableCell">
 <td><input type="button" value="Porownaj" class="StyleForm" onclick="location.href = rootDir+'history/diff/{$ArticleID}/'+$('[name=OldVer]:checked').val()+'/'+$('[name=NewVer]:checked').val()+'/';" /></td>

</tr>
  </table>
<!-- TEXT -->
</div>
</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->