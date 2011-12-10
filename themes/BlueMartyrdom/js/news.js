$(document).ready(function(){

$(".VoteLeft a").click(function(){
	var DivVote = this;
	$.getJSON($(this).attr("href")+"&json=true",{ajaxmethod:true}, function(data) {
		var ToAdd = data.modified;
		if(data.result){
			$(DivVote).parent("div").find(".VoteResult").html(($(DivVote).find("div").hasClass('UpVote') ? eval($(DivVote).parent("div").find(".VoteResult").text()+"+"+ToAdd) : eval($(DivVote).parent("div").find(".VoteResult").text()+"-"+ToAdd)));
			$(DivVote).fadeTo('slow', 0.3, function() {
      $(this).attr("href", "#").unbind("click").click(function(){return false;});
    });
		}else{
		CreateWindowLayer("Error", data.message, "#ff0000");
		}
	});
	return false;
});
	


});