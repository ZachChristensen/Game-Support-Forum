<?php
interface iThreadQuery{
	function query($threadID);
	function getResult();
}

class threadQueryDB implements iThreadQuery{
	protected $result;
	
	function __construct($threadID){
		include_once 'ConnectToDB.inc.php';
		$this->query($threadID);
	}
	
	function query($threadID){
		$conn = (new DBConnect())->getConnection();
		$sql = "select * from post where threadID = ".$threadID.";";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$queryResult = $stmt->fetchAll();
		$this->result = $queryResult;
	}
	
	function getResult(){
		return $this->result;
	}
}



abstract class ThreadDisplayer {
	protected $postArray;
	protected $outputString;
	protected $AllPostsArr;
	protected $threadID;
	
	function __construct($threadID){
		include_once "isNumericCheck.inc.php";
		$this->threadID = $threadID;
		if (isNumericCheck($threadID)){
			$this->AllPostsArr = (new threadQueryDB($threadID))->getResult();
			$this->createThread();
			$this->outputThread();
		}
	}
	
	function outputThread(){
		echo $this->outputString;
	}
	
	function appendPost($post, $op = false){
		//If it is the first post then give it a different style
		if ($op == true){
			$this->outputString .= '<div class="OP">';
		}else{
			$this->outputString .= '<div class="post">';
		}
		$this->outputString .= '<div class="OP">
				<div class="imgContainer">';
					if (!$post['image'] == null){
						$filename = $post["imageName"];
						
						if (strlen($filename) > 18){
							$filename =  substr($filename,0,16) . "(...)". substr($filename,-4,4);
						}
						$this->outputString .= '<a class="imageLink" style="text-align:center;" title="'.$post["imageName"].'" href="imageRetrieve.php?id='.$post['postID'].'"><p>'.$filename.'</p></a>';
						$this->outputString .= '<img class="postImg" src=imageRetrieve.php?id='.$post["postID"].' />';
						}
							$this->outputString .= '<div class="postInfo">
								<p class="subject">' . $post["postSubject"] . '</p>
								<p class="name">'. $post["postName"] .'</p>
								<p class="otherInfo">PostNo.' . $post["postID"] .  '<br>TimeStamp:'. $post["timeOfPost"] . '</p> 
							</div>
						</div>
						<div class="postText">
							<p>'. $post["postText"] .'</p>
						</div>
					</div>
					</div>
		';
	}
	
	function createString(){
		$this->appendPost($this->AllPostsArr[0], true);
		array_shift($this->AllPostsArr);
		while ( sizeof($this->AllPostsArr) > 0 ){
			$this->appendPost($this->AllPostsArr[0]);
			array_shift($this->AllPostsArr);
		}
		$this->outputString .= '</div>';
	}
}
?>