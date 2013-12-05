<?php

   $db = new mysqli('localhost', 'StiegelA', 'han-fred', 'StiegelA');
   if ($db->connect_error):
     die ("Could not connect to db " . $db->connect_error);
   endif;

   header('Content-type: text/xml');
   echo "<?xml version='1.0' encoding='utf-8'?>";
   echo "<IDResponse>";

   $gid = $_POST['gid'];
   $status = $_POST['status'];
   $guess = $_POST['guess'];
   $inc = $_POST['inc'];

   echo "<Data>$gid</Data>";

   $query = "delete from Updates where Game_id = '$gid'";
   $db->query($query) or die ("Invalid: " . $db->error);

   $query = "insert into Updates values ('$gid', '$status', '$guess', '$inc')";
   $db->query($query) or die ("Invalid: " . $db->error);

   echo "</IDResponse>";

?>