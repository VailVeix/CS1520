<?php

   $db = new mysqli('localhost', 'StiegelA', 'han-fred', 'StiegelA');
   if ($db->connect_error):
     die ("Could not connect to db " . $db->connect_error);
   endif;

   header('Content-type: text/xml');
   echo "<?xml version='1.0' encoding='utf-8'?>";
   echo "<IDResponse>";

   //$name = $_POST['name'];
   $name = "VV";
   echo "<Data>hi</Data>";

   // Get User_id
   $query = "select User_id from Users where Name = '$name'";
   $result = $db->query($query);
   $result = $result->fetch_array();

   $id = $result['User_id'];

   // Get current game we are filling.
   $query = "select * from GV";
   $result = $db->query($query);
   $row = $result->fetch_array();

   $player = $row['Player'];
   $value = $row['Value'];

   if($player == 1){
   		// Insert player one and new game into the games table. They should still be waiting.
   		$query = "insert into Games values('$value', '$id', '-1')";
   		$db->query($query) or die ("Invalid: " . $db->error);

   		// Increment player and update GV table
   		$player++;
   		$query = "delete from GV where Value = '$value'";
   		$db->query($query) or die ("Invalid: " . $db->error);

   		$query = "insert into GV values('$value', '$player')";
   		$db->query($query) or die ("Invalid: " . $db->error);

         $query = "insert into G values ('$value', '', '0', '0')";
         $db->query($query) or die ("Invalid: " . $db->error);

        $query = "insert into Updates values ('$value', '0', '', '')";
        $db->query($query) or die ("Invalid: " . $db->error);

   		// Set return value to be game id and player id
   		echo "<Result>Waiting</Result>";
         echo "<Game_ID>$value</Game_ID>";
         echo "<P>1</P>";
   }
   else{
         // Update Games table with player 2
   		$query = "select Player1 from Games where Game_id='$value'";
   		$result = $db->query($query) or die ("Invalid: " . $db->error);
   		$result = $result->fetch_array();
         $player1 = $result['Player1'];

         $query = "delete from Games where Game_id='$value'";
         $db->query($query) or die ("Invalid: " . $db->error);

         $query = "insert into Games values('$value', '$player1', $id)";
         $db->query($query) or die ("Invalid: " . $db->error);

         // Update GV Table with new game
         $query = "delete from GV where Value = '$value'";
         $db->query($query) or die ("Invalid: " . $db->error);

         $newval = $value +1;
         $query = "insert into GV values ('$newval', '1')";
         $db->query($query) or die ("Invalid: " . $db->error);

         // Set return value to be game id and player id
         echo "<Result>Ready</Result>";
         echo "<Game_ID>$value</Game_ID>";
         echo "<P>2</P>";
   }

   echo "</IDResponse>";

?>