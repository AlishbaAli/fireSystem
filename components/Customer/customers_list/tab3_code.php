<?php
// 	operatorid  contact problem complete completedby completiondate supplemented supplementedby supplementeddate lasteditorid pendingparts datewoscheduled wotimelength assigntoid repeatcall dateofservice laborbilltocustomer partsbilltocustomer comment
if (isset($is_Submit_tab3) && $is_Submit_tab3 == 'Y') {
	if (decrypt($csrf_token) != $_SESSION["csrf_session"]) {
		header("location: signout");
		exit();
	}
	if (isset($timeout_time) && $timeout_time == "") {
		$error['msg'] 			= "Enter Labor Hours";
		$timeout_time_valid 	= "invalid";
	}
	if (isset($timeout_date) && $timeout_date == "") {
		$error['msg'] 		= "Enter Labor Hours";
		$timeout_date_valid 	= "invalid";
	}
	if (isset($timein_time) && $timein_time == "") {
		$error['msg'] 		= "Enter Labor Hours";
		$timein_time_valid 	= "invalid";
	}
	if (isset($timein_date) && $timein_date == "") {
		$error['msg'] 		= "Enter Labor Hours";
		$timein_date_valid 	= "invalid";
	}
	if (isset($laborhours) && $laborhours == "") {
		$error['msg'] 		= "Enter Labor Hours";
		$laborhours_valid 	= "invalid";
	}
	if (isset($technicianid) && $technicianid == "") {
		$error['msg'] 		= "Select Technician";
		$technicianid_valid = "invalid";
	}
	if (isset($workorderid) && $workorderid == "") {
		$error['msg'] 		= "Select Work Order";
		$workorderid_valid = "invalid";
	}
	if (!isset($id) || (isset($id)  && ($id == "0" || $id == ""))) {
		$error['msg'] = "Please add customer  First";
	}
	if (empty($error)) {

		$timein_date1 				= "0000-00-00";
		$timeout_date1 				= "0000-00-00";

		if (isset($timein_date) && $timein_date != "") {
			$timein_date1 = convert_date_mysql_slash($timein_date);
		}
		if (isset($timeout_date) && $timeout_date != "") {
			$timeout_date1 = convert_date_mysql_slash($timeout_date);
		}
		if ($timein_time != "") {
			$phpdate 			= strtotime($timein_time);
			$timein_time1 		= date('H:i:s', $phpdate);
			$timein_date1		= $timein_date1 . " " . $timein_time1;
		}
		if ($timeout_time != "") {
			$phpdate2 			= strtotime($timeout_time);
			$timeout_time1 	= date('H:i:s', $phpdate2);
			$timeout_date1 	= $timeout_date1 . " " . $timeout_time1;
		}







		if ($cmd3 == 'add') {
			$sql_ee1 				= "	SELECT a.* FROM workdone a  
										WHERE  a.workorderid 	= '" . $workorderid . "' 
										AND a.technicianid 		= '" . $technicianid . "' 
										AND a.laborhours	 	= '" . $laborhours . "' 
										AND a.timeout	 		= '" . $timeout_date1 . "' 
										AND a.timein	 		= '" . $timein_date1 . "'  ";
			$result_ee1 			= $db->query($conn, $sql_ee1);
			$counter_ee1			= $db->counter($result_ee1);
			if ($counter_ee1 == 0) {
				$sql = "INSERT INTO workdone(workorderid, technicianid, laborhours, partsused, contacted, drivetimestart, timein, timeout, 
												operatorid, laboramount, partsamount, workdone, add_date, add_by, add_ip)
						VALUES	('" . $workorderid . "', '" . $technicianid . "', '" . $laborhours . "', '" . $partsused . "', '" . $contacted . "', '" . $timein_date1 . "', '" . $timein_date1 . "', 
								'" . $timeout_date1 . "',  '" . $operatorid . "',  '" . $laboramount . "',  '" . $partsamount . "',  '" . $workdone . "', '" . $add_date . "', 
									'" . $_SESSION['username'] . "', '" . $add_ip . "')";
				//echo $sql;
				$ok = $db->query($conn, $sql);
				if ($ok) {
					$workorderid = $technicianid = $laborhours = $laborhours = $partsused = $contacted = $timein_date = $timein_time = $timeout_date = $timeout_time = $operatorid = $laboramount = $partsamount = $workdone = "";
					$msg['msg_success'] = " record  has been added successfully.";
				} else {
					$error['msg'] = "There is Error, Please check it again OR contact Support Team.";
				}
			} else {
				$error['msg'] = "This record already exist.";
			}
		} else if ($cmd3 == 'edit') {
			$sql_ee1 				= "	SELECT a.* FROM workdone a  
										WHERE  a.workorderid 	= '" . $workorderid . "' 
										AND a.technicianid 		= '" . $technicianid . "' 
										AND a.laborhours 		= '" . $laborhours . "'
										AND a.timeout	 		= '" . $timeout_date1 . "' 
										AND a.timein	 		= '" . $timein_date1 . "'  
										AND id					!='" . $detail_id . "'  ";
			$result_ee1 			= $db->query($conn, $sql_ee1);
			$counter_ee1			= $db->counter($result_ee1);
			if ($counter_ee1 == 0) {
				$sql_c_up = "UPDATE  workdone SET  
													workorderid				= '" . $workorderid . "' , 
													technicianid			= '" . $technicianid . "' ,
													laborhours 				= '" . $laborhours . "',
													partsused				= '" . $partsused . "',
													contacted				= '" . $contacted . "',
													drivetimestart			= '" . $timein_date1 . "',
													timein					= '" . $timein_date1 . "',
													timeout					= '" . $timeout_date1 . "',
													operatorid				= '" . $operatorid . "',
													laboramount				= '" . $laboramount . "',
													partsamount				= '" . $partsamount . "',
													workdone				= '" . $workdone . "',
													update_date				= '" . $add_date . "',
													update_by				= '" . $_SESSION['username'] . "',
													update_ip				= '" . $add_ip . "'
													WHERE id ='" . $detail_id . "' ";
				$ok = $db->query($conn, $sql_c_up);
				if ($ok) {
					$button_edu = "Edit";
					$msg['msg_success'] = "Record Updated Successfully.";
				} else {
					$error['msg'] = "There is Error, record did not update, Please check it again OR contact Support Team.";
				}
			} else {
				$error['msg'] = "This record already exist .";
			}
		}
	}
} else if (isset($cmd3) && $cmd3 == 'delete' && isset($detail_id)) {
	$sql_del 			= "	DELETE FROM workdone WHERE id = '" . $detail_id . "' ";
	$ok = $db->query($conn, $sql_del);
	if ($ok) {
		$cmd3 = "add";
		$error['msg'] = "Record Deleted Successfully";
	} else {
		$error['msg'] = "There is Error, record did not delete, Please check it again OR contact Support Team.";
	}
} else if (isset($cmd3) && $cmd3 == 'edit' && isset($detail_id)) {
	$button_edu 		= "Edit";
	$sql_ee 			= "	SELECT a.* FROM workdone a WHERE a.id = '" . $detail_id . "'  ";
	//echo $sql_ee;
	$result_ee 			= $db->query($conn, $sql_ee);
	$counter_ee1		= $db->counter($result_ee);
	if ($counter_ee1 > 0) {
		$row_ee					= $db->fetch($result_ee);
		$workorderid			= $row_ee[0]['workorderid'];
		$technicianid			= $row_ee[0]['technicianid'];
		$laborhours				= $row_ee[0]['laborhours'];
		$partsused				= $row_ee[0]['partsused'];
		$contacted				= $row_ee[0]['contacted'];
		$operatorid				= $row_ee[0]['operatorid'];
		$laboramount			= $row_ee[0]['laboramount'];
		$partsamount			= $row_ee[0]['partsamount'];
		$workdone				= $row_ee[0]['workdone'];

		if ($row_ee[0]['timein'] == "0000-00-00 00:00:00") {
			$timein_date 			= "";
			$timein_time 			= "";
		} else {
			$timein_date			= str_replace("-", "/", convert_date_display_date_from_datetime($row_ee[0]['timein']));
			$timein_time			= convert_date_display_time_from_datetime($row_ee[0]['timein']);
		}
		if ($row_ee[0]['timeout'] == "0000-00-00 00:00:00") {
			$timein_date 			= "";
			$timein_time 			= "";
		} else {
			$timeout_date			= str_replace("-", "/", convert_date_display_date_from_datetime($row_ee[0]['timeout']));
			$timeout_time			= convert_date_display_time_from_datetime($row_ee[0]['timeout']);
		}
	} else {
		$error['msg'] = "No record found";
	}
}
