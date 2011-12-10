<div data-role="page" id="xv-main-page-id" data-theme="c">
	<div data-role="header"> 
	<a href="#xv-menu-id" data-role="button" data-theme="b" data-transition="flip">Menu</a>
		<h1>{$SiteTopic}</h1> 
	<a href="{$URLS.Script}" data-icon="home" data-iconpos="notext" data-direction="reverse" data-theme="b" data-transition="slidedown">Home</a>
	</div><!-- /header -->
	{$smarty.capture.ADVBanner}
	
	<!--CONTENT -->
	
	{if $ReadArticleIndexOut.Accepted == "no"}
		{$ReadArticleIndexOut.AcceptedMsg}
	{/if}
	<div class="xv-content">
		{$Content}
	</div>
	
	{$smarty.capture.ADVBottomText}
	
	<div style="clear:both"></div>
	
	<div data-role="collapsible-set">
		{if $DivisionsCount > 0}
			<div data-role="collapsible" data-collapsed="true">
			<h3>Subkategorie ({$DivisionsCount})</h3>
				<ul data-role="listview" data-filter="true">
					{foreach from=$Divisions item=Column key=ColumnNO}
					{if $Column}
						{foreach from=$Column item=Value key=CharDivision}
							<li data-role="list-divider">{$CharDivision}</li> 
								{foreach from=$Value item=ArticleLink}
								<li><a href="{$UrlScript}{$ArticleLink.URL|substr:1|replace:' ':'_'}" id="art-{$ArticleLink.ID}">{$ArticleLink.Topic}</a></li>
								{/foreach}
						{/foreach}
					{/if}
					{/foreach}
				</ul>
			</div>
		{/if}
		
		{if $LoadInfo}
			<div data-role="collapsible" data-collapsed="true">
				<h3>Info</h3>
					{include  file='info.tpl' inline}
			</div>
		{/if}
	
		{if $LoadComment}
			<div data-role="collapsible" data-collapsed="true">
				<h3>Komentarze ({$CommentsCount})</h3>
			{include  file='comment.tpl' inline}
			</div>
		{/if}

	</div>
	
	<!--/CONTENT -->
{include  file='footer-main.tpl' inline}
</div><!-- /page xv-main-id -->