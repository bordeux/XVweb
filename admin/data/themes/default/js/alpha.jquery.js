(function($) {
	jQuery.fn.jalpha = function(options) {
		if(options == "destroy"){
			$(this).trigger('jalpha.destroy');
			return this;
		}

		var options = jQuery.extend({
			zindex: 25,
			position: "absolute",
			addclass: "xv-alpha",
			background: "rgba(0,0,0, 0.6)",
			text: "",
			click : function(){
			
			}
		}, options);


		return this.each(function() {

		
		var position = $(this).position();
		var RandomNum = Math.random();
		
			$(this).after($("<div>").css({
				position:  options.position,
				zIndex: options.zindex,
				"top": position.top,
				"left": position.left,
				"height": $(this).height(),
				"width" : $(this).width(),
				"display" : "table",
				opacity: 0
			}).css("background","").css("background", options.background).addClass("xv-alpha").addClass(options.addclass).attr("id", "jalpha-"+$(this).attr("id")).click(options.click).html(options.text));
			$("#jalpha-"+$(this).attr("id")).fadeTo('slow', 1);
			
			$(this).bind('jalpha.destroy', function() {
						$("div#jalpha-"+$(this).attr("id")).fadeTo('slow', 0.0, function() {
								$(this).remove();
							});
							
			});
		});
	};
})(jQuery);
