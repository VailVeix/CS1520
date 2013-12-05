<?php

   $db = new mysqli('localhost', 'StiegelA', 'han-fred', 'StiegelA');
   if ($db->connect_error):
     die ("Could not connect to db " . $db->connect_error);
   endif;

   header('Content-type: text/xml');
   echo "<?xml version='1.0' encoding='utf-8'?>";
   echo "<IDResponse>";

   echo "<Data>$gid</Data>";

   $query = "delete from G where Game_id = '$gid'";
   $db->query($query) or die ("Invalid: " . $db->error);

   $query = "insert into G values ('$gid', '', 0, '')";
   $db->query($query) or die ("Invalid: " . $db->error);

   echo "<Result>Yes</Result>";

   echo "</IDResponse>";

?>