<?php
/*
	index.php - main file
	
	This software created by Ákos Nikházy
	
	It uses the Have I Been Pwned API (https://haveibeenpwned.com/API/v2) to check a list of emails against the 5 billon+ database.
	It is a slow process because the API do not let us be faster than 1500ms between calls. As ajax is far from precize I set it
	to 3 seconds.

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

	if($passwordProtection)
	{
		startSession($sessionID);
		// session_destroy();
		if(!isset($_SESSION['login']))
		{
			if(isset($_POST['pw']))
			{
				$pass = file_get_contents('pw.txt');
				
				if($pass == saltPasswordHash($_POST['pw'],$passwordSalt))
				{
					$_SESSION['login'] = 1;
					header('location:'.(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
				} 
				else
				{?>
					<div id="error">
					<?php echo $expressions['errorWrongPassword'];?>
					</div>
				<?php
				}
				
			}
			?>
			<div id="login">
				<form method="post" action="">
					<input type="password" name="pw" placeholder="<?php echo $expressions['password'];?>"><input type="submit" value="<?php echo $expressions['login'];?>">
				<form>
			</div>
			<?php
			
		}
	
	}
	if(!$passwordProtection || ($passwordProtection && isset($_SESSION['login'])))
	{
?>
<a href="reports.php"><?php echo $expressions['reports'];?></a> <?php if($passwordProtection){ ?>| <a href="changePW.php"><?php echo $expressions['changePassword'];?></a> | <a href="logout.php"><?php echo $expressions['logout'];?></a><?php } ?>
<div id="tested">
	<table>
		<tr><td><?php echo $expressions['fileName'];?></td><td><?php echo $fileName; ?></td></tr>
		<tr><td><?php echo $expressions['testedAddress'];?></td><td id="address">-</td></tr>
		<tr><td><?php echo $expressions['finished'];?></td><td id="finished">0</td></tr>
		<tr><td><?php echo $expressions['due'];?></td><td id="due">1</td></tr>
	</table>
	<span id="pause"><?php echo $expressions['pause'];?></span>
	<span id="start"><?php echo $expressions['start'];?></span>
</div>
<div id="list">
<div id="legend"><?php echo $expressions['legend'];?>: <span class="good"><?php echo $expressions['legendOKText'];?></span>. <span class="bad"><?php echo $expressions['legendNOTOKText'];?></span></div>
</div>
<footer>Created by Ákos Nikházy - <?php echo (date('Y')>2018)?'2018-' . date('Y'):'2018'; ?> - has no affiliation with Have I Been Pwned</footer>
<script>
$(document).ready(function(){
	
	$("#list,#pause").hide();
	
	emails = [<?php $first = true;foreach($emails[0] as $email){if($first){echo '"'.$email.'"';$first = false;}else{echo ',"' . $email . '"';}} ?>];
	
	emailCount = emails.length;	
	counter = 0;	
	badList = [];
	pause = false;

	$("#start").click(function(){
		checkEmail();
		$(this).hide();
		$("#list,#pause").show();
	});
	
	$("#pause").click(function(){
		
		pause = !pause;
		
		$(this).html((pause)?"<?php echo $expressions['continue'];?>":"<?php echo $expressions['pause'];?>");
		
	});
	
	$("#due").html(emailCount - counter);
	
	function checkEmail() {
		
		$("#address").html(emails[counter]); 	
		
		if(!pause)
		{
		    $.ajax({
				url: "https://haveibeenpwned.com/api/v2/breachedaccount/"+emails[counter]+"?truncateResponse=true",
				method: "GET",
				cache: false,
				async: false,
				statusCode:{
					404: function(){
						$("#list").append('<div class="good">'+emails[counter]+'</div>');
					},
					200: function(){
						$("#list").append('<div class="bad">'+emails[counter]+'</div>');
					}
			  
				}
			}).always(function(msg){
				if(!msg.readyState){
					console.log(msg);
					badList.push([emails[counter],msg]);
					
				}
				counter++;
				$("#finished").html(counter);
				$("#due").html(emailCount - counter);
				
				if(counter<emailCount)
				{
					setTimeout(checkEmail, 3000);
				} 
				else 
				{
					$.post( "ajax/save.php", { data: JSON.stringify(badList) } ).always(function(msg) {
				
						if(msg.status == 'done'){
							$("#pause").hide();
							$("#address").html("<?php echo $expressions['done'];?> - <a href=\"reports.php\"><?php echo $expressions['reports'];?></a>"); 	
							
						}
						
						if(msg.status == 'error'){
							alert("<?php echo $expressions['errorSaveReport'];?>");
						}
					 });
					
					
					
				}
				  
			});
		}
		else 
		{
			setTimeout(checkEmail, 3000);
		}
	}	
});
</script>
<?php } ?>
</body></html>