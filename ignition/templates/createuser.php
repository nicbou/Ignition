<!DOCTYPE html>
<html>
<head>
	<title>Create a new user</title>
	<style>
		body{background:#eee;width:100%;height:100%;padding:0;margin:0;font:15px/20px sans-serif}
		label,#username,#password{display:block}
		form{width:400px;height:156px;position:absolute;top:50%;left:50%;margin:-98px 0 0 -220px;padding:20px;background:#fff;border-radius:5px;box-shadow:0 2px 20px -10px rgba(0,0,0,0.5);}
			.error{padding:5px 20px;width:400px;margin:0;position:absolute;top:-15px;left:0;background:#faa;border-radius:5px 5px 0 0}
			#newusername,#newpassword{width:100%}
		p{padding:0;margin:0 0 10px;}
	</style>
</head>
<body>
	<form method="POST">
		<p>To get started with Ignition, you need to set your admin username and password below.</p>
		<label for="newusername">Username: </label>
		<input type="text" id="newusername" name="newusername"/>
		<label for="newpassword">Password: </label>
		<input type="password" id="newpassword" name="newpassword"/>
		<input type="submit" id="submit" value="Sign in"/>
	</form>
</body>
</html>