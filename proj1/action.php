<?php

if(isset($_POST['user'])){

  		setcookie("user", 1, time()+(60*60*24*30));

  		$fp = fopen("users.txt", "a+");
		$buffer = 1;
		$text;
		$i = 0;

		$buffer = fgets($fp);
		$users = array();

  		while($buffer != NULL){
			$text = $buffer;

			if($buffer == "\n"){
			}
			else{
				$real_text = explode("^", $text);
				$users[$i][0] = $real_text[0];
				$i++;
			}

			$buffer = fgets($fp);

		}
		echo "</br>hi</br>";

		if(isset($_COOKIE['edit'])){
			$words = $_COOKIE['edit'];
			print_r($words);
			$words .= $i;
			echo "</br>hi</br>";
			setcookie('edit', $words, time()+(60*60*24*30));
		}
		else{
			$words = "";
			$words .= $i;
			setcookie('edit', $words, time()+(60*60*24*30));
		}

		print_r($_COOKIE['edit']);
		echo "</br>hi</br>";

		fseek($fp, 0, SEEK_END);
		fwrite($fp, "\n");
		fwrite($fp, $_POST['user']);
		fwrite($fp, "^");

		$i = 0;
		foreach($_POST as $a){
			if($i == 0){
				$i++;
			}
			else if($i == (count($_POST) - 1)){
				fwrite($fp, $a);
			}
			else{
				fwrite($fp, $a);
				fwrite($fp, "|");
				$i++;
			}
		}

		fclose($fp);
}
else if(isset($_POST['Edit'])){

	$fp = fopen("users.txt", "a+");
	$buffer = 1;
	$text;
	$i = 0;

	$buffer = fgets($fp);
	$users = array();

		while($buffer != NULL){
		$text = $buffer;

		if($buffer == "\n"){
		}
		else{
			$real_text = explode("^", $text);
			$users[$i][0] = $real_text[0];
			$users[$i][1] = explode("|", $real_text[1]);
			$i++;
		}

		$buffer = fgets($fp);
	}

	fclose($fp);

	$x = 0;
	$sched = array();
	foreach($_POST as $a){
		if($x == 0){
			$x = 1;
			$u_name = $a;
		}
		else{
			$sched[$a] = $a;
		}
	}

	foreach($users as $u){
		if($u[0] == $u_name){
			unset($u[1]);
			$i = 0;
			foreach($sched as $s){
				$u[1][$i] = $s;
				$i++;
			}
		}
		print_r($u[1]);
		echo "</br>";
	}
	$fp = fopen("users.txt", "w+");
	$buffer = 1;
	$SeanStatus = 0;

	foreach($users as $u){
		if($u[0] == $u_name){
			unset($u[1]);
			$i = 0;
			foreach($sched as $s){
				$u[1][$i] = $s;
				$i++;
			}
		}
		$m = 0;
		fwrite($fp, $u[0]);
		fwrite($fp, "^");
		$SeanStatus = count($u[1]);
		for($i = 0; $i < $SeanStatus; $i++){
			if($m == ($SeanStatus-1)){
				fwrite($fp, $u[1][$i]);
				echo $u[1][$i];
				echo "</br>";
			}
			else{
				fwrite($fp, $u[1][$i]);
				fwrite($fp, "|");
				$m++;
				echo $u[1][$i];
				echo "|";
			}
		}
	}
	//fwrite($fp, "\n");

	fclose($fp);

}

header("location: /~acs119/php/assign1/table.php");

?>