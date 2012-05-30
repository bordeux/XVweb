	<div class="reklamo" id="RCenter">
		{$smarty.capture.ADVInfo}
	</div>
	
<div class="xv-article-info">
	<div class="xv-article-details">
		<div class="tablediv">
			<div class="rowdiv">
				<div class="celldiv">{$language.LastModification}:</div>
				<div class="celldiv">{$ReadArticleOut.Date}</div>
				<div class="celldiv">{$language.LastAuthor}:</div>
				<div class="celldiv"><a href="{$URLS.Script}Users/{$ReadArticleOut.Author|escape:'url'}/" >{$ReadArticleOut.Author}</a></div>
			</div>
			<div class="rowdiv">
				<div class="celldiv">{$language.ViewCount}:</div>
				<div class="celldiv">{$ReadArticleIndexOut.Views}</div>
				<div class="celldiv">{$language.Version}:</div>
				<div class="celldiv">{$ReadArticleOut.Version}</div>
			</div>
		</div>
	</div>
	
	<div class="xv-article-tags">{$language.Tags}: <span id="tags">{$ReadArticleIndexOut.Tag}</span></div>
	<div class="xv-article-addons">		
		<a href='?{add_get_var value="doc=true"}'><img src="{$URLS.Theme}img/blank.png" class="xv-icon-doc" alt="Microsoft Word" /></a>
		<a href='?{add_get_var value="view=true&download=true&html=true"}'><img src="{$URLS.Theme}img/blank.png" class="xv-icon-html" alt="HTML" /></a>
		<a href='?{add_get_var value="pdf=true&ajax=true"}'><img src="{$URLS.Theme}img/blank.png" class="xv-icon-pdf" alt="PDF" /></a>
		<a href="?view=true" class="xv-print-page"><img src="{$URLS.Theme}img/blank.png" class="xv-icon-print" alt="Print" /></a>
		<g:plusone size="small"></g:plusone>
		
		{$PluginsButton}
	</div>
	<div class="clear"></div>
</div>