<?php 
//Provides basic secure authentication for ignition. Uses Bcrypt and Ignition's ORM, RedBean

class DefaultAuthManager {
	//The constructor starts the session
	public function __construct(){
		session_start();
	}

	public function login($username,$password){
		//Attempt to find a user in the database, and connect it
		$user = R::findOne(
			USERS_TABLE, //Todo: configurable table name
			' username=? AND password=?',
			array( $username, crypt( $password, $this->getBcryptSalt($username) ) )
		);

		if( !is_null($user) ){
			$_SESSION['username'] = $user->username;
			return true;
		}
		else {
			return false;
		}
	}

	public function logout(){
		unset($_SESSION);
		session_destroy();
	}

	public function isUserLoggedIn(){
		return !empty($_SESSION['username']);
	}

	public function hasUsers(){
		return (R::count(USERS_TABLE) > 0);
	}

	public function createUser($username,$password){
		$user = R::dispense(USERS_TABLE);
		$user->username = $username;
		$user->password = crypt( $password, $this->getBcryptSalt($username) );
		R::store($user);
		$_SESSION['username'] = $user->username;
	}


	//Use bcrypt to generate a password hash for comparison
	private function getBcryptSalt($salt){
		//We use blowfish, and require it
		if( CRYPT_BLOWFISH != 1 )
			throw new Exception("bcrypt is not supported by your PHP installation");
		$algorythm = '$2a$';
		//The number of iterations. Higher is safer, but also slower
		$iterations = 10;
		return $algorythm . str_pad($iterations,2,'0',STR_PAD_LEFT) . '$' . $salt;
	}
}
