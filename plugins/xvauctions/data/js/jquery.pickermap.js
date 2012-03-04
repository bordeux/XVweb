$(function(){
var no_loaded_libs = true;

var on_loaded_libs = function(handle){

	var alpha_content = $("<div>").css({
		"width" : "650px",
		"margin" : "auto",
		"margin-top" : "50px",
		"background" : "#FFF",
		"border-radius" : "15px",
		"padding" : "30px"
	}).html(
		"<div style='text-align:center; padding: 5px;'>"+
			"Adress: <input type='text' class='adress-picker' value='"+$(handle).val()+"' />"+
			" <input type='button' class='alpha-close' value='OK' />"+
		"</div>"+
		"<div style='height: 300px; width:100%;' id='map-picker'>"+
		"</div>"+
		"<div style='clear:both'></div>"
	);
											
	var alpha_effect = $("<div>").css({
		"position" : "fixed",
		"z-index" : "99999999",
		"height" : $(window).height()+"px",
		"width" : $(window).width()+"px",
		"top" : "0",
		"left" : "0",
		"background" : "rgba(0, 0, 0, 0.6)"
	}).addClass("alpha-close").append(alpha_content).click(function(event){
		if($(event.target).is(".alpha-close")){
			$(handle).val($(this).find("input").val());
			$(this).hide("slow", function(){
				$(this).remove();
			});
		}
	});
	$("body").append(alpha_effect);

	var addresspickerMap = $( ".adress-picker" ).addresspicker({
												mapOptions: {
													  zoom: 5, 
													  center: new google.maps.LatLng(52.173931692568, 18.8525390625), 
													  scrollwheel: true,
													  mapTypeId: google.maps.MapTypeId.ROADMAP,
													  radius: ($(handle).parent().find("input[type='number']").val()*1000)
													},
											  elements: {
												map:  "#map-picker",
												lat	 : $(handle).data("lnt"),
												lng	 : $(handle).data("lng")
											  }
											});
											
									var gmarker = addresspickerMap.addresspicker( "marker");
											gmarker.setVisible(true);
											addresspickerMap.addresspicker( "updatePosition");
};
	$(".xva-pick-map").click(function(){
		if(no_loaded_libs){
		var txahandle = this;
			
				$.getScript(URLS['Site']+"plugins/xvauctions/data/js/jquery-ui-1.8.16.custom.min.js", function() {
					$.getScript(URLS['Site']+"plugins/xvauctions/data/js/jquery.ui.addresspicker.js", function() {
						on_loaded_libs(txahandle);
					});
				});
			

		}else{
			on_loaded_libs(this);
		}
	});

});