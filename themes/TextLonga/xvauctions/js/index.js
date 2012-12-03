function xva_number_format(nStr)
{
  nStr += '';
  x = nStr.split('.');
  x1 = x[0];
  x2 = x.length > 1 ? '.' + x[1] : '';
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(x1)) {
    x1 = x1.replace(rgx, '$1' + ' ' + '$2');
  }
  return x1 + x2;
};
$(function(){
	$(".xvauction-index .xvauction-index-category").click(function(){
		if($(this).is(".xvauction-index-selected")){
			//return false;
		}
		$(".xvauction-index-category").removeClass("xvauction-index-selected");
		$(this).addClass("xvauction-index-selected");
		var $theme = $('<a href="#ret" class="xvauction-index-item">'+
				'<div class="xvauction-index-cost">'+
					'<div class="xvauction-index-cost-bnow" title="Kup teraz!"></div>'+
					'<div class="xvauction-index-cost-auction" title="Aukcja"></div>'+
				'</div>'+
				'<div class="xvauction-index-title">title</div>'+
			'</a>');
		 $(".xvauction-index-item").fadeTo(300, 0, function() {
			$(this).remove();
		});
		
		$.post(URLS.Script+'api/xvauctions/xvauctions/json/', { "get_auctions": '["'+(($(this).attr("href")))+'"]' },
		 function(data) {
			$.each(data.get_auctions.result.list, function(key, val){
			var $theme_set = $theme.clone();

			$theme_set.find(".xvauction-index-title").text(val.Title);
			$theme_set.css("background-image", 'url('+val.Thumbnail2+')')
			$theme_set.attr("href", URLS['Script']+"auction/"+val.ID+'/');
			$theme_set.css("opacity", "0");
			if(val.Type == "buynow" || val.Type == "advert" || val.Type == "dutch"){
				$theme_set.find(".xvauction-index-cost-auction").remove();
				$theme_set.find(".xvauction-index-cost-bnow").text(xva_number_format(val.Cost));
			}else if(val.Type == "auction"|| val.Type == "errand"){
				$theme_set.find(".xvauction-index-cost-bnow").remove();
				$theme_set.find(".xvauction-index-cost-auction").text(xva_number_format(val.Cost));
			}else if(val.Type == "both"){
				$theme_set.find(".xvauction-index-cost-bnow").text(xva_number_format(val.Cost));
				$theme_set.find(".xvauction-index-cost-auction").text(xva_number_format(val.Cost2));
			}
				$theme_set.appendTo(".xvauction-index");
				$theme_set.fadeTo('slow', 1);
			});
			$(".xvauction-index").append("<div style='clear:both;'></div>");
			
		}, "json");
 
	
		/*$.getJSON(URLS.Script+'api/xvauctions/xvauctions/json/', (window.btoa ? { "get_auctions_b64": '["'+(window.btoa($(this).attr("href")))+'"]'  } : { "get_auctions": '["'+(($(this).attr("href")))+'"]'  } ), function(data) {
			$.each((window.btoa ? data.get_auctions_b64.result.list : data.get_auctions.result.list ), function(key, val){
			var $theme_set = $theme.clone();

			$theme_set.find(".xvauction-index-title").text(val.Title);
			$theme_set.css("background-image", 'url('+val.Thumbnail2+')')
			$theme_set.attr("href", URLS['Script']+"auction/"+val.ID+'/');
			$theme_set.css("opacity", "0");
			if(val.Type == "buynow"){
				$theme_set.find(".xvauction-index-cost-auction").remove();
				$theme_set.find(".xvauction-index-cost-bnow").text(val.Cost);
			}else if(val.Type == "auction"){
				$theme_set.find(".xvauction-index-cost-bnow").remove();
				$theme_set.find(".xvauction-index-cost-auction").text(val.Cost);
			}else if(val.Type == "both"){
				$theme_set.find(".xvauction-index-cost-bnow").text(val.Cost);
				$theme_set.find(".xvauction-index-cost-auction").text(val.Cost2);
			}
				$theme_set.appendTo(".xvauction-index");
				$theme_set.fadeTo('slow', 1);
			});
			$(".xvauction-index").append("<div style='clear:both;'></div>");
			
		});*/
		return false;
	});	
	
	$(".xvauction-index-selected").trigger('click');
});