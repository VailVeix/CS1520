<!DOCTYPE html>
<html>
<body>

<title>Schedule Action</title>
<div align="center">

<?php
	session_start();

	$db = new mysqli('localhost', 'StiegelA', 'han-fred', 'StiegelA');
  	if ($db->connect_error):
	    die ("Could not connect to db: " . $db->connect_error);
  	endif;

	print_r($_POST);
	print_r($_SESSION);

	$user_id = $_SESSION['user_id'];

	$query = "delete from UserDates where User_id=" . $user_id;
	$db->query($query);

	$result = $db->query("select * from UserDates");
	$row = $result->num_rows;
	$max = 1;
	print_r($result);

	for($i = 0; $i < $row; $i++){
		$r = $result->fetch_array(); 
		echo "HERE";
		echo $r['UD'];
		echo "ENDHERE";
		if($r['UD'] > $max){ 
			$max = $r['UD']; 
		} 
	}
	$max++;

	echo $user_id;
	echo "<br/>";

	foreach($_POST as $d){
		$date_id = $d;
		echo $d;
		echo "<br/>";
		$ans = 1;
		$query = "insert into UserDates values ('$max', '$user_id', '$d', '$ans')";
		echo $query;
		echo "<br/>";
		$result = $db->query($query)  or die ("Invalid: " . $db->error);
		echo "<br/>";
		echo "<br/>result here";
		print_r($result);
		echo "end here<br/>";
		echo "<br/>";
		$max++;
	}

	$result = $db->query("select * from UserDates");
	$row = $result->num_rows;

	print_r($result);

	for($i = 0; $i < $row; $i++){
		$r = $result->fetch_array();
		echo $r['User_id'];
		echo "\t";
		echo $r['Date_id'];
		echo "\t";
		echo $r['Ans'];
		echo "<br/>";
	}

	$here = "location: /~acs119/php/assign2/schedule.php?schedule_id=" . $_SESSION['schedule_id'] . "&user_id=" . $_SESSION['user_id'];
	header($here);

?>

</body>
</html>
