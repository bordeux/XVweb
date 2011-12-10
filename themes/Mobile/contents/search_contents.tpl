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
	<div id="Title">
	{$SiteTopic}
	</div>
	<div id="ContentDiv">
		<div id="TextDiv">
			<!-- TEXT -->
			

				{if $JoinForm == false}
				<form action="{$UrlScript}Search/" method="get" name="SearchForm">
					{$language.Search}: <input accesskey="s" type="text" name="Search" value="{$smarty.get.Search|escape:'html'}" class="Search" />
					<input type="checkbox" value="true" name="AllVersion" id="AllVersion" class="StyleForm" {if $smarty.get.AllVersion == true}checked="checked"{/if} /> <label for="AllVersion">Szukaj w wszyskich wersjach</label> 
					<input type="submit" value="{$language.Search}" class="StyleForm" /> 
				</form>
					<br />
				{/if}
				{$Pager.0}
				<hr />
					{if empty($SearchArray)}
						<div style="text-align: center; margin:10px; font-weight: bold; ">{$language.NotFoundKeyword|sprintf:$smarty.get.Search|escape:"html"}</div>
						{else}
							{foreach from=$SearchArray item=SearchResult}
								<div id="Search-ID" style="background-color:#F8F8F8;">
									<div id="TitleSearch-ID" style="font-size:15px; margin-top:10px; font-weight: bold;">
										<a href="{$UrlScript}{$SearchResult.URL|substr:1}{if $smarty.get.AllVersion == true}?version={$SearchResult.Version}{/if}">{$SearchResult.Topic}</a>
									</div>
									<div id="DescriptionSearch-ID"> 
										<div style="margin-left:10px;">
											{$SearchResult.Contents}
										</div>
									</div>
									<div id="FooterSearch-ID" style="font-size: 11px; color : #1C8C1C; ">
									{$UrlScript}{$SearchResult.URL|substr:1} -  {$SearchResult.StrByte} B {$SearchResult.Lenght} Char {math equation="round(x*10)" x=$SearchResult.Relevance}% {$language.Relevance} 
									</div>
								</div> 
								<hr />
						{/foreach}

				{/if}
				{$Pager.1}
				{$Content}

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