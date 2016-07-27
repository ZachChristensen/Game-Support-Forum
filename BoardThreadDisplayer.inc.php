<?php
include_once "ThreadDisplayer.inc.php";
include_once "iThreadDisplayer.inc.php";

class BoardThreadDisplayer extends ThreadDisplayer implements iThreadDisplayer{
	function __construct($threadID){
		parent::__construct($threadID);
	}
	
	function createThread(){
		$this->outputString = '<div class="thread boardThread" title="Click to view and reply to the thread" onclick="document.location = \'Thread.php?Thread='.$this->AllPostsArr[0]["threadID"].'\'">';
		$this->createString();
	}
}
?>