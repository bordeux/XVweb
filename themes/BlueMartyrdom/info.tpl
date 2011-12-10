	<div class="reklamo" id="RCenter">
		{$smarty.capture.ADVInfo}
	</div>
	
<div id="fp_ads">
	<div class="cssprite InfoIMG">&nbsp;</div>
	<div id="StarDiv" style="display: inline; margin-right: 10px; float: right;">
		{if "Voting"|perm && ($ReadArticleOut.Author != $Session.Logged_User)}Głosuj: <a href="?vote=1&amp;t=article&amp;id={$ReadArticleIndexOut.ID}&amp;SIDCheck={$JSVars.SIDUser}" class="vote voteup"><img src="{$UrlTheme}img/blank.png" alt="Vote UP" /></a>	&middot;  <a href="?vote=0&amp;t=article&amp;id={$ReadArticleIndexOut.ID}&amp;SIDCheck={$JSVars.SIDUser}" class="vote votedown"><img src="{$UrlTheme}img/blank.png" alt="Vote Down" /></a> | {/if}<span id="VoteStatus">Ocena: <span class="Votes">{if $ReadArticleIndexOut.Votes > 0}+{/if}{$ReadArticleIndexOut.Votes}</span> (Liczba głosów: {$ReadArticleIndexOut.AllVotes}) </span>
		<a href="?{addget value="doc=true"}"><img src="{$UrlTheme}img/blank.png" class="cssprite DocIconIMG" alt="Microsoft Word" /></a>
		<a href="?{addget value="view=true&download=true&html=true"}"><img src="{$UrlTheme}img/blank.png" class="cssprite HTMLIconIMG" alt="HTML" /></a>
		<a href="?{addget value="pdf=true&ajax=true"}"><img src="{$UrlTheme}img/blank.png" class="cssprite PDFIconIMG" alt="PDF" /></a>
		<a href="#" onclick="PrintPage('?{addget value="view=true&html=true"}',300,400);"><img src="{$UrlTheme}img/blank.png" class="cssprite PrintIconIMG" alt="Print" /></a>
		{$PluginsButton}
	</div>
	<div id="InfoArticle">
		<div  class="tablediv">
			<div class="rowdiv">
				<div  class="celldiv">{$language.LastModification}:</div>
				<div  class="celldiv">{$ReadArticleOut.Date}</div>
				<div  class="celldiv">{$language.LastAuthor}:</div>
				<div  class="celldiv"><a href="{$UrlScript}Users/{$ReadArticleOut.Author|escape:'url'}/" >{$ReadArticleOut.Author}</a></div>
			</div>
			<div class="rowdiv">
				<div  class="celldiv">{$language.ViewCount}:</div>
				<div  class="celldiv">{$ReadArticleIndexOut.Views}</div>
				<div  class="celldiv">{$language.Version}:</div>
				<div  class="celldiv">{$ReadArticleOut.Version}</div>
			</div>
		</div>
	</div>
	<div id="TagList"> <img src="{$UrlTheme}img/tagicon.gif" alt="{$language.Tags}"/> {$language.Tags}: <span id="tags">{$ReadArticleIndexOut.Tag}</span></div>
</div>