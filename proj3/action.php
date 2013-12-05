<!DOCTYPE html>
<html>
<body>

<?php
  session_start();
  print_r($_SESSION);

  $db = new mysqli('localhost', 'StiegelA', 'han-fred', 'StiegelA');
  if ($db->connect_error):
    die ("Could not connect to db: " . $db->connect_error);
  endif;

  $uname = $_POST["user"];
  $name = "Name";
  $upassword = $_POST["password"];
  $password = "Password";
  $found = false;

  $result = $db->query("select Name from Users");
  $rows = $result->num_rows;
  for($i = 0; $i < $rows; $i++){
    $r = $result->fetch_array();
    if($r[$name] == $uname){
      $i = $rows+1;
      $found = true;
    }
  }

  if($found){
    $query = "select Password from Users where Name='" . $uname . "'";
    $result = $db->query($query);
    $r = $result->fetch_array();

    if($r[$password] == $upassword){
      $_SESSION['username'] = $uname;
      header("location: /~acs119/php/assign3/home.php");
    }
    else{
      $_SESSION['error'] = "Password is incorrect.";
      header("location: /~acs119/php/assign3/login.php");
    }
      
  }
  else{
    $_SESSION['error'] = "Username is incorrect.";
    header("location: /~acs119/php/assign3/login.php");    
  }

?>

</body>
</html>
