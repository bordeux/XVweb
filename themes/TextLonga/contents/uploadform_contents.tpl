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
	<div id="EditPanel" class="ui-tabs ui-widget ui-widget-content">
		<div class="xv-title-wrapper" style="text-align:center;">
				<div class="xv-link-map">
				{foreach from=$MiniMap item=Value name=minimap}
					{if $smarty.foreach.minimap.last}
						{$Value.Name}
					{else}
						<a href="{$URLS.Script}{$Value.Url|replace:' ':'_'|urlrepair|substr:1}">{$Value.Name}</a> >>
					{/if}
				{/foreach}
			</div>
			
			<h1 class="xv-topic">{$SiteTopic|default:"Upload file"}</h1>
		</div>
	</div>

<div class="xv-text-wrapper">

<!-- TEXT -->
<form action="{$URLS.Script}File/?SendFile=true" method="post" enctype="multipart/form-data">
	<div class="xv-uploader">
			<input type="file" name="UploadForm[]"  multiple="true" />
			<input type="submit" value="{$language.Send}"  />
		</div>
</form>
<div>
	<b>Wstawienie pliku na stronę:</b><br/>
	<code>&lt;file id=&quot;IDPLIKU&quot; /&gt;</code><br/>
	<b>Wstawienie obrazka na stronę:</b><br/>
	<code>&lt;img src=&quot;-img-&quot; replace=&quot;-img-&quot; file=&quot;IDPLIKU&quot; /&gt;</code><br/>
</div>

<!-- TEXT -->
<div style="clear:both;"></div>
</div>
{if $LoadInfo}
	{include  file='info.tpl' inline}
{/if}

	<div class="reklamo" id="RCenter">
		{$smarty.capture.ADVCenter}
	</div>
	
{if $LoadComment}
	{include  file='comment.tpl' inline}
{/if}
</div>
</div>
<div style="clear:both;"></div>
 <!-- /Content -->