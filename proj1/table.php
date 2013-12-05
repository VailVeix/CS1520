<!DOCTYPE html>
<html>
 <body>

  <h1 align = "center">Select Your Meeting Times</h1>
  
  <table border = "1"
   cellpadding = "10"
   align = "center">
  
  <?php

  	if(!isset($_COOKIE['user'])){
  		setcookie("user", "-1", time()+(60*60*24*30));
  	}

  	// Write new info to text file.

  	$edits = array();

  	if(isset($_COOKIE['user'])){
  		if(isset($_COOKIE['edit'])){
  			$words = $_COOKIE['edit'];
  			for($i = 0; $i < strlen($words); $i++){
  				$edits[$i] = substr($words, $i, 1);
  			}
  		}
  	}

  	// Open Schedule File	
    $fp = fopen("schedule.txt", "r");
	$buffer = 1;
	$schedule;
	$i = 0;

	$buffer = fgets($fp);
	$dates = array();

	// Store Dates and Times in the dates array.
	// [0][0] is the date. [0][1] is an array of times.
	echo "<tr><td>User</td>";
	echo "<td>Action</td>";
    while($buffer != NULL){

		$schedule = $buffer;
		
		$real_schedule = explode("^", $schedule);
		$dates[$i][0] = $real_schedule[0];
		$dates[$i][1] = explode("|", $real_schedule[1]);
		$i++;
		
		$buffer = fgets($fp);		
		
	}

	$checker = 0;
	$events = 0;
		
	// Print out the dates and times.
	// Also get the maximum numbers of meetings.
	foreach ($dates as $d){
		foreach ($d as $a){	
			if($checker == 0){
				$date = $a;
				#echo $date; echo "<br/>";
				$checker = 1;
			}
			else{
		*		foreach ($a as $b){					
					echo "<td>$date<br/>$b</td>";
					$events++;
					$checker = 0;
				}
			}			
		}
	}

	echo "</tr>";
	
	fclose($fp);

	// Open User File
	$fp = fopen("users.txt", "a+");
	$buffer = 1;
	$text;
	$i = 0;

	$buffer = fgets($fp);
	$users = array();

	// Store users in an array
	// [0][0] is their name. [0][1] is an array of which meetings they are attending.
	$user_num = 0;
	while($buffer != NULL){
		$text = $buffer;

		if($buffer == "\n"){
		}
		else{
			$real_text = explode("^", $text);
			$users[$i][0] = $real_text[0];
			$users[$i][1] = explode("|", $real_text[1]);
			$i++;
			$user_num++;
		}

		$buffer = fgets($fp);

	}

	// Total how many people are going to each event.
	$checker = 0;
	$totals = array();

	for($x = 0; $x < $events; $x++){
		$totals[$x] = 0;
	}

	// Print out users and their specific meetings.	
	$total_u = 0;
	$u_time = sizeof($edits);
	$v_time = sizeof($edits);

	$edit = array();
	$e = 0;

	for($i = 0; $i < $user_num; $i++){
		if(isset($_POST[$i])){
			$edit[$i] = 1;
			$e = 1;
		}
	}

	if($e == 0){
		foreach ($users as $u){
			echo "<tr><td>"; echo $u[0]; echo "</td>";
			if($edits != NULL && $edits[$u_time-$v_time] == $total_u){
				echo "<td><form name = 'input' method = 'POST' action = table.php>";
				echo "<input type ='submit' name = '$total_u' value = 'Edit'>";
				echo "</form></td>";
				if($v_time > 0)
					$v_time--;
			}
			else{
				echo "<td></td>";
			}
			#echo $u[1][0]; echo "<br/>";
			for($x = 0; $x < $events; $x++){
				$count = 0;
				for($y = 0; $y < count($u[1]); $y++){
					if($u[1][$y] == $x && $u[1][$y] != NULL){
						echo "<td>&#x2717;</td>";
						$totals[$x]++;;
						$count = 0;
						break;
					}
					else
						$count = 1;
				}
				if($count == 1){
					echo "<td></td>";
				}
			}
			echo "</tr>";
			$total_u++;
		}
	}
	else{
		foreach ($users as $u){
			if(array_key_exists($total_u, $edit)){
				echo "<tr>";
				echo "<form name = 'input' method = 'POST' action = action.php>";
				echo "<td><input type='text' value = '$u[0]' name='Edit'></td>"; 
				echo "<td>";
				echo "<input type ='submit'>";
				echo "</td>";

				for($i = 0; $i < $events; $i++){
					$count = 0;
					for($y = 0; $y < count($u[1]); $y++){
						if($u[1][$y] == $i && $u[1][$y] != NULL){
							echo "<td><form name = 'input' method = 'POST' action = action.php>";
							echo "<input type = 'checkbox' name = $i value = $i checked = true></td>";
							$count = 0;
							break;
						}
						else{
							$count = 1;
						}
							
					}
					if($count == 1){
						echo "<td><form name = 'input' method = 'POST' action = action.php>";
						echo "<input type = 'checkbox' name = $i value = $i></td>";
					}

				}
				echo "</form></tr>";
				if($v_time > 0)
						$v_time--;
			}
			else{
				echo "<tr><td>"; echo $u[0]; echo "</td>";
				if($edits != NULL && $edits[$u_time-$v_time] == $total_u){
					echo "<td><form name = 'input' method = 'POST' action = table.php>";
					echo "<input type ='submit' name = '$total_u' value = 'Edit'>";
					echo "</form></td>";
					if($v_time > 0)
						$v_time--;
				}
				else{
					echo "<td></td>";
				}
				#echo $u[1][0]; echo "<br/>";
				for($x = 0; $x < $events; $x++){
					$count = 0;
					for($y = 0; $y < count($u[1]); $y++){
						if($u[1][$y] == $x && $u[1][$y] != NULL){
							echo "<td>&#x2717;</td>";
							$totals[$x]++;
							$count = 0;
							break;
						}
						else
							$count = 1;
					}
					if($count == 1){
						echo "<td></td>";
					}
				}
			}
			echo "</tr>";
			$total_u++;
		}
	}

	// Print out empty line with new button

	if(isset($_POST['New'])){
		echo "<tr>";
		echo "<form name = 'input' method = 'POST' action = action.php>";
		echo "<td><input type='text' name='user'></td>"; 
		echo "<td>";
		echo "<input type ='submit'>";
		echo "</td>";
		for($i = 0; $i < $events; $i++){
			echo "<td><form name = 'input' method = 'POST' action = action.php>";
			echo "<input type = 'checkbox' name = $i value = $i></td>";
		}
		echo "</form></tr>";
	#	echo "dingus<br/>";
	}	
	else{
		echo "<tr>";
		echo "<td></td>"; 
		echo "<td><form name = 'input' method = 'POST' action = table.php>";
		echo "<input type ='submit' value = 'New' name = 'New'>";
		echo "</td>";
		for($i = 0; $i < $events; $i++){
			echo "<td></td>";
		}
		echo "</form></tr>";
		#echo "dongus<br/>";
	}

	//print_r($_POST);

	// Print out totals line.
	echo "<tr><td>TOTAL</td><td></td>";
	foreach($totals as $i){
		echo "<td>$i</td>";
	}
	echo "</tr>";
	#print_r($dates);
	
?>
	
	</table>

	<h1 align = "center">WOW SUCH TABLE!!! SO SCHEDULE!!!</h1>

 </body>
</html>
