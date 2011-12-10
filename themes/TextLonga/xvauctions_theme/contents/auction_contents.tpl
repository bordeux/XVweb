<!-- Content -->
 <div id="Content">
 {if $Advertisement}
	<div class="reklamo" id="RTop">
		{$smarty.capture.ADVHeight}
	</div>
{/if}
	<div class="xvauction-main" >
	
	<div class="category_parents_tree">
		<a href="{$URLS.Auctions}/">{"xca_auctions"|xvLang}</a> 
		
		{foreach from=$category_tree item=cat_parent}
			&gt;&gt; <a href="{$URLS.Auctions}{$cat_parent.Category}">{$cat_parent.Name}</a> 
		{/foreach}
	</div>
	<div style="clear:both;"></div>
		<div class="xvauction-header">
			<div class="xvauction-header-thumbnail">
					{if $auction_info.Thumbnail}
						<img src="{$URLS.Thumbnails}/{$auction_info.Thumbnail}" alt='{$auction_info.Title|escape:"html"}'/>
					{else}
						<img src="{$URLS.Theme}xvauctions_theme/img/no_picture.png" alt='{"xca_no_picture"|xvLang}'  />
					{/if}
							
			</div>
			<div class="xvauction-header-title">
				<h1>{$auction_info.Title|escape:"html"} <span>({"xca_auction_id"|xvLang} : {$auction_info.ID})</span></h1>
			</div>
		</div>
	<div class="xvauction-info">
		<div class="xvauction-info-left">
			<div class="xvauction-info-left-caption">{"xca_informations"|xvLang}</div>
			<table>
				<tr>
					<td>{"xca_actual_cost"|xvLang}</td>
					<td>
							{if $auction_info.Type == "buynow"}
								{$auction_info.BuyNow|number_format:2:'.':' '} {"xca_coin_type"|xvLang}
							{elseif $auction_info.Type == "auction"}
								{$auction_info.Auction|number_format:2:'.':' '} {"xca_coin_type"|xvLang} 
							{elseif $auction_info.Type == "dutch"}
								{$auction_info.BuyNow|number_format:2:'.':' '} {"xca_coin_type"|xvLang}
							{else}
								<span class="item-buynow">{$auction_info.BuyNow|number_format:2:'.':' '} {"xca_coin_type"|xvLang}</span> <br /> 
								{"xca_auction"|xvLang} <span class="item-auction">{$auction_info.Auction} {"xca_coin_type"|xvLang}</span>
							{/if}
					</td>
				</tr>
				<tr>
					<td>{"xca_auction_type"|xvLang}</td>
					<td>
					{if $auction_info.Type == "buynow"}
						<span class="item-buynow">{"xca_buynow"|xvLang}</span>
					{elseif $auction_info.Type== "auction"}
						{"xca_normal_auction"|xvLang}
					{elseif $auction_info.Type == "both"}
						Aukcja + <span class="item-buynow">{"xca_buynow"|xvLang}</span>
					{elseif $auction_info.Type == "dutch"}
						{"xca_dutch_auction"|xvLang}
					{/if}
					</td>
				</tr>
				<tr>
				<td>{"xca_to_end"|xvLang}</td>
					<td  class="xvauction-info-period">
						{$auction_info.End|countdown:$auction_info.NowTime}
						<div>{"xca_start"|xvLang} : {$auction_info.Start}</div>
						<div>{"xca_end"|xvLang} : {$auction_info.End}</div>
					</td>
				</tr>				
				<tr>
					<td>{"xca_seller1"|xvLang}</td>
					<td  class="xvauction-info-seller">
					<a href="{$URLS.Script}Users/{$auction_info.Seller|escape:'url'}/">{$auction_info.Seller}</a> (80%)
						<div>
							<a href="{$URLS.Script}Messages/Write/?To={$auction_info.Seller|escape:'url'}">{"xca_ask_question"|xvLang}</a>
						</div>
						<div>
							<a href="{$URLS.Auctions}/?auction_seller={$auction_info.Seller|escape:'url'}">{"xca_show_his_items"|xvLang}</a>
						</div>
					</td>
				</tr>
				<tr>
					<td>{"xca_pieces"|xvLang}</td>
					<td>{$auction_info.Pieces-$auction_available_pieces}  / {$auction_info.Pieces}</td>
				</tr>		
				<tr>
					<td>{"xca_buy_offer"|xvLang}</td>
					<td>	
					{if $auction_info.AuctionsCount}
							{$auction_info.AuctionsCount}
						{else}
								-
						{/if}
					</td>
				</tr>
			</table>

		</div>	
		<div class="xvauction-info-right">
			<div class="xvauction-info-right-caption">{"xca_bid"|xvLang}</div>
			<div class="xvauction-info-right-content">
			{if $auction_info.Enabled}
							{if $auction_info.Type == "buynow"}
	
								<form action="{$URLS.AuctionBuy}/{$auction_info.ID}/" method="post" style="text-align:center;">
									<input type="hidden" name="confirm_buy" value="{if $xva_config.confirm_buy}0{else}1{/if}" />
									<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
									<input type="hidden" name="type" value="buynow" />
									<input type="hidden" name="auction" value="{$auction_info.ID}" />
									<div>{"xca_cost"|xvLang}: {$auction_info.BuyNow|number_format:2:'.':' '} {"xca_coin_type"|xvLang}</div>
									<div>{"xca_pieces"|xvLang} : <input type="number" min="1" max="{$auction_available_pieces}" name="pieces" style="width: 55px;" {literal}pattern="(([0-9]){0,})"{/literal} value="1"/></div>
									<div><input type="image" src="{$URLS.Theme}xvauctions_theme/img/buy_now_big.png" style="width: 70px; height: 25px; background: none; border: none; " alt="{'xca_buynow'|xvLang}"></div>
								</form>
				
							{elseif $auction_info.Type == "auction"}
								
								<form action="{$URLS.AuctionBuy}/{$auction_info.ID}/" method="post" style="text-align:center;">
								<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
								<input type="hidden" name="confirm_buy" value="{if $xva_config.confirm_buy}0{else}1{/if}" />
								<input type="hidden" name="type" value="auction" />
								<input type="hidden" name="auction" value="{$auction_info.ID}" />
									<div>{"xca_not_less_than"|xvLang} {$auction_info.Auction|number_format:2:'.':' '} {"xca_coin_type"|xvLang}</div>
										{literal}<div><input type="text" name="offer" pattern="((([0-9]){0,10})|(([0-9]){0,10}(\.)([0-9]){2}))" /></div>{/literal}
									<input type="submit" value="{'xca_bid'|xvLang}" />
								</form>
								
							{elseif $auction_info.Type == "dutch"}
								<form action="{$URLS.AuctionBuy}/{$auction_info.ID}/" method="post" style="text-align:center;">
								<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
								<input type="hidden" name="confirm_buy" value="{if $xva_config.confirm_buy}0{else}1{/if}" />
								<input type="hidden" name="auction" value="{$auction_info.ID}" />
									<input type="hidden" name="type" value="buynow" />
									<div>{"xca_cost"|xvLang} : {$auction_info.BuyNow|number_format:2:'.':' '} {"xca_coin_type"|xvLang}</div>
									<div>{"xca_pieces"|xvLang} : <input type="number" min="1" max="{$auction_available_pieces}" name="pieces" style="width: 55px;" {literal}pattern="(([0-9]){0,})"{/literal} value="1" /></div>
									<input type="image" src="{$URLS.Theme}xvauctions_theme/img/buy_now_big.png" style="width: 70px; height: 25px; background: none; border: none; " alt="{'xca_buynow'|xvLang}">
								</form>
							{else}
								<form action="{$URLS.AuctionBuy}/{$auction_info.ID}/" method="post" style="text-align:center;">
								<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
								<input type="hidden" name="confirm_buy" value="{if $xva_config.confirm_buy}0{else}1{/if}" />
								<input type="hidden" name="auction" value="{$auction_info.ID}" />
									<input type="hidden" name="type" value="buynow" />
									<div>{"xca_cost"|xvLang} : {$auction_info.BuyNow|number_format:2:'.':' '} {"xca_coin_type"|xvLang}</div>
									<div>{"xca_pieces"|xvLang} : <input  type="number" min="1" max="{$auction_available_pieces}" name="pieces" style="width: 55px;" {literal}pattern="(([0-9]){0,})"{/literal} value="1" /></div>
									<input type="image" src="{$URLS.Theme}xvauctions_theme/img/buy_now_big.png" style="width: 70px; height: 25px; background: none; border: none; " alt="{'xca_buynow'|xvLang}">
								</form>
								
								<form action="{$URLS.AuctionBuy}/{$auction_info.ID}/" method="post" style="text-align:center; margin-top: 20px;">
								<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
								<input type="hidden" name="confirm_buy" value="{if $xva_config.confirm_buy}0{else}1{/if}" />
								<input type="hidden" name="auction" value="{$auction_info.ID}" />
								<input type="hidden" name="type" value="auction" />
									<div>{"xca_not_less_than"|xvLang} {$auction_info.Auction|number_format:2:'.':' '} {"xca_coin_type"|xvLang}</div>
										{literal}<div><input type="text" name="auction_val" pattern="((([0-9]){0,10})|(([0-9]){0,10}(\.)([0-9]){2}))" /></div>{/literal}
									<input type="submit" value="{'xca_bid'|xvLang}" />
								</form>
								
							{/if}
				{else}
					<div style="padding: 20px; text-align:center;">
						<b>{"xca_sale_finished"|xvLang}</b>
						<div>{"xca_offer"|xvLang} : {if $auction_selled}<a href="#offers">{$auction_selled}</a>{else}{"xca_no_offer"|xvLang}{/if}</div>
					</div>
				{/if}
			
			</div>
		<div style="text-align:right;"><a href="42">{"xca_report_violations"|xvLang}</a></div>
		<div style="clear:both"></div>
		</div>
	</div>
	<div style="clear:both"></div>
	<div class="xvauction-post">
		
	</div>
	<div style="clear:both"></div>
		<div class="xvauction-description">
				<div class="xvauction-description-caption">{"xca_description"|xvLang}</div>
				<div class="xvauction-description-content">
				<!-- AUCTION CONTENT -->
				
						{$auction_description}
				
				<!-- END AUCTION CONTENT -->
					<div style="clear:both;"></div>
				</div>
				
		</div>
	
		<div class="xvauction-offers" id="offers">
				<div class="xvauction-offers-caption">{"xca_offers"|xvLang}</div>
				<div class="xvauction-offers-content">

						{if $auction_selled}
				<table style="width : 100%; text-align: center;">
					<thead> 
						<tr>
							<th>{"xca_user"|xvLang}</th>
							<th>{"xca_pieces"|xvLang}</th>
							<th>{"xca_offer1"|xvLang}</th>
							<th>{"xca_date"|xvLang}</th>
						</tr>
					</thead> 
				<tbody> 
				{foreach from=$auction_offers item=offer}
					<tr>
						<td>{$offer.User|substr:"0":"1"}...{$offer.User|substr:"-1"} (42%)</td>
						<td>{$offer.Pieces}</td>
						<td>{$offer.Cost} {"xca_coin_type"|xvLang}</td>
						<td>{$offer.Date}</td>
					</tr>
				{/foreach}
				</tbody>
			</table>
						{else}
							<div style="text-align:center">{"xca_no_offers"|xvLang}</div>
						{/if}
					<div style="clear:both;"></div>
				</div>
				
		</div>
		<div style="text-align:right; margin-right: 20px;"><b>{"xca_views"|xvLang}: {$auction_info.Views}</b></div>
	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->