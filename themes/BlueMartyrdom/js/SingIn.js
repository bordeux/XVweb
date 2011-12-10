// Input 0
ThemeClass.SendLoged = function() {
  if($("#LoginLogin").val() == "") {
    $("#LoginLogin").css("border", "2px solid #FF0000");
    ErrorAlert("<b>" + Language["EmptyNickname"] + "</b>");
    return false
  }if($("#LoginPassword").val() == "") {
    $("#LoginPassword").css("border", "2px solid #FF0000");
    ErrorAlert(Language["EmptyNickname"]);
    return false
  }if($("#LoginPassword").val().length < 3) {
    $("#LoginPassword").css("border", "2px solid #FF0000");
    ErrorAlert(Language["EmptyShortPassword"]);
    return false
  }sendPost("LoginDiv", "LoginForm", URLS.Script + "login/signin")
};
ThemeClass.SendLogedOpenID = function() {
  var a = $("form[name=LoginFormOpenID] input[name=openid_url]"), b = new RegExp;
  b.compile("^([A-Za-z]+://|)[A-Za-z0-9-_]+\\.[A-Za-z0-9-_%&?/.=]+$");
  if(!b.test(a.val())) {
    a.css("border", "2px solid #FF0000");
    ErrorAlert("<b>" + Language["BadOpenID"] + "</b>");
    return false
  }$("form[name=LoginFormOpenID]").attr("action", URLS.Script + "OpenID/OpenIDLogin/");
  $("form[name=LoginFormOpenID]").submit();
  return true
};
ThemeClass.LogedWindow = function() {
CreateWindowLayer("LogWindow", 
 ["<div id='LoginDiv'>",
	  "<div style='float:left;'>",
		  "<a href='#' onclick='ThemeClass.LogedWihtOpenID(); return false;'>",
			"<img src='" , URLS.Theme , "img/blank.png' class='cssprite OpenIDIconIMG' alt='OpenID'/>",
		  "</a>",
		  " <a href='" , URLS.Script , "GoogleID/?Path=", location.href.match(/^.*\//) ,"'>",
			"<img src='" , URLS.Theme , "img/blank.png' class='GoogleIMG' alt='Google Account'/>",
		  "</a>",
		  " <a href='" , URLS.Script , "Facebook/?Path=", location.href.match(/^.*\//) ,"'>",
			"<img src='" , URLS.Theme , "img/blank.png' class='FacebookLogin' alt='Facebook Account'/>",
		  "</a>",
	  "</div>",
	  "<form id='LoginForm' name='LoginForm' method='post' onsubmit='ThemeClass.SendLoged(); return false;' style='clear:both;'>",
	  "<br />",
		"<label for='textinput'>",Language["Nick"], ":</label>",
	  "<br />",
		"<input type='text' class='StyleForm' name='LoginLogin' id='LoginLogin' size='12' />",
	  "<br />",
		"<label for='passwordinput'>" , Language["Password"] , ":</label>",
	  "<br />",
		"<input type='password' class='StyleForm' type='text' name='LoginPassword' id='LoginPassword' size='20' />",
	  "<br />",
		"<input type='checkbox' value='true' name='LoginRemember' id='LoginRememberID' />",
		" <label for=\"LoginRememberID\">" , Language["RememberPassword"] , " </label>",
	  "<br /><br />",
		"<input type='submit' name='ButtonOk' value='"+Language["Send"]+"' class='StyleForm' onclick='ThemeClass.SendLoged(); return false;' />",
	  "</form>",
	  "<br />",
		"<a href='#' onclick='LostPasswordJS(); return false;' >Zapomnia\u0142em has\u0142a</a>  | <a href='#' onclick='RegisterWindows(); return false;'>Zarejestruj si\u0119</a>",
"</div>"].join(String.fromCharCode(13)));
};
ThemeClass.LogedWihtOpenID = function() {
  CreateWindowLayer("LogWindowOpenID", 
 ["<div id='LoginDivOpenID'>",
	 "<form id='LoginFormOpenID' name='LoginFormOpenID' method='post' onsubmit='ThemeClass.SendLogedOpenID();' >",
		 "<br />",
			"<label for='textinput'>" , Language["OpenID"] , ":</label>",
		 "<br />",
			"<input type='text' id='textinput' class='StyleForm' name='openid_url' style='width:200px; background: url(" + URLS.Theme + "img/icon_openid.gif) no-repeat; padding-left: 18px;' />",
		 "<br />",
			"<input type='checkbox' value='true' name='LoginRemember' id='LoginRememberID' />",
			" <label for=\"LoginRememberID\">" , Language["RememberMe"] , " </label>",
		 "<br />",
		 "<br />",
			"<input type='button' name='ButtonOk' value='" , Language["Send"] , "' class='StyleForm' onclick='ThemeClass.SendLogedOpenID(); return false;' />",
	 "</form>",
 "</div>"].join(String.fromCharCode(13)));
};