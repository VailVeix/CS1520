<?php

   $db = new mysqli('localhost', 'StiegelA', 'han-fred', 'StiegelA');
   if ($db->connect_error):
     die ("Could not connect to db " . $db->connect_error);
   endif;

   header('Content-type: text/xml');
   echo "<?xml version='1.0' encoding='utf-8'?>";
   echo "<IDResponse>";

   $gid = $_POST['gid'];
   //$gid = 1;
   echo "<Data>$gid</Data>";

   do{

      $query = "select * from G where Game_id = '$gid'";
      $result = $db->query($query) or die ("Invalid: " . $db->error);

      $result = $result->fetch_array();
      $status = $result['Status'];

   }while($status != 0);

   $len = $result['Length'];

   echo "<Length>$len</Length>";

   echo "<Result>Ready</Result>";

   echo "</IDResponse>";

?>