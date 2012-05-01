{function settings}  
{if "AdminPanel"|xv_perm}
	<a href="{$URLS.Script}Administration/{$url}" target="_blank" style="{if $left}left:{$left}px;{/if} {if $right}right:{$right}px;{/if}{if $mleft}margin-left:{$mleft}px;{/if} {if $mright}margin-right:{$mright}px;{/if}" class="xv-settings"><span>settings</span></a>
{/if}
{/function}