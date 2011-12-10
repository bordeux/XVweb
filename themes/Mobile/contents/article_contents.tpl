<!-- Content -->
<div id="Content">
		<div id="MiniMap">
		{foreach from=$MiniMap item=Value name=minimap}
		{if $smarty.foreach.minimap.last}
			{$Value.Name}
		{else}
			<a href="{$UrlScript}{$Value.Url|urlrepair|substr:1}">{$Value.Name}</a> &gt;
		{/if}
		{/foreach}
		</div>
	<div id="ArticleTools">
			<ul>
			<li>
				<a href="{$UrlScript}history/{$ReadArticleIndexOut.ID}/" title="{$language.History}"  class="selected">{$language.History}</a>
			</li>
			{if "EditArticle"|perm}
				<li>
					<a href="{$UrlScript}Write/?Edit&amp;id={$ReadArticleIndexOut.ID}"  >{$language.EditArticle}</a>
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
					{if $ReadArticleIndexOut.Observed}<a href="?Watch=0&amp;SIDCheck={$JSVars.SIDUser}" title="{$language.UnWatch}">{$language.UnWatch}</a>{else}<a href="?Watch=1&amp;SIDCheck={$JSVars.SIDUser}" title="{$language.Watch}">{$language.Watch}</a>{/if}
				</li>	
				<li>
					{if $ReadArticleIndexOut.Bookmark}<a href="?Bookmark=0&amp;SIDCheck={$JSVars.SIDUser|md5}" title="{$language.AddBookmark}">{$language.AddBookmark}</a>{else}<a href="?Bookmark=1&amp;SIDCheck={$JSVars.SIDUser}" title="{$language.DeleteBookmark}">{$language.DeleteBookmark}</a>{/if}
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
			{if $ReadArticleIndexOut.Accepted == "no"}
				{$ReadArticleIndexOut.AcceptedMsg}
			{/if}
			<div id='FinallContent'>
			{$Content}
			</div>
			{if $Divisions}
			<hr />
			{foreach from=$Divisions item=Column key=ColumnNO}
			{if $Column}
			<div class="DivisionsColumn" id="Column{$ColumnNO}">
				{foreach from=$Column item=Value key=CharDivision}

					<li><span>{$CharDivision}</span>
						<ul>
							{foreach from=$Value item=ArticleLink}
							<li><a href="{$UrlScript}{$ArticleLink.URL|substr:1}" id="art-{$ArticleLink.ID}">{$ArticleLink.Topic}</a></li>
					{/foreach}
						</ul>
					</li>

				{/foreach}
			</div>
			{/if}
			{/foreach}
			{/if}

			<!-- TEXT -->
			<div style="clear:both;"></div>
		</div>
		{if $LoadInfo}
			{include  file='info.tpl'}
		{/if}
		{if $LoadComment}
			{include  file='comment.tpl'}
		{/if}
	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->