<?php 

//Include the ignition config
	include_once(dirname(__FILE__)."/config.php");

//Connect to the database with the RedBean ORM
	require_once(dirname(__FILE__)."/redbean.php");
	R::setup('mysql:host='.DATABASE_HOST.';dbname='.DATABASE_NAME,DATABASE_USER,DATABASE_PASSWORD);

//User authentication

	//The auth manager that handles user creation and login. You can provide your own.
	require_once(dirname(__FILE__)."/authentication/default_auth_manager.php");
	$authManager = new DefaultAuthManager(); //Todo: decouple this

	//Log the user in
	if( isset($_POST['username']) && isset($_POST['password']) ){
		$authManager->login($_POST['username'],$_POST['password']);
	}

	//Create the initial user with the given username and password
	if( isset($_POST['newusername']) && isset($_POST['newpassword']) && !$authManager->hasUsers() ){
		$authManager->createUser($_POST['newusername'],$_POST['newpassword']);
	}

	//Show the login form if ?login is appended to the URL
	//If there are no users in the users table, show the user creation form
	if( isset($_GET['login']) ){
		if( $authManager->hasUsers() ){
			include(dirname(__FILE__)."/templates/login.php");
		}
		else{
			include(dirname(__FILE__)."/templates/createuser.php");
		}
		exit(); //Do not output the rest of the page
	}
	elseif( isset($_GET['logout']) ){
		$authManager->logout();
	}

	//Application state functions
	function isAdmin(){
		global $authManager;
		return $authManager->isUserLoggedIn();
	}

	function isEditing($block_name){
		return ( isset($_GET['edit']) && $_GET['edit']==$block_name );
	}

	//If gettext isn't enabled, define a fallback function to output text
	if( !function_exists('_')){
		function _($string){return $string;}
	}

	//Load the default block. Implementations of it are loaded a few lines below
	include_once(dirname(__FILE__)."/blocks/block.php");

	//Include all Block implementations
	foreach (glob(dirname(__FILE__)."/blocks/*.block.php") as $filename){
		include_once $filename;
	}