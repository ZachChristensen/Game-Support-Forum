<?php
include_once "ThreadDisplayer.inc.php";
include_once "iThreadDisplayer.inc.php";

//You don't need the div to act as a link to a page with the thread on it because you are already there
class LinklessThreadDisplayer extends ThreadDisplayer implements iThreadDisplayer{
	function __construct($threadID){
		parent::__construct($threadID);
	}
	
	function createThread(){
		$this->outputString = '<div class="thread">';
		$this->createString();
	}
}
?>