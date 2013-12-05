<?php

   $db = new mysqli('localhost', 'StiegelA', 'han-fred', 'StiegelA');
   if ($db->connect_error):
     die ("Could not connect to db " . $db->connect_error);
   endif;

   header('Content-type: text/xml');
   echo "<?xml version='1.0' encoding='utf-8'?>";
   echo "<IDResponse>";

   //$gid = $_POST['gid'];
   $gid = 1;

   echo "<Data>$gid</Data>";

   do{

      $query = "select * from Updates where Game_id = '$gid'";
      $result = $db->query($query) or die ("Invalid: " . $db->error);

      $result = $result->fetch_array();
      $status = $result['Status'];

   }while($status == 0);

   $guess = $result['Guess'];
   $inc = $result['Incorrect'];

   echo "<Guess>";
   echo $guess;
   echo "</Guess>";
   echo "<Inc>";
   echo $inc;
   echo "</Inc>";
   echo "<Status>";
   echo $status;
   echo "</Status>";

   $query = "delete from Updates where Game_id = '$gid'";
   $db->query($query) or die ("Invalid: " . $db->error);

   $query = "insert into Updates values ('$gid', '0', '$guess', '$inc')";
   $db->query($query) or die ("Invalid: " . $db->error);

   echo "</IDResponse>";

?>