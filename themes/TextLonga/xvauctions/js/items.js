$(function(){
	$(".items-thumbnail img").hover(
	  function () {
		var big_th_url = $(this).attr("src");
		big_th_url = big_th_url.replace("/xvauctions/th/","/xvauctions/th/300x200_");
		$(this).parent().append($("<div>").css({
			position: "absolute",
			marginLeft : "60px"
		}).addClass("xva-th-big").html($("<img>").attr({
			src : big_th_url,
			alt : "Please wait"
		})));
	  }, 
	  function () {
		$(this).parent().find(".xva-th-big").remove();
	  }
	);
});