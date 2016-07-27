<?php
try {
	include_once 'ConnectToDB.inc.php';
	$conn = ConnectToDB();
	$stmt = $conn->prepare('SELECT image, imageName FROM post WHERE postID=' .$_GET['id'] . ' LIMIT 1;');

	$stmt->execute();
	
	$allData = $stmt->fetch(PDO::FETCH_ASSOC);
	$image = $allData['image'];
	$fileName = $allData['imageName'];
	if ($image != null) {
		header("Content-type: image/jpeg");
		header("Content-Disposition: inline; filename=".$fileName."");
		echo $image;
	}
	else{
		return null;
	}
}
catch(PDOException $e) {
	// error
	echo 'ERROR Query: ' . $e->getMessage();
	die();
}
?>