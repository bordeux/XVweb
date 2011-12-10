$(function(){

	$("#Preview a").toggle(
	function () {

		$("#Preview #Image").html("<img src='"+$("#FileNameJS").attr("href")+"' alt='Image'/>").show("slow");
	},
	function () {
		$("#Preview #Image").hide("hide");
	}
	);
	$("#DeleteFile").click(function(){
		  CreateWindowLayer("DeleteFile" , QueryView("DeleteFile", 
  ["<div class='LightBulbTip'>",Language["DeleteArticleMSG"].replace(/%s/i, "bkj"),"</div>"].join("")
  ,//next arg
  ["<a href='?SIDCheck="+SIDUser+"&Delete=true'>","<button class='StyleForm'>",Language["Yes"],"</button></a>",
  "<a style='margin-left:20%;' href='#' onclick='CancelWindowLayer(\"DeleteFile\"); return false;' ><button class='StyleForm'>"+Language["No"]+"</button></a>"].join("")
  ));
  return false;

	});
});
