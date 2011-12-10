ThemeClass.SendComment = function(IDCom)
{
if(empty(IDCom))
var CommentFormID = $('#CommentForm'); else var CommentFormID = $('#CommentForm'+IDCom)
	if ($(CommentFormID).find("textarea").val().length < 6)
	{
		$(CommentContent).find("input[name='CommentContent']").css("border", "2px solid #FF0000");
		ErrorAlert("<b>"+ Language["ShortComment"] +"</b>");
		return false;
	} 
	if(!empty(IDCom)){
			$("#EditCommentLabel-"+IDCom).html(Language["Edit"]);
		SaveComment[IDCom] =  $("#CommentID-"+IDCom).html();	 
		sendPost("CommentID-"+IDCom, 'CommentForm'+IDCom, URLS.Script+"receiver/SC");
		$("#EditCommentLabel-"+IDCom).click(function(){
		EditComment($GetID("EditCommentLabel-"+IDCom), IDCom);
		return false;
});
return true;
	}
	
	$.ajax({
		type: "POST",
		url: URLS.Script+"receiver/AddComment",
		data: $("#CommentForm").serialize(),
		cache: false,
		dataType: "html",
		error: function(){ErrorAlert("<b>"+ Language["ServerError"] +"</b>");},
		success: function(data){
				$("#fp_comment_two").prepend(data);
				$("#"+$(data).attr("id")).hide().show("slow");
				}
	}
	);
return true;
	


};