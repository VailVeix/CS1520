<?php

   $db = new mysqli('localhost', 'StiegelA', 'han-fred', 'StiegelA');
   if ($db->connect_error):
     die ("Could not connect to db " . $db->connect_error);
   endif;

   $outcome = $_POST['type'];
   $username = $_POST['username'];

   $result = $db->query("select * from Users where Name = '" . $username . "'");
   $result = $result->fetch_array();

   $user_id = $result['User_id'];
   $email = $result['Email'];
   $password = $result['Password'];
   $rounds = $result['Rounds'];
   $rounds++;
   $won = $result['Won'];

   if($outcome == 0){
   	$won++;
   }

   $query = "delete from Users where Name='" . $username . "'";
   $db->query($query)or die ("Invalid: " . $db->error);

   $query = "insert into Users values('$user_id', '$email', '$username', '$password', '$rounds', '$won')";
   $db->query($query)or die ("Invalid: " . $db->error);

   $returnvalue = $rounds . "|" . $won;
   echo $returnvalue;
?>