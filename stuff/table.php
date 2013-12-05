<!DOCTYPE html>
<html>
 <body>

  <h1 align = "center">Select Your Meeting Times</h1>
  
  <table border = "1"
   cellpadding = "10"
   align = "center">
  
  <?php
	if(isset($_POST['New'])){
		echo "it's not empty";
	}
	else
		echo "it's empty";
print_r($_POST);
	
    $fp = fopen("schedule.txt", "r");
	$buffer = 1;
	$schedule;
	$i = 0;

	$buffer = fgets($fp);
	$dates = array();

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
		
		foreach ($dates as $d){
			foreach ($d as $a){	
				if($checker == 0){
					$date = $a;
					#echo $date; echo "<br/>";
					$checker = 1;
				}
				else{
					foreach ($a as $b){					
						echo "<td>$date<br/>$b</td>";
						$events++;
						$checker = 0;
					}
				}			
			}
		}

	echo "</tr>";
	
	fclose($fp);

	$fp = fopen("users.txt", "r");
	$buffer = 1;
	$text;
	$i = 0;

	$buffer = fgets($fp);
	$users = array();

	while($buffer != NULL){
		$text = $buffer;

		$real_text = explode("^", $text);
		$users[$i][0] = $real_text[0];
		$users[$i][1] = explode("|", $real_text[1]);
		$i++;

		$buffer = fgets($fp);

	}

	$checker = 0;
	$totals = array();

	for($x = 0; $x < $events; $x++){
		$totals[$x] = 0;
	}
		
		foreach ($users as $u){
			echo "<tr><td>"; echo $u[0]; echo "</td>";
			echo "<td></td>";
			#echo $u[1][0]; echo "<br/>";
			for($x = 0; $x < $events; $x++){
				$count = 0;
				for($y = 0; $y < count($u[1]); $y++){
					if($u[1][$y] == $x){
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
		}

	echo "<tr>";
	echo "<td></td>"; 
	echo "<td><form name = 'input' method = 'POST' action = table.php>";
	echo "<input type ='submit' value = 'New' name = 'New'>";
	echo "</form></td>";
	for($i = 0; $i < $events; $i++){
		echo "<td></td>";
	}
	echo "</tr>";

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
