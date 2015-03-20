<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link href='http://fonts.googleapis.com/css?family=Lato:100,400' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:100,400' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/style.css" title="main styles" type="text/css" media="screen" charset="utf-8">
<script src="js/frameworks/jquery.js" charset="utf-8"></script>
<script src="js/frameworks/jqease.js" charset="utf-8"></script>
<script src="js/main.js" charset="utf-8"></script>
</head>
<body>
	<div class = "verticalCenter"></div>
	<div id = "loginBox">
		<div id = "loginTitle">Climate<b>View</b></div>
		<div id = "loginContainer">
			<div class = "credential"><span class = "prompt">Username:</span><input type="text"/></div>
			<div class = "credential"><span class = "prompt">Service Code:</span><input type="password"/></div>
			<input type = "button" value="Login" />
			<span id = "request">Request Account</span>		
		</div>
	</div>
	<video autoplay loop>
		<source src="images/clouds.mp4" type="video/mp4">
	</video>
</body>
</html>