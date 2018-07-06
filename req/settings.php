<?php
/*
	settings.php - settings
	
	This software created by Ákos Nikházy
	
*/


/*
//based on this it selects language from the lang folder. You should name lang files the same. You write "en" here the file should be "en.php"
*/
$lang 		= 'en'; 				 
// $lang 		= 'en'; 
// $lang 		= 'pl'; //not existent just an example. Create a lang/pl.php file based on the others to have more languages. 

/*
//it will read the email list from this folder
*/
$listFolder	= 'lists';				 

/*
//this file contains the email addresses to test (just filename.extension)			
*/
$fileName	= 'email-list-test.txt';

/*
//password protect the app?
*/
$passwordProtection = true;
// $passwordProtection = false;

/*
//store the password hash here. It should be a sha256 has salted like this (not actual function): sha256($passwordSalt . "password"). 
//Otherwise change the passwordSalt() function's code to fit your idea about salting
*/
$passwordFile = 'ps.txt';

/*
//salt for password. Change this if you want to hash a new password
*/
$passwordSalt = 'This Is The Salt Do Not Change This Only If You Want New Password';


/*
//the session id. Never the same as other applications on the server
*/
$sessionID = 'hibp-check-up';
?>