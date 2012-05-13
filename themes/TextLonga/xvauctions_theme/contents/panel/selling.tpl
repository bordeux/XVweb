<!-- Content -->
 <div id="Content">
 {if $Advertisement}
	<div class="reklamo" id="RTop">
		{$smarty.capture.ADVHeight}
	</div>
{/if}
	<div class="xvauction-main" >
	<div class="category_parents_tree" >
		<a href="{$URLS.Auctions}/">{"xca_auctions"|xv_lang}</a> 
			&gt;&gt; <a href="{$URLS.AuctionPanel}">{"xca_auctions_panel"|xv_lang}</a> 
			&gt;&gt; <a href="{$URLS.AuctionPanel}/selling/">{$Title}</a>
	
	</div>
	<div style="clear:both;"></div>

	<div class="xvauction-sidebar">
		{include file="xvauctions_theme/contents/panel/menu_panel.tpl" inline}
	</div>	
	<div class="xvauction-right">
		

	<div class="xauction-tabs ui-tabs ui-widget ui-widget-content ui-corner-top">
		<div class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top">
			<div style="text-align:center; color: #474747; font-size: 14px;">{$Title}</div>
		</div>
		<div>
		
 {if $smarty.get.sort == "desc"}
		{$SmartySort='asc'}
		{$SmartyChar='↑'}
	 {else}
		{$SmartySort='desc'}
		{$SmartyChar='↓'}
 {/if}
 {if $search_filters_remove}
<div class="auctions-filters">
	<div class="auctions-filters-caption">{"xca_filter_parameters"|xv_lang}</div>
	<div class="auctions-filters-content">
	{foreach from=$search_filters_remove item=filter}
	 	<a href="?{$filter.link}">{$filter.caption}</a>
	{/foreach}
		<div style="clear:both;"></div>
	</div>
</div>
{/if}
	{if $auctions_list}
		<div class='auctions-items'>
			<table style="width : 100%; text-align: center;">
				<caption>{$pager.0}</caption>
				<thead> 
					<tr>
						<th class="items-thumbnail"></th>
						<th class="items-title"><a href='?{add_get_var value="sortby=title&sort=$SmartySort"}'>{$SmartyChar} {"xca_description"|xv_lang}</a></th>
						<th class="items-cost"><a href='?{add_get_var value="sortby=cost&sort=$SmartySort"}'>{$SmartyChar} {"xca_cost"|xv_lang}</a></th>
						<th class="items-offers"><a href='?{add_get_var value="sortby=offers&sort=$SmartySort"}'>{$SmartyChar} {"xca_offer"|xv_lang}</a></th>
						<th class="items-timeout"><a href='?{add_get_var value="sortby=end&sort=$SmartySort"}'>{$SmartyChar} {"xca_to_end"|xv_lang}</a></th>
						<th class="items-timeout"><a href='?{add_get_var value="sortby=views&sort=$SmartySort"}'>{$SmartyChar} {"Views"|xv_lang}</a></th>
						<th class="items-none"></th>
					</tr>
				</thead> 
				<tbody> 
				{foreach from=$auctions_list item=auction}
					<tr>
						<td class="items-thumbnail">
							<a href="{$URLS.Auction}/{$auction.ID}/">
							{if $auction.Thumbnail}
								<img src="{$URLS.Thumbnails}/{$auction.Thumbnail}" style="width:64; height:48px;" />
							{else}
								<img src="{$URLS.Theme}xvauctions_theme/img/no_picture.png" style="width:64; height:48px;" />
							{/if}
							</a>
						</td>
						<td class="items-title">
						<a href="{$URLS.Auction}/{$auction.ID}/">{$auction.Title}</a>
						</td>
						<td class="items-cost">
							{if $auction.Type == "buynow"}
								<span class="item-buynow">{$auction.BuyNow|number_format:2:'.':' '} {"xca_coin_type"|xv_lang}</span>
							{elseif $auction.Type == "auction"}
								<span class="item-auction">{$auction.Auction|number_format:2:'.':' '} {"xca_coin_type"|xv_lang}</span>
							{elseif $auction.Type == "dutch"}
								<span class="item-buynow">{$auction.Auction|number_format:2:'.':' '} {"xca_coin_type"|xv_lang}</span> <br />  <span class="item-auction">{$auction.AuctionMin|number_format:2:'.':' '} {"xca_coin_type"|xv_lang}</span>
							{else}
								<span class="item-buynow">{$auction.BuyNow|number_format:2:'.':' '} {"xca_coin_type"|xv_lang}</span> <br />  <span class="item-auction">{$auction.Auction} {"xca_coin_type"|xv_lang}</span>
							{/if}
						</td>
						<td class="items-offers">
							{if $auction.AuctionsCount}
							{$auction.AuctionsCount}
							{else}
							-
							{/if}
						</td>
						<td class="items-timeout">
							{$auction.End|countdown:$auction.NowTime}
						</td>
						<td class="items-timeout">
							{$auction.Views}
						</td>
						<td class="items-timeout">
							<a href="{$URLS.AuctionsAdd}?step=edit&amp;id={$auction.ID}">{"xca_edit_auction"|xv_lang}</a>
							<a href="{$URLS.AuctionPanel}/finish/{$auction.ID}/">{"xca_finish"|xv_lang}</a>
						</td>
					</tr>
				{/foreach}

			
				</tbody> 
			</table>
			<div class="xv-table-pager">
				{$pager.1}
			</div>
	</div>
	{else}
			<div style="margin: 40px;">
				<div style="background: #F3FFCD; border: 1px solid #B1DA81; color: #4B5D40; text-align:center; padding: 20px; ">
					<h2 style="color: #60A536; font-size: 16px; font-weight:bold;">{"xca_zero_results1"|xv_lang}</h2>
					{"xca_zero_results2"|xv_lang}
				</div>
			</div>
	{/if}
	</div>
	
	
		</div>
		
				
	</div>

	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->