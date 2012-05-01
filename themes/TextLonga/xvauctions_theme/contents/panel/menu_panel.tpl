{function menu_active title=""}      
	{if $data == $panel_mode}
		<li class="xvauction-links-selected"><span>{$title}</span></li>
	{else}
		<li><a href="{$URLS.AuctionPanel}/{$data}/">{$title}</a></li>
	{/if}
{/function}

		{if "xva_Buy"|xv_perm}
		<div class="xvauction-sidebar-item">
			<div class="xvauction-sidebar-item-title">{"xca_shopping"|xv_lang}</div>
			<div class="xvauction-sidebar-item-content">
				<ul class="xvauction-links">
							{menu_active data="bought" title="xca_bought"|xv_lang}
							{menu_active data="bid" title="xca_bid"|xv_lang}
							{menu_active data="no_bought" title="xca_no_bought"|xv_lang}
				</ul>
			</div>
		</div>
		{/if}
		{if "xva_Sell"|xv_perm}
		<div class="xvauction-sidebar-item">
			<div class="xvauction-sidebar-item-title">{"xca_sale"|xv_lang}</div>
			<div class="xvauction-sidebar-item-content">
				<ul class="xvauction-links">
							<li><a href="{$URLS.AuctionsAdd}">{"xca_sell"|xv_lang}</a></li>
							{menu_active data="selled" title="xca_selled"|xv_lang}
							{menu_active data="selling" title="xca_selling"|xv_lang}
							{menu_active data="no_selled" title="xca_no_selled"|xv_lang}
							{menu_active data="to_add" title="xca_to_add"|xv_lang}
				</ul>
			</div>
		</div>	
		{/if}
		{if "xva_Sell"|xv_perm || "xva_Buy"|xv_perm}
		<div class="xvauction-sidebar-item">
			<div class="xvauction-sidebar-item-title">{"xca_comments"|xv_lang}</div>
			<div class="xvauction-sidebar-item-content">
				<ul class="xvauction-links">
							{menu_active data="comments_to_add" title="xca_comments_add"|xv_lang}
							{menu_active data="comments" title="xca_comments_received"|xv_lang}
				</ul>
			</div>
		</div>
		{/if}
		{if "xva_payments"|xv_perm}
		<div class="xvauction-sidebar-item">
			<div class="xvauction-sidebar-item-title">{"xca_payments"|xv_lang}</div>
			<div class="xvauction-sidebar-item-content">
				<ul class="xvauction-links">
							{menu_active data="payment_history" title="xca_payments_history"|xv_lang}
							{menu_active data="payment_add" title="xca_payments_add_coins"|xv_lang}
							{menu_active data="payment_transfer" title="xca_payments_transfer"|xv_lang}
				</ul>
			</div>
		</div>
		{/if}
		<div class="xvauction-sidebar-item">
			<div class="xvauction-sidebar-item-title">Moje konto</div>
			<div class="xvauction-sidebar-item-content">
				<ul class="xvauction-links">
							{menu_active data="account_address" title="Adres zamieszkania"}
							{menu_active data="account_notifications" title="Powiadomienia"}
				</ul>
			</div>
		</div>