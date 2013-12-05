<?php

   $db = new mysqli('localhost', 'StiegelA', 'han-fred', 'StiegelA');
   if ($db->connect_error):
     die ("Could not connect to db " . $db->connect_error);
   endif;

   header('Content-type: text/xml');
   echo "<?xml version='1.0' encoding='utf-8'?>";
   echo "<IDResponse>";

   $gid = $_POST['gid'];
   echo "<Data>$gid</Data>";

   // Loop through until Player 2 is set.
   do{

      $query = "select Player2 from Games where Game_id='$gid'";
      $result = $db->query($query) or die ("Invalid: " . $db->error);

      $result = $result->fetch_array();
      $player2 = $result['Player2'];

   }while($player2 == -1);

   echo "<Result>Ready</Result>";

   echo "</IDResponse>";

?>