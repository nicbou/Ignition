<?php 

//Database configuration
	define('DATABASE_HOST','localhost');
	define('DATABASE_NAME','...');
	define('DATABASE_USER','...');
	define('DATABASE_PASSWORD','...');

//Admin login and password
	define('ADMIN_USERNAME','...');
	define('ADMIN_PASSWORD','...');

	/* The format of the ADMIN_PASSWORD variable
	** Defaults to plain text, but password can be in plain, md5 or sha1 format.
	** It is strongly recommended that you don't use 'plain', but was left there
	** for the sake of simplicity.
	** Accepted values: plain, md5, sha1 */
	define('ADMIN_PASSWORD_TYPE','plain');

?>