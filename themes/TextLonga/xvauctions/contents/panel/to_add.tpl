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
			&gt;&gt; <a href="{$URLS.AuctionPanel}/to_add/">{$Title}</a> 
	
	</div>
	<div style="clear:both;"></div>

	<div class="xvauction-sidebar">
		{include file="xvauctions/contents/panel/menu_panel.tpl" inline}
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

	{if $to_add_list}
		<div class='auctions-items'>
			<table style="width : 100%; text-align: center;">
				<caption>{$pager.0}</caption>
				<thead> 
					<tr>

						<th class="items-checkbox"><input type="checkbox" name="select_all" value="true" class="select_all" data-selector='input[name="auction[]"]' /></th>
						<th class="items-thumbnail"></th>
						<th class="items-title"><a href='?{add_get_var value="sortby=title&sort=$SmartySort"}'>{$SmartyChar} {"xca_description"|xv_lang}</a></th>
						<th class="items-cost"><a href='?{add_get_var value="sortby=cost&sort=$SmartySort"}'>{$SmartyChar} {"xca_cost"|xv_lang}</a></th>
						<th class="items-pieces"><a href='?{add_get_var value="sortby=start&sort=$SmartySort"}'>{$SmartyChar} {"xca_start"|xv_lang}</a></th>
						<th class="items-timeout"><a href='?{add_get_var value="sortby=end&sort=$SmartySort"}'>{$SmartyChar}  {"xca_end"|xv_lang}</a></th>

					</tr>
				</thead> 
				<tbody> 
				{foreach from=$to_add_list item=auction}
					<tr>
						<td class="items-checkbox"><input type="checkbox" name="auction[]" value="{$auction.ID}" /></td>
						<td class="items-thumbnail">
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
							<span>{$auction.Auction|number_format:2:'.':' '} {"xca_coin_type"|xv_lang}</span>
						</td>
						<td class="items-start">
							{$auction.Start}
						</td>
						<td class="items-end">
							{$auction.End}
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
					<h2 style="color: #60A536; font-size: 16px; font-weight:bold;">{"xca_zero_results3"|xv_lang}</h2>
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