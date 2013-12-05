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

   $query = "select * from G where Game_id = '$gid'";
   $result = $db->query($query) or die ("Invalid: " . $db->error);

   $result = $result->fetch_array();

   $word = $result['Word'];

   echo "<Word>";
   echo $word;
   echo "</Word>";

   echo "</IDResponse>";

?>