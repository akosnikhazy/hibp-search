<?php
/*
	changePW.php - main file
	
	This software created by Ákos Nikházy
	


*/

require_once('req/settings.php');
require_once('req/functions.php');
require_once('lang/' . $lang . '.php');

preg_match_all('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i',file_get_contents($listFolder . '/' .$fileName),$emails); //so any file with email addresses seperated in any way goes
?>
<!doctype html>
<html lang="<?php echo $lang; ?>">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $expressions['htmlTitle'];?></title>
  <link rel="stylesheet" href="resources/css/main.css">
  <script src="resources/js/jq.js"></script>
</head>
<body>

<?php

	if(!$passwordProtection){
		header('location:index.php');
	}
	else
	{
		startSession($sessionID);
		 // session_destroy();
		if(!isset($_SESSION['login']))
		{
			header('location:index.php');
		}
		else
		{
			if(isset($_POST['oldPW']) && isset($_POST['newPW'])&& isset($_POST['repeatPW']))
			{
				
				if($_POST['oldPW'] == '' || $_POST['newPW'] == '' || $_POST['repeatPW'] == '')
				{
					?>
					
					<div id="error">
					<?php echo $expressions['errorEmptyPassword'];?>
					</div>
					
					<?php
				}
				else if(file_get_contents('pw.txt') != saltPasswordHash($_POST['oldPW'],$passwordSalt))
				{
					?>
					
					<div id="error">
					<?php echo $expressions['errorWrongPassword'];?>
					</div>
					
					<?php
					
				}
				else if($_POST['newPW'] != $_POST['repeatPW'])
				{
					?>
					
					<div id="error">
					<?php echo $expressions['errorPasswordNotSame'];?>
					</div>
					
					<?php
					
				} else {
					
					file_put_contents('pw.txt',saltPasswordHash($_POST['newPW'],$passwordSalt));
					header('location:index.php');
					
				}
					
			}
		
		
		?>

			<form method="post" action="" id="changePW">
				<label><span><?php echo $expressions['oldPW'];?></span><input type="password" name="oldPW"></label>
				<label><span><?php echo $expressions['newPW'];?></span><input type="password" name="newPW"></label>
				<label><span><?php echo $expressions['repeatPW'];?></span><input type="password" name="repeatPW"></label>
				<input type="submit" value="<?php echo $expressions['changePassword'];?>">
			</form>
			
			
		<?php 
		}
	
	}
?>
</body></html>