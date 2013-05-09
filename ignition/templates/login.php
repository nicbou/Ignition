<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<style>
		body{background:#eee;width:100%;height:100%;padding:0;margin:0;font:15px/20px sans-serif}
		label,#username,#password{display:block}
		form{width:400px;height:122px;position:absolute;top:50%;left:50%;margin:-81px 0 0 -220px;padding:20px;background:#fff;border-radius:5px;box-shadow:0 2px 20px -10px rgba(0,0,0,0.5);}
			.error{padding:5px 20px;width:400px;margin:0;position:absolute;top:-15px;left:0;background:#faa;border-radius:5px 5px 0 0}
			#username,#password{width:100%}
		p{padding:20px;margin:-30px 0 0 -220px;width:400px;position:absolute;top:50%;left:50%;background:#fff;border-radius:5px;box-shadow:0 2px 20px -10px rgba(0,0,0,0.5)}
	</style>
</head>
<body>
	<?php if(!isAdmin()): ?>
		<form method="POST">
			<?php
				if( isset($_POST['username']) && isset($_POST['password']) ){
					echo "<div class='error'>"._('The username or password is invalid')."</div>";
				}
			?>
			<label for="username">Username: </label>
			<input type="text" id="username" name="username"/>
			<label for="password">Password: </label>
			<input type="password" id="password" name="password"/>
			<input type="submit" id="submit" value="Sign in"/>
		</form>
	<?php else:?>
		<p><?php echo _('You are now logged in, and may edit the site.')?></p>
	<?php endif;?>
</body>
</html>