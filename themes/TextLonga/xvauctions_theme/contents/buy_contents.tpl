<!-- Content -->
 <div id="Content">
 {if $Advertisement}
	<div class="reklamo" id="RTop">
		{$smarty.capture.ADVHeight}
	</div>
{/if}
	<div class="xvauction-main" >

			<div class="buy-items">
			{if $buy_done}
			<div style="margin: 40px;">
				<div style="background: #F3FFCD; border: 1px solid #B1DA81; color: #4B5D40; text-align:center; padding: 20px; ">
					<h2 style="color: #60A536; font-size: 16px; font-weight:bold;">{"xca_buy_message2"|xv_lang} <a href="{$URLS.Auction}/{$auction_info.ID}/">{$auction_info.Title|escape:"htmlall"}</a></h2>
					{if $buy_type == "buy_now"}
					<span>{"xca_buy_message1"|xv_lang}</span>
						<form method="get" action="{$URLS.AuctionPanel}/payment_pay/{$bought_id}/" style="text-align:center;"> 
							<input style="line-height: 30px; height: 32px; " type="submit" value="{'xca_pay_for_think'|xv_lang}" />
						</form>
						{else}
							<span>{"xca_buy_message3"|xv_lang} <a href="{$URLS.AuctionPanel}/bid/">{"xca_here"|xv_lang}</a></span>
						{/if}
					<p>Czynności:</p>
					<ul>
						<li><a href="{$URLS.AuctionPanel}/Bought/">{"xca_go_to_bought"|xv_lang}</a></li>
						<li><a href="{$URLS.Auction}/{$auction_info.ID}/">{"xca_back_to_auction"|xv_lang}</a></li>
					</ul>
				</div>
			</div>
			{if $buy_message}
				<fieldset style="margin-top: 10px;">
					<legend>{"xca_message_from_seller"|xv_lang}</legend>
					
						<div class="xva-seller-message">
							{$buy_message}
						</div>
						<div style="clear:both;"></div>
					
				</fieldset>
			{/if}
			{else}
				<table>
					<thead> 
						<tr>
							<th class="items-thumbnail"></th>	
							<th class="items-title">{"xca_title"|xv_lang}</th>	
							<th class="items-cost">{"xca_cost_per_one"|xv_lang}</th>	
							<th class="items-pieces">{"xca_piece"|xv_lang}</th>	
							<th class="items-sum">{"xca_sum"|xv_lang}</th>	
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<a href="{$URLS.Auction}/{$auction_info.ID}/" target="_blank">
									{if $auction_info.Thumbnail}
										<img src="{$URLS.Thumbnails}/{$auction_info.Thumbnail}" alt='{$auction_info.Title|escape:"html"}'/>
									{else}
										<img src="{$URLS.Theme}xvauctions_theme/img/no_picture.png" alt='{"xca_no_picture"|xv_lang}'  />
									{/if}
								</a>
							</td>
							<td><a href="{$URLS.Auction}/{$auction_info.ID}/" target="_blank">{$auction_info.Title|escape:"htmlall"}</a> <br />
							<span style="font-size:8px;">ID: {$auction_info.ID}</span></td>
							<td>{if $buy_type == "buy_now"}<span class="item-buynow"> {$buy_cost|number_format:2:'.':' '} {"xca_coin_type"|xv_lang} </span>{else} {$buy_cost|number_format:2:'.':' '} {"xca_coin_type"|xv_lang} <br /> (licytacja) {/if}</td>
							<td>{$buy_pieces}</td>
							<td><b style="color:#0F9100;">{$buy_sum|number_format:2:'.':' '} {"xca_coin_type"|xv_lang}</b></td>
						</tr>
					</tbody>
				</table>
				{if "xva_Buy"|xv_perm}
				<form action="?buy=true" method="post" style="text-align:center;">
					<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
					<input type="hidden" name="pieces" value="{$smarty.post.pieces|escape:'htmlall'}" />
					<input type="hidden" name="type" value="{$smarty.post.type|escape:'htmlall'}" />
					<input type="hidden" name="offer" value="{$smarty.post.offer|escape:'htmlall'}" />
					<input type="hidden" name="confirm_buy" value="1" />
					<input type="submit" value="{'xca_make_offer'|xv_lang}!" />
				</form>
				{else}
					<div class="error">{"xca_not_have_access_to_buy"|xv_lang}. </div>
				{/if}
			<div>
				<p>Czynności:</p>
					<ul>
						<li><a href="{$URLS.AuctionPanel}/Bought/">{"xca_go_to_bought"|xv_lang}</a></li>
						<li><a href="{$URLS.Auction}/{$auction_info.ID}/">{"xca_back_to_auction"|xv_lang}</a></li>
					</ul>
			</div>
			{/if}
			</div>
	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->