<?php
if ($_SERVER['HTTP_HOST'] == 'localhost') {
	$mysql_user 	= "root";
	//$mysql_password = "#@aftab91";
	$mysql_password = "";
	$mysql_database = "fireg";
} else {
	$mysql_user 	= "";
	$mysql_password = "";
	$mysql_database = "";
}
$mysql_hostname = "localhost";
$prefix = "";
$conn = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect mysql");
mysqli_select_db($conn, $mysql_database) or die("Could not select database");
