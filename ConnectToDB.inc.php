<?php
interface iDBConnect{
	function getConnection();
	function createConnection();
}

class DBConnect implements iDBConnect{
	public $connect;
	
	function __construct(){
		$this->createConnection();
	}
	
	function createConnection(){
		$server = "localhost";
		$user = "root";
		$pass = "";
		try{
			$connection = new PDO("mysql:host=$server;dbname=minotaurimageboard", $user, $pass);
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{
			echo "<br>" . $e->getMessage();
		}
		
		$this->connect = $connection;
	}
	
	function getConnection(){
		return $this->connect;
	}
}


function ConnectToDB(){
	$servername = "localhost";
	$username = "root";
	$password = "";
	try{
		$conn = new PDO("mysql:host=$servername;dbname=minotaurimageboard", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e)
	{
		echo "<br>" . $e->getMessage();
	}	
	return $conn;
}
?>