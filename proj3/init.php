<!DOCTYPE html>
<html>
<body>

<?php
  $db = new mysqli('localhost', 'StiegelA', 'han-fred', 'StiegelA');
  if ($db->connect_error):
    die ("Could not connect to db: " . $db->connect_error);
  endif;

  $db->query("drop table Users");
  $db->query("drop table Words");

  # Users --> User_id, Email, Name, Password, Rounds, Won
  $result = $db->query("create table Users (User_id int primary key not null, Email char(40) not null, Name char (20) not null, Password char(15) not null, Rounds int, Won int)") or die ("Invalid: ". $db->error);

  # Words --> Word_id, Word
  $result = $db->query("create table Words (Word_id int primary key not null, Word char(5) not null)") or die ("Invalid" . $db->error);

  # Open User File and add them to database.
  $fp = fopen("users.txt", "r");

  $buffer = fgets($fp);

  while($buffer != NULL){
    $storage = explode("^", $buffer);
	$query = "insert into Users values('$storage[0]', '$storage[1]', '$storage[2]', '$storage[3]', '$storage[4]', '$storage[5]')";
    $db->query($query) or die ("Invalid: " . $db->error);
    $buffer = fgets($fp);

  }

  fclose($fp);

  $fp = fopen("words.txt", "r");

  $buffer = fgets($fp);
  $count = 0;

  while($buffer != NULL){

    $query = "insert into Words values('$count', '$buffer')";
    $db->query($query) or die ("Invalid: " . $db->error);
    $count++;
    $buffer = fgets($fp);

  }

  fclose($fp);

?>

</body>
</html>
