<!-- Content -->
 <div id="Content">
 {if $Advertisement}
	<div class="reklamo" id="RTop">
		{$smarty.capture.ADVHeight}
	</div>
{/if}
	{$xva_config.html_message}
	<div class="xvauction-main" >
	<div class="category_parents_tree" >
		<a href="{$URLS.Auctions}/">{"xca_auctions"|xv_lang}</a> 
		
		{foreach from=$auctions_category_tree item=cat_parent}
			&gt;&gt; <a href="{$URLS.Auctions}{$cat_parent.Category}">{$cat_parent.Name}</a> 
		{/foreach}
	</div>
	<div style="clear:both;"></div>
	<div style="float:right; margin-top: -30px; padding-right: 10px;">
		<a href="{$URLS.AuctionsAdd}/?step=category&amp;category={$auctions_category|escape:'url'}">{"xca_sell_here"|xv_lang}</a>
	</div>
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

		{$SubMode=0}
		<div class="xvauction-sidebar-item">
		{settings url="XVauctions/Categories/" mleft=200}
			<div class="xvauction-sidebar-item-title">{"xca_categories"|xv_lang}</div>
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
		
		<div class="xvauction-sidebar-item">
			<div class="xvauction-sidebar-item-title">{"xca_view_options"|xv_lang}</div>
			<div class="xvauction-sidebar-item-content">
				<form action="?" method="get" style="padding-bottom: 20px;">
				
				<div class="auction-search-quick-item">
					<fieldset>
					<legend><label style="width: 54px;" for="auction_cost-id">{"xca_cost"|xv_lang}</label></legend>
					 {"xca_from"|xv_lang} 
					<input {literal}pattern="((([0-9]){0,10})|(([0-9]){0,10}(\.)([0-9]){2}))"{/literal} id="auction_cost-id" type="text" value="{$smarty.get.auction_cost_from|escape:'html'}" name="auction_cost_from" style="width: 44px;"> 
					<label for="auction_cost-two-id" style="width: 54px;">{"xca_to"|xv_lang} </label>
					<input {literal}pattern="((([0-9]){0,10})|(([0-9]){0,10}(\.)([0-9]){2}))"{/literal} id="auction_cost-two-id" type="text" value="{$smarty.get.auction_cost_to|escape:'html'}" name="auction_cost_to" style="width: 44px;">  {"xca_coin_type"|xv_lang}
					</fieldset>
				</div>
			
				{foreach from=$quick_search_fields item=field}
					{$field}
				{/foreach}
				<input type="submit" value='{"xca_show"|xv_lang}' />
				</form>
			</div>
		</div>
		
	</div>	
	<div class="xvauction-right">
		

	<div class="xauction-tabs ui-tabs ui-widget ui-widget-content ui-corner-top">
		<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top">
			<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary {if $smarty.get.auction_type == '' ||  $smarty.get.auction_type == 'all'}ui-state-active{/if}">
				<a href="?{add_get_var value="auction_type="}" title='{"xca_all1"|xv_lang}' style="padding-left:20px;"> <span class="ui-icon ui-icon-script" style="margin-left:-16px;"></span>{"xca_all1"|xv_lang}</a>
			</li>
			{if $xva_config.buynow_enabled}<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary {if $smarty.get.auction_type == 'buynow'}ui-state-active{/if}">
				<a href="?{add_get_var value="auction_type=buynow"}" title="{"xca_only_buy_now"|xv_lang}" style="padding-left:20px;"> <span class="ui-icon ui-icon-script" style="margin-left:-16px;"></span>{"xca_only_buy_now"|xv_lang}</a>
			</li>{/if}
			{if $xva_config.auction_enabled}<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary {if $smarty.get.auction_type == 'auction'}ui-state-active{/if}">
				<a  href="?{add_get_var value="auction_type=auction"}" title="{"xca_only_auctions"|xv_lang}" style="padding-left:20px;"> <span class="ui-icon ui-icon-script" style="margin-left:-16px;"></span>{"xca_only_auctions"|xv_lang}</a>
			</li>{/if}
			{if $xva_config.dutch_enabled}<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary {if $smarty.get.auction_type == 'dutch'}ui-state-active{/if}">
				<a  href="?{add_get_var value="auction_type=dutch"}" title="{"xca_only_dutch_auctions"|xv_lang}" style="padding-left:20px;"> <span class="ui-icon ui-icon-script" style="margin-left:-16px;"></span>{"xca_only_dutch_auctions"|xv_lang}</a>
			</li>{/if}	
			{if $xva_config.advert_enabled}<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary {if $smarty.get.auction_type == 'advert'}ui-state-active{/if}">
				<a  href="?{add_get_var value="auction_type=advert"}" title="{"xca_only_adverts"|xv_lang}" style="padding-left:20px;"> <span class="ui-icon ui-icon-script" style="margin-left:-16px;"></span>{"xca_only_adverts"|xv_lang}</a>
			</li>{/if}
			{if "AdminPanel"|perm}
			<li class="ui-state-default ui-corner-top ui-state-hover" style="float:right;">
				<a href="{$URLS.Script}Administration/XVauctions/Categories/?cat={$auctions_category|escape:'url'}" style="padding:0px" target="_blank"><span class="ui-button  ui-icon ui-icon-wrench " title="{'xca_edit_category'|xv_lang}"></span></a>
			</li>
			{/if}

		</ul>
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
						<th class="items-title"><a href='?{add_get_var value="sortby=title&sort=$SmartySort"}'>{$SmartyChar} {"xca_auction_title"|xv_lang}</a></th>
						<th class="items-cost"><a href='?{add_get_var value="sortby=cost&sort=$SmartySort"}'>{$SmartyChar} {"xca_cost"|xv_lang}</a></th>
						<th class="items-offers"><a href='?{add_get_var value="sortby=offers&sort=$SmartySort"}'>{$SmartyChar} {"xca_offer"|xv_lang}</a></th>
						<th class="items-timeout"><a href='?{add_get_var value="sortby=end&sort=$SmartySort"}'>{$SmartyChar} {"xca_to_end"|xv_lang}</a></th>
					</tr>
				</thead> 
				<tbody> 
				{foreach from=$auctions_list item=auction}
					<tr>
						<td class="items-thumbnail">
						{settings url="XVauctions/Auction/{$auction.ID}/"}
							<a href="{$URLS.Auction}/{$auction.ID}/">
							{if $auction.Thumbnail}
								<img src="{$URLS.Thumbnails}/{$auction.Thumbnail}" style="width:64; height:48px;" />
							{else}
								<img src="{$URLS.Theme}xvauctions/img/no_picture.png" style="width:64; height:48px;" />
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
							{elseif $auction.Type == "advert"}
								<span class="item-advert">{"xca_avert"|xv_lang}</span> 
								<br /> 
								{$auction.BuyNow|number_format:2:'.':' '} {"xca_coin_type"|xv_lang}
							{elseif $auction.Type == "errand"}
								<span class="item-errand">{"xca_errand"|xv_lang}</span> 
								<br /> 
								{$auction.BuyNow|number_format:2:'.':' '} {"xca_coin_type"|xv_lang}
							{elseif $auction.Type == "dutch"}
								<span class="item-buynow item-dutch-cost">{$auction.BuyNow|number_format:2:'.':' '} {"xca_coin_type"|xv_lang}</span> <br />  <span class="item-auction">{$auction.AuctionMin|number_format:2:'.':' '} {"xca_coin_type"|xv_lang}</span>
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