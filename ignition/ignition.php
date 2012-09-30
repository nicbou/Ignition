<?php 

//Include the ignition database
	include_once(dirname(__FILE__)."/config.php");

//User authentication
	session_start();

	//Log the user in
		if( isset($_POST['username']) && isset($_POST['password']) ){
			if( $_POST['username'] == ADMIN_USERNAME ){
				$comparison = false;
				switch( ADMIN_PASSWORD_TYPE ){
					case('plain'):
						$comparison = ( $_POST['password'] == ADMIN_PASSWORD );
						break;
					case('md5'):
						$comparison = ( md5($_POST['password']) == ADMIN_PASSWORD );
						break;
					case('sha1'):
						$comparison = ( sha1($_POST['password']) == ADMIN_PASSWORD );
						break;
				}

				if ( $comparison === true )
					$_SESSION['username'] = ADMIN_USERNAME;
			}
		}

	//Show the login form
		if( isset($_GET['login']) ){
			include(dirname(__FILE__)."/login.php");
			exit();
		}
		elseif( isset($_GET['logout']) ){
			unset($_SESSION);
			session_destroy();
		}

	//Login functions
		function is_admin(){
			if( isset($_SESSION['username']) && !empty($_SESSION['username']) )
				return true;
			else
				return false;
		}

		function is_editing($block_name){
			if( isset($_GET['edit']) && $_GET['edit']==$block_name )
				return true;
			else
				return false;
		}

	//Gettext fallback
		if( !function_exists('_')){
			function _($string){return $string;}
		}

//Connect to the database with the RedBean ORM
	require_once(dirname(__FILE__)."/redbean.php");
	R::setup('mysql:host='.DATABASE_HOST.';dbname='.DATABASE_NAME,DATABASE_USER,DATABASE_PASSWORD);

//Load the default block, which in turn loads implementations of it
	include_once(dirname(__FILE__)."/blocks/block.php");

?>