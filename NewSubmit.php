<?php
interface iSubmit{
	function prepName();
	function prepImage();
}

abstract class NewSubmit implements iSubmit{
	protected $conn;
	protected $post;
	protected $file;
	protected $imageName;
	protected $imageData;
	protected $name;
	
	function __construct($postData, $fileData){
		//conect to the db
		include_once 'ConnectToDB.inc.php';
		$this->conn = ConnectToDB();
		//load POST data to the object.
		$this->post = $postData;
		$this->file = $fileData;
		
		//prepare data for submit
		$this->prepName();
		$this->prepImage();
	}
	
	function prepName(){
		$this->name = $this->post['Name'];
		$namenospace = str_replace(' ', '', $this->post['Name']);
		if ($namenospace == "" or $this->name == null){
			$this->name = "Anonymous";
		}
	}
	
	function prepImage(){
		$fileName = $this->file['Image']['tmp_name'];
		//is the image set and existing
		if(isset($this->file['Image']) && $this->file['Image']['size'] > 0){
			//checks to make sure its actually an image
			$imageSize = getimagesize($this->file['Image']['tmp_name']);
			if($imageSize==FALSE){
				 echo "That is not an image, image upload failed.";
				 $this->imageName = null;
				 $this->imageData = null;
				 return;
			 }
			 $this->imageData = addslashes(file_get_contents($fileName));
			 $this->imageName = addslashes($this->file['Image']['name']);
		} 
	}
}
?>