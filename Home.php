<!DOCTYPE html>
<html>
<head>
	<title> Theseus & Minotaur Social Site!</title>
	<link rel="stylesheet" href="MinotaurStyle.css">
	<link rel="shortcut icon" href="bull.ico">
	<meta charset="UTF-8"> 
</head>
<body>
	<div id="content">
		<h1>Theseus and Minotaur</h1>
		<?php  
		try {
			include_once 'ConnectToDB.inc.php';
			$conn = ConnectToDB();
			$sql = "select count(*) from post;";
			$stmt = $conn->prepare($sql);
			$stmt->execute();				
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$postCount = $stmt->fetchAll();
			echo '<h3>Home Page</h3> <p id="description">'. $postCount[0]['count(*)'] .' posts made so far!</p>';
			//a super complex query to go along side my other planned super complex query
			$sql = 
"SELECT a.boardID, a.boardName, a.description, a.threadCount, b.postCount, c.postCount24 from
	(select thread.boardID as 'boardID', boardName, description ,count(1) as 'threadCount' 
    from thread 
    inner join board 
    on thread.boardID = board.boardID 
    group by boardID
    ) as a
join
	(select board.boardID as 'boardID', count(1) as 'postCount' 
    from post 
    inner join thread 
    on post.threadID = thread.threadID 
    inner join board 
    on thread.boardID = board.boardID 
    group by board.boardID
    ) as b
on a.boardID = b.boardID
left join
	(select board.boardID as 'boardID', count(postID) as 'postCount24' 
    from post 
    inner join thread 
    on post.threadID = thread.threadID 
    inner join board
    on thread.boardID = board.boardID 
    WHERE thread.lastUpdated >= (DATE_SUB(now(), INTERVAL 12 Hour)) 
    group by board.boardID
    ) as c
on b.boardID = c.boardID
order by a.boardID;"
			;

			$stmt = $conn->prepare($sql);
			$stmt->execute();				
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$BoardsAndStats = $stmt->fetchAll();
			echo "<div id='homeTableContainer'><table id=\"homeTable\"><tr><th>Board Name</th><th>Total Threads</th><th>Total Posts</th><th>Posts Last 24 Hours</th></tr>";
			foreach ($BoardsAndStats as $Board){
				echo '<tr onclick="document.location = \'Board.php?Board='.$Board['boardID'].'\'"><td><p class="homeBoardTitle">'.$Board['boardName'] .'</p><p class="homeBoardDesc">'.$Board['description'].'</p></td><td>'. $Board['threadCount'] .'</td><td>'. $Board['postCount'] .'</td><td>';
				if($Board['postCount24'] == null){
					echo '0';
				}else{
					echo $Board['postCount24'];
				}
				echo '</td></tr>';
			}
			echo "</table></div>";
			
			//news section
			include_once 'DisplayNews.inc.php';
			showHomeNews();
			
			
		}catch(PDOException $e){
			$outputString = $sql . "<br>" . $e->getMessage();//instead of a thread it will return the error message and query.
		}
			$conn = null;
			?>
		<p id="copyright">&copy; Zach Christensen 2015</p>
	</div> 
</body>
</html>