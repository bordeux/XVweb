<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
		<link rel="stylesheet" type="text/css" href="style/style.css" /> 
		<link rel="stylesheet" type="text/css" href="style/scrollpath.css" /> 
		<link href="http://fonts.googleapis.com/css?family=Terminal+Dosis&subset=latin" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="script/lib/prefixfree.min.js"></script>
		<!--[if lt IE 9]>
			<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<title>XVweb instalator</title>
	</head>
	<body>
	<form action="install_script.php" id="xv-install-form" method="post" >
		<div class="wrapper">
			<div class="start">
				<h1>XVweb instalator</h1>
				<span class="arrow">&darr;</span> Let's start <span class="arrow">&darr;</span>
			</div>
			
			<div class="license">
				<span class="big">I acept <br /><a href="license.txt" target="_blank">GNU GENERAL PUBLIC LICENSE </a></span>
				<span class="upside-down big yes-no"><a href="#yes">YES</a><a href="#no">NO</a></span>
			</div>

			<div class="db-server hide-now">
				<span class="big">Set MYSQL database server host (for example localhost)</span>
				<span class="upside-down big"><input type="text"  value="localhost" name="db_server" /></span>
				<span class="upside-down big"><a href="#next">Next</a></span>
			</div>			
			
			<div class="db-name hide-now">
				<span class="big">Set MYSQL database name</span>
				<span class="upside-down big"><input type="text"  value="" name="db_name" /></span>
				<span class="upside-down big"><a href="#next">Next</a></span>
			</div>

			<div class="db-user hide-now">
				<span class="big">Set MYSQL database user</span>
				<span class="upside-down big"><input type="text"  value="" name="db_user" /></span>
				<span class="upside-down big"><a href="#next">Next</a></span>
			</div>

			<div class="db-password hide-now">
				<span class="big">Set MYSQL database password</span>
				<span class="upside-down big"><input type="text"  value="" name="db_password" /></span>
				<span class="upside-down big"><a href="#next">Next</a></span>
			</div>

			<div class="db-prefix hide-now">
				<span class="big">Set MYSQL tables prefix</span>
				<span class="upside-down big"><input type="text"  value="xv_" name="db_prefix" /></span>
				<span class="upside-down big"><a href="#next">Next</a></span>			
			</div>

			<div class="mail hide-now">
				<span class="big">Set your em@il</span>
				<span class="upside-down big"><input type="mail"  value="" name="mail" /></span>
				<span class="upside-down big"><a href="#next">Next</a></span>		
			</div>	
			<div class="install hide-now">
				<span class="big">Start install?</span>
				<span class="upside-down big"><a href="#next">Yes, go!</a></span>		
			</div>		
			
			<div class="status">
				<textarea readonly="readonly" id="xv-install-status">
					Please wait....
				</textarea>
			</div>
		</div>
	</form>
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
	<script type="text/javascript" src="script/lib/jquery.easing.js"></script>
	<script type="text/javascript" src="script/jquery.scrollpath.js"></script>
	<script type="text/javascript" src="script/instalator.js"></script>
	</body>
</html>
