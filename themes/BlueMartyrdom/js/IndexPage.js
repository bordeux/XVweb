
var IndexPageClass = {};
IndexPageClass.Save = function (){
var WidgetOptions = {};
$('#WidgetsMainID .xv-widget').each(function(index) {

	WidgetOptions[$(this).attr("name").split(';')[0]] = {
		width : $(this).width()+"px",
		name : $(this).find('.ui-dialog-title').text(),
		file : $(this).attr("name").split(';')[1]
	};
  });

			$.post(URLS.Script+"?SaveSort=true",WidgetOptions,   function(data){

  }) 
};
$(function(){

		$('.WidgetsMain').sortable({
		connectWith: '.WidgetsMain',
		handle: '.ui-dialog-titlebar',
		cursor: 'move',
		placeholder: 'placeholder',
		forceHelperSize: true,
		forcePlaceholderSize: true,
		update: function(event, ui) {
			IndexPageClass.Save();
		},
		opacity: 0.4
	})
	.disableSelection();
	
	$('.xv-widget').resizable({
			handles: "e",
			stop: function(event, ui) { IndexPageClass.Save(); }
		});

		$(".ui-dialog-titlebar-close").click(function(){
			$(this).parents(".xv-widget").effect( "drop",{}, 500, function(){
				$(this).remove();
				IndexPageClass.Save();
			} );
		});
		
	$('.ui-dialog-title').dblclick(function() {
			$(this).html($("<input>").attr({"type":"text", "id":"EditNameWidget",  }).css("width", "100%").val($(this).text()).blur(function(){
			if($(this).val() != ""){
				$(this).replaceWith($(this).val());
				IndexPageClass.Save();
				}
		}));
		$("#EditNameWidget").focus();
	});
	
	




});