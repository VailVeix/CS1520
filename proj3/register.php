<!DOCTYPE html>
<html>
<body>

<title>Register</title>
<div align="center">

<?php
	session_start();

	echo "<h1>Register new User</h1>";
	echo "<h3>Please Fill Out Information Below</h3>";
	echo "</div>";

	if(isset($_SESSION['error'])){
		echo "<b>";
		echo $_SESSION['error'];
		echo "</b>";
		unset($_SESSION['error']);
	}


	echo "<form name = 'register' action = 'register_action.php' method = 'post'>";
	echo "Username:";
	echo "<input type = 'text' name = 'user'></br>";
	echo "Password:";
	echo "<input type = 'password' name = 'password'>";
	echo "<br/>";
	echo "Email:";
	echo "\t&nbsp&nbsp&nbsp&nbsp&nbsp";
	echo "<input type = 'email' name = 'email'>";
	echo "<br/>";
	echo "<input type = 'submit' value = 'Submit'>";
	echo "</form>";

?>

</body>
</html>
