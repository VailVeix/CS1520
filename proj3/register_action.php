<!DOCTYPE html>
<html>
<body>

<title>Registration Complete</title>
<div align="center">

<?php
  session_start();

  $db = new mysqli('localhost', 'StiegelA', 'han-fred', 'StiegelA');
  if ($db->connect_error):
    die ("Could not connect to db: " . $db->connect_error);
  endif;

  $name = $_POST["user"];
  $password = $_POST["password"];
  $email = $_POST["email"];

  if($name == NULL){
    $_SESSION['error'] = "You must have a username.";
    header("location: /~acs119/php/assign3/register.php");
  }
  if($password == NULL){
    $_SESSION['error'] = "You must have a password.";
    header("location: /~acs119/php/assign3/register.php");
  }
  if($email == NULL){
    $_SESSION['error'] = "You must have a email.";
    header("location: /~acs119/php/assign3/register.php");
  }

  $result = $db->query("select * from Users");
  $row = $result->num_rows;
  $max = 0;
  $found = false;

  for($i = 0; $i < $row; $i++){
    $r = $result->fetch_array();
    if($r['User_id'] > $max){
      $max = $r['User_id'];
    }
    if($r['Email'] == $email){
      $i = $row+1;
      $found = true;
    }
  }

  if($found){
    $_SESSION['error'] = "This email already has an account";
    header("location: /~acs119/php/assign3/register.php");
  }

  $max++;

  $query = "insert into Users values('$max', '$email', '$name', '$password', 0, 0)";
  $db->query($query) or die ("Invalid: " . $db->error);

  echo "<h1>Registration Complete</h1>";
  echo "<br/><br/>";
  echo "<a href='http://cs1520.cs.pitt.edu/~acs119/php/assign3/login.php'>Log in?</a>";

?>

</body>
</html>
