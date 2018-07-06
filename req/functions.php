<?php
/*
	function.php - collection of functions duh
	
	This software created by Ákos Nikházy
	

*/
function saltPasswordHash($pw,$salt)
{

	return hash('sha256', $salt.$pw);
	
}

function startSession($id)
{
	session_id($id);
	session_start();
}

function vd($var,$die = false)
{//Var_Dump on steroids. 
	echo '<pre>';
	var_dump($var);
	echo '</pre>';	
	
	if($die) die(); // :)
}

?>