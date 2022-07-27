<?php
// 	operatorid  contact problem complete completedby completiondate supplemented supplementedby supplementeddate lasteditorid pendingparts datewoscheduled wotimelength assigntoid repeatcall dateofservice laborbilltocustomer partsbilltocustomer comment
if (isset($is_Submit_tab2) && $is_Submit_tab2 == 'Y') {
	if (decrypt($csrf_token) != $_SESSION["csrf_session"]) {
		header("location: signout");
		exit();
	}
	if (isset($problem) && $problem == "") {
		$error['msg'] = "Enter Problem Detail";
		$problem_valid = "invalid";
	}
	if (isset($contact) && $contact == "") {
		$error['msg'] = "Enter Contact Name";
		$contact_valid = "invalid";
	}
	if (isset($operatorid) && $operatorid == "") {
		$error['msg'] = "Select Operator";
		$operatorid_valid = "invalid";
	}
	if (!isset($id) || (isset($id)  && ($id == "0" || $id == ""))) {
		$error['msg'] = "Please add customer  First";
	}
	if (empty($error)) {
		$dateofservice1 				= "0000-00-00";
		$datewoscheduled1 				= "0000-00-00";
		$supplementeddate1				= "0000-00-00";
		$underwrittingdateend1 			= "0000-00-00";

		if (isset($dateofservice) && $dateofservice != "") {
			$dateofservice1 = convert_date_mysql_slash($dateofservice);
		}
		if (isset($datewoscheduled) && $datewoscheduled != "") {
			$datewoscheduled1 = convert_date_mysql_slash($datewoscheduled);
		}
		if (isset($supplementeddate) && $supplementeddate != "") {
			$supplementeddate1 = convert_date_mysql_slash($supplementeddate);
		}
		if (isset($completiondate) && $completiondate != "") {
			$completiondate1 = convert_date_mysql_slash($completiondate);
		}

		if ($completiontime != "") {
			$phpdate 			= strtotime($completiontime);
			$completiontime1 	= date('H:i:s', $phpdate);
			$completiondate1 	= $completiondate1 . " " . $completiontime1;
		}
		if ($supplementedtime != "") {
			$phpdate2 			= strtotime($supplementedtime);
			$supplementedtime1 	= date('H:i:s', $phpdate2);
			$supplementeddate1 	= $supplementeddate1 . " " . $supplementedtime1;
		}
		if ($timewoscheduled != "") {
			$phpdate3 			= strtotime($timewoscheduled);
			$timewoscheduled1 	= date('H:i:s', $phpdate3);
			$datewoscheduled1 	= $datewoscheduled1 . " " . $timewoscheduled1;
		}

		if ($cmd2 == 'add') {
			$sql_ee1 				= "	SELECT a.* FROM workorders a  
										WHERE  a.customerinfoid = '" . $id . "' 
										AND a.operatorid = '" . $operatorid . "' 
 										AND a.contact = '" . $contact . "' 
										AND a.problem = '" . $problem . "' ";
			$result_ee1 			= $db->query($conn, $sql_ee1);
			$counter_ee1			= $db->counter($result_ee1);
			if ($counter_ee1 == 0) {
				$sql = "INSERT INTO workorders(customerinfoid, operatorid, contact, problem, complete, completedby, completiondate, 
												supplemented, supplementedby, supplementeddate, lasteditorid, pendingparts, 
												datewoscheduled, wotimelength, assigntoid, repeatcall, dateofservice, laborbilltocustomer, 
												partsbilltocustomer, comments, createdondate, add_date, add_by, add_ip)
						VALUES	('" . $id . "',  '" . $operatorid . "', '" . $contact . "', '" . $problem . "', '" . $complete . "', '" . $completedby . "', '" . $completiondate1 . "', 
									'" . $supplemented . "', '" . $supplementedby . "', '" . $supplementeddate1 . "', '" . $lasteditorid . "', '" . $pendingparts . "', 
									'" . $datewoscheduled1 . "', '" . $wotimelength . "', '" . $assigntoid . "', '" . $repeatcall . "', '" . $dateofservice1 . "', '" . $laborbilltocustomer . "', 
									'" . $partsbilltocustomer . "', '" . $comment . "', '" . $add_date . "', '" . $add_date . "', '" . $_SESSION['username'] . "', '" . $add_ip . "')";
				//echo $sql;
				$ok = $db->query($conn, $sql);
				if ($ok) {
					$operatorid = $contact = $problem = $complete = $completedby = $completiondate = $supplemented = $supplementedby = $supplementeddate = $lasteditorid = $pendingparts = $datewoscheduled = $wotimelength = $assigntoid = $repeatcall = $dateofservice = $laborbilltocustomer = $partsbilltocustomer = $comment = "";
					$msg['msg_success'] = " record  has been added successfully.";
				} else {
					$error['msg'] = "There is Error, Please check it again OR contact Support Team.";
				}
			} else {
				$error['msg'] = "This record already exist.";
			}
		} else if ($cmd2 == 'edit') {
			$sql_ee1 				= "	SELECT a.* FROM workorders a  
										WHERE  a.customerinfoid = '" . $id . "' 
										AND a.operatorid 		= '" . $operatorid . "' 
										AND a.contact 			= '" . $contact . "' 
										AND a.problem 			= '" . $problem . "'
										AND id 				   !='" . $detail_id . "' ";
			$result_ee1 			= $db->query($conn, $sql_ee1);
			$counter_ee1			= $db->counter($result_ee1);
			if ($counter_ee1 == 0) {
				$sql_c_up = "UPDATE  workorders SET  
													operatorid				= '" . $operatorid . "' , 
													contact    				= '" . $contact . "' ,
													problem 				= '" . $problem . "',
													complete				= '" . $complete . "',
													completedby				= '" . $completedby . "',
													completiondate			= '" . $completiondate1 . "',
													supplemented			= '" . $supplemented . "',
													supplementedby			= '" . $supplementedby . "',
													supplementeddate		= '" . $supplementeddate1 . "',
													lasteditorid			= '" . $lasteditorid . "',
													pendingparts			= '" . $pendingparts . "',
													datewoscheduled			= '" . $datewoscheduled1 . "',
													wotimelength			= '" . $wotimelength . "',
													assigntoid				= '" . $assigntoid . "',
													repeatcall				= '" . $repeatcall . "',
													dateofservice			= '" . $dateofservice1 . "',
													laborbilltocustomer		= '" . $laborbilltocustomer . "',
													partsbilltocustomer		= '" . $partsbilltocustomer . "',
													comments				= '" . $comment . "',
													createdondate			= '" . $add_date . "',
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
} else if (isset($cmd2) && $cmd2 == 'delete' && isset($detail_id)) {
	$sql_del 			= "	DELETE FROM workorders WHERE id = '" . $detail_id . "' ";
	$ok = $db->query($conn, $sql_del);
	if ($ok) {
		$cmd2 = "add";
		$error['msg'] = "Record Deleted Successfully";
	} else {
		$error['msg'] = "There is Error, record did not delete, Please check it again OR contact Support Team.";
	}
} else if (isset($cmd2) && $cmd2 == 'edit' && isset($detail_id)) {
	$button_edu 		= "Edit";
	$sql_ee 			= "	SELECT a.* FROM workorders a WHERE a.id = '" . $detail_id . "'  ";
	// echo $sql_ee;
	$result_ee 			= $db->query($conn, $sql_ee);
	$counter_ee1		= $db->counter($result_ee);
	if ($counter_ee1 > 0) {
		$row_ee 					= $db->fetch($result_ee);
		$operatorid					= $row_ee[0]['operatorid'];
		$contact					= $row_ee[0]['contact'];
		$problem					= $row_ee[0]['problem'];
		$complete 					= $row_ee[0]['complete'];
		$completedby				= $row_ee[0]['completedby'];
		if ($row_ee[0]['completiondate'] == "0000-00-00 00:00:00") {
			$completiondate 			= "";
			$completiontime 			= "";
		} else {
			$completiondate			= str_replace("-", "/", convert_date_display_date_from_datetime($row_ee[0]['completiondate']));
			$completiontime			= convert_date_display_time_from_datetime($row_ee[0]['completiondate']);
		}

		//supplementedtime completiontime

		$supplemented 				= $row_ee[0]['supplemented'];
		$supplementedby				= $row_ee[0]['supplementedby'];
		if ($row_ee[0]['supplementeddate'] == "0000-00-00 00:00:00") {
			$supplementeddate 			= "";
			$supplementedtime 			= "";
		} else {
			$supplementeddate			= str_replace("-", "/", convert_date_display_date_from_datetime($row_ee[0]['supplementeddate']));
			$supplementedtime			= convert_date_display_time_from_datetime($row_ee[0]['supplementeddate']);
		}

		$lasteditorid2				= $row_ee[0]['lasteditorid'];
		$pendingparts 				= $row_ee[0]['pendingparts'];
		if ($row_ee[0]['datewoscheduled'] == "0000-00-00 00:00:00") {
			$datewoscheduled 			= "";
			$timewoscheduled 			= "";
		} else {
			$datewoscheduled			= str_replace("-", "/", convert_date_display_date_from_datetime($row_ee[0]['datewoscheduled']));
			$timewoscheduled			= convert_date_display_time_from_datetime($row_ee[0]['datewoscheduled']);
		}

		$wotimelength 				= $row_ee[0]['wotimelength'];
		$assigntoid 				= $row_ee[0]['assigntoid'];
		$repeatcall 				= $row_ee[0]['repeatcall'];
		if ($row_ee[0]['dateofservice'] == "0000-00-00 00:00:00") {
			$dateofservice 			= "";
		} else {
			$dateofservice			= str_replace("-", "/", convert_date_display_date_from_datetime($row_ee[0]['dateofservice']));
		}
		$laborbilltocustomer 		= $row_ee[0]['laborbilltocustomer'];
		$partsbilltocustomer 		= $row_ee[0]['partsbilltocustomer'];
		$comment2					= $row_ee[0]['comments'];
	} else {
		$error['msg'] = "No record found";
	}
}
