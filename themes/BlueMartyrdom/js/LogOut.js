ThemeClass.LogOutFoo = function(){
document.cookie = 'UnLoged=trye; expires=Thu, 01-Jan-70 00:00:01 GMT;'; 
document.cookie = 'LogedUser=; expires=Thu, 01-Jan-70 00:00:01 GMT;'; 
document.cookie = 'LogedUserPass=; expires=Thu, 01-Jan-70 00:00:01 GMT;'; 
location.href = "?LogOut=true";
}
ThemeClass.LogOut = function()
{
  CreateWindowLayer("UnLoged",QueryView("UnLoged", Language["QuestionUnLoged"] ,"<input type='button' name='ButtonNo' onclick='ThemeClass.LogOutFoo();' value='"+ Language["Yes"] +"' class='StyleForm' /><input type='button' name='ButtonNo' value='"+ Language["No"] +"' class='StyleForm' style='margin-left:20%;' onclick='CancelWindowLayer(\"UnLoged\"); return false;' />"));
}