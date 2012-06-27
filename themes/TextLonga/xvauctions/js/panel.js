$(function(){
	$(".select_all").change(function(){
		if($(this).is(":checked")){
			$($(this).data("selector")).attr("checked", true);
		}else{
			$($(this).data("selector")).attr("checked", false);
		}
	return false;
	});

});