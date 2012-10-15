<?php 

//Include the ignition config
	include_once(dirname(__FILE__)."/config.php");

//Connect to the database with the RedBean ORM
	require_once(dirname(__FILE__)."/redbean.php");
	R::setup('mysql:host='.DATABASE_HOST.';dbname='.DATABASE_NAME,DATABASE_USER,DATABASE_PASSWORD);

//User authentication
	session_start();

	//Setup bcrypt to safely store and compare user passwords
		function getBcryptSalt($salt){
			//We use blowfish, and require it
			if( CRYPT_BLOWFISH != 1 )
				throw new Exception("bcrypt is not supported by your PHP installation");
			$algorythm = '$2a$';
			//The number of iterations. Higher is safer, but also slower
			$iterations = 10;
			return $algorythm . str_pad($iterations,2,'0',STR_PAD_LEFT) . '$' . $salt;
		}

	//Log the user in using the correct password comparison method
		if( isset($_POST['username']) && isset($_POST['password']) ){
			//Attempt to find a user in the database, and connect it
			$user = R::findOne(
				'ignition_users',
				' username=? AND password=?',
				array( $_POST['username'], crypt( $_POST['password'],getBcryptSalt($_POST['username']) ) )
			);

			if( !is_null($user) )
				$_SESSION['username'] = $user->username;
		}

	//Create the user with the given username and password
		if( isset($_POST['newusername']) && isset($_POST['newpassword']) && R::count('users') == 0 ){
			$user = R::dispense('ignition_users');
			$user->username = $_POST['newusername'];
			$user->password = crypt( $_POST['newpassword'],getBcryptSalt($_POST['newusername']) );
			R::store($user);
			$_SESSION['username'] = $user->username;
		}

	//Show the login form if ?login is appended to the URL
	//If there are no users in the users table, show the user creation form
		if( isset($_GET['login']) ){
			if( R::count('ignition_users') > 0 ){
				include(dirname(__FILE__)."/templates/login.php");
			}
			else{
				include(dirname(__FILE__)."/templates/createuser.php");
			}
			exit();//Do not output the rest of the page
		}
		elseif( isset($_GET['logout']) ){
			unset($_SESSION);
			session_destroy();
		}

	//Application state functions
		function isAdmin(){
			return ( isset($_SESSION['username']) && !empty($_SESSION['username']) );
		}

		function isEditing($block_name){
			return ( isset($_GET['edit']) && $_GET['edit']==$block_name );
		}

	//Password hashing functions


	//If gettext isn't enabled, define a fallback function to output text
		if( !function_exists('_')){
			function _($string){return $string;}
		}

//Load the default block. Implementations of it are loaded at the end of block.php
	include_once(dirname(__FILE__)."/blocks/block.php");

?>