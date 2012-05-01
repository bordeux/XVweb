<!-- Content -->
 <div id="Content">
 <div id="TitleDiv">
 {$SiteTopic}
 </div>
<div id="ContentDiv">
<div id="EditPanel">
	<ol>
		<ul>
			<li>
				<a href="{$Url}Write/?url={$PathInfo}" title="{$language.Write}"  class="selected">{$language.Write}</a>
			</li>
		</ul>
	</ol>
</div>
<div id="TextDiv">
<div class="LightBulbTip">
				{$Content}
				<img src="{$UrlTheme}img/LightbulbIcon.png" alt="Tip" /> {$language.ArticleNotFoundContent|replace:"<create>":"<a href='`$Url`write/?url=`$PathInfo`' style='font-weight: bold;'>"|replace:"</create>":"</a>"|replace:"<tocreate>":"<a href='`$Url`write/?url=/SuggestCreation`$PathInfo`' style='font-weight: bold;'>"|replace:"</tocreate>":"</a>"}
				</div>
{$Pager.0}
					{if empty($SearchArray)}
		<div style="text-align: center; margin:10px; font-weight: bold; ">{$language.NotFoundKeyword|sprintf:$smarty.get.Search|escape:"html"}</div>
		{else}
		<br />{$language.ResultSearch}:
			{foreach from=$SearchArray item=SearchResult}
				<div id="Search-ID" style="background-color:#F8F8F8;">
					<div id="TitleSearch-ID" style="font-size:15px; margin-top:10px; font-weight: bold;">
						<a href="{$URLS.Script}{$SearchResult.URL|substr:1}?version={$SearchResult.Version}">{$SearchResult.Topic}</a>
					</div>
					<div id="DescriptionSearch-ID"> 
						<div style="margin-left:10px;">
							{$SearchResult.Contents}
						</div>
					</div>
					<div id="FooterSearch-ID" style="font-size: 11px; color : #1C8C1C; ">
					{$URLS.Script}{$SearchResult.URL|substr:1} -  {$SearchResult.StrByte} B {$SearchResult.Lenght} Char {math equation="round(x*10)" x=$SearchResult.Relevance}% {$language.Relevance} 
					</div>
				</div> 
				<hr />
		{/foreach}
		{/if}
{$Pager.1}
</div>
</div>
</div>
<div style="clear:both;"></div>
<!-- /Content -->