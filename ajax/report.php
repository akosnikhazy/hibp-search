<?php
/*
	report.php - read a report
	
	This software created by Ákos Nikházy

*/
session_start();

require_once('../req/settings.php');

header('Content-Type: application/json');

if(empty($_SERVER['HTTP_X_REQUESTED_WITH']))
	exit(json_encode(array('status' => 'error')));

if($passwordProtection && !isset($_SESSION['login']))
{
		
	exit(json_encode(array('status' => 'error')));
	
}

if(isset($_GET['file']))
{
	
	exit(json_encode(file_get_contents('../reports/' . $_GET['file'])));
	
}

exit(json_encode(array('status' => 'error')));
?>
