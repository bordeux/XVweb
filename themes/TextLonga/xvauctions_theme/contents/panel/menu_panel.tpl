{function menu_active title=""}      
	{if $data == $panel_mode}
		<li class="xvauction-links-selected"><span>{$title}</span></li>
	{else}
		<li><a href="{$URLS.AuctionPanel}/{$data}/">{$title}</a></li>
	{/if}
{/function}

		{if "xva_Buy"|xvPerm}
		<div class="xvauction-sidebar-item">
			<div class="xvauction-sidebar-item-title">{"xca_shopping"|xvLang}</div>
			<div class="xvauction-sidebar-item-content">
				<ul class="xvauction-links">
							{menu_active data="bought" title="xca_bought"|xvLang}
							{menu_active data="bid" title="xca_bid"|xvLang}
							{menu_active data="no_bought" title="xca_no_bought"|xvLang}
				</ul>
			</div>
		</div>
		{/if}
		{if "xva_Sell"|xvPerm}
		<div class="xvauction-sidebar-item">
			<div class="xvauction-sidebar-item-title">{"xca_sale"|xvLang}</div>
			<div class="xvauction-sidebar-item-content">
				<ul class="xvauction-links">
							<li><a href="{$URLS.AuctionsAdd}">{"xca_sell"|xvLang}</a></li>
							{menu_active data="selled" title="xca_selled"|xvLang}
							{menu_active data="selling" title="xca_selling"|xvLang}
							{menu_active data="no_selled" title="xca_no_selled"|xvLang}
							{menu_active data="to_add" title="xca_to_add"|xvLang}
				</ul>
			</div>
		</div>	
		{/if}
		{if "xva_Sell"|xvPerm || "xva_Buy"|xvPerm}
		<div class="xvauction-sidebar-item">
			<div class="xvauction-sidebar-item-title">{"xca_comments"|xvLang}</div>
			<div class="xvauction-sidebar-item-content">
				<ul class="xvauction-links">
							{menu_active data="comments_to_add" title="xca_comments_add"|xvLang}
							{menu_active data="comments" title="xca_comments_received"|xvLang}
				</ul>
			</div>
		</div>
		{/if}
		{if "xva_payments"|xvPerm}
		<div class="xvauction-sidebar-item">
			<div class="xvauction-sidebar-item-title">{"xca_payments"|xvLang}</div>
			<div class="xvauction-sidebar-item-content">
				<ul class="xvauction-links">
							{menu_active data="payment_history" title="xca_payments_history"|xvLang}
							{menu_active data="payment_add" title="xca_payments_add_coins"|xvLang}
							{menu_active data="payment_transfer" title="xca_payments_transfer"|xvLang}
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