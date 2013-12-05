<!DOCTYPE html>
<html>
<body>

<title>Schedule</title>
<div align="center">

 <table border = "1"
   cellpadding = "10"
   align = "center">

<?php
	session_start();

	$_SESSION['schedule_id'] = $_GET['schedule_id'];
	$_SESSION['user_id'] = $_GET['user_id'];

	$db = new mysqli('localhost', 'StiegelA', 'han-fred', 'StiegelA');
  	if ($db->connect_error):
    	die ("Could not connect to db: " . $db->connect_error);
  	endif;

	$col = 1;

	echo "<h1>The Master Scheduler 5000 Remixed!!</h1>";

	$query = "select * from Schedule where Schedule_id=" . $_GET['schedule_id'];
	$result = $db->query($query);
	$r = $result->fetch_array();
	echo "<h3>";
	echo $r['Name'];
	echo "</h3>";

	echo "<tr> <td> User </td>";

	$query = "select * from Dates where Schedule_id=" . $_GET['schedule_id'];
	$result = $db->query($query);
	$row = $result->num_rows;
	$dates = array();

	for($i = 0; $i < $row; $i++){
		$dates[$i] = $result->fetch_array();
		echo "<td>";
		echo $dates[$i]['Date'];
		echo "<br/>";
		echo $dates[$i]['Time'];
		echo "</td>";
		$col++;
	}

	echo "<td> Action </td>";
	echo "</tr>";

	$query = "select User_id, Name from Users where Schedule_ID=" . $_GET['schedule_id'];
	$result = $db->query($query);
	$row = $result->num_rows;
	$users = array();
	
	for($i = 0; $i < $col-1; $i++){
		$totals[$i] = 0;
	}

	for($i = 0; $i < $row; $i++){
		echo "<tr>";
		$users[$i] = $result->fetch_array();
		echo "<td>";
		echo $users[$i]['Name'];
		echo "</td>";

		if($users[$i]['User_id'] == $_GET['user_id']){
			echo "<form name = 'schedule' action = 'schedule2.php' metho = 'post'>";

			for($j = 0; $j < $col-1; $j++){
				$query = "select * from UserDates where User_id=" . $users[$i]['User_id'] . " and Date_id=". $dates[$j]['Date_id'];
				$new_result = $db->query($query);

				if($new_result != NULL){
					$new_r = $new_result->fetch_array();
					if($new_r['Ans'] == 1){
						echo "<td>&#x2717;</td>";
						$totals[$j]++;
					}
					else{
						echo "<td></td>";
					}
				}
				else{
					echo "<td></td>";
				}
			}

			echo "<td><input type = 'submit' value = 'Edit'></td>";
			echo "</tr>";
		}
		else{

			for($j = 0; $j < $col-1; $j++){
				$query = "select * from UserDates where User_id=" . $users[$i]['User_id'] . " and Date_id=". $dates[$j]['Date_id'];
				$new_result = $db->query($query);

				if($new_result != NULL){
					$new_r = $new_result->fetch_array();
					if($new_r['Ans'] == 1){
						echo "<td>&#x2717;</td>";
						$totals[$j]++;
					}
					else{
						echo "<td></td>";
					}
				}
				else{
					echo "<td></td>";
				}

			}
			echo "<td></td>";
			echo "</tr>";
		}
	}

	echo "<tr>";
	echo "<td>Totals</td>";
	for($i = 0; $i < $col-1; $i++){
		echo "<td>";
		echo $totals[$i];
		echo "</td>";
	}
	echo "<td></td></tr>";



?>

</table>
</body>
</html>
