var XVauctionCategories = {};
XVauctionCategories.actualCat = "/";
XVauctionCategories.actualParent = "/";
XVauctionCategories.get = function(parent){
	$.getJSON(URLS['Script'] + "Administration/get/XVauctions/GetCat/", { cat: parent, random: Math.random()}, function(data) {
	$(".xv-auction-list ul *").remove();
	$(".xv-auction-list").data("xvauction-loc", parent);
		$(".xv-auction-list ul").append(
			$("<li>").html(".").data({
				"xa-cat" : "/"
			}).addClass("xvauction-category-item")
		);
		XVauctionCategories.actualParent = data.parent;
		$(".xv-auction-list ul").append(
			$("<li>").html("..").data({
				"xa-cat" : data.parent
			}).addClass("xvauction-category-item")
		);
		
		$.each(data.info, function(i,item){
			$(".auction-current-"+i).val(item);
		});
		$(".auction-fields-ul *").remove()
		$.each(data.fields, function(i,item){
			$(".auction-fields-ul").append("<li><a class='xv-get-window' href='"+ URLS['Script'] + "Administration/XVauctions/EditFields/?cat="+escape(item.Category)+"'>"+item.Category+" (fields: "+item.CountFields+")</a></li>");
		});
		
		$(".auction-edit-fields").attr("href", URLS['Script'] + "Administration/XVauctions/EditFields/?cat="+escape(data.info.Category));		
		$(".auction-edit-options").attr("href", URLS['Script'] + "Administration/XVauctions/EditOptions/?cat="+escape(data.info.Category));
		$(".auction-edit-options").attr("href", URLS['Script'] + "Administration/XVauctions/EditCatOptions/?cat="+escape(data.info.Category));
		
		$(".auction-cur-dir").val(parent);
		
		
    $.each(data.sub, function(i,item){
		$(".xv-auction-list ul").append(
			$("<li>").html(item.Name+ " <span>"+item.Childrens+"</span>").data({
				"xa-cat" : item.Category
			}).addClass("xvauction-category-item")
		);
   
    });
	XVauctionCategories.actualCat = parent;
	$('.xv-auction-list').trigger('xachanged');
  });
};


$(function(){
	XVauctionCategories.get($(".xv-auction-list").data("start"));
	$(".xvauction-category-item").live("click", function(){
		XVauctionCategories.get($(this).data("xa-cat"));
	});	
	$(".xvauction-category-back").live("click", function(){
		XVauctionCategories.get("/");
	});
});