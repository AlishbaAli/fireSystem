<?php

//Query for Employee's Profile
if (isset($is_submit_profile) && $is_submit_profile == 'Y') {
	if (isset($company_name) && $company_name == "") {
		$error['msg'] 	= "Please Enter Company Name";
		$company_name_valid	= "invalid";
	}
	if (decrypt($csrf_token) != $_SESSION["csrf_session"]) {
		header("location: signout");
		exit();
	}
	$table_name = "customerinfo";
	if ($cmd == 'add') {
		$sql1 		= "	SELECT * FROM " . $table_name . " WHERE subscriber_users_id = '" . $subscriber_users_id . "' AND csaccountnum = '" . $csaccountnum . "'";
		$result1 	= $db->query($conn, $sql1);
		$count2 	= $db->counter($result1);
		if ($count2 > 0) {
			$error['msg'] 		= "Sorry! This Cs Account Number is already exist, try another.";
			$csaccountnum_valid	= "invalid";
		}
	}
	if ($cmd == 'edit') {
		$sql1 		= "	SELECT * FROM " . $table_name . " WHERE subscriber_users_id = '" . $subscriber_users_id . "' AND csaccountnum = '" . $csaccountnum . "'  AND id != '" . $id . "'";
		$result1 	= $db->query($conn, $sql1);
		$count2 	= $db->counter($result1);
		if ($count2 > 0) {
			$error['msg'] 		= "Sorry! This Cs Account Number is already exist, try another.";
			$csaccountnum_valid	= "invalid";
		}
	}
	$dateoflastservice1 = "0000-00-00";
	if ($dateoflastservice != "") {
		$dateoflastservice1 = convert_date_mysql_slash($dateoflastservice);
	}
	if (empty($error)) {
		if ($cmd == 'add') {
			// company_name csaccountnum streetnumber streetname suite  zipcode phonenumber secondphonenumber salesmanid lasteditorid billingnumber comment  dateoflastservice  cityid stateid taxid typeofsystemid specialinstructionsid
			$sql6 = "INSERT INTO " . $table_name . "(subscriber_users_id, name, csaccountnum, streetnumber, streetname, suite, 
													zipcode, phonenumber, secondphonenumber, salesmanid, lasteditorid, billingnumber, 
													comment, dateoflastservice, cityid, stateid, taxid, typeofsystemid, specialinstructionsid, 
													add_date, add_by, add_ip) 
												VALUES
													('" . $subscriber_users_id . "' , '" . $company_name . "' , '" . $csaccountnum  . "' , '" . $streetnumber  . "' , '" . $streetname  . "' , '" . $suite  . "' , 
													'" . $zipcode  . "' , '" . $phonenumber  . "' , '" . $secondphonenumber  . "' , '" . $salesmanid  . "' , '" . $lasteditorid  . "' , '" . $billingnumber  . "' ,
													'" . $comment  . "' , '" . $dateoflastservice1 . "' , '" . $cityid . "', '" . $stateid . "' , '" . $taxid . "' , '" . $typeofsystemid . "' ,  '" . $specialinstructionsid . "'
													,  '" . $add_date . "',  '" . $_SESSION['username'] . "', '" . $add_ip . "' )";
			//echo $sql6;
			$ok = $db->query($conn, $sql6);
			if ($ok) {
				$cmd 	= "edit";
				$id 	= mysqli_insert_id($conn);
				$msg['msg_success'] = "Record has been added Successfully.";
			} else {
				$error['msg'] = "There is Error, Please check it again OR contact Support Team.";
			}
		} else if ($cmd == 'edit') {
			$sql_c_up = "UPDATE " . $table_name . " SET 		 
																name 					=   '" . $company_name . "',
																csaccountnum	    	=	'" . $csaccountnum . "',
																streetnumber			=   '" . $streetnumber . "',
																streetname 				= 	'" . $streetname . "',
																suite  					=   '" . $suite . "',
																zipcode 				= 	'" . $zipcode . "',
																phonenumber 			=   '" . $phonenumber . "',
																secondphonenumber  		=	'" . $secondphonenumber . "',
																salesmanid  			=	'" . $salesmanid . "',
																lasteditorid  			=	'" . $lasteditorid . "',
																billingnumber  			=	'" . $billingnumber . "',
																comment  				=	'" . $comment . "',
																dateoflastservice  		=	'" . $dateoflastservice1 . "',
																cityid 		    		=   '" . $cityid . "',
																stateid 				= 	'" . $stateid . "',
																taxid  					=	'" . $taxid . "',
																typeofsystemid  		=	'" . $typeofsystemid . "',
																specialinstructionsid	= 	'" . $specialinstructionsid . "',

																update_date				= 	'" . $add_date . "',
																update_by 				= 	'" . $_SESSION['username'] . "' ,
																update_ip 				= 	'" . $add_ip . "' 

												WHERE id = '" . $id . "' AND subscriber_users_id = '" . $subscriber_users_id . "'   ";
			//echo $sql_c_up; 
			$ok = $db->query($conn, $sql_c_up);
			if ($ok) {
				$msg['msg_success'] = "Record Updated Successfully.";
			} else {
				$error['msg'] = "There is Error, record does not update, Please check it again OR contact Support Team.";
			}
		}
	}
} else if ($cmd == 'edit' && isset($id)) {
	$sql_ee 				= "SELECT a.* FROM customerinfo a  WHERE a.subscriber_users_id = '" . $subscriber_users_id . "'  AND a.id = '" . $id . "' "; //echo $sql_ee;
	$result_ee 				= $db->query($conn, $sql_ee);
	$counter_ee1			= $db->counter($result_ee);
	if ($counter_ee1 > 0) {
		$row_ee 					= $db->fetch($result_ee);
		$company_name				= $row_ee[0]['name'];
		$csaccountnum				= $row_ee[0]['csaccountnum'];
		$streetnumber				= $row_ee[0]['streetnumber'];
		$streetname 				= $row_ee[0]['streetname'];
		$suite						= $row_ee[0]['suite'];
		$zipcode 					= $row_ee[0]['zipcode'];
		$phonenumber				= $row_ee[0]['phonenumber'];
		$secondphonenumber			= $row_ee[0]['secondphonenumber'];
		$salesmanid 				= $row_ee[0]['salesmanid'];
		$lasteditorid 				= $row_ee[0]['lasteditorid'];
		$billingnumber 				= $row_ee[0]['billingnumber'];
		$comment 					= $row_ee[0]['comment'];
		$dateoflastservice 			= $row_ee[0]['dateoflastservice'];
		$dateoflastservice 			= str_replace("-", "/", convert_date_display($row_ee[0]['dateoflastservice']));
		$cityid 					= $row_ee[0]['cityid'];
		$stateid 					= $row_ee[0]['stateid'];
		$taxid 						= $row_ee[0]['taxid'];
		$typeofsystemid				= $row_ee[0]['typeofsystemid'];
		$specialinstructionsid		= $row_ee[0]['specialinstructionsid'];
	} else {
		$error['msg'] = "No record found";
	}
}
