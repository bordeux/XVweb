EditProfile.DeleteUserJS  = function(User) {
	CreateWindowLayer("DeleteUser" , QueryView("DeleteUser", Language["DeleteUser"].replace(/%s/i, User),"<a href='?delete=true&SIDCheck="+SIDUser+"'><input type='button' name='ButtonNo' value='"+ Language["Yes"] +"' class='StyleForm' /></a><input type='button' name='ButtonNo' value='"+ Language["No"] +"' class='StyleForm' onclick='CancelWindowLayer(\"DeleteUser\"); return false;' style='margin-left:20%;'/>"));
	return false;
}