<!-- Content -->
<div id="Content">
		<div id="MiniMap">
		{foreach from=$MiniMap item=Value name=minimap}
		{if $smarty.foreach.minimap.last}
			{$Value.Name}
		{else}
			<a href="{$UrlScript}{$Value.Url|urlrepair|substr:1}">{$Value.Name}</a> &gt;
		{/if}
		{/foreach}
		</div>
	<div id="Title">
	{$SiteTopic}
	</div>
	<div id="ContentDiv">
		<div id="TextDiv">
			<!-- TEXT -->
				<div id="UploadForm">
					<form action="{$UrlScript}File/?SendFile=true" method="post" enctype="multipart/form-data">
						<input type="file" name="UploadForm[]" id="UploadFormInput" class="StyleForm" /> <br/>
						<input type="submit" value="{$language.Send}" class="StyleForm" />
					</form>
				</div>
			<!-- TEXT -->
			<div style="clear:both;"></div>
		</div>
	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->