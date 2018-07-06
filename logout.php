<?php
/*
	logout.php - destroys session if password protection is on
	
	This software created by Ákos Nikházy	

*/

require_once('req/settings.php');

if($passwordProtection)
{
	
	session_start();
	session_destroy();
	
}

header('location:index.php');
?>