<!-- Content -->
<div id="Content">
		<div id="MiniMap">
		{foreach from=$MiniMap item=Value name=minimap}
		{if $smarty.foreach.minimap.last}
			{$Value.Name}
		{else}
			<a href="{$URLS.Script}{$Value.Url|urlrepair|substr:1}">{$Value.Name}</a> &gt;
		{/if}
		{/foreach}
		</div>
	<div id="ArticleTools">
			<ul>
			<li>
				<a href="{$URLS.Script}history/{$ReadArticleIndexOut.ID}/" title="{$language.History}"  class="selected">{$language.History}</a>
			</li>
			{if "EditArticle"|perm}
				<li>
					<a href="{$URLS.Script}Write/?Edit&amp;id={$ReadArticleIndexOut.ID}"  >{$language.EditArticle}</a>
				</li>
			{/if}
			{if "EditTags"|perm}
				<li>
					<a href="#EditTag" title="{$language.Tags}" onclick="EditTag('{$ReadArticleIndexOut.ID}', '{$ReadArticleIndexOut.Tag}'); return false;"  id="EditTagButton">{$language.Tags}</a>
				</li>
			{/if}
			{if "DeleteVersion"|perm}
				<li>
					<a href="#DeleteVersion" title="{$language.DeleteArticleVersion}" onclick="DeleteVersionArt({$ReadArticleIndexOut.ID}, {$ReadArticleOut.Version}); return false;"  >{$language.DeleteArticleVersion}</a>
				</li>
			{/if}
			{if "DeleteArticle"|perm}
				<li>
					<a href="#DeleteArticle" title="{$language.DeleteArticle}" onclick="DeleteArticle({$ReadArticleIndexOut.ID}, '{$ReadArticleIndexOut.Topic|escape:'html'}'); return false;" >{$language.DeleteArticle}</a>
				</li>
			{/if}
			{if  $Session.Logged_Logged}
				<li>
					{if $ReadArticleIndexOut.Observed}<a href="?Watch=0&amp;SIDCheck={$JSVars.SIDUser|md5}" title="{$language.UnWatch}">{$language.UnWatch}</a>{else}<a href="?Watch=1&amp;SIDCheck={$JSVars.SIDUser|md5}" title="{$language.Watch}">{$language.Watch}</a>{/if}
				</li>	
				<li>
					{if $ReadArticleIndexOut.Bookmark}<a href="?Bookmark=0&amp;SIDCheck={$JSVars.SIDUser|md5}" title="{$language.AddBookmark}">{$language.AddBookmark}</a>{else}<a href="?Bookmark=1&amp;SIDCheck={$JSVars.SIDUser|md5}" title="{$language.DeleteBookmark}">{$language.DeleteBookmark}</a>{/if}
				</li>
			{/if}
		</ul>
	</div>
	<div id="Title">
	{$SiteTopic}
	</div>
	<div id="ContentDiv">
		<div id="TextDiv">
			<!-- TEXT -->
<table id="HistoryTable" class="ZabraCell" summary="History Table" style="text-align: center;">
<tr class="TableHeaderCell">
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
	<td><a href="{$URLS.Script}{$ArticleURL|substr:1}?version={$HistoryArray.Version}">{$HistoryArray.Date}</a></td>
	<td>{$HistoryArray.Version}</td>
	<td><a href="{$URLS.Script}Users/{$HistoryArray.Author|urlrepair}/">{$HistoryArray.Author}</a></td>
	<td>{$HistoryArray.DescriptionOfChange}</td>
</tr>
{/foreach}
<tr class="TableCell">
	<td>
		<input type="button" value="Porownaj" class="StyleForm" onclick="location.href = rootDir+'history/diff/{$ArticleID}/'+$('[name=OldVer]:checked').val()+'/'+$('[name=NewVer]:checked').val()+'/';" />
	</td>
</tr>
</table>
			
			<!-- TEXT -->
			<div style="clear:both;"></div>
		</div>
	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->