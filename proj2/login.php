<!DOCTYPE html>
<html>
<body>

<title>Log in</title>
<div align="center">

<?php
	session_start();

	echo "<h1>Welcome To The Schedule Maker 500!!!</h1>";
	echo "<h3>Please Log In Below</h3>";
	echo "</div>";

	if(isset($_SESSION['error'])){
		echo "<b>";
		echo $_SESSION['error'];
		echo "</b>";
		unset($_SESSION['error']);
	}


	echo "<form name = 'action' action = 'action.php' method = 'post'>";
	echo "Username:";
	echo "<input type = 'text' name = 'user'></br>";
	echo "Password:";
	echo "<input type = 'password' name = 'password'>";
	echo "<br/>";
	echo "<input type = 'submit' value = 'Submit'>";
	echo "</form>";
	echo "<a href='http://cs1520.cs.pitt.edu/~acs119/php/assign2/password.php'>Forgot Password</a>";


?>

</body>
</html>
