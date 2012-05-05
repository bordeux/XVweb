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
</div>
</body>
</html>