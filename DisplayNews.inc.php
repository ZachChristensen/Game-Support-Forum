<?php
function showHomeNews(){
	try{
	if(!function_exists('ConnectToDB')){
		include_once 'ConnectToDB.inc.php';
	}
	$conn = ConnectToDB();
	$sql = "select * from newsStory order by newsID desc limit 3;";
	
	$stmt = $conn->prepare($sql);
	$stmt->execute();				
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$AllNewsArr = $stmt->fetchAll();
	//var_dump($AllNewsArr);
	echo '<div id="newsContainer">';
	echo '<h2>Latest Site News:</h2>';
	foreach ($AllNewsArr as $News){
		echo '<div style="width:33%;height:200px;display:inline-block;">
		<h3><a href="News.php?News='.$News['newsID'].'">'.$News['title'].'</a></h3>
		<p>By '.$News['author'].'</p>
		<p>On '.$News['createdOn'].'</p>
		<p>'.$News['body'].'</p>
		</div>';
	}
	echo '</div>';
	}catch(PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}
	$conn = null;
}
?>