<?php
include('path.php');
include($directory_path . "conf/session_start.php");
include($directory_path . "conf/connection.php");
include($directory_path . "conf/functions.php");
$db 	 = new mySqlDB;
$user_id 	= 0;
$school_id 	= 0;
if (isset($_SESSION['user_id']))			$school_user_id 	= $_SESSION['user_id'];
if (isset($school_user_id) && $school_user_id > 0) {
	$log_history = "INSERT INTO user_login_logout_history (user_id, user_type, entry_type, add_date, add_ip)
					VALUES('" . $user_id . "', '" . $_SESSION['user_type'] . "', 'User Logout', '" . $add_date . "', '" . $add_ip . "')";
	$db->query($conn, $log_history);
	$log_2 			= "UPDATE users SET sec_users = 0 WHERE id = '" . $school_user_id . "'"; //echo $log_2; die;
	$db->query($conn, $log_2);
}
session_unset();
session_destroy();
header("location: signin");
exit();
