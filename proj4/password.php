<!DOCTYPE html>
<html>
<body>

<title> Forgot Password </title>
<div align="center">

<?php
	session_start();

	if(!isset($_POST['forgotuser'])){
		echo "<h3>Please enter your username below.</h3>";

		if(isset($_SESSION['error'])){
			echo "<b>";
			echo $_SESSION['error'];
			echo "</b>";
			unset($_SESSION['error']);
		}

		echo "<form name = 'password' action = 'password.php' method = 'post'>";
		echo "Username:";
		echo "<input type = 'text' name = 'forgotuser'></br>";
		echo "<input type = 'submit' value = 'Submit'>";
		echo "</form>";
	}
	else{

		$db = new mysqli('localhost', 'StiegelA', 'han-fred', 'StiegelA');
  		if ($db->connect_error):
    		die ("Could not connect to db: " . $db->connect_error);
  		endif;

  		$name = $_POST['forgotuser'];

  		$result = $db->query("select Name from Users");
  		$rows = $result->num_rows;
  		for($i = 0; $i < $rows; $i++){
    		$r = $result->fetch_array();
    		if($r["Name"] == $name){
      			$i = $rows+1;
      			$found = true;
    		}
  		}	

  		if($found){
  			echo "<h3>Your password has been emailed to you.</h3>";

	  		$query = "select Email from Users where Name='" . $name . "'";
	  		$result = $db->query($query);
	  		$r = $result->fetch_array();
	  		$receive = $r['Email'];

	  		$query = "select Password from Users where Name='" . $name . "'";
	  		$result = $db->query($query);
	  		$r = $result->fetch_array();
	  		$pass = $r['Password'];

	  		$sub = "Forgot Your Password?";
	  		$msg = "Your current password is:  " . $pass;

	  		mail($receive, $sub, $msg, NULL);
	  	}
	  	else{
	  		unset($_POST['forgotuser']);
	  		$_SESSION['error'] = "Invalid user name. Please try again.";
	  		header("location: /~acs119/php/assign4/password.php");
	  	}


  		echo "<a href='http://cs1520.cs.pitt.edu/~acs119/php/assign4/login.php'>Back to Login?</a>";

	}

?>

</body>
</html>
