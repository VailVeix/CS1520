<!DOCTYPE html>
<html>
<body>

<?php
  $db = new mysqli('localhost', 'StiegelA', 'han-fred', 'StiegelA');
  if ($db->connect_error):
    die ("Could not connect to db: " . $db->connect_error);
  endif;

  $db->query("drop table Users");
  $db->query("drop table Games");
  $db->query("drop table GV");
  $db->query("drop table G");
  $db->query("drop table Updates");

  # Users --> User_id, Email, Name, Password
  $result = $db->query("create table Users (User_id int primary key not null, Email char(40) not null, Name char (20) not null, Password char(15) not null)") or die ("Invalid: ". $db->error);

  # Games --> Game_id, Player1, Player2
  $result = $db->query("create table Games (Game_id int primary key not null, Player1 int, Player2 int)") or die ("Invalid: ". $db->error);

  # G --> Game_id, Word, Status, Length
  $result = $db->query("create table G (Game_id int primary key not null, Word char (20), Status int, Length int)") or die ("Invalid: " . $db->error);

  # Updates --> Game_id, Status, Guess, Incorrect
  $result = $db->query("create table Updates (Game_id int primary key not null, Status int, Guess char (25), Incorrect char (25))") or die ("Invalid: " . $db->error);

  # GV --> Value, Player
  $result = $db->query("create table GV (Value int primary key not null, Player int)") or die ("Invalid: ". $db->error);

  # Open User File and add them to database.
  $fp = fopen("users.txt", "r");

  $buffer = fgets($fp);

  while($buffer != NULL){
    $storage = explode("^", $buffer);
	  $query = "insert into Users values('$storage[0]', '$storage[1]', '$storage[2]', '$storage[3]')";
    $db->query($query) or die ("Invalid: " . $db->error);
    $buffer = fgets($fp);

  }

  fclose($fp);

  $query = "insert into GV values ('1', '1')";
  $db->query($query) or die ("Invalid insert " . $db->error);

?>

</body>
</html>
