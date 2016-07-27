<?php
include_once "NewSubmit.php";

interface iSubmitter{
	function insertToDB();
	function prepName();
	function prepImage();
}

class SubmitThread extends NewSubmit implements iSubmitter{
	public $newThreadID;
	
	function __construct($post, $files){
		parent::__construct($post, $files);
		$this->insertToDB();
	}
	
	function insertToDB(){
		try {
			$sql = "insert into thread values( null,".$_POST['Board'].", now(),false, null);";
			$this->conn->exec($sql);
			$this->newThreadID = $this->conn->lastInsertId();
			$sql = "insert into post values(null, now(), '".addslashes($this->name)."', '". addslashes($this->post['Subject']) ."', '". $this->imageData ."', '". $this->imageName ."', '" . addslashes($this->post['Message']) . "', " . $this->newThreadID. ");";
			$this->conn->exec($sql);
			}
		catch(PDOException $e){
			ErrorHandler($e);
		}
		$this->conn = null;
	}
}

$ThreadMaker = new SubmitThread($_POST, $_FILES);
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
		<h3>Thread #<?php echo  $ThreadMaker->newThreadID;?> Created!</h3>
		
		<div style="text-align:center;">
			<button style="margin:3em 0; float: none;"type="submit" class="button" onclick="location.href='Thread.php?Thread=<?php echo $ThreadMaker->newThreadID; ?>'">New Thread Successful Click Here to Return to the Thread</button>
		</div>
	</div>
</body>
</html>