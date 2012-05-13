<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{"ip_ban_title"|xv_lang}</title>
<link rel="stylesheet" href="{$URLS.Site}plugins/ip_ban/theme/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{$URLS.Site}plugins/ip_ban/theme/color_{$ip_ban_config->theme}.css" type="text/css" media="screen" />
<!--[if lt IE 7]>
<script type='text/javascript' src='unitpngfix.js'></script>
<script type='text/javascript'>clear = 'images/clear.gif';</script>
<![endif]-->
</head>
<body><div id="wrapper">
<div id="logo"  class="blank">
	<h1>{"ip_ban_h1"|xv_lang} </h1>
	<h2>{("ip_ban_message"|xv_lang)|sprintf:$check_ip->IP}</h2>
</div>
<div id="when">
	<p>{("ip_ban_expire_time"|xv_lang)|sprintf:$check_ip->Expire}</p>
</div>
<div id="form">{"ip_ban_reason"|xv_lang}:
<p>{$check_ip->Message}</p>
</div>
{if $smarty.get.ip_ban_login_mode}
	<div class="login">
	<form method="post" action="{$URLS.Script}">
	<input type="hidden" name="ip_ban_login" value="true" />
	<input type="hidden" name="xv_sid" value="{$JSVars.SIDUser}" />
		<div>
				<input type="text" name="login" autocomplete="off" placeholder="Login..." />
				<input type="password" autocomplete="off" name="password" placeholder="Password..." />
				<input type="submit" value="Login" />
		</div>
	</form>
	</div>
{else}
<div style="position:fixed; right:5px; bottom:2px;">
	<a style="color:#000;" href="?ip_ban_login_mode=true">?</a>
</div>{/if}
</div>
</body>
</html>