<!-- Content -->
 <div id="Content">
 {if $Advertisement}
	<div class="reklamo" id="RTop">
		{$smarty.capture.ADVHeight}
	</div>
{/if}
	<div class="xvauction-main" >
	
	<div class="category_parents_tree">
		<a href="{$URLS.Auctions}/">{"xca_auctions"|xv_lang}</a> 
		
		{foreach from=$category_tree item=cat_parent}
			&gt;&gt; <a href="{$URLS.Auctions}{$cat_parent.Category}">{$cat_parent.Name}</a> 
		{/foreach}
	</div>
	<div style="clear:both;"></div>
		<div class="xvauction-header">
			<div class="xvauction-header-thumbnail">
			{settings url="XVauctions/Auction/{$auction_info.ID}/"}
					{if $auction_info.Thumbnail}
						<img src="{$URLS.Thumbnails}/{$auction_info.Thumbnail}" alt='{$auction_info.Title|escape:"html"}'/>
					{else}
						<img src="{$URLS.Theme}xvauctions_theme/img/no_picture.png" alt='{"xca_no_picture"|xv_lang}'  />
					{/if}
							
			</div>
			<div class="xvauction-header-title">
				<h1>{$auction_info.Title|escape:"html"} <span>({"xca_auction_id"|xv_lang} : {$auction_info.ID})</span></h1>
			</div>
		</div>
	<div class="xvauction-info">
		<div class="xvauction-info-left">
			<div class="xvauction-info-left-caption">{"xca_informations"|xv_lang}</div>
			<table>
				<tr>
					<td>{"xca_actual_cost"|xv_lang}</td>
					<td>
							{if $auction_info.Type == "buynow"}
								{$auction_info.BuyNow|number_format:2:'.':' '} {"xca_coin_type"|xv_lang}
							{elseif $auction_info.Type == "auction"}
								{$auction_info.Auction|number_format:2:'.':' '} {"xca_coin_type"|xv_lang} 
							{elseif $auction_info.Type == "dutch"}
								{$auction_info.BuyNow|number_format:2:'.':' '} {"xca_coin_type"|xv_lang}
							{else}
								<span class="item-buynow">{$auction_info.BuyNow|number_format:2:'.':' '} {"xca_coin_type"|xv_lang}</span> <br /> 
								{"xca_auction"|xv_lang} <span class="item-auction">{$auction_info.Auction} {"xca_coin_type"|xv_lang}</span>
							{/if}
					</td>
				</tr>
				<tr>
					<td>{"xca_auction_type"|xv_lang}</td>
					<td>
					{if $auction_info.Type == "buynow"}
						<span class="item-buynow">{"xca_buynow"|xv_lang}</span>
					{elseif $auction_info.Type== "auction"}
						{"xca_normal_auction"|xv_lang}
					{elseif $auction_info.Type == "both"}
						Aukcja + <span class="item-buynow">{"xca_buynow"|xv_lang}</span>
					{elseif $auction_info.Type == "dutch"}
						{"xca_dutch_auction"|xv_lang}
					{/if}
					</td>
				</tr>
				<tr>
				<td>{"xca_to_end"|xv_lang}</td>
					<td  class="xvauction-info-period">
						{$auction_info.End|countdown:$auction_info.NowTime}
						<div>{"xca_start"|xv_lang} : {$auction_info.Start}</div>
						<div>{"xca_end"|xv_lang} : {$auction_info.End}</div>
					</td>
				</tr>				
				<tr>
					<td>{"xca_seller1"|xv_lang}</td>
					<td  class="xvauction-info-seller">
					<a href="{$URLS.Script}Users/{$auction_info.Seller|escape:'url'}/">{$auction_info.Seller}</a> (80%)
						<div>
							<a href="{$URLS.Script}Messages/Write/?To={$auction_info.Seller|escape:'url'}">{"xca_ask_question"|xv_lang}</a>
						</div>
						<div>
							<a href="{$URLS.Auctions}/?auction_seller={$auction_info.Seller|escape:'url'}">{"xca_show_his_items"|xv_lang}</a>
						</div>
					</td>
				</tr>
				<tr>
					<td>{"xca_pieces"|xv_lang}</td>
					<td>{$auction_info.Pieces-$auction_available_pieces}  / {$auction_info.Pieces}</td>
				</tr>		
				<tr>
					<td>{"xca_buy_offer"|xv_lang}</td>
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
			<div class="xvauction-info-right-caption">{"xca_bid"|xv_lang}</div>
			<div class="xvauction-info-right-content">
			{if $auction_info.Enabled}
							{if $auction_info.Type == "buynow"}
	
								<form action="{$URLS.AuctionBuy}/{$auction_info.ID}/" method="post" style="text-align:center;">
									<input type="hidden" name="confirm_buy" value="{if $xva_config.confirm_buy}0{else}1{/if}" />
									<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
									<input type="hidden" name="type" value="buynow" />
									<input type="hidden" name="auction" value="{$auction_info.ID}" />
									<div>{"xca_cost"|xv_lang}: {$auction_info.BuyNow|number_format:2:'.':' '} {"xca_coin_type"|xv_lang}</div>
									<div>{"xca_pieces"|xv_lang} : <input type="number" min="1" max="{$auction_available_pieces}" name="pieces" style="width: 55px;" {literal}pattern="(([0-9]){0,})"{/literal} value="1"/></div>
									<div><input type="image" src="{$URLS.Theme}xvauctions_theme/img/buy_now_big.png" style="width: 70px; height: 25px; background: none; border: none; " alt="{'xca_buynow'|xv_lang}"></div>
								</form>
				
							{elseif $auction_info.Type == "auction"}
								
								<form action="{$URLS.AuctionBuy}/{$auction_info.ID}/" method="post" style="text-align:center;">
								<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
								<input type="hidden" name="confirm_buy" value="{if $xva_config.confirm_buy}0{else}1{/if}" />
								<input type="hidden" name="type" value="auction" />
								<input type="hidden" name="auction" value="{$auction_info.ID}" />
									<div>{"xca_not_less_than"|xv_lang} {$auction_info.Auction|number_format:2:'.':' '} {"xca_coin_type"|xv_lang}</div>
										{literal}<div><input type="text" name="offer" pattern="((([0-9]){0,10})|(([0-9]){0,10}(\.)([0-9]){2}))" /></div>{/literal}
									<input type="submit" value="{'xca_bid'|xv_lang}" />
								</form>
								
							{elseif $auction_info.Type == "dutch"}
								<form action="{$URLS.AuctionBuy}/{$auction_info.ID}/" method="post" style="text-align:center;">
								<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
								<input type="hidden" name="confirm_buy" value="{if $xva_config.confirm_buy}0{else}1{/if}" />
								<input type="hidden" name="auction" value="{$auction_info.ID}" />
									<input type="hidden" name="type" value="buynow" />
									<div>{"xca_cost"|xv_lang} : {$auction_info.BuyNow|number_format:2:'.':' '} {"xca_coin_type"|xv_lang}</div>
									<div>{"xca_pieces"|xv_lang} : <input type="number" min="1" max="{$auction_available_pieces}" name="pieces" style="width: 55px;" {literal}pattern="(([0-9]){0,})"{/literal} value="1" /></div>
									<input type="image" src="{$URLS.Theme}xvauctions_theme/img/buy_now_big.png" style="width: 70px; height: 25px; background: none; border: none; " alt="{'xca_buynow'|xv_lang}">
								</form>
							{else}
								<form action="{$URLS.AuctionBuy}/{$auction_info.ID}/" method="post" style="text-align:center;">
								<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
								<input type="hidden" name="confirm_buy" value="{if $xva_config.confirm_buy}0{else}1{/if}" />
								<input type="hidden" name="auction" value="{$auction_info.ID}" />
									<input type="hidden" name="type" value="buynow" />
									<div>{"xca_cost"|xv_lang} : {$auction_info.BuyNow|number_format:2:'.':' '} {"xca_coin_type"|xv_lang}</div>
									<div>{"xca_pieces"|xv_lang} : <input  type="number" min="1" max="{$auction_available_pieces}" name="pieces" style="width: 55px;" {literal}pattern="(([0-9]){0,})"{/literal} value="1" /></div>
									<input type="image" src="{$URLS.Theme}xvauctions_theme/img/buy_now_big.png" style="width: 70px; height: 25px; background: none; border: none; " alt="{'xca_buynow'|xv_lang}">
								</form>
								
								<form action="{$URLS.AuctionBuy}/{$auction_info.ID}/" method="post" style="text-align:center; margin-top: 20px;">
								<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
								<input type="hidden" name="confirm_buy" value="{if $xva_config.confirm_buy}0{else}1{/if}" />
								<input type="hidden" name="auction" value="{$auction_info.ID}" />
								<input type="hidden" name="type" value="auction" />
									<div>{"xca_not_less_than"|xv_lang} {$auction_info.Auction|number_format:2:'.':' '} {"xca_coin_type"|xv_lang}</div>
										{literal}<div><input type="text" name="offer" pattern="((([0-9]){0,10})|(([0-9]){0,10}(\.)([0-9]){2}))" /></div>{/literal}
									<input type="submit" value="{'xca_bid'|xv_lang}" />
								</form>
								
							{/if}
				{else}
					<div style="padding: 20px; text-align:center;">
						<b>{"xca_sale_finished"|xv_lang}</b>
						<div>{"xca_offer"|xv_lang} : {if $auction_selled}<a href="#offers">{$auction_selled}</a>{else}{"xca_no_offer"|xv_lang}{/if}</div>
					</div>
				{/if}
			
			</div>
		<div style="text-align:right;"><a href="42">{"xca_report_violations"|xv_lang}</a></div>
		<div style="clear:both"></div>
		</div>
	</div>
	{if $auction_details}
	<div style="clear:both"></div>
		<div class="xvauction-details" >
		{foreach from=$auction_details item=detail}
			<div class="xvauction-details-item">
				<div class="xvauction-details-caption">
					{$detail.caption}
				</div>
				<div class="xvauction-details-value">
					{$detail.val}
				</div>
			</div>	
		{/foreach}
			<div style="clear:both"></div>
		</div>
	{/if}
	<div style="clear:both"></div>
		<div class="xvauction-description">
				<div class="xvauction-description-caption">{"xca_description"|xv_lang}</div>
				<div class="xvauction-description-content">
				
					<div class="xvauction-description-text">
						<!-- AUCTION CONTENT -->
						
								{$auction_description}
						
						<!-- END AUCTION CONTENT -->
						</div>
						
					<div style="clear:both;"></div>
					<div class="xvauction-description-footer">
					{foreach from=$auction_footer item=footer_set}{$footer_set}{/foreach}
					</div>
					<div style="clear:both;"></div>
				</div>
				
		</div>
	
		<div class="xvauction-offers" id="offers">
				<div class="xvauction-offers-caption">{"xca_offers"|xv_lang}</div>
				<div class="xvauction-offers-content">

						{if $auction_selled}
				<table style="width : 100%; text-align: center;">
					<thead> 
						<tr>
							<th>{"xca_user"|xv_lang}</th>
							<th>{"xca_pieces"|xv_lang}</th>
							<th>{"xca_offer1"|xv_lang}</th>
							<th>{"xca_date"|xv_lang}</th>
						</tr>
					</thead> 
				<tbody> 
				{foreach from=$auction_offers item=offer}
					<tr>
						<td>{$offer.User|substr:"0":"1"}...{$offer.User|substr:"-1"} (42%)</td>
						<td>{$offer.Pieces}</td>
						<td>{$offer.Cost} {"xca_coin_type"|xv_lang}</td>
						<td>{$offer.Date}</td>
					</tr>
				{/foreach}
				</tbody>
			</table>
						{else}
							<div style="text-align:center">{"xca_no_offers"|xv_lang}</div>
						{/if}
					<div style="clear:both;"></div>
				</div>
				
		</div>
		<div style="text-align:right; margin-right: 20px;"><b>{"xca_views"|xv_lang}: {$auction_info.Views}</b></div>
	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->