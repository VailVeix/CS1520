<?php

   $db = new mysqli('localhost', 'StiegelA', 'han-fred', 'StiegelA');
   if ($db->connect_error):
     die ("Could not connect to db " . $db->connect_error);
   endif;

   header('Content-type: text/xml');
   echo "<?xml version='1.0' encoding='utf-8'?>";
   echo "<IDResponse>";

   $guess = $_POST['guess'];
   $gid = $_POST['gid'];

   echo "<Data>$gid</Data>";

   $query = "select * from G where Game_id = '$gid'";
   $result = $db->query($query);
   $result = $result->fetch_array();

   $word = $result['Word'];
   $length = $result['Length'];

   $return;

   echo "<Locations>";

   $found = false;

   $i = 0;
   for($i = 0; $i < $length; $i++){
      if($guess == $word{$i}){
         echo "$i";
         $found = true;
      }
   }

   if($found == false){
      echo "NONE";
   }

   echo "</Locations>";

   echo "</IDResponse>";

?>