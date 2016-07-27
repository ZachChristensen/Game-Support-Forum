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
		
		<?php  
		include_once 'ConnectToDB.inc.php';
		include_once 'LinklessThreadDisplayer.inc.php';
		include_once 'isNumericCheck.inc.php';
		
		if (isNumericCheck($_GET["Thread"])){
			$conn = ConnectToDB();
			$sql = "select boardName, description from board join thread on board.boardID = thread.boardID where threadID = ". $_GET["Thread"] .";";
			$stmt = $conn->prepare($sql);
			$stmt->execute();				
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$boardName = $stmt->fetchAll();
			echo '<h3>' . $boardName[0]['boardName'].' - Thread # '. $_GET["Thread"].'</h3> <p id="description">'. $boardName[0]['description'] .'</p>'.
			'<form method="POST" action="Reply.php">
			<input  type="hidden" name="Thread" value="'.$_GET['Thread'].'" />
			<input type="submit" value="Reply" class="button" onclick="location.href=\'Reply.php\'"></input>
			</form>';
			
			$conn = ConnectToDB();
			$sql = "select boardID from thread where threadID = ".$_GET["Thread"].";";
			$stmt = $conn->prepare($sql);
			$stmt->execute();				
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$boardName = $stmt->fetchAll();
			echo '<button id="backBtn" class="button" title="Back to board select" onclick="location.href=\'Board.php?Board='.$boardName[0]['boardID'].'\';">Board </button>'; 
			
			//display the thread	
			$displayer = new LinklessThreadDisplayer($_GET["Thread"]);
		}
		?>
		<p id="copyright">&copy; Zach Christensen 2015</p>
	</div> 
</body>
</html>
