<?php

   $db = new mysqli('localhost', 'StiegelA', 'han-fred', 'StiegelA');
   if ($db->connect_error):
     die ("Could not connect to db " . $db->connect_error);
   endif;

   $max = 2378;
   $random = rand(0, $max);

   $result = $db->query("select Word from Words where Word_id = '" . $random . "'");
   $word = $result->fetch_array();

   echo $word['Word'];

?>