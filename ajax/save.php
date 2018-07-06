<?php
/*
	save.php - saves a log file
	
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

if(isset($_POST['data']))
{

	file_put_contents ('../reports/'.date('Y-m-d_G-i-s').'.json',$_POST['data']);
	exit(json_encode(array('status' => 'done')));
	
}

exit(json_encode(array('status' => 'error')));
?>