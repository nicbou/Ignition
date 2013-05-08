<?php
	interface AuthManager {
		//Attempts to log a user in, returns true on success, false when credentials are wrong
		public function login($username,$password);

		//Logs a user out
		public function logout();

		//Returns true if the application has one or more users
		public function hasUsers();

		//Returns true if a user is logged in
		public function isUserLoggedIn();

		//Creates a new user
		public function createUser($username,$password);
	}