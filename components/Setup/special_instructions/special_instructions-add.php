<?php
if (!isset($module)) {
	require_once('../../../conf/functions.php');
	disallow_direct_school_directory_access();
}
$db 					= new mySqlDB;
$selected_db_name 		= $_SESSION["db_name"];
$subscriber_users_id	= $_SESSION["subscriber_users_id"];
$user_id 				= $_SESSION["user_id"];
if (!isset($_SESSION['csrf_session'])) {
	$_SESSION['csrf_session'] = session_id();
}
if ($cmd == 'edit') {
	$title_heading = "Edit Special Instruction";
	$button_val = "Edit";
}
if ($cmd == 'add') {
	$title_heading 	= "Add Special Instruction";
	$button_val 	= "Add";
	$id 			= "";
}
if ($cmd == 'edit' && isset($id)) {
	$sql_ee 				= "	SELECT a.* FROM specialinstructions a WHERE a.id = '" . $id . "' AND a.subscriber_users_id = '" . $subscriber_users_id . "'   ";
	$result_ee 				= $db->query($conn, $sql_ee);
	$row_ee 				= $db->fetch($result_ee);
	$specialinstructions	=  $row_ee[0]['specialinstructions'];
	$instnumber				=  $row_ee[0]['instnumber'];
}
extract($_POST);

foreach ($_POST as $key => $value) {
	if (!is_array($value)) {
		$data[$key] = remove_special_character(trim(htmlspecialchars(strip_tags(stripslashes($value)), ENT_QUOTES, 'UTF-8')));
		$$key = $data[$key];
	}
}
if (isset($is_Submit) && $is_Submit == 'Y') {
	if (decrypt($csrf_token) != $_SESSION["csrf_session"]) {
		header("location: signout");
		exit();
	}
	if (isset($specialinstructions) && $specialinstructions == "") {
		$error['msg'] = "Enter Special Instruction";
		$specialinstructions_valid = "invalid";
	}
	if (isset($instnumber) && $instnumber == "") {
		$error['msg'] = "Enter Instruction No";
		$instnumber_valid = "invalid";
	}
	if (empty($error)) {
		if ($cmd == 'add') {
			$sql_ee 			= "	SELECT a.* FROM specialinstructions a 
									WHERE a.subscriber_users_id 	= '" . $subscriber_users_id . "' 
									AND a.instnumber				= '" . $instnumber . "' ";
			$result_ee 			= $db->query($conn, $sql_ee);
			$counter_ee			= $db->counter($result_ee);
			if ($counter_ee == 0) {
				$sql = "INSERT INTO specialinstructions(subscriber_users_id, specialinstructions, instnumber,  add_date, add_by, add_ip)
						VALUES('" . $subscriber_users_id . "', '" . $specialinstructions . "',  '" . $instnumber . "', '" . $add_date . "', '" . $_SESSION['username'] . "', '" . $add_ip . "')";
				echo $sql;
				$ok = $db->query($conn, $sql);
				if ($ok) {
					$specialinstructions = $instnumber = "";
					$msg['msg_success'] = "Special Instruction has been added successfully.";
				} else {
					$error['msg'] = "There is Error, Please check it again OR contact Support Team.";
				}
			} else {
				$error['msg'] = "This Special Instruction is already exist.";
			}
		} else if ($cmd == 'edit') {
			check_id($db, $conn, $id, "specialinstructions", $subscriber_users_id, $selected_db_name);
			$sql_ee 			= "	SELECT a.* FROM specialinstructions a 
									WHERE a.subscriber_users_id	= '" . $subscriber_users_id . "' 
									AND a.instnumber			= '" . $instnumber . "'
									AND a.id 				   != '" . $id . "'";
			$result_ee 			= $db->query($conn, $sql_ee);
			$counter_ee			= $db->counter($result_ee);
			if ($counter_ee == 0) {
				$sql_c_up = "UPDATE specialinstructions SET	specialinstructions		= '" . $specialinstructions . "', 
															instnumber				= '" . $instnumber . "', 
															update_date				= '" . $add_date . "',
															update_by				= '" . $_SESSION['username'] . "',
															update_ip				= '" . $add_ip . "'
							WHERE id = '" . $id . "'  ";
				//echo $sql_c_up;
				$ok = $db->query($conn, $sql_c_up);
				if ($ok) {
					$msg['msg_success'] = "Record Updated Successfully.";
				} else {
					$error['msg'] = "There is Error, record does not update, Please check it again OR contact Support Team.";
				}
			} else {
				$error['msg'] = "This Special Instruction is already exist.";
			}
		}
	}
} ?>
<!-- BEGIN: Page Main-->
<div id="main" class="<?php echo $page_width; ?>">
	<div class="row">
		<div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
		<div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
			<!-- Search for small screen-->
			<div class="container">
				<div class="row">
					<div class="row">
						<div class="col s10 m6 l6">
							<h5 class="breadcrumbs-title mt-0 mb-0"><span><?php echo $title_heading; ?></span></h5>
							<ol class="breadcrumbs mb-0">
								<li class="breadcrumb-item"><?php echo $title_heading; ?>
								</li>
								<li class="breadcrumb-item"><a href="?string=<?php echo encrypt("module=" . $module . "&page=listing") ?>">List</a>
								</li>
							</ol>
						</div>
						<div class="col s2 m6 l6">
							<a class="btn waves-effect waves-light green darken-1 breadcrumbs-btn right" href="?string=<?php echo encrypt("module=" . $module . "&page=listing") ?>" data-target="dropdown1">
								List
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col s12 m12 16">
			<div id="Form-advance" class="card card card-default scrollspy">
				<div class="card-content">
					<?php
					if (isset($error['msg'])) { ?>
						<div class="card-alert card red lighten-5">
							<div class="card-content red-text">
								<p><?php echo $error['msg']; ?></p>
							</div>
							<button type="button" class="close red-text" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
					<?php } else if (isset($msg['msg_success'])) { ?>
						<div class="card-alert card green lighten-5">
							<div class="card-content green-text">
								<p><?php echo $msg['msg_success']; ?></p>
							</div>
							<button type="button" class="close green-text" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
					<?php } ?>
					<h4 class="card-title">Detail Form</h4>
					<form method="post" autocomplete="off" enctype="multipart/form-data">
						<input type="hidden" name="is_Submit" value="Y" />
						<input type="hidden" name="cmd" value="<?php if (isset($cmd)) echo $cmd; ?>" />
						<input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
																			echo encrypt($_SESSION['csrf_session']);
																		} ?>">
						<div class="row">
							<div class="input-field col m6 s12">
								<i class="material-icons prefix">today</i>
								<input id="specialinstructions" type="text" name="specialinstructions" value="<?php if (isset($specialinstructions)) {
																													echo $specialinstructions;
																												} ?>" required="" class="validate <?php if (isset($specialinstructions_valid)) {
																																						echo $specialinstructions_valid;
																																					} ?>">
								<label for="specialinstructions">Special Instruction</label>
							</div>
							<div class="input-field col m6 s12">
								<i class="material-icons prefix">add</i>
								<input id="instnumber" type="text" name="instnumber" value="<?php if (isset($instnumber)) {
																								echo $instnumber;
																							} ?>" required="" class="validate <?php if (isset($instnumber_valid)) {
																																	echo $instnumber_valid;
																																} ?>">
								<label for="instnumber">Special Instruction</label>
							</div>
						</div>
						<div class="row">
							<div class="row">&nbsp;&nbsp;</div>
							<div class="row">
								<div class="input-field col m4 s12"></div>
								<div class="input-field col m4 s12">
									<button class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12" type="submit" name="action"><?php echo $button_val; ?></button>
								</div>
								<div class="input-field col m4 s12"></div>
							</div>
						</div>
					</form>
				</div>
				<?php include('sub_files/right_sidebar.php'); ?>
			</div>
		</div>
	</div><br><br>
	<!-- END: Page Main-->