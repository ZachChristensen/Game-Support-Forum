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
			$conn = ConnectToDB();
			$sql = "select boardName, description from board where boardID = ".$_GET["Board"].";";
			$stmt = $conn->prepare($sql);
			$stmt->execute();				
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$boardName = $stmt->fetchAll();
			echo '<h3>' . $boardName[0]['boardName'].'</h3> <p id="description">'. $boardName[0]['description'] .'</p>';
		?>
		<form method="POST" action="NewThread.php">
		<input  type="hidden" name="Board" value="<?php echo $_GET['Board'];?>" />
		<button type="submit" value="Create a new thread" class="button">New Thread</button>
		</form>
		
		<button id="backBtn" class="button" Title="Back to the home page" onclick="location.href='Home.php';">Home</button> 
			<?php
			try {
				include_once 'BoardThreadDisplayer.inc.php';
				$conn = ConnectToDB();
				$sql = "select threadID from thread where boardID = ".$_GET["Board"]." order by lastUpdated desc;";
				
				$stmt = $conn->prepare($sql);
				$stmt->execute();				
				$stmt->setFetchMode(PDO::FETCH_ASSOC);
				$AllThreadsArr = $stmt->fetchAll();
				//Displays every thread
				foreach ($AllThreadsArr as $Thread){
					$displayer = new BoardThreadDisplayer($Thread["threadID"]);
				}
			}catch(PDOException $e){
				echo $sql . "<br>" . $e->getMessage();
			}
			$conn = null;
			?>
		<p id="copyright">&copy; Zach Christensen 2015</p>
	</div> 
</body>
</html>