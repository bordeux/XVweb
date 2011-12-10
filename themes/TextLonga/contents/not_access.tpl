<!-- Content -->
 <div id="Content">
<div id="ContentDiv">
		{if $smarty.get.msg}
			<div class="{if $smarty.get.success}success{else}failed{/if}">
			{if $smarty.get.title}<h2>{$smarty.get.title|escape:"html"}</h2>{/if}
				{$smarty.get.msg|escape:"html"}
				{if $smarty.get.list}
				<ul>
					{foreach from=$smarty.get.list item=Value name=minimap}
					<li>{$Value|escape:"html"}</li>
					{/foreach}
				</ul>
				{/if}
			</div>
		{/if}
		<div class="error">
			<h2>Brak dostępu</h2>
			Nie masz dostepu do przeglądania tej treści. Spróbój się zarejestrować.
		</div>
</div>
</div>
<div style="clear:both;"></div>
 <!-- /Content -->