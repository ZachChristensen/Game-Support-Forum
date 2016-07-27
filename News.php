<!DOCTYPE html>
<html>
<head>
	<title> Theseus & Minotaur Social Site!</title>
	<link rel="shortcut icon" href="bull.ico">
	<link rel="stylesheet" href="MinotaurStyle.css">
</head>
<body>
	<div id="content">
		<h1>Theseus and Minotaur</h1>
		<h3><?php  echo 'News Story # '. $_GET["News"];
		?></h3>		
		<?php 
			include_once 'ConnectToDB.inc.php';
			$conn = ConnectToDB();
			$sql = "select * from newsStory where newsID = ".$_GET["News"].";";
			$stmt = $conn->prepare($sql);
			$stmt->execute();				
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$News = $stmt->fetchAll();
			$News = $News[0];
			//var_dump($News);
			echo '<button style="display:inline;" id="backBtn" class="button" title="Back to the home page" onclick="location.href=\'Home.php\'">Home </button>'; 
			
			echo '<div style=" padding:1em; margin:20px;display:inline-block; width:calc(100% - 40px);background-color:#CECDE8;">';
			echo '<div style="width:100%;display:inline;">
			<h3>'.$News['title'].'</h3>
			<p>By '.$News['author'].'    On '.$News['createdOn'].'</p>
			<p>'.$News['body'].'</p>
			</div>';
			echo '</div>';
		?>
		
		<p id="copyright">&copy; Zach Christensen 2015</p>
	</div> 
</body>
</html>
