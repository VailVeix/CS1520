<!DOCTYPE html>
<html>
<body>

<title> Create Action </title>
<div align="center">

<?php
	session_start();

	echo "<h1>Thanks!</h1>";
	echo "A message has been sent to each individual with a link to this schedule.";
	echo "<br/><br/>";

	echo "<a href='http://cs1520.cs.pitt.edu/~acs119/php/assign2/home.php'>Home?</a>";

	$db = new mysqli('localhost', 'StiegelA', 'han-fred', 'StiegelA');
  	if ($db->connect_error):
    	die ("Could not connect to db: " . $db->connect_error);
  	endif;

	$uname = $_SESSION['username'];

	# Schedule ID. (Increment previous highest one.)
	$result = $db->query("select Schedule_id from Schedule");
	$row = $result->num_rows;
	$max = 0;

	for($i = 0; $i < $row; $i++){
		$r = $result->fetch_array();
		if($r['Schedule_id'] > $max){
			$max = $r['Schedule_id'];
		}
	}

	$max++;
	$schedule_id = $max;
	$schedule_name = $_POST['schedulename'];

	# Date ID. (Same.)
	$result = $db->query("select Date_id from Schedule");
	$row = $result->num_rows;
	$max = 0;

	for($i = 0; $i < $row; $i++){
		$r = $result->fetch_array();
		if($r['Date_id'] > $max){
			$max = $r['Date_id'];
		}
	}

	$max++;
	$date_id = $max;

	# User ID. (Also, Same.)
	$result = $db->query("select User_id from Schedule");
	$row = $result->num_rows;
	$max = 0;

	for($i = 0; $i < $row; $i++){
		$r = $result->fetch_array();
		if($r['User_id'] > $max){
			$max = $r['User_id'];
		}
	}

	$max++;
	$user_id = $max;

	# Add this to the schedule database.
	$query = "select Maker_id from Makers where Name='" . $uname . "'";
	$result = $db->query($query);
	$r = $result->fetch_array();
	$maker_id = $r['Maker_id'];

	$query = "insert into Schedule values ('$schedule_id', '$schedule_name', '$date_id', '$user_id', '$maker_id')";
	$result = $db->query($query);

	$result = $db->query("select Date_id from Dates");
	$row = $result->num_rows;
	$max = 0;

	for($i = 0; $i < $row; $i++){
		$r = $result->fetch_array();
		if($r['Date_id'] > $max){
			$max = $r['Date_id'];
		}
	}

	$max++;
	$newdate_id = $max;

	$listofdates = explode(",", $_POST['dates']);

	foreach($listofdates as $d){
		$dat = explode("@", $d);
		$query = "insert into Dates values ('$newdate_id', '$dat[0]', '$dat[1]', '$schedule_id')";
		$result = $db->query($query);
		$newdate_id++;
	}

	$listofpeople = explode(",", $_POST['emails']);

	$result = $db->query("select User_id from Users");
	$row = $result->num_rows;
	$max = 0;

	for($i = 0; $i < $row; $i++){
		$r = $result->fetch_array();
		if($r['User_id'] > $max){
			$max = $r['User_id'];
		}
	}

	$max++;
	$newuser_id = $max;

	for($i = 0; $i < count($listofpeople); $i+=2){
		$query = "insert into Users values ('$newuser_id', '" . $listofpeople[$i] . "', '" . $listofpeople[$i+1] . "', '$schedule_id')";
		$result = $db->query($query);
		$newuser_id++;
	}

	$query = "select User_id, Name, Email from Users where Schedule_ID=" . $schedule_id;
	$result = $db->query($query);
	$row = $result->num_rows;

	$sub = "A New Schedule Includes You! Check it out!";

	for($i = 0; $i < $row; $i++){
		$r = $result->fetch_array();
		$receive = $r['Email'];
		$name = $r['Name'];
		$msg = "Hey$name!\n\nHere's a link to a schedule you've been added to. Please check it out.\nhttp://cs1520.cs.pitt.edu/~acs119/php/assign2/schedule.php?schedule_id=" . $schedule_id . "&user_id=" . $r['User_id'];
		mail($receive, $sub, $msg, NULL);
	}


?>

</body>
</html>
