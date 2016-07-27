<?php
include_once "NewSubmit.php";

interface iSubmitter{
	function insertToDB();
	function prepName();
	function prepImage();
}

class SubmitReply extends NewSubmit implements iSubmitter{
	function __construct($post, $files){
		parent::__construct($post, $files);
		$this->insertToDB();
	}
	
	function insertToDB(){	
		try {
			include_once 'ConnectToDB.inc.php';
			$conn = ConnectToDB();
			$sql = "insert into post values(null, now(), '".addslashes($this->name)."', '". addslashes($this->post['Subject']) ."', '". $this->imageData ."', '". $this->imageName ."', '" . addslashes($this->post['Message']) . "', " . $_POST['Thread']. ");";
			$this->conn->exec($sql);
			}
		catch(PDOException $e)
			{
			echo $sql . "<br>" . $e->getMessage();
			}
		$conn = null;
	}
}

$ReplyMaker = new SubmitReply($_POST, $_FILES);
?>

<!DOCTYPE html>
<html>
<head>
	<title> Theseus & Minotaur Social Site - Success!</title>
	<link rel="shortcut icon" href="bull.ico">
	<link rel="stylesheet" href="MinotaurStyle.css">
</head>
<body>
	<div id="content">
		<h1>Theseus and Minotaur</h1>
		<h3>Post made to thread #<?php echo $_POST["Thread"] ?></h3>
		
		<div style="text-align:center;">
			<button style="margin:3em 0; float: none;"type="submit" class="button" onclick="location.href='Thread.php?Thread=<?php echo $_POST['Thread']?>'">Post Successful Click Here to Return to the Thread</button>
		</div>
	</div>
</body>
</html>
