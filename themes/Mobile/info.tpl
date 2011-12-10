<div id="InoContent">
<hr />
		<a href="?{addget value="doc=true"}"><img src="{$UrlTheme}img/docicon.png" alt="Microsoft Word" /></a>
		<a href="?{addget value="view=true&download=true&html=true"}"><img src="{$UrlTheme}img/htmlicon.png"  alt="HTML" /></a>
		<a href="?{addget value="pdf=true"}"><img src="{$UrlTheme}img/pdficon.png" alt="PDF" /></a>
{if "Voting"|perm && ($ReadArticleOut.Author != $Session.Logged_User)}Głosuj: <a href="?vote=1&amp;t=article&amp;id={$ReadArticleIndexOut.ID}&amp;SIDCheck={$JSVars.SIDUser}" class="vote voteup">+</a>	&middot;  <a href="?vote=0&amp;t=article&amp;id={$ReadArticleIndexOut.ID}&amp;SIDCheck={$JSVars.SIDUser}" class="vote votedown">-</a> | {/if}<span id="VoteStatus">Ocena: <span class="Votes">{if $ReadArticleIndexOut.Votes > 0}+{/if}{$ReadArticleIndexOut.Votes}</span> (Liczba głosów: {$ReadArticleIndexOut.AllVotes}) </span>
	<div id="InfoArticle">
		<div class="tablediv">
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
{$language.Tags}: <span id="tags">{$ReadArticleIndexOut.Tag}</span>
</div>