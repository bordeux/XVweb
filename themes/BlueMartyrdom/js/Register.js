var RegisterClass = {};

RegisterClass.CheckForm = function(){
if($("#RegLogin").val()==""){
$("#RegLogin").css("border", "2px solid #FF0000")
ErrorAlert("<b>"+ Language["EmptyNickname"] +"</b>");
return false;
}
if($("#RegPassword").val()==""){
$("#RegPassword").css("border", "2px solid #FF0000")
ErrorAlert("<b>"+ Language["EmptyPassword"] +"</b>");
return false;
}

if(!($("#RegPassword").val() == $("#RegRPassword").val())){
$("#RegPassword").css("border", "2px solid #FF0000")
$("#RegRPassword").css("border", "2px solid #FF0000")
ErrorAlert("<b>"+ Language["EmptyDifferentPassword"] +"</b>");
return false;
}

if(($("#RegPassword").val()).length < 3){
$("#RegPassword").css("border", "2px solid #FF0000")
ErrorAlert("<b>"+ Language["EmptyShortPassword"] +"</b>");
return false;
}

if(($("#RegMail").val()) == ""){
$("#RegMail").css("border", "2px solid #FF0000")
ErrorAlert("<b>"+ Language["EmptyMail"] +"</b>");
return false;
}

if(($("#RegMail").val()).indexOf("@") < 3){
$("#RegMail").css("border", "2px solid #FF0000")
ErrorAlert("<b>"+ Language["BadMail"] +"</b>");
return false;
}

if(($("#captcha").val()).length < 3){
$("#captcha").css("border", "2px solid #FF0000")
ErrorAlert("<b>"+ Language["EmptyCaptcha"] +"</b>");
return false;
}

return true;
}

RegisterClass.Send = function(){
 if(RegisterClass.CheckForm())
	sendPost('ResultRegister', 'RegisterForm', rootDir+"Register/?SingUp=true");
}

function ReoladCaptcha(){
$GetID('CaptchaImage').src = rootDir+"Captcha/captcha.gif?rand="+Math.random();
}
ThemeClass.GetRegisterWindow = function (){
  CreateWindowLayer("RegWindow" ,"<div id='RegisterDiv'><form id='RegisterForm' name='RegisterForm' method='post' onenter='RegisterClass.Send();'><br /><div id='ResultRegister'></div><label for='RegLogin'>"+ Language["Nick"] +":</label><br /><input type='text' name='register[User]' id='RegLogin' size='12' class='StyleForm' onchange='ThemeClass.ValidateUser(this)'/><br /><label for='RegPassword'>"+ Language["Password"] +":</label><br /><input type='password' id='RegPassword' name='register[Password]' class='StyleForm' size='20' /><br /><label for='RegRPassword'>Powtórz hasło:</label><br /><input type='password' class='StyleForm' name='register[RPassword]' id='RegRPassword' size='20' /><br /><label for='RegMail'>Adres e-mail:</label><br /><input type='text' class='StyleForm' name='register[Mail]' id='RegMail' size='20' /><br /><div style='margin-top : 5px;  margin-left:10%;'><div style='float: left;'><div style='float: left; vertical-align:middle;'><img style='margin-top:4px;' src='"+rootDir+"Captcha/CaptchaImage/captcha.gif?rand="+Math.random()+"' id='CaptchaImage' /></div><a href='"+rootDir+"Captcha/Audio?CaptchaWav'><img src='"+URLS.Theme+"img/blank.png' class='cssprite' id='AudioIconIMG' /></a><br /><a href='#' onclick='ReoladCaptcha(); return false;'><img src='"+URLS.Theme+"img/blank.png' class='cssprite' id='RefreshIconIMG'/></a></div><input type='text' id='captcha' name='register[Captcha]' size='7' class='StyleForm' /><br /><label for='captcha'> Kod z obrazka </label></div><br><input type='button' value='"+ Language["Send"] +"' onclick='RegisterClass.Send();' class='StyleForm'/></form> <br /></div>");
  }