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
			<div class="xvauction-sidebar-item-title">{"xca_categories"|xvLang}</div>
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
			{foreach from=$xva_index_page_categories item=category}
					<a href="{$category.link}" class="xvauction-index-category{if $category.selected} xvauction-index-selected{/if}">
						<div>
							<img src="{$URLS.Site}plugins/xvauctions/index/icons/{$category.icon}" />
							<h3>{$category.title}</h3>
							<span>{$category.desc}</span>
						</div>
					</a>	
			{/foreach}
					{*<a href="http://titek.pl/XVweb.git/auctions/" class="xvauction-index-category">
						<div>
							<img src="{$URLS.Site}plugins/xvauctions/index/icons/new.png" />
							<h3>Nowe</h3>
							<span>Lorem ipsum dolor sit amet consect</span>
						</div>
					</a>			
					<a href="http://titek.pl/XVweb.git/auctions/" class="xvauction-index-category xvauction-index-selected">
						<div>
							<img src="{$URLS.Site}plugins/xvauctions/index/icons/star.png" />
							<h3>Polecane</h3>
							<span>Lorem ipsum dolor sit amet consect</span>
						</div>
					</a>
					<a href="http://titek.pl/XVweb.git/auctions/?sortby=end&sort=asc" class="xvauction-index-category">
						<div>
							<img src="{$URLS.Site}plugins/xvauctions/index/icons/new.png" />
							<h3>Kończące się</h3>
							<span>Lorem ipsum dolor sit amet consect</span>
						</div>
					</a>*}
			</div>
		
		<div style="clear:both;"></div>
		</div>
	</div>

	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->