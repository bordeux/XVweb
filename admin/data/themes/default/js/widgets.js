WidgetsClass = {};
$(function(){

//*** WIDGETS CLASS**/
	$(".xv-widget").liveDraggable({
		handle : ".xv-widget-move",
		snap: ".xv-sidebar",
		stop: function(){
			WidgetsClass.savepos(this);
		}
	});
	$(".xv-widget-close").live("click", function(){
		var widHandle = $(this).parents(".xv-widget");
		
				var jqxhr = $.getJSON(AdminLink + 'get/Widgets/Close/', {widget : widHandle.data("xv-name"), wid : widHandle.data("xv-wid")}, function (json) {
							if (json.error) {
								alert("Error with " + print_r(json));
							} else {
								widHandle.hide("slow");
							}
						}).error(function (data, textStatus) {
							alert("Error with " + print_r(textStatus));
						});
				return false;
	});
	
	
	WidgetsClass.create = function(json, functrig){
	$.get(AdminLink + 'get/Widgets/Get/', {name: json.name , wid: json.wid } , function(data) {
		  	var WidgetTheme = $('<div class="xv-widget" data-xv-name="'+json.name+'" id="widget-'+json.wid+'" data-xv-wid="'+json.wid+'">'+
						'<a href="#Close" class="xv-widget-close"></a>' +
						'<a href="#Move" class="xv-widget-move"></a>'+
							'<div class="xv-widget-area">' + 
								data +
							'</div>' +
							'<div style="clear:both"></div>' +
						'</div>');
		WidgetTheme.css({
			top: json.top,
			left: json.left
		});
		WidgetTheme.appendTo("#xv-windows");
		if(typeof functrig !== "undefined"){
			functrig();
			};
			
		});
	};
	
	WidgetsClass.add = function(xvname){
	var WidgetTMPWID = "wg-"+Math.floor(Math.random()*9999999);
		WidgetsClass.create({
			wid: WidgetTMPWID,
			name: xvname,
			top: (20+Math.floor(Math.random()*400))+"px",
			left: (20+Math.floor(Math.random()*500))+"px"
		}, function(){
			WidgetsClass.savepos($("#widget-"+WidgetTMPWID));
		});
	}
	
	WidgetsClass.savepos = function(widHandle){
			widHandle = $(widHandle);
					var jqxhd = $.getJSON(AdminLink + 'get/Widgets/Position/', {widget : widHandle.data("xv-name"), wid : widHandle.data("xv-wid"), top : widHandle.css("top"), left: widHandle.css("left"), "xv-sid" : SIDUser}, function (json) {
							if (json.error) {
								alert("Error with " + print_r(json));
							} else {
								//alert(json.result);
							}
						}).error(function (data, textStatus) {
							alert("Error with " + print_r(textStatus));
						});
	};
	
	
	if (typeof UserConfig['administration']['widgets'] !== 'undefined'){
	
	$.each(UserConfig['administration']['widgets'], function(key, value) { 
			  WidgetsClass.create({
					left: value.left,
					top: value.top,
					wid : value.wid,
					name : value.name
				});
		});
	}
	$( ".xv-sidebar" ).droppable({
			accept: ".xv-widget",
			hoverClass: "xv-sidebar-active"
		})
//*** WIDGETS CLASS**/

});