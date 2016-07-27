<?php
interface iThreadDisplayer{
	function __construct($threadID);
	function createThread();
	function createString();
	function appendPost($post, $op = false);
	function outputThread();
}
?>