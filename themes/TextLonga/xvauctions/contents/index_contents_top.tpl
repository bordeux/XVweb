<!-- Content -->
 <div id="Content">
 {if $Advertisement}
	<div class="reklamo" id="RTop">
		{$smarty.capture.ADVHeight}
	</div>
{/if}
	{$xva_config.html_message}
	<div class="xvauction-main" >

	<div class="xvauction-sidebar">
	
	<div class="xvauction-sidebar-item">
		<div class="xvauction-sidebar-item-title">{"xca_search"|xv_lang}</div>
		<div class="xvauction-sidebar-item-content">
			<form action="{$URLS.Auctions}" method="get" class="xvauction-sidebar-search">
				<input type="search" name="auction_search" value="{$smarty.get.auction_search|escape}" speech x-webkit-speech />
				<input type="submit" value='{"xca_search"|xv_lang}'>
			</form>
		</div>
	</div>
	
		<div class="xvauction-sidebar-item">
		{settings url="XVauctions/Categories/" mleft=200}
			<div class="xvauction-sidebar-item-title">{"xca_categories"|xv_lang} </div>
			<div class="xvauction-sidebar-item-content">
				<ul class="xvauction-categories">
					{foreach from=$auctions_categories item=category key=equiv}
						{if {$category.isSelected}}
							<li class="xvauction-categories-selected"><span>{$category.Name} ({$category.AuctionsCount})</span></li>
						{else}
						{if {$category.isChild} && $SubMode == 0}
							<ul style="padding-left:30px;">
							{$SubMode=1}
						{/if}
						{if !{$category.isChild} && $SubMode == 1}
							</ul>
							{$SubMode=0}
						{/if}
							<li><a href="{$URLS.Auctions}{$category.Category}{if $smarty.server.QUERY_STRING != ""}?{add_get_var value=""}{/if}">{$category.Name} ({$category.AuctionsCount})</a></li>
						{/if}
					{/foreach}
				</ul>
			</div>
		</div>
	</div>	
	<div class="xvauction-right">
		<div class="xvauction-index">
			<div class="xvauction-index-right">
				{settings url="System/Config/xva_index_page/" mleft=1}
			{foreach from=$xva_index_page_categories item=category}
					<a href="{$category.link}" class="xvauction-index-category{if $category.selected} xvauction-index-selected{/if}">
						<div>
							<img src="{$URLS.Site}plugins/xvauctions/index/icons/{$category.icon}" />
							<h3>{$category.title}</h3>
							<span>{$category.desc}</span>
						</div>
					</a>	
			{/foreach}
			</div>
		
		<div style="clear:both;"></div>
		</div>
	</div>

	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->