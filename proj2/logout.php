<!DOCTYPE html>
<html>
<body>

<title> Log Out </title>
<div align="center">

<?php
	session_start();

	echo "<h1>Goodbye. I'll Miss You.</h1>";
	
	$_SESSION = array();
	session_destroy();

	echo "<a href='http://cs1520.cs.pitt.edu/~acs119/php/assign2/login.php'>Log in?</a>";

?>

</body>
</html>
