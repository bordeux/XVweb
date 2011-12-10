ThemeClass.EditComment  = function(EditLink,IDComment){
	EditLink.innerHTML = Language["Cancel"];
	EditLink.onclick = function TmpFunctionOnClick(){
		$("#CommentID-"+IDComment).html(SaveComment[IDComment]);
		EditLink.innerHTML = Language["Edit"];
		EditLink.onclick = function TmpFunction(){
			EditComment(EditLink, IDComment);
		return false;
		};
		return false;
	};

	SaveComment[IDComment] =  $("#CommentID-"+IDComment).html();
	GetAjax(URLS.Script+"receiver/EC?id="+IDComment, "CommentID-"+IDComment);
};