<?php
//$timezone = "Asia/Karachi";
//date_default_timezone_set($timezone);
$add_ip 					= $_SERVER['REMOTE_ADDR'];
$add_date 					= date("Y-m-d H:i:s");
$project_domain 			= "fireg.com";
$project_domain2 			= "fireg.com";
$project_name				= "FireG, Inc.";
$emailProvider 				= "sendGrid";
$admin_email 				= "info@fireg.com";

define("PROJECT_TITLE", "FireG, Inc.");
define("PROJECT_TITLE2", "FireG, Inc.");
define("FROMEMAIL", "info@fireg.com");
define("FROMNAME", "FireG, Inc.");
define("SUB_DOMAIN_STATIC", "fireg");
$subdomain = SUB_DOMAIN_STATIC;
if ($_SERVER['HTTP_HOST'] == 'localhost') {
	define("HTTP_HOST", $_SERVER['HTTP_HOST'] . "/fireg");
	$http_protocol = "http://";
} else {
	define("HTTP_HOST", $_SERVER['HTTP_HOST'] . "/fireg");
	$http_protocol = "https://";
}
define("PROJECT_URL", $http_protocol . HTTP_HOST);
define("HTTP_PROTOCOL", $http_protocol);
$selected_for_test_on_local = "fireg";
$selected_db_name			= "fireg";
///////////////////////////////////////// MAC Address START////////////////////////
/* * Getting MAC Address using PHP
* Md. Nazmul Basher */
$mac_address = "";
ob_start(); // Turn on output buffering
system('ipconfig /all'); //Execute external program to display output
$mycom	= ob_get_contents(); // Capture the output into a variable
ob_clean(); // Clean (erase) the output buffer
$findme 		= "Physical";
$pmac 			= strpos($mycom, $findme); // Find the position of Physical text
$mac_address	= substr($mycom, ($pmac + 36), 17); // Get Physical Address
///////////////////////////////////////// MAC Address END////////////////////////

$todaymysql_date_comparison	= date("Ymd");
class mySqlDB
{
	// Methods
	function query($conn, $query)
	{
		return mysqli_query($conn, $query);
	}
	function counter($result)
	{
		return mysqli_num_rows($result);
	}
	function fetch($result)
	{
		while ($row = mysqli_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}
}
function addZero($number)
{
	if ($number < 10 || $number == 0) $number = "0" . $number;
	return $number;
}
function setTimezone($timezone)
{
	if ($timezone == 'undefined' || $timezone == 'PST8PDT' || $timezone == 'UTC' || $timezone == '') {
		$timezone = "Asia/Karachi";
		date_default_timezone_set($timezone);
	} else {
		date_default_timezone_set($timezone);
	}
	return $timezone;
}
function convertTimeAMPM($time)
{
	$time_Array = explode(':', $time);
	$hour 		= $time_Array[0];
	$minutes 	= $time_Array[1];
	if ($hour > 11 && $hour <= 24) $ampm = "PM";
	else $ampm = "AM";
	if ($hour > 12) $hour = $hour - 12;
	if ($hour < 10 && $hour > 0) $hour = "0" . $hour;
	else if ($hour == '00') $hour = "12";
	else if ($hour == '0') $hour = "12";
	$time = $hour . ":" . $minutes . " " . $ampm;
	return $time;
}
function timeAMPMWithSeconds($time)
{
	$time_Array = explode(':', $time);
	$hour 		= $time_Array[0];
	$minutes 	= $time_Array[1];
	$seconds 	= $time_Array[2];
	if ($hour > 11 && $hour <= 24) $ampm = "PM";
	else $ampm = "AM";
	if ($hour > 12) $hour = $hour - 12;
	if ($hour == '00') $hour = "12";
	else if ($hour == '0') $hour = "12";
	$time = $hour . ":" . $minutes . ":" . $seconds . " " . $ampm;
	return $time;
}
//////////////// Function to reset session if record does not found in table ///////////
function site_traffic($db, $conn, $page, $timezone)
{

	$add_ip 		= $_SERVER['REMOTE_ADDR'];
	$add_date 		=  date("Y-m-d H:i:s");
	////// Traffic history  START //////////////
	$sql_traffic1 		= "SELECT * FROM site_traffic_detail WHERE page_name = '" . $page . "' AND user_ip = '" . $add_ip . "' ";
	//echo $sql_traffic1;die;
	$result_traffic1 	= $db->query($conn, $sql_traffic1);
	$count_traffic1 	= $db->counter($result_traffic1);
	if ($count_traffic1 == 0) {
		$sql_inst1 = "INSERT INTO site_traffic_detail (page_name, user_ip, total_views, timezone, add_date)
												values('" . $page . "', '" . $add_ip . "', 1, '" . $timezone . "', '" . $add_date . "') ";
		$db->query($conn, $sql_inst1);
	} else {
		$row_traffic1 	= $db->fetch($result_traffic1);
		$total_views 	= $row_traffic1[0]['total_views'];
		$total_views 	= $total_views + 1;

		$sql_upd1 = "UPDATE site_traffic_detail SET total_views = '" . $total_views . "', visitor_detail_seen = 0,  update_date = '" . $add_date . "'
						WHERE page_name = '" . $page . "' AND user_ip = '" . $add_ip . "' ";
		$db->query($conn, $sql_upd1);
	}
	////// Traffic history  END //////////////
}
//////////////// Disallow Direct Access Admin ///////////
function disallow_direct_school_directory_access()
{
	header("location: " . HTTP_PROTOCOL . HTTP_HOST . "/signout");
	exit();
	//*/
}
//////////////// Disallow Direct Access Super Admin ///////////
function disallow_direct_sadmin_directory_access()
{
	header("location: " . HTTP_PROTOCOL . HTTP_HOST . "/sadmin/signout");
	exit();
	//*/
}
//////////////// Function to reset session of Super Admin if record does not found in table ///////////
function check_session_exist2($db, $conn, $user_id, $username, $user_type)
{
	$sql 		= "SELECT * FROM super_admin
					WHERE enabled = 1
					AND id 			= '" . $user_id . "'
					AND username 	= '" . $username . "'
					AND user_type 	= '" . $user_type . "' "; //echo $sql;die;
	$result 	= $db->query($conn, $sql);
	$count 		= $db->counter($result);
	///*
	if ($count == 0) {
		session_unset();
		session_destroy();
		header("location: " . HTTP_PROTOCOL . HTTP_HOST . "/sadmin/signout");
		exit();
	}
	//*/
}
//////////////// Function to reset session of School Login if record does not found in table ///////////
function check_session_exist4($db, $conn, $user_id, $username, $user_type, $db_name, $parm2, $parm3)
{
	$sql 		= " SELECT * FROM users
					WHERE id = '" . $user_id . "'
					AND username = '" . $username . "' 
					AND user_type = '" . $user_type . "' 
					AND enabled = 1 "; //echo $sql;die;
	$result 	= $db->query($conn, $sql);
	$count 		= $db->counter($result);
	///*
	if ($count == 0) {
		session_unset();
		session_destroy();
		header("location: " . HTTP_PROTOCOL . HTTP_HOST . "/signout");
		exit();
	}
	//*/
}
//////////////// Function to reset session of User Login if record does not found in table ///////////
function check_session_exist3($db, $conn, $user_id, $username, $user_type)
{
	$sql 		= "SELECT * FROM users
					WHERE enabled = 1
					AND id 			= '" . $user_id . "'
					AND username 	= '" . $username . "'
					AND user_type 	= '" . $user_type . "' "; //echo $sql;die;
	$result 	= $db->query($conn, $sql);
	$count 		= $db->counter($result);
	///*
	if ($count == 0) {
		session_unset();
		session_destroy();
		header("location: " . HTTP_PROTOCOL . HTTP_HOST . "/signout");
		exit();
	}
	//*/
}
//////////////// Function check menu permissions For Super Admin ///////////
function check_menu_permissions_super_admin($db, $conn, $user_id, $menu_id)
{
	$sql 		= "	SELECT * FROM super_admin_role_permissions a
					INNER JOIN super_admin_roles b ON b.id = a.role_id
					INNER JOIN super_admin_user_roles c ON c.role_id = b.id
					WHERE c.user_id = '" . $user_id . "'
					AND a.menu_id 	= '" . $menu_id . "' "; //echo $sql;//die;
	$result 	= $db->query($conn, $sql);
	$count 		= $db->counter($result);
	if ($count > 0) {
		return 1;
	} else {
		return 0;
	}
}
//////////////// Function check menu permissions For School Users ///////////
function check_menu_permissions($db, $conn, $user_id, $subscriber_users_id, $user_type, $menu_id, $db_name, $parm2, $parm3)
{
	$sql 		= "	SELECT * FROM role_permissions a
					INNER JOIN roles b ON b.id = a.role_id
					INNER JOIN user_roles c ON c.role_id = b.id
					WHERE  c.subscriber_users_id = '" . $subscriber_users_id . "' 
					AND a.menu_id 	= '" . $menu_id . "' ";
	// echo $sql;die;
	$result 	= $db->query($conn, $sql);
	$count 		= $db->counter($result);
	if ($user_type == 'Admin') {
		if ($count > 0) {
			return 1;
		} else {
			return 0;
		}
	} else {
		if ($count > 0) {
			$sql 		= "	SELECT * FROM sub_users_role_permissions a
							INNER JOIN sub_users_roles b ON b.id = a.role_id
							INNER JOIN sub_users_user_roles c ON c.role_id = b.id
							WHERE  c.user_id = '" . $user_id . "' 
							AND a.menu_id 	= '" . $menu_id . "' ";
			// echo $sql; die;
			$result 	= $db->query($conn, $sql);
			$count 		= $db->counter($result);
			if ($count > 0) {
				return 1;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}
}
//////////////// Function check menu child ///////////
function check_module_permission_super_admin($db, $conn, $module, $user_id)
{
	$sql 		= "	SELECT a.* FROM super_admin_menus a
					INNER JOIN super_admin_role_permissions b ON b.menu_id = a.id
					INNER JOIN super_admin_user_roles c ON c.role_id = b.role_id
					WHERE a.enabled = 1 AND b.enabled = 1
					AND a.folder_name 	= '" . $module . "'
					AND c.user_id 		= '" . $user_id . "' ";
	$result 	= $db->query($conn, $sql); //echo $sql;die;
	$count 		= $db->counter($result);
	if ($count > 0) {
		$row = $db->fetch($result);
		return $row[0]['menu_name'];
	} else {
		return "";
	}
}
//////////////// Function check menu child ///////////
function check_module_permission($db, $conn, $module, $user_id, $user_type)
{
	if ($user_type == 'Admin') {
		$sql 		= " SELECT a.menu_name 
						FROM menus a
						INNER JOIN role_permissions b ON b.menu_id = a.id
						INNER JOIN user_roles c ON c.role_id = b.role_id
						WHERE a.enabled 		= 1
						AND b.enabled 			= 1
						AND a.folder_name 		= '" . $module . "'
						ORDER BY b.id DESC LIMIT 1 ";
		$result 	= $db->query($conn, $sql); //echo $sql;die;
		$count 		= $db->counter($result);
		if ($count > 0) {
			$row = $db->fetch($result);
			return $row[0]['menu_name'];
		} else {
			return "";
		}
	} else {
		$sql 		= " SELECT a.menu_name 
						FROM menus a
						INNER JOIN sub_users_role_permissions b ON b.menu_id = a.id
						INNER JOIN sub_users_user_roles c ON c.role_id = b.role_id
						WHERE a.enabled 		= 1
						AND b.enabled 			= 1
						AND a.folder_name 		= '" . $module . "'
						AND c.user_id 	= '" . $user_id . "'
						ORDER BY b.id DESC LIMIT 1 ";
		$result 	= $db->query($conn, $sql); //echo $sql;die;
		$count 		= $db->counter($result);
		if ($count > 0) {
			$row = $db->fetch($result);
			return $row[0]['menu_name'];
		} else {
			return "";
		}
	}
}
//////////////// Function check menu child ///////////
function check_menu_child_super_admin($db, $conn, $parent_id, $m_level)
{
	$sql 		= "	SELECT * FROM super_admin_menus
					WHERE parent_id = '" . $parent_id . "'
					AND m_level 	= '" . $m_level . "' 
					AND enabled 	= 1 ORDER BY sort_order ";
	//echo $sql;die;
	$result 	= $db->query($conn, $sql);
	$count 		= $db->counter($result);
	if ($count > 0) {
		return 1;
	} else {
		return 0;
	}
}
//////////////// Function check menu child ///////////
function check_id($db, $conn, $id, $table_name)
{
	$sql 		= "	SELECT * FROM " . $table_name . "
					WHERE id = '" . $id . "'  ";
	$result 	= $db->query($conn, $sql);
	$count 		= $db->counter($result);
	if ($count == 0) {
		session_unset();
		session_destroy();
		header("location: " . HTTP_PROTOCOL . HTTP_HOST . "/signout");
		exit();
	}
}
//////////////// Function check menu child ///////////
function check_menu_child($db, $conn, $parent_id, $m_level)
{
	$sql 		= "	SELECT * FROM menus
					WHERE parent_id = '" . $parent_id . "'
					AND m_level 	= '" . $m_level . "' 
					AND enabled 	= 1 ORDER BY sort_order ";
	// echo $sql;
	$result 	= $db->query($conn, $sql);
	$count 		= $db->counter($result);
	if ($count > 0) {
		return 1;
	} else {
		return 0;
	}
}
function insert_error($db, $conn, $error_type, $field_name, $field_value, $error_msg, $error_page_name)
{

	$add_ip 		= $_SERVER['REMOTE_ADDR'];
	$add_date 		=  date("Y-m-d H:i:s");
	$timezone 		= date_default_timezone_get();
	$field_value 	= trim(htmlspecialchars(strip_tags(stripslashes($field_value)), ENT_QUOTES, 'UTF-8'));
	$error_msg 		= trim(htmlspecialchars(strip_tags(stripslashes($error_msg)), ENT_QUOTES, 'UTF-8'));

	$sql_error 		= "INSERT INTO error_log (error_type, field_name, field_value, error_msg, error_page_name,
																				timezone, add_date, add_ip)
						VALUES ('" . $error_type . "', '" . $field_name . "','" . $field_value . "', '" . $error_msg . "', '" . $error_page_name . "',
																'" . $timezone . "', '" . $add_date . "', '" . $add_ip . "')";
	$db->query($conn, $sql_error);
}
function remove_special_character($field)
{
	// single and double codes = &#039;, &quot;
	$field = str_replace(array("'", "$", "\"", "&#039;", "&quot;", "=", "||", "%"), "", $field);
	return $field;
}
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
// date conversion from british to mysql compatible
function convert_date_mysql($date)
{
	$date_explode = explode("-", $date);

	$day = $date_explode[0];
	$month = $date_explode[1];
	$year = $date_explode[2];

	$mysql_date = $year . "-" . $month . "-" . $day;
	if ($mysql_date == '--') $mysql_date = '';

	return $mysql_date;
}
// date conversion from british to mysql compatible
function convert_date_mysql_slash($date)
{
	$date_explode = explode("/", $date);

	$day = $date_explode[0];
	$month = $date_explode[1];
	$year = $date_explode[2];

	$mysql_date = $year . "-" . $month . "-" . $day;
	if ($mysql_date == '--') $mysql_date = '';

	return $mysql_date;
}
// date conversion from mysql to british
function convert_date_display($date)
{

	if ($date != '0000-00-00' && $date != '') {
		$date_explode = explode("-", $date);

		$year = $date_explode[0];
		$month = $date_explode[1];
		$day = $date_explode[2];

		$mysql_date = trim($day) . "-" . trim($month) . "-" . trim($year);
	} else {
		$mysql_date = '';
	}
	return $mysql_date;
}
function sort_date_format($date, $sort_type_current, $sort_type_new, $separator, $new_separator)
{ //  type = 'Mysql or USA OR Normal'
	$date_explode 	= explode($separator, $date);

	if (sizeof($date_explode) == 3) {
		$date_array1 	= $date_explode[0];
		$date_array2 	= $date_explode[1];
		$date_array3 	= $date_explode[2];
		if ($sort_type_current == 'Mysql' && $sort_type_new == 'USA') { // Mysql 2020-03-25
			$retundate = $date_array2 . $new_separator . $date_array3 . $new_separator . $date_array1;
		} else if ($sort_type_current == 'Mysql' && $sort_type_new == 'Normal') { // Mysql 2020-03-25
			$retundate = $date_array3 . $new_separator . $date_array2 . $new_separator . $date_array1;
		} else if ($sort_type_current == 'USA' && $sort_type_new == 'Normal') { // USA 03-25-2020
			$retundate = $date_array2 . $new_separator . $date_array1 . $new_separator . $date_array3;
		} else if ($sort_type_current == 'USA' && $sort_type_new == 'Mysql') { // USA 03-25-2020
			$retundate = $date_array3 . $new_separator . $date_array1 . $new_separator . $date_array2;
		} else if ($sort_type_current == 'Normal' && $sort_type_new == 'Mysql') { // Normal 25-03-2020
			$retundate = $date_array3 . $new_separator . $date_array2 . $new_separator . $date_array1;
		} else if ($sort_type_current == 'Normal' && $sort_type_new == 'USA') { // Normal 25-03-2020
			$retundate = $date_array2 . $new_separator . $date_array1 . $new_separator . $date_array3;
		}
	} else {
		$retundate = "";
	}
	return $retundate;
}
function replace_date_separator($date, $separator, $new_separator)
{
	$date_explode = explode($separator, $date);
	if (sizeof($date_explode) == 3) {
		$month 	= $date_explode[0];
		$day 	= $date_explode[1];
		$year 	= $date_explode[2];
		$dateDashes = $month . $new_separator . $day . $new_separator . $year;
	} else {
		$dateDashes = "";
	}
	return $dateDashes;
}
function remove_date_separator($date, $separator)
{
	$date_explode = explode($separator, $date);
	if (sizeof($date_explode) == 3) {
		$day 	= $date_explode[0];
		$month 	= $date_explode[1];
		$year 	= $date_explode[2];
		$new_date = $day . $month . $year;
	} else {
		$new_date = "";
	}
	return $new_date;
}
function dateformat1($date)
{
	if ($date != NULL && $date != "") {
		$date = date_create($date);
		$date = date_format($date, "F d, Y");
	}
	return $date;
}
function dateformat2($date)
{
	if ($date != NULL && $date != "") {
		$date = date_create($date);
		$date = date_format($date, "M d, Y");
	}
	return $date;
}
function dateformat3($date)
{
	if ($date != NULL && $date != "") {
		$date = date_create($date);
		$date = date_format($date, "d/m/Y");
	}
	return $date;
}
function dateformat1_with_time($date)
{
	if ($date != NULL && $date != "") {
		$date = date_create($date);
		$date = date_format($date, "M d, Y h:i:s A");
	}
	return $date;
}

function dateformat1_with_time_USA($date)
{
	if ($date != NULL && $date != "") {
		$date = date_create($date);
		$date = date_format($date, "d/m/Y h:i A");
	}
	return $date;
}
function convert_date_display_date_from_datetime($date)
{
	if ($date != NULL && $date != "") {
		$date = date_create($date);
		$date = date_format($date, "d-m-Y");
	}
	return $date;
}
function convert_date_display_time_from_datetime($date)
{
	$time = "";
	if ($date != NULL && $date != "") {
		if (substr($date, 11, 8) != '00:00:00') {
			$date = date_create($date);
			$time = date_format($date, "h:i A");
		}
	}
	return $time;
}
function convert_month_letter($month)
{
	return date("F", mktime(null, null, null, $month));
}
function dateDifference($date_1, $date_2, $differenceFormat = '%a')
{
	$datetime1 = date_create($date_1);
	$datetime2 = date_create($date_2);

	$interval = date_diff($datetime1, $datetime2);

	return $interval->format($differenceFormat);

	//////////////////////////////////////////////////////////////////////
	//PARA: Date Should In YYYY-MM-DD Format
	//RESULT FORMAT:
	// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
	// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
	// '%m Month %d Day'                                            =>  3 Month 14 Day
	// '%d Day %h Hours'                                            =>  14 Day 11 Hours
	// '%d Day'                                                        =>  14 Days
	// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
	// '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
	// '%h Hours                                                    =>  11 Hours
	// '%a Days                                                        =>  468 Days

}
function displayPost_Time($date_difference)
{
	$break_date_time = explode(" ", $date_difference);
	$date_array 	= explode("-", $break_date_time[0]);
	$time_array 	= explode(":", $break_date_time[1]);

	$years 			= $date_array[0];
	$months 		= $date_array[1];
	$days 			= $date_array[2];

	$hours 			= $time_array[0];
	$minutes 		= $time_array[1];
	$seconds 		= $time_array[2];
	$ago 			= "Ago";
	$post_Time 	= "";
	$comma 		= "";
	if ($years > 0) {
		if ($years > 1) {
			$post_Time .= $years . " Years";
		} else {
			$post_Time .= $years . " Year";
		}
		$comma 		= ", ";
	}
	if ($months > 0) {
		if ($months > 1) {
			$post_Time .= $comma . $months . " Months";
		} else {
			$post_Time .= $comma . $months . " Month";
		}
		$comma 		= " and ";
	}
	if ($days > 0) {
		if ($days > 1) {
			$post_Time .= $comma . $days . " Days";
		} else {
			$post_Time .= $comma . $days . " Day";
		}
	}
	if ($years == '0' && $months == '0' && $days == '0') {
		$post_Time 	= "";
		$comma 		= "";
		if ($hours > 0) {
			if ($hours > 1) {
				$post_Time .= $hours . " Hours";
			} else {
				$post_Time .= $hours . " Hour";
			}
			$comma 		= " and ";
		}
		if ($minutes > 0) {
			if ($minutes > 1) {
				$post_Time .= $comma . $minutes . " Minutes";
			} else {
				$post_Time .= $comma . $minutes . " Minute";
			}
			$comma 		= ", ";
		}
		if ($hours == '0' && $minutes == '0') {
			if ($seconds > 1) {
				$post_Time .= $comma . $seconds . " Seconds";
			} else {
				$post_Time .= $comma . " Just Added ";
				$ago = "";
			}
		}
	}
	return $post_Time . " " . $ago;
}
// Compress image
function compressImage($source, $destination, $quality)
{
	$info = getimagesize($source);
	if ($info['mime'] == 'image/jpeg')
		$image = imagecreatefromjpeg($source);
	elseif ($info['mime'] == 'image/gif')
		$image = imagecreatefromgif($source);
	elseif ($info['mime'] == 'image/png')
		$image = imagecreatefrompng($source);
	imagejpeg($image, $destination, $quality);
}
function imageWidthHeight($image)
{
	$info = getimagesize($image);
	list($width, $height, $type, $attr) = getimagesize($image);
	//echo "Width of image : " . $width . "<br>"."Height of image : " . $height . "<br>";
	//echo "Image type :" . $type . "<br>"."Image attribute :" .$attr;
	$imageWidthHeight[] = $width;
	$imageWidthHeight[] = $height;
	return $imageWidthHeight;
}
function resizePicture($targetPath,  $original_img_width,  $original_img_height,  $new_width, $new_pic_name, $saveDirctory)
{

	$perc_reduce 			= 100 - (($new_width / $original_img_width) * 100);
	$new_height 			= $original_img_height - (($original_img_height / 100) * $perc_reduce);
	// (1) READ THE ORIGINAL IMAGE
	$info = getimagesize($targetPath);
	if ($info['mime'] == 'image/jpeg') 		$original = imagecreatefromjpeg($targetPath);
	elseif ($info['mime'] == 'image/gif') 	$original = imagecreatefromgif($targetPath);
	elseif ($info['mime'] == 'image/png') 	$original = imagecreatefrompng($targetPath);
	// (2) EMPTY CANVAS WITH REQUIRED DIMENSIONS
	$resized = imagecreatetruecolor($new_width, $new_height); // SMALLER
	// (3) RESIZE THE IMAGE
	imagecopyresampled($resized, $original, 0, 0, 0, 0, $new_width, $new_height, $original_img_width, $original_img_height);
	// (4) SAVE/OUTPUT RESIZED IMAGE
	$brand_logo_sm = $new_pic_name . ".jpeg";
	$resized_path = $saveDirctory . "/" . $brand_logo_sm;
	imagejpeg($resized, $resized_path);
	// (5) OPTIONAL - CLEAN UP
	imagedestroy($original);
	imagedestroy($resized);

	return $brand_logo_sm;
}
/// For Height still neeed test //////////
function resizePictureSetHeight($targetPath,  $original_img_width,  $original_img_height,  $new_height, $new_pic_name, $saveDirctory)
{

	$perc_reduce 			= 100 - (($new_height / $original_img_height) * 100);
	$new_width 				= $original_img_width - (($original_img_width / 100) * $perc_reduce);
	// (1) READ THE ORIGINAL IMAGE
	$info = getimagesize($targetPath);
	if ($info['mime'] == 'image/jpeg') 		$original = imagecreatefromjpeg($targetPath);
	elseif ($info['mime'] == 'image/gif') 	$original = imagecreatefromgif($targetPath);
	elseif ($info['mime'] == 'image/png') 	$original = imagecreatefrompng($targetPath);
	// (2) EMPTY CANVAS WITH REQUIRED DIMENSIONS
	$resized = imagecreatetruecolor($new_width, $new_height); // SMALLER
	// (3) RESIZE THE IMAGE
	imagecopyresampled($resized, $original, 0, 0, 0, 0, $new_width, $new_height, $original_img_width, $original_img_height);
	// (4) SAVE/OUTPUT RESIZED IMAGE
	$img_name = $new_pic_name . ".jpeg";
	$resized_path = $saveDirctory . "/" . $img_name;
	imagejpeg($resized, $resized_path);
	// (5) OPTIONAL - CLEAN UP
	imagedestroy($original);
	imagedestroy($resized);
	return $img_name;
}
function encrypt($sData)
{
	$sKey = '24234#dd1133a$a*';
	$sResult = '';
	for ($i = 0; $i < strlen($sData); $i++) {
		$sChar    = substr($sData, $i, 1);
		$sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
		$sChar    = chr(ord($sChar) + ord($sKeyChar));
		$sResult .= $sChar;
	}
	return encode_base64($sResult);
}
function decrypt($sData)
{
	$sKey = '24234#dd1133a$a*';
	$sResult = '';
	$sData   = decode_base64($sData);

	for ($i = 0; $i < strlen($sData); $i++) {
		$sChar    = substr($sData, $i, 1);
		$sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
		$sChar    = chr(ord($sChar) - ord($sKeyChar));
		$sResult .= $sChar;
	}
	return $sResult;
}
function encode_base64($sData)
{
	$sBase64 = base64_encode($sData);
	return strtr($sBase64, '+/', '-_');
}
function decode_base64($sData)
{
	$sBase64 = strtr($sData, '-_', '+/');
	return base64_decode($sBase64);
}

function sendEmailSendGrid($subject_to, $toEmail, $toname, $body, $parm1, $parm2, $parm3, $parm4, $parm5, $parm6)
{
	$email = new \SendGrid\Mail\Mail();
	$sendgrid = new \SendGrid('Sdddddddddddddddddddd');
	$email->setFrom(FROMEMAIL, FROMNAME);
	$email->setSubject($subject_to);
	$email->addTo($toEmail, $toname);
	$email->addContent("text/html", $body);
	try {
		$response = $sendgrid->send($email);
	} catch (Exception $e) {
		$response = "";
	}
	return $response;
}
function tep_db_prepare_input($string)
{
	if (is_string($string)) {
		return trim(stripslashes($string));
	} elseif (is_array($string)) {
		reset($string);
		while (list($key, $value) = each($string)) {
			$string[$key] = tep_db_prepare_input($value);
		}
		return $string;
	} else {
		return $string;
	}
}
function numberFormatLeadingZeros($number, $digitsLimit)
{ // numberLimit= how much digits should at least
	$value = str_pad($number, $digitsLimit, '0', STR_PAD_LEFT);
	return $value;
}
function nameFormat1($first_name, $middle_name, $last_name)
{
	$std_full_name = "";
	if ($last_name == "") {
		$std_full_name = $middle_name . " " . $first_name;
	} else if ($middle_name == "") {
		$std_full_name = $last_name . ", " . $first_name;
	} else {
		$std_full_name = $last_name . ", " . $middle_name . " " . substr($first_name, 0, 1);
	}
	echo $std_full_name;
}
function nameFormat_return($first_name, $middle_name, $last_name)
{
	$std_full_name = "";
	if ($last_name == "") {
		$std_full_name = $middle_name . " " . $first_name;
	} else if ($middle_name == "") {
		$std_full_name = $last_name . ", " . $first_name;
	} else {
		$std_full_name = $last_name . ", " . $middle_name . " " . substr($first_name, 0, 1);
	}
	return $std_full_name;
}
function getIndianCurrency(float $number)
{
	$decimal = round($number - ($no = floor($number)), 2) * 100;
	$hundred = null;
	$digits_length = strlen($no);
	$i = 0;
	$str = array();
	$words = array(
		0 => '', 1 => 'one', 2 => 'two',
		3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
		7 => 'seven', 8 => 'eight', 9 => 'nine',
		10 => 'ten', 11 => 'eleven', 12 => 'twelve',
		13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
		16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
		19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
		40 => 'forty', 50 => 'fifty', 60 => 'sixty',
		70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
	);
	$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');

	while ($i < $digits_length) {
		$divider = ($i == 2) ? 10 : 100;
		$number = floor($no % $divider);
		$no = floor($no / $divider);
		$i += $divider == 10 ? 1 : 2;
		if ($number) {
			$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
			$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
			$str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
		} else $str[] = null;
	}

	$rupees = implode('', array_reverse($str));
	$paise = '';

	// if ($decimal) {
	//     $paise = 'and ';
	//     $decimal_length = strlen($decimal);

	//     if ($decimal_length == 2) {
	//         if ($decimal >= 20) {
	//             $dc = $decimal % 10;
	//             $td = $decimal - $dc;
	//             $ps = ($dc == 0) ? '' : '-' . $words[$dc];

	//             $paise .= $words[$td] . $ps;
	//         } else {
	//             $paise .= $words[$decimal];
	//         }
	//     } else {
	//         $paise .= $words[$decimal % 10];
	//     }
	//     $paise .= 'Cent';
	// }
	// return ($rupees ? $rupees . 'rupees' : '') . $paise ;


	return ($rupees ? $rupees . '' : '');
}
function mysqlDateValidation($date)
{
	$is_validate 	= 0;
	$strLength 		= strlen($date);
	if ($strLength == '10') {
		if (strpos($date, '-', 6) !== false) {
			if (strpos($date, '-', 3) !== false) {
				$is_validate = 1;
			}
		}
	}
	return $is_validate;
}
function timeValidation($time)
{
	$is_validate 	= 0;
	$strLength 		= strlen($time);
	if ($strLength == '8') {
		$time_last_str = substr($time, -2);
		$time_first_str = substr($time, 2, 1);
		if ($time_last_str == 'AM' ||  $time_last_str == 'am' ||  $time_last_str == 'PM' ||  $time_last_str == 'pm') {
			if ($time_first_str == ':') {
				$is_validate = 1;
			}
		}
	}
	return $is_validate;
}

function sendSMS($db, $conn, $school_admin_id, $selected_db_name, $username, $phone_no, $msg_content, $module_menue_id, $sending_purpose, $parm1 = "", $parm2 = "", $parm3 = "")
{
	$add_ip 					= $_SERVER['REMOTE_ADDR'];
	$add_date 					= date("Y-m-d H:i:s");
	return "";
}
function sendSMS_MainSite($db, $conn, $username, $phone_no, $msg_content, $sending_purpose, $parm1 = "", $parm2 = "", $parm3 = "")
{
	$add_ip 					= $_SERVER['REMOTE_ADDR'];
	$add_date 					= date("Y-m-d H:i:s");
	return "";
}

//////////////// Function check menu child ///////////
function check_module_permission_school($db, $conn, $menu_id, $school_user_id, $subscriber_users_id, $user_type, $db_name)
{
	if ($user_type == 'Admin') {
		$sql 		= " SELECT a.menu_name 
						FROM menus a
						INNER JOIN role_permissions b ON b.menu_id = a.id
						INNER JOIN user_roles c ON c.role_id = b.role_id
						WHERE a.enabled 		= 1
						AND b.enabled 			= 1
						AND a.id 				= '" . $menu_id . "'
						AND c.subscriber_users_id 	= '" . $subscriber_users_id . "' 
						ORDER BY b.id DESC LIMIT 1";
		$result 	= $db->query($conn, $sql);
		$count 		= $db->counter($result);
		if ($count > 0) {
			$row = $db->fetch($result);
			return $row[0]['menu_name'];
		} else {
			return "";
		}
	} else {
		$sql 		= " SELECT a.menu_name FROM menus a
						INNER JOIN " . $db_name . ".role_permissions b ON b.menu_id = a.id
						INNER JOIN " . $db_name . ".user_roles c ON c.role_id = b.role_id
						WHERE a.enabled 		= 1
						AND b.enabled 			= 1
						AND a.id 		= '" . $menu_id . "'
						AND c.subscriber_users_id 	= '" . $subscriber_users_id . "'
						AND c.school_user_id 	= '" . $school_user_id . "'
						ORDER BY b.id DESC LIMIT 1 ";
		$result 	= $db->query($conn, $sql); //echo $sql;die;
		$count 		= $db->counter($result);
		if ($count > 0) {
			$row = $db->fetch($result);
			return $row[0]['menu_name'];
		} else {
			return "";
		}
	}
}
