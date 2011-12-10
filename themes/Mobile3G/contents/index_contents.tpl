<div class="WidgetsMain" id="WidgetsMainID" >


{foreach from=$Widgets item=Widget name=WidgetsForeach}
	{foreach from=$Widget key=NameWidget item=WidgetValue}
		<div name="{$NameWidget};{$WidgetValue.name.file}" style="width:100%;"  data-role="collapsible" >
			  <h3>{$WidgetValue.name.value}</h3>
		   <div style="min-height: 109px; width: auto;" class="ui-dialog-content ui-widget-content">
			  <div>{$WidgetValue.content.value}</div>
		   </div>
		</div>	
		{/foreach}
{/foreach}
</div>
	<div style="clear:both;"> </div>