<?php
//checks that a int is a actually just a int in order to prevent sql injection
function isNumericCheck($num){
	if (is_numeric($num) && ((int)$num == $num)){
		return true;
	}
	else{
		echo '<h3>' .htmlspecialchars($num) . ' is an invalid query string</h3>';
		return false;
	}
}
?>