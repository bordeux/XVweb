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
			&gt;&gt; {$Title}
	
	</div>
	<div style="clear:both;"></div>

	<div class="xvauction-sidebar">
		{include file="xvauctions_theme/contents/panel/menu_panel.tpl" inline}
	</div>	
	<div class="xvauction-right">
		

	<div class="xauction-tabs ui-tabs ui-widget ui-widget-content ui-corner-top">
		<div class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top">
			<div style="text-align:center; color: #474747; font-size: 14px;">Dodawanie komentarza</div>
		</div>
		<div>
		{if $added_comment}
			<div style="padding: 20px;">
				<div class="success">Komentarz został wystawiony!</div>
				
			</div>
		{else}

			<script type="text/javascript" src="{$URLS.Theme}xvauctions_theme/js/stars/jquery.rating.js"></script>
			<link rel="stylesheet" media="screen" type="text/css" href="{$URLS.Theme}xvauctions_theme/js/stars/jquery.rating.css" />
		{literal}	
		<script type="text/javascript">
				$(document).ready(function(){
					$(".xva-stars").rating({showCancel: false});
				});		
			
			</script>
		{/literal}
			<div style="padding: 50px;">
			<form action="?add=true" method="post">
			<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
				<div class="LightBulbTip" style="margin-bottom: 20px;">
				 Wystawiasz teraz komentarz do aukcji <a href="{$URLS.Auction}/{$bought_info.Auction}/" target="_blank"><b>{$bought_info.Title}</b> , id: {$bought_info.Auction}</a> dla użytkownika 
				</div>
				<div style="float:left">
					<table>	
					{if $comment_mode == "buyer"}					
						<tr>
							<td style="width: 200px; font-weight: bold;">Zgodność przedmiotu z opisem</td>
							<td>
								<select class="xva-stars" name="compatibility">
									<option value="1">Very poor</option>
									<option value="2">Poor</option>
									<option value="3">OK</option>
									<option value="4" selected="selected">Good</option>
									<option value="5">Very good</option>
								</select> 
							</td>
						</tr>			
						<tr>
							<td style="width: 200px; font-weight: bold;">Kontakt ze Sprzedającym</td>
							<td>
								<select class="xva-stars" name="contact">
									<option value="1">Very poor</option>
									<option value="2">Poor</option>
									<option value="3">OK</option>
									<option value="4" selected="selected">Good</option>
									<option value="5">Very good</option>
								</select> 
							</td>
						</tr>
						<tr>
							<td style="width: 200px; font-weight: bold;">Czas realizacji zamówienia</td>
							<td>
								<select class="xva-stars" name="realization">
									<option value="1">Very poor</option>
									<option value="2">Poor</option>
									<option value="3">OK</option>
									<option value="4" selected="selected">Good</option>
									<option value="5">Very good</option>
								</select> 
							</td>
						</tr>
						<tr>
							<td style="width: 200px; font-weight: bold;">Koszt wysyłki</td>
							<td>
								<select class="xva-stars" name="shipping">
									<option value="1">Very poor</option>
									<option value="2">Poor</option>
									<option value="3">OK</option>
									<option value="4" selected="selected">Good</option>
									<option value="5">Very good</option>
								</select>
							</td>
						</tr>
						{/if}
						<tr>
							<td style="width: 200px; font-weight: bold;">Typ komentarza</td>
							<td>
								<input type="radio" name="comment_type" value="positive" id="comment-type-positive" checked="checked"/>
									<label for="comment-type-positive" style="color: #009B00; font-weight: bold;">Pozytywny</label>
								<input type="radio" name="comment_type" value="neutral" id="comment-type-neutral"/>
									<label for="comment-type-neutral" style="color: #646464; font-weight: bold;">Neutralny</label>
								<input type="radio" name="comment_type" value="negative" id="comment-type-negative"/>
									<label for="comment-type-negative" style="color: #EE3E2B; font-weight: bold;">Negatywny</label>
					
							</td>
						</tr>
			
			
						<tr>
							<td style="width: 200px; font-weight: bold;">Komentarz</td>
							<td><textarea name="comment"  style="width: 300px; height: 60px;">Transakcja udana. Serdecznie polecam.</textarea></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" value="Wystaw komentarz" name="submit" /></td>
						</tr>

					</table>
				</div>
				{if $comment_mode == "buyer"}
				<div style="float:left; margin-left: 40px; width: 300px;" class="LightBulbTip">
					Oceń w skali od 1 do 5. Ocena 1 ozacza ocenę najniższą. Pamiętaj, że oceny już nie będziesz mógł zmienić. Proszę o rozwagę.
				</div> 
				{/if}
				
				<div style="float:left; margin-left: 40px; margin-top: 30px; width: 300px;" class="LightBulbTip">
					W komentarzu opisz przebieg tranzakcji.
				</div>
				</form>
				<div style="clear:both;"></div>
			</div>
			{/if}
			<div style="clear:both;"></div>
		</div>
	
	
		</div>
		
				
	</div>

	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->