<!DOCTYPE html>
<html>
<body>

<title> Home </title>
<div align="center">

<?php
	session_start();

	echo "<h1>Welcome Home!</h1>";
	echo "<h4>What do you want to do?</h4>";

	echo "&nbsp;&nbsp;&nbsp;";

	echo "<a href='http://cs1520.cs.pitt.edu/~acs119/php/assign3/start.php'>Play Game</a>";

	echo "&nbsp;&nbsp;&nbsp;";

	echo "<a href='http://cs1520.cs.pitt.edu/~acs119/php/assign3/logout.php'>Log Out</a>";

?>

</body>
</html>
