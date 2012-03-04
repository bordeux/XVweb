$(function(){
	$(".xvauction-index-category").click(function(){
		if($(this).is(".xvauction-index-selected")){
			//return false;
		}
		$(".xvauction-index-category").removeClass("xvauction-index-selected");
		$(this).addClass("xvauction-index-selected");
		var $theme = $('<a href="#ret" class="xvauction-index-item">'+
				'<div class="xvauction-index-cost">'+
					'<div class="xvauction-index-cost-bnow"></div>'+
					'<div class="xvauction-index-cost-auction"></div>'+
				'</div>'+
				'<div class="xvauction-index-title">title</div>'+
			'</a>');
		 $(".xvauction-index-item").fadeTo(300, 0, function() {
			$(this).remove();
		});
		$.getJSON(URLS.Script+'api/xvauctions/xvauctions/json/', { "get_auctions": '["'+($(this).attr("href"))+'"]'  }, function(data) {
			$.each(data.get_auctions.result.list , function(key, val){
			var $theme_set = $theme.clone();

			$theme_set.find(".xvauction-index-title").text(val.Title);
			$theme_set.css("background-image", 'url('+val.Thumbnail2+')')
			$theme_set.attr("href", URLS['Script']+"auction/"+val.ID+'/');
			$theme_set.css("opacity", "0");
			if(val.Type = "buynow"){
				$theme_set.find(".xvauction-index-cost-auction").remove();
				$theme_set.find(".xvauction-index-cost-bnow").text(val.Cost);
			}
				$theme_set.prependTo(".xvauction-index");
				$theme_set.fadeTo('slow', 1);
			});
		});
		return false;
	});	
	
	$(".xvauction-index-selected").trigger('click');
});