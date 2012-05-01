  <!-- Content -->
 <div id="Content">
	 <div id="TitleDiv">
		{$SiteTopic}
	 </div>
	<div id="ContentDiv" >
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
			
			<div id="EditPanel" class="ui-tabs ui-widget ui-widget-content ui-corner-top">
				<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top">
					<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary">
						<a href="#Wysiwyg" title="{$language.Content}"  class="xv-tab" rel="Wysiwyg" style="padding-left:20px;"> <span class="ui-icon ui-icon-pencil" style="margin-left:-16px;"></span>{$language.Content} - WYSIWYG</a>
					</li>
					<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary">
						<a href="#EditForm" title="{$language.Content}"  class="xv-tab" rel="EditForm" style="padding-left:20px;"> <span class="ui-icon ui-icon-pencil" style="margin-left:-16px;"></span>{$language.Content}</a>
					</li>
					{if $WriteUrlArticle}
						<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary">
							<a href="#LoadFromFile" title="{$language.Settings}" class="xv-tab" rel="LoadFromFile"  style="padding-left:20px;"> <span class="ui-icon ui-icon-document" style="margin-left:-16px;"></span>{$language.LoadFromFile}</a>
						</li>
					{else}
					<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary">
						<a href="#EditStetting"  title="{$language.Settings}" class="xv-tab" rel="EditStetting"  style="padding-left:20px;"> <span class="ui-icon ui-icon-gear" style="margin-left:-16px;"></span>{$language.Settings}</a>
					</li>
					{/if}
				</ul>
				
				<div id="MiniMap">
				{foreach from=$MiniMap item=Value name=minimap}
					{if $smarty.foreach.minimap.last}
						{$Value.Name}
					{else}
						<a href="{$URLS.Script}{$Value.Url|replace:' ':'_'|urlrepair|substr:1}">{$Value.Name}</a> <img src="{$UrlTheme}img/blank.png" class="cssprite SpaceIconIMG" alt="&gt;&gt;"/>
					{/if}
				{/foreach}
				</div>
			</div>
		<div class="xv-text-wrapper" style="width: 95%;">
			<!-- TEXT -->
			<!-- WYSIWYG EDITOR START -->   
				<fieldset id="Wysiwyg">
				{if $smrty.get.exploit != "true"}
					{include file="contents/write_edit_wysiwyg.tpl" inline}
				{/if}
				</fieldset>
			<!-- WYSIWYG EDITOR END --> 

			<!-- NORMAL EDITOR START -->   
				<fieldset id="EditForm">
					{include file="contents/write_edit_normal.tpl" inline}
				</fieldset>
			<!-- NORMAL EDITOR END --> 

			<!-- DOC UPLOAD  START --> 
				<fieldset id="LoadFromFile" style="display:none;">
					<legend>{$language.LoadFromFile}</legend>
					{include file="contents/write_edit_upload.tpl" inline}
				</fieldset>
			<!-- DOC UPLOAD  END --> 

			<!-- SETTINGS EDITOR START --> 
				<fieldset style="display:none;" id="EditStetting">
					<legend>{$language.Settings}</legend>
						{include file="contents/write_edit_settings.tpl" inline}
				</fieldset>
			<!-- SETTINGS EDITOR END --> 
		</div>
	</div>
</div>
<div style="clear:both;"></div>
 <!-- /Content -->