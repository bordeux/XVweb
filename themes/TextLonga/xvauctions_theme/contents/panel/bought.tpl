<!-- Content -->
 <div id="Content">
 {if $Advertisement}
	<div class="reklamo" id="RTop">
		{$smarty.capture.ADVHeight}
	</div>
{/if}
	<div class="xvauction-main" >
	<div class="category_parents_tree" >
		<a href="{$URLS.Auctions}/">{"xca_auctions"|xvLang}</a> 
			&gt;&gt; <a href="{$URLS.AuctionPanel}">{"xca_auctions_panel"|xvLang}</a> 
			&gt;&gt; <a href="{$URLS.AuctionPanel}/bought/">{$Title}</a> 
	
	</div>
	<div style="clear:both;"></div>

	<div class="xvauction-sidebar">
		{include file="xvauctions_theme/contents/panel/menu_panel.tpl" inline}
	</div>	
	<div class="xvauction-right">
		

	<div class="xauction-tabs ui-tabs ui-widget ui-widget-content ui-corner-top">
		<div class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top">
			<div style="text-align:center; color: #474747; font-size: 14px;">{"xca_bought_items"|xvLang}</div>
		</div>
		<div>
		{if $smarty.get.paid}
			<div class="success">Dziękujemy. Dyspozycja zapłaty została przyjęta</div>
		{/if}
 {if $smarty.get.sort == "desc"}
		{$SmartySort='asc'}
		{$SmartyChar='↑'}
	 {else}
		{$SmartySort='desc'}
		{$SmartyChar='↓'}
 {/if}
 {if $search_filters_remove}
<div class="auctions-filters">
	<div class="auctions-filters-caption">{"xca_filter_parameters"|xvLang}</div>
	<div class="auctions-filters-content">
	{foreach from=$search_filters_remove item=filter}
	 	<a href="?{$filter.link}">{$filter.caption}</a>
	{/foreach}
		<div style="clear:both;"></div>
	</div>
</div>
{/if}
	{if $boughts_list}
		<div class='auctions-items'>
			<form action="?" method="post">
			<table style="width : 100%; text-align: center;">
				<caption>{$pager.0}</caption>
				<thead> 
					<tr>

						<th class="items-checkbox"><input type="checkbox" name="select_all" value="true" class="select_all" data-selector='input[name="auction[]"]' /></th>
						<th class="items-thumbnail"></th>
						<th class="items-title"><a href='?{addget value="sortby=title&sort=$SmartySort"}'>{$SmartyChar} {"xca_description"|xvLang}</a></th>
						<th class="items-cost"><a href='?{addget value="sortby=cost&sort=$SmartySort"}'>{$SmartyChar} {"xca_cost"|xvLang}</a></th>
						<th class="items-pieces"><a href='?{addget value="sortby=pieces&sort=$SmartySort"}'>{$SmartyChar} {"xca_pieces"|xvLang}</a></th>
						<th class="items-date"><a href='?{addget value="sortby=date&sort=$SmartySort"}'>{$SmartyChar} {"xca_date"|xvLang}</a></th>
						<th class="items-seller"><a href='?{addget value="sortby=date&sort=$SmartySort"}'>{$SmartyChar} {"xca_seller"|xvLang}</a></th>
						<th class="items-options"></th>

					</tr>
				</thead> 
				<tbody> 
				{foreach from=$boughts_list item=auction}
					<tr>
						<td class="items-checkbox"><input type="checkbox" name="auction[]" value="{$auction.ID}" /></td>
						<td class="items-thumbnail">
							<a href="{$URLS.Auction}/{$auction.Auction}/">
							{if $auction.Thumbnail}
								<img src="{$URLS.Thumbnails}/{$auction.Thumbnail}" style="width:64; height:48px;" />
							{else}
								<img src="{$URLS.Theme}xvauctions_theme/img/no_picture.png" style="width:64; height:48px;" />
							{/if}
							</a>
						</td>
						<td class="items-title">
						<a href="{$URLS.Auction}/{$auction.Auction}/">{$auction.Title}</a>
						</td>
						<td class="items-cost">
							<span>{$auction.Cost|number_format:2:'.':' '} {"xca_coin_type"|xvLang}</span>
						</td>
						<td class="items-pieces">
							{$auction.Pieces}
						</td>
						<td class="items-date">
							{$auction.Date}
						</td>	
						<td class="items-seller">
							{$auction.Seller}
						</td>
						<td class="items-options">
							{if $auction.Paid == 0}<a href="{$URLS.AuctionPanel}/payment_pay/{$auction.ID}/">{"xca_pay"|xvLang}</a>{else}✓ Zapłacono{/if} <br />
							<a href="{$URLS.AuctionPanel}/get_address/{$auction.Seller}/">{"xca_contractor_data"|xvLang}</a> <br />
							{if $auction.CommentedBuyer == 0}<a href="{$URLS.AuctionPanel}/comment_add/{$auction.ID}/">{"xca_comment_add"|xvLang}</a> {else}✓ Komentarz wystawiony{/if}<br />
						</td>
					</tr>
				{/foreach}

			
				</tbody> 
			</table>
			<div class="xv-table-pager">
				{$pager.1}
			</div>
			<input type="submit" value="{'xca_hidde'|xvLang}" name="hidde" />
			</form>
	</div>
	{else}
			<div style="margin: 40px;">
				<div style="background: #F3FFCD; border: 1px solid #B1DA81; color: #4B5D40; text-align:center; padding: 20px; ">
					<h2 style="color: #60A536; font-size: 16px; font-weight:bold;">{"xca_zero_results3"|xvLang}</h2>
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