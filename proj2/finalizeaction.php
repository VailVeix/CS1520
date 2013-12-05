<!DOCTYPE html>
<html>
<body>

<title>FinalizeAction</title>
<div align="center">

<?php
	session_start();

	$db = new mysqli('localhost', 'StiegelA', 'han-fred', 'StiegelA');
  	if ($db->connect_error):
	    die ("Could not connect to db: " . $db->connect_error);
  	endif;

	foreach($_POST as $a){
		$sched_id = $a;
		$query = "select * from Schedule where Schedule_id='" . $a . "'";
		$result = $db->query($query);
		$row = $result->num_rows;

		$r = $result->fetch_array();

		$sched_name = $r['Name'];

		echo $r['Name'];
	}
	
	$query = "select * from Dates where Schedule_id='$sched_id'";	
	$result = $db->query($query);
	$row = $result->num_rows;
	$dates = array();
	$col = 0;

	for($i = 0; $i < $row; $i++){
		$dates[$i] = $result->fetch_array();
		$col++;
	}

	$query = "select * from Users where Schedule_id='$sched_id'";

	$result = $db->query($query);
	$row = $result->num_rows;
	$users = array();
	
	for($i = 0; $i < $col; $i++){
		$totals[$i] = 0;
	}

	for($i = 0; $i < $row; $i++){
		$users[$i] = $result->fetch_array();

		for($j = 0; $j < $col; $j++){
			$query = "select * from UserDates where User_id=" . $users[$i]['User_id'] . " and Date_id=". $dates[$j]['Date_id'];
			$new_result = $db->query($query);

			if($new_result != NULL){
				$new_r = $new_result->fetch_array();
				if($new_r['Ans'] == 1){
					$totals[$j]++;
				}
			}

		}
	}

	echo "<br/>";

	$max = $totals[0];
	$x = 0;

	for($i = 0; $i < $col; $i++){
		if($totals[$i] > $max){
			$max = $totals[$i];
			$x = $i;
		}
	}

	$sub = "The Final Date for $sched_name is...";
	$msg = "Hello!\nThe final date is " . $dates[$x]['Date'] . ".\nThe meeting starts at ". $dates[$x]['Time'] . ".";

	for($i = 0; $i < count($users); $i++){
		$receive = $users[$i]['Email'];
		mail($receive, $sub, $msg, NULL);
	}

	echo "<h1>IT'S BEEN FINALIZED!!!</h1>";

	echo "<div align='center'><a href='http://cs1520.cs.pitt.edu/~acs119/php/assign2/home.php'>Go Home?</a></div>";



?>

</body>
</html>
