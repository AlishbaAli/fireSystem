<?php
include('../../../path.php');
include($directory_path_for_module_folder_index . "conf/session_start.php");
include($directory_path_for_module_folder_index . "conf/connection.php");
include($directory_path_for_module_folder_index . "conf/functions.php");
$db = new mySqlDB;
if (isset($_SESSION["username"]) && isset($_SESSION["user_id"]) && isset($_SESSION["schoolDirectory"]) && $_SESSION["schoolDirectory"] == 'fireguard' &&  isset($_SESSION["project_name"]) && $_SESSION["project_name"] == $project_name) {
	$check_module_permission = check_module_permission($db, $conn, $module, $_SESSION["user_id"], $_SESSION["user_type"]);
	if ($check_module_permission == "") {
		header("location: " . $directory_path_for_module_folder_index . "signout");
		exit();
	} else {
		$selected_db_name = $_SESSION["db_name"];
		if (isset($_POST['type']) && $_POST['type'] == 'update') {
			$db = new mySqlDB;
			$record_id 		  = $_POST['record_id'];
			$new_status       = $_POST['value'];
			$sql_c_up = "UPDATE warranty SET 	enabled 		= '" . $new_status . "',
												update_date 	= '" . $add_date . "',
												update_by 	 	= '" . $_SESSION['username'] . "',
												update_ip 	 	= '" . $add_ip . "'
						WHERE id = '" . $record_id . "' ";
			$ok = $db->query($conn, $sql_c_up);
			echo $ok;
		}
	}
}
