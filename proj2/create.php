<!DOCTYPE html>
<html>
<body>

<title> Create </title>
<div align="center">

<?php
	session_start();

	echo "<h1>Create a Magical Schedule of Awesome.</h1></div>";

	echo "<form name = 'create' action = 'createaction.php' method = 'post'>";

	echo "<b>Schedule Name:</b><br/>";
	echo "<input type = 'text' name = 'schedulename'></br>";
	
	echo "<br/><b>Dates: (Enter dates like this:)</b><br/>";
	echo "<textarea rows = '8' cols = '50' name = 'dates'>";
	echo "10-22-2013 @ 12:00,\n";
	echo "10-24-2013 @ 17:00";
	echo "</textarea><br/>";
	
	echo "<br/><b>Names and Emails: (Enter name and emails like this:)</b><br/>";
	echo "<textarea rows = '8' cols = '50' name = 'emails'>";
	echo "Alex, abc123@yahoo.com,\n";
	echo "Zach, zps6@pitt.edu";
	echo "</textarea><br/>";
	
	echo "<input type = 'submit' value = 'Submit'>";
	echo "</form>";


	echo "<div align='center'><a href='http://cs1520.cs.pitt.edu/~acs119/php/assign2/home.php'>Go Home?</a></div>";


?>

</body>
</html>
