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
			&gt;&gt; <a href="{$URLS.AuctionPanel}/payment_history/">{$Title}</a> 
	
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

	{if $payments_list}
		<div class='auctions-items'>
			<table style="width : 100%; text-align: center;">
				<caption>{$pager.0}</caption>
				<thead> 
					<tr>
						<th class="items-title"><a href='?{addget value="sortby=id&sort=$SmartySort"}'>{$SmartyChar} {"ID"|xvLang}</a></th>
						<th class="items-title"><a href='?{addget value="sortby=title&sort=$SmartySort"}'>{$SmartyChar} {"Title"|xvLang}</a></th>
						<th class="items-cost"><a href='?{addget value="sortby=amount&sort=$SmartySort"}'>{$SmartyChar} {"xca_payments_amount"|xvLang}</a></th>
						<th class="items-date"><a href='?{addget value="sortby=date&sort=$SmartySort"}'>{$SmartyChar} {"xca_date"|xvLang}</a></th>
						<th class="items-date"><a href='?{addget value="sortby=auction&sort=$SmartySort"}'>{$SmartyChar} {"xca_auction_id"|xvLang}</a></th>

					</tr>
				</thead> 
				<tbody> 
				{foreach from=$payments_list item=payment}
					<tr>
						<td class="items-id"><a href="{$URLS.AuctionPanel}/payment_details/{$payment.ID}/">{$payment.ID}</a></td>
						<td class="items-title"><a href="{$URLS.AuctionPanel}/payment_details/{$payment.ID}/">{$payment.Title}</a></td>
						<td class="items-cost">{if $payment.Amount > 0}<span style="font-weight:bold; color:#3f7f00;">{$payment.DecAmount|number_format:2:'.':' '}  {"xca_coin_type"|xvLang}</span>{else}<span style="font-weight:bold; color:#bf0000;">{$payment.DecAmount|number_format:2:'.':' '}  {"xca_coin_type"|xvLang}</span>{/if}</td>
						<td class="items-date">{$payment.Date}</td>
						<td class="items-auction">{if $payment.Auction|is_null}----{else}<a href="{$URLS.Auction}/{$payment.Auction}/">{$payment.Auction}</a>{/if}</td>
					</tr>
				{/foreach}
				</tbody> 
			</table>
				<div style="float:right; padding-right: 30px">Dostępne środki : {if $Session.xv_payments_amount > 0} <span style="font-weight:bold; color:#3f7f00;">{({$Session.xv_payments_amount}/100)|number_format:2:'.':' '}  {"xca_coin_type"|xvLang}</span>{else}<span style="font-weight:bold; color:#bf0000;">{({$Session.xv_payments_amount}/100)|number_format:2:'.':' '}  {"xca_coin_type"|xvLang}</span>{/if}</div>
			<div class="xv-table-pager">
				{$pager.1}
			</div>
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