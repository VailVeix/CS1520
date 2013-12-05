<!DOCTYPE html>
<html>
<body>

<title> Finalize </title>
<div align="center">

<?php
	session_start();

	echo "<h1> Finalize Your Schedules </h1>";
	echo "Select a box below. </div>";

	$db = new mysqli('localhost', 'StiegelA', 'han-fred', 'StiegelA');
  	if ($db->connect_error):
    	die ("Could not connect to db: " . $db->connect_error);
  	endif;

  	$query = "select Maker_id from Makers where Name='" . $_SESSION['username'] . "'";
  	$result = $db->query($query)  or die ("Invalid: " . $db->error);
  	$r = $result->fetch_array();
  	$id = $r['Maker_id'];
  	
  	$query = "select * from Schedule where Maker_id=" . $id;
  	$result = $db->query($query);
  	$row = $result->num_rows;

  	echo "<form name = 'finalize' action = 'finalizeaction.php' method = 'post'>";

  	for($i = 0; $i < $row; $i++){
  		$r = $result->fetch_array();
  		echo $r['Name'];
  		echo "<br/>";
  		$sched_id = $r['Schedule_id'];
  		echo "<input type = 'radio' name = '$i' value = '$sched_id'>";
  		echo "<br/>";
  		echo "<br/>";
  	}

  	echo "<input type = 'submit' value = 'Submit'>";
  	echo "</form>";


  	echo "<div align='center'><a href='http://cs1520.cs.pitt.edu/~acs119/php/assign2/home.php'>Go Home?</a></div>";

?>

</body>
</html>
