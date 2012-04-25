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
		{settings url="XVauctions/Categories/" mleft=200}
			<div class="xvauction-sidebar-item-title">{"xca_categories"|xvLang} </div>
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
							<li><a href="{$URLS.Auctions}{$category.Category}{if $smarty.server.QUERY_STRING != ""}?{addget value=""}{/if}">{$category.Name} ({$category.AuctionsCount})</a></li>
						{/if}
					{/foreach}
				</ul>
			</div>
		</div>
	</div>	
	<div class="xvauction-right">
		<div class="xvauction-index">
			<div class="xvauction-index-right">
				{settings url="System/Config/xva_index_page/" mleft=300}
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