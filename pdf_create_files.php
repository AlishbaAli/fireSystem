<?php
include('path.php');
include($directory_path . "conf/session_start.php");
include($directory_path . "conf/connection.php");
include($directory_path . "conf/functions.php");
$db 					= new mySqlDB;
$selected_db_name 		= $_SESSION["db_name"];
$subscriber_users_id 	= $_SESSION["subscriber_users_id"];
$user_id 				= $_SESSION["user_id"];

$parm1 = "";
$parm2 = "";
$parm3 = "";
check_session_exist4($db, $conn, $user_id, $_SESSION["username"], $_SESSION["user_type"], $selected_db_name, $parm2, $parm3);
extract($_POST);
if (isset($menu_id)) {
	$check_module_permission = "";
	$check_module_permission = check_module_permission_school($db, $conn, $menu_id, $user_id, $subscriber_users_id, $_SESSION["user_type"], $selected_db_name);
	$pageTitle 	= $check_module_permission;
	if ($check_module_permission == "") {
		header("location: " . $directory_path . "signout");
	}
	$sql_ee1 	= "	SELECT * FROM subscribers_users  WHERE id = '" . $subscriber_users_id . "' "; //echo $sql_ee1; die;
	$result_ee1 	= $db->query($conn, $sql_ee1);
	$count_ee1 	= $db->counter($result_ee1);
	if ($count_ee1 > 0) {
		$row_ee1						= $db->fetch($result_ee1);
		$company_name					= $row_ee1[0]['company_name'];
		$company_logo					= $row_ee1[0]['company_logo'];
	}
	/////////////////////////////////////////// Master ////////////////////////////////////////////
	$sql_ee 	= "	SELECT 	CONCAT(b.fname, ' ', b.lname) AS operator_name,
							CONCAT(c.fname, ' ', c.lname) AS assign_to_name, 
							a2.`name`, a2.streetnumber, a2.streetname, a2.cityid, a2.stateid, a2.suite, a2.zipcode, a2.phonenumber,
						 	d.city, e.state,
							a.*
					FROM workorders a
					INNER JOIN customerinfo a2 ON a2.id = a.customerinfoid
					LEFT JOIN employee b ON b.id = a.operatorid  
					LEFT JOIN employee c ON c.id = a.assigntoid
					LEFT JOIN city d ON d.id = a2.cityid
					LEFT JOIN state e ON c.id = a2.stateid
 
					WHERE a.id = '" . $workorder_id . "' "; //echo $sql_ee; die;
	$result_ee 	= $db->query($conn, $sql_ee);
	$count_ee 	= $db->counter($result_ee);
	$css = "
		<style>
			h1 {
				color: navy;
				font-size: 24pt;
				text-decoration: underline;
			}
			h2 {
				color: #000066;
				font-size: 16pt;
				text-align: center;
			}
			h3 {
				color: #000066;
				font-size: 11pt;
			}
			table{
				font-family: helvetica;
			}
			table.top{
				width: 100%;
				font-size: 13px;
			}
			table.second{
				color: #00000;
				font-size: 13px;
				width: 100%;
				font-weight: bold;
			}
			table.first {
				color: #000066;
				font-size: 14px;
				width: 100%;
			}
			.first th {
				border: 1px solid #999;
				//background-color: #EAEDEE;
				//text-align: center;
				//vertical-align:middle;
			}
			
			.first td {
				// border: 1px solid #999;
				font-weight: bold;
			} 
			.bord td {
				border: 1px solid #202124;
				
			} 
			td.withborders{
			 	border: 1px solid #202124;
			} 
			.student_info_section{
				background-color: #EAEDEE;
				border: 3px solid #999;
				border-radius: 5px;
				width: 100%;
				padding: 5px 20px;
			}  
			.uic{
				text-transform: uppercase;
				font-style: italic;
				text-decoration: underline;
			} 
		</style>";
	require_once '../../../mpdf/vendor/autoload.php';
	$mpdf = new \Mpdf\Mpdf();
	if ($count_ee > 0) {
		$row_ee 		= $db->fetch($result_ee);
		$cust_name 		= $row_ee[0]['name'];
		$streetnumber 	= $row_ee[0]['streetnumber'];
		$streetname 	= $row_ee[0]['streetname'];
		$city_name 		= $row_ee[0]['city'];
		$state_name 	= $row_ee[0]['state'];
		$suite 			= $row_ee[0]['suite'];
		$zipcode 		= $row_ee[0]['zipcode'];
		$phonenumber 	= $row_ee[0]['phonenumber'];
		$contact 		= $row_ee[0]['contact'];
		$problem 		= $row_ee[0]['problem'];
		$comments 		= $row_ee[0]['comments'];
		$createdondate 		= $row_ee[0]['createdondate'];
		include('pdf_detail.php');
		$report_data = $report_data . $css;
		// echo $report_data;die;
		$mpdf->AddPage('P', '', '', '', '', 10, 10, 10, 10, 0, 0);
		$mpdf->writeHTML($report_data);
		$mpdf->SetTitle('Print ' . $workorder_id . ' Work Order');
		$file_name = "Print " . $workorder_id . " Work Order.pdf";
		$mpdf->output($file_name, 'I');
	} else {
		echo "<br><h1>Sorry! No record found </h1>";
	}
} else {
	echo "<br><h1>Sorry! No file is available </h1>";
}
