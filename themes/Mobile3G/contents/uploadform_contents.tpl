  <!-- Content -->
 <div id="Content">
 {if $Advertisement}
	<div class="reklamo" id="RTop">
		{$smarty.capture.ADVHeight}
	</div>
{/if}
 <div id="TitleDiv">
 {$SiteTopic}
 </div>
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
		<div id="MiniMap">
		{foreach from=$MiniMap item=Value name=minimap}
		{if $smarty.foreach.minimap.last}
		{$Value.Name}
		{else}
		<a href="{$URLS.Script}{$Value.Url|urlrepair|substr:1}">{$Value.Name}</a> <img src="{$UrlTheme}img/space.gif" />
		{/if}
		{/foreach}
		</div>
<div id="EditPanel">{$EditPanel}</div>
<div id="TextDiv">
		
	<form action="{$URLS.Script}File/?SendFile=true" method="post" enctype="multipart/form-data">
<div id="UploadForm">
		<div  class="tablediv" style="width:100%;">
			<div class="rowdiv">
				<div  class="celldiv" style="width:50%;">

		<input type="file" name="UploadForm[]" id="UploadFormInput" class="StyleForm" multiple="true"/>
		<input type="checkbox" value="true" checked="checked" class="StyleForm" id="CloudID" name="ToCloud"/> <label for="CloudID">To Cloud</label><br />
		<input type="submit" value="{$language.Send}" class="StyleForm" />
	</div>
				<div class="celldiv" style="width:300px;">
<b>Wstawienie pliku na stronę:</b><br/>
<code>&lt;file id=&quot;IDPLIKU&quot;/&gt;</code><br/>
<b>Wstawienie obrazka na stronę:</b><br/>
<code>&lt;img src=&quot;[img]&quot; replace=&quot;[img]&quot; file=&quot;IDPLIKU&quot;/&gt;</code><br/>
				</div>
			</div>
		</div>
</div>
</form>


<div style="clear: both;"> </div>



</div>
</div>
</div>
<div style="clear:both;"></div>
 <!-- /Content -->