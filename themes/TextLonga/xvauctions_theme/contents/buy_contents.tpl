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
					<h2 style="color: #60A536; font-size: 16px; font-weight:bold;">Gratulujemy złożenia oferty dla <a href="{$URLS.Auction}/{$auction_info.ID}/">{$auction_info.Title|escape:"htmlall"}</a></h2>
					{if $buy_type == "buy_now"}
					<span>Możesz teraz przejść do płatności za przedmiot</span>
						<form method="get" action="{$URLS.AuctionPanel}/payment_pay/{$bought_id}/" style="text-align:center;"> 
							<input style="line-height: 30px; height: 32px; " type="submit" value="Zapłać za przedmiot" />
						</form>
						{else}
							<span>Listę licytowanych przedmiotów znajdziesz <a href="{$URLS.AuctionPanel}/bid/">tutaj</a></span>
						{/if}
					<p>Czynności:</p>
					<ul>
						<li><a href="{$URLS.AuctionPanel}/Bought/">Idź do listy kupionych przedmiotów</a></li>
						<li><a href="{$URLS.Auction}/{$auction_info.ID}/">Powrót do aukcji</a></li>
					</ul>
				</div>
			</div>
			{if $buy_message}
				<fieldset style="margin-top: 10px;">
					<legend>Wiadomość od sprzedawcy</legend>
					
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
							<th class="items-title">Tytuł</th>	
							<th class="items-cost">Cena/szt</th>	
							<th class="items-pieces">Sztuk</th>	
							<th class="items-sum">Razem</th>	
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<a href="{$URLS.Auction}/{$auction_info.ID}/" target="_blank">
									{if $auction_info.Thumbnail}
										<img src="{$URLS.Thumbnails}/{$auction_info.Thumbnail}" alt='{$auction_info.Title|escape:"html"}'/>
									{else}
										<img src="{$URLS.Theme}xvauctions_theme/img/no_picture.png" alt='{"xca_no_picture"|xvLang}'  />
									{/if}
								</a>
							</td>
							<td><a href="{$URLS.Auction}/{$auction_info.ID}/" target="_blank">{$auction_info.Title|escape:"htmlall"}</a> <br />
							<span style="font-size:8px;">ID: {$auction_info.ID}</span></td>
							<td>{if $buy_type == "buy_now"}<span class="item-buynow"> {$buy_cost|number_format:2:'.':' '} {"xca_coin_type"|xvLang} </span>{else} {$buy_cost|number_format:2:'.':' '} {"xca_coin_type"|xvLang} <br /> (licytacja) {/if}</td>
							<td>{$buy_pieces}</td>
							<td><b style="color:#0F9100;">{$buy_sum|number_format:2:'.':' '} {"xca_coin_type"|xvLang}</b></td>
						</tr>
					</tbody>
				</table>
				{if "xva_Buy"|xvPerm}
				<form action="?buy=true" method="post" style="text-align:center;">
					<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
					<input type="hidden" name="pieces" value="{$smarty.post.pieces|escape:'htmlall'}" />
					<input type="hidden" name="type" value="{$smarty.post.type|escape:'htmlall'}" />
					<input type="hidden" name="offer" value="{$smarty.post.offer|escape:'htmlall'}" />
					<input type="hidden" name="confirm_buy" value="1" />
					<input type="submit" value="Złóż ofertę!" />
				</form>
				{else}
					<div class="error">Nie masz uprawnień do kupywania przedmiotów. </div>
				{/if}
			<div>
				<p>Czynności:</p>
					<ul>
						<li><a href="{$URLS.AuctionPanel}/Bought/">Idź do listy kupionych przedmiotów</a></li>
						<li><a href="{$URLS.Auction}/{$auction_info.ID}/">Powrót do aukcji</a></li>
					</ul>
			</div>
			{/if}
			</div>
	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->