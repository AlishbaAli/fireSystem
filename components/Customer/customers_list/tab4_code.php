<?php

// 	operatorid  contact problem complete completedby completiondate supplemented supplementedby supplementeddate lasteditorid pendingparts datewoscheduled wotimelength assigntoid repeatcall dateofservice laborbilltocustomer partsbilltocustomer comment
if (isset($is_Submit_tab4) && $is_Submit_tab4 == 'Y') {

    
	if (decrypt($csrf_token) != $_SESSION["csrf_session"]) {
		header("location: signout");
		exit();
	}
    
    if (isset($contractdate) && $contractdate == "") {
		$error['msg'] 		= "Enter Contract Date";
		$contractdate_valid 	= "invalid";
	}
    if (isset($contractexpirationdate) && $contractexpirationdate == "") {
		$error['msg'] 		= "Enter Contract Expiration Date";
		$contractexpirationdate_valid 	= "invalid";
	}
    if (empty($error)) {

		$contractdate1 				= "0000-00-00";
		$contractexpirationdate1 	= "0000-00-00";

		if (isset($contractdate) && $contractdate != "") {
			$contractdate1 = convert_date_mysql_slash($contractdate);
		}
		if (isset($contractexpirationdate) && $contractexpirationdate != "") {
			$contractexpirationdate1 = convert_date_mysql_slash($contractexpirationdate);
		}
     
        if ($cmd4 == 'add') {
			$sql_ee1 				= "	SELECT * FROM contracts	WHERE  customerinfoid 	= '" . $id . "' 
										AND csaccountnum 		= '" . $csaccountnum . "' 
										AND contractdate	 	= '" . $contractdate1 . "' 
										AND contractexpirationdate = '" . $contractexpirationdate1 . "' 
										 ";
                                       // echo $sql_ee1;
			$result_ee1 			= $db->query($conn, $sql_ee1);
			$counter_ee1			= $db->counter($result_ee1);
			if ($counter_ee1 == 0) {
				$sql = "INSERT INTO contracts(customerinfoid, csaccountnum, contractdate, contractexpirationdate)
						VALUES	('" . $id . "', '" . $csaccountnum . "', '" . $contractdate1 . "', '"
                         . $contractexpirationdate1 . "')";
				//echo $sql;
				$ok = $db->query($conn, $sql);

				if ($ok) {
					$id = $csaccountnum = $contractdate = $contractexpirationdate = "";
					$msg['msg_success'] = " record  has been added successfully.";
				} else {
					$error['msg'] = "There is Error, Please check it again OR contact Support Team.";
				}
			} else {
				$error['msg'] = "This record already exists.";
			}
		}
        else if ($cmd4 == 'edit') {
			$sql_ee1 				= "	SELECT * FROM contracts	WHERE  customerinfoid 	= '" . $id . "' 
            AND csaccountnum 		= '" . $csaccountnum . "' 
            AND contractdate	 	= '" . $contractdate1 . "' 
            AND contractexpirationdate = '" . $contractexpirationdate1 . "' 
             ";
			$result_ee1 			= $db->query($conn, $sql_ee1);
			$counter_ee1			= $db->counter($result_ee1);
			if ($counter_ee1 == 0) {
				$sql_c_up = "UPDATE  contracts SET  
													contractdate				= '" . $contractdate1 . "' , 
													contractexpirationdate			= '" . $contractexpirationdate1 . "' 
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

}
else if (isset($cmd4) && $cmd4 == 'delete' && isset($detail_id)) {
	$sql_del 			= "	DELETE FROM contracts WHERE id = '" . $detail_id . "' ";
	$ok = $db->query($conn, $sql_del);
	if ($ok) {
		$cmd4 = "add";
		$error['msg'] = "Record Deleted Successfully";
	} else {
		$error['msg'] = "There is Error, record did not delete, Please check it again OR contact Support Team.";
	}
}
else if (isset($cmd4) && $cmd4 == 'edit' && isset($detail_id)) {
	$button_edu 		= "Edit";
	$sql_ee 			= "	SELECT * FROM contracts WHERE id = '" . $detail_id . "'  ";
	//echo $sql_ee;
	$result_ee 			= $db->query($conn, $sql_ee);
	$counter_ee1		= $db->counter($result_ee);
	if ($counter_ee1 > 0) {
		$row_ee					= $db->fetch($result_ee);
		$csaccountnum			= $row_ee[0]['csaccountnum'];
	

		if ($row_ee[0]['contractdate'] == "0000-00-00 00:00:00") {
			$contractdate 			= "";
			
		} else {
			$contractdate			= str_replace("-", "/", convert_date_display_date_from_datetime($row_ee[0]['contractdate']));
			
		}
		if ($row_ee[0]['contractexpirationdate'] == "0000-00-00 00:00:00") {
			$contractexpirationdate 			= "";
			
		} else {
			$contractexpirationdate			= str_replace("-", "/", convert_date_display_date_from_datetime($row_ee[0]['contractexpirationdate']));
		
		}
	} else {
		$error['msg'] = "No record found";
	}
}
?>