<div class="WidgetsMain" id="WidgetsMainID" >


{foreach from=$Widgets item=Widget name=WidgetsForeach}
	{foreach from=$Widget key=NameWidget item=WidgetValue}
		<div class="ui-dialog ui-widget ui-widget-content ui-corner-all  xv-widget" name="{$NameWidget};{$WidgetValue.name.file}" style="width:{$WidgetValue.width};">
		   <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
			  <span id="ui-dialog-title-dialog" class="ui-dialog-title">{$WidgetValue.name.value}</span>
			  <a class="ui-dialog-titlebar-close ui-corner-all" href="#"><span class="ui-icon ui-icon-closethick">close</span></a>
		   </div>
		   <div style="min-height: 109px; width: auto;" class="ui-dialog-content ui-widget-content">
			  <div class="widget-content">{$WidgetValue.content.value}</div>
			  <div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se" ></div>
		   </div>
		</div>	
		{/foreach}
{/foreach}


	</div>
	<div style="clear:both;"> </div>