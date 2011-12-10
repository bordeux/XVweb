	<div class="reklamo" id="RCenter">
		{$smarty.capture.ADVInfo}
	</div>
	
<div class="xv-article-info">
	<div class="xv-vote-warpper">
		{if "Voting"|perm && ($ReadArticleOut.Author != $Session.Logged_User)}Głosuj: <a href="?vote=1&amp;t=article&amp;id={$ReadArticleIndexOut.ID}&amp;SIDCheck={$JSVars.SIDUser}" class="vote voteup"><img src="{$URLS.Theme}img/blank.png" alt="Vote UP" /></a>	&middot;  <a href="?vote=0&amp;t=article&amp;id={$ReadArticleIndexOut.ID}&amp;SIDCheck={$JSVars.SIDUser}" class="vote votedown"><img src="{$URLS.Theme}img/blank.png" alt="Vote Down" /></a> | {/if}<span id="VoteStatus">Ocena: <span class="Votes">{if $ReadArticleIndexOut.Votes > 0}+{/if}{$ReadArticleIndexOut.Votes}</span> (Liczba głosów: {$ReadArticleIndexOut.AllVotes}) </span>
	</div>
	<div class="xv-article-details">
		<div class="tablediv">
			<div class="rowdiv">
				<div class="celldiv">{$language.LastModification}:</div>
				<div class="celldiv">{$ReadArticleOut.Date}</div>
				<div class="celldiv">{$language.LastAuthor}:</div>
				<div class="celldiv"><a href="{$UrlScript}Users/{$ReadArticleOut.Author|escape:'url'}/" >{$ReadArticleOut.Author}</a></div>
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
		<a href='?{addget value="doc=true"}'><img src="{$URLS.Theme}img/blank.png" class="xv-icon-doc" alt="Microsoft Word" /></a>
		<a href='?{addget value="view=true&download=true&html=true"}'><img src="{$URLS.Theme}img/blank.png" class="xv-icon-html" alt="HTML" /></a>
		<a href='?{addget value="pdf=true&ajax=true"}'><img src="{$URLS.Theme}img/blank.png" class="xv-icon-pdf" alt="PDF" /></a>
		<a href="?view=true" class="xv-print-page"><img src="{$URLS.Theme}img/blank.png" class="xv-icon-print" alt="Print" /></a>
		<g:plusone size="small"></g:plusone>
		
		{$PluginsButton}
	</div>
	<div class="clear"></div>
</div>