<!DOCTYPE html>
<html>
<body>

<?php
  $db = new mysqli('localhost', 'StiegelA', 'han-fred', 'StiegelA');
  if ($db->connect_error):
    die ("Could not connect to db: " . $db->connect_error);
  endif;

  $db->query("drop table Users"); 
  $db->query("drop table Makers");
  $db->query("drop table Schedule");
  $db->query("drop table Dates");
  $db->query("drop table UserDates");

  # Makers: Maker_id, Name, Email, Password, Schedule_ID
  $result = $db->query("create table Makers (Maker_id int primary key not null, Name char(20) not null,
    Email char(30) not null, Password char(10) not null, Schedule_ID int)") or die ("Invalid: " . $db->error);

  #Users: User_id, Name, Email, Schedule_ID
  $result = $db->query("create table Users (User_id int primary key not null, Name char(40), Email char(40) not null, Schedule_ID int)") or die ("Invalid: " . $db->error);

  #Schedule: Schedule_id, Name, Date_id, User_id, Maker_id
  $result = $db->query("create table Schedule (Schedule_id int primary key not null, Name char(30) not null, 
    Date_id int, User_id int, Maker_id int not null)") or die ("Invalid: " . $db->error);

  #Dates: Date_id, Date, Time, Schedule_id
  $result = $db->query("create table Dates (Date_id int primary key not null, Date char(15), Time char(10), Schedule_id int)") or die ("Invalid: " . $db->error);

  #UD: User_id, Date_id, Ans
  $result = $db->query("create table UserDates (UD int not null, User_id int not null, Date_id int not null, Ans int not null)") or die ("Invalid: " . $db->error);

  $db->query("insert into Makers values (0, 'VailVeix', 'acs119@pitt.edu', '1234', 0)") or die ("Invalid: " . $db->error);
  $db->query("insert into Makers values (1, 'Vail', 'acs119+maker1@pitt.edu', '123456', 1)") or die ("Invalid: " . $db->error);

?>

</body>
</html>
