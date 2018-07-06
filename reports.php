<?php
/*
	reports.php - report reader
	
	This software created by Ákos Nikházy
	
	This simple file reads reports that generated on index.php
	
	

*/
session_start();

require_once('req/settings.php');
require_once('lang/' . $lang . '.php');

$reports = scandir('reports');
unset($reports[0]);
unset($reports[1]);

if(!$passwordProtection || isset($_SESSION['login']))
{
?>

<!doctype html>
<html lang="<?php echo $lang; ?>">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $expressions['htmlTitleReport'];?></title>
  <link rel="stylesheet" href="resources/css/main.css">
  <script src="resources/js/jq.js"></script>
</head>
<body>
<div id="container">
	<div id="reports">
	<a href="index.php" id="mainLink"><?php echo $expressions['main'];?></a>
	<?php
	foreach($reports as $report){
		
		echo '<div>' . $report . '</div>';
		
	}
	?>
	</div>
	<div id="report"></div>
</div>
<footer>Created by Ákos Nikházy - <?php echo (date('Y')>2018)?'2018-' . date('Y'):'2018'; ?> - has no affiliation with Have I Been Pwned</footer>
<script>
$(document).ready(function(){
	$("#reports div").click(function(){
		$("#reports div").removeClass("selected");
		$(this).addClass("selected");
		$("#report").html("");
		 $.ajax({
				url: "ajax/report.php",
				method: "GET",
				cache: false,
				async: false,
				data: { file: $(this).html() }
			}).always(function(msg){
				console.log(msg);
				
				var report = JSON.parse(msg);
				
				console.log(report);
				
			
				
				for(i = 0;i<report.length;i++){
					
					html = '<div class="email">';
					html +='<div class="subemail">' + report[i][0] + '</div>';
					
					for(j = 0;j<report[i][1].length;j++){
						
						name = report[i][1][j].Name;
						html += '<div class="breach">' + name + '</div>';
					}
					
					html += '</div>';
					$("#report").append(html);
					
				}
				
				
				
				  
			});
	});
});
</script></body></html>
<?php 
	  }
	  else
	  {
		 echo $expressions['goaway'];
	  }  
?>