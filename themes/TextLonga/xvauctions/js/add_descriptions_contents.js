$(function(){

var ItemTypeAuction = function(name, hide){
	if(hide){
		$("input[name='add["+name+"]']").parents(".xvauction-add-item").hide("slow")
	}else{
		$("input[name='add["+name+"]']").parents(".xvauction-add-item").show("slow")
	}
};

var refreshTypeAuction = function(){
		var AuctionType = parseInt($("select[name='add[type]']").val());
		ItemTypeAuction("buynow" ,true);
		ItemTypeAuction("auction_start" ,true);
		ItemTypeAuction("auction_min" ,true);
		ItemTypeAuction("dutch_start" ,true);
		ItemTypeAuction("dutch_min" ,true);
		switch (AuctionType){
			case 0: // kup teraz
			  ItemTypeAuction("buynow" ,false);
			  break;
			case 1: //aukcja
				ItemTypeAuction("auction_start" ,false);
				ItemTypeAuction("auction_min" ,false);
			  break;
			case 2: // kup teraz + aukcja
				ItemTypeAuction("buynow" ,false);
				ItemTypeAuction("auction_start" ,false);
				ItemTypeAuction("auction_min" ,false);
			  break;
			case 3: // aukcja holenderska
				ItemTypeAuction("dutch_start" ,false);
				ItemTypeAuction("dutch_min" ,false);
			  break;
			};
	};
	
$("select[name='add[type]']").change(refreshTypeAuction);
refreshTypeAuction();


});