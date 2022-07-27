<?php
if (isset($test_on_local) && $test_on_local == 1) {
	$fname = $lname = $initials = $employeeid = $jobtitle =  $email =  $comments =  $jobtitle = "TEST";
	$active = 1;
	$departmentid = $billingdepartment = 2;
	$hiredate = "16/06/2022";
	$email = $comments = "TEST";
}

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
	$title_heading = "Update Employee";
	$button_val = "Save";
}
if ($cmd == 'add') {
	$title_heading 	= "Add Employee";
	$button_val 	= "Add";
	$id 			= "";
}
if ($cmd == 'edit' && isset($id)) {
	$sql_ee 			= "	SELECT a.*, b.id AS user_id
							FROM employee a 
							LEFT JOIN users b ON b.emp_id = a.id
							WHERE a.id = '" . $id . "' AND a.subscriber_users_id = '" . $subscriber_users_id . "'   ";
	// echo $sql_ee;
	$result_ee 			= $db->query($conn, $sql_ee);
	$row_ee 			= $db->fetch($result_ee);
	$fname				=  $row_ee[0]['fname'];
	$lname				=  $row_ee[0]['lname'];
	$initials			=  $row_ee[0]['initials'];
	$departmentid		=  $row_ee[0]['departmentid'];
	$employeeid			=  $row_ee[0]['employeeid'];
	$jobtitle			=  $row_ee[0]['jobtitle'];
	$active				=  $row_ee[0]['active'];
	$active				=  $row_ee[0]['active'];
	$user_id			=  $row_ee[0]['user_id'];
	$passwordprofileid	=  $row_ee[0]['passwordprofileid'];

	if ($row_ee[0]['hiredate'] == "0000-00-00 00:00:00") {
		$hiredate 			= "";
	} else {
		$hiredate			= str_replace("-", "/", convert_date_display_date_from_datetime($row_ee[0]['hiredate']));
	}
	if ($row_ee[0]['terminationdate'] == "0000-00-00 00:00:00" || $row_ee[0]['terminationdate'] == "9999-12-31 00:00:00") {
		$terminationdate	= "";
	} else {
		$terminationdate	= str_replace("-", "/", convert_date_display_date_from_datetime($row_ee[0]['terminationdate']));
	}
	$billingdepartment	=  $row_ee[0]['billingdepartment'];
	$email				=  $row_ee[0]['email'];
	$comments			=  $row_ee[0]['comments'];
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
	if (isset($passwordprofileid) && $passwordprofileid == "") {
		$error['msg'] = "Select Password Profile ";
	}
	if (isset($hiredate) && $hiredate == "") {
		$error['msg'] = "Enter Hire Date ";
		$hiredate_valid = "invalid";
	}
	if (isset($active) && $active == "") {
		$error['msg'] = "Select Active Yes/No";
	}

	// if (isset($jobtitle) && $jobtitle == "") {
	// 	$error['msg'] = "Enter Job Title";
	// 	$jobtitle_valid = "invalid";
	// }
	// if (isset($departmentid) && $departmentid == "") {
	// 	$error['msg'] = "Enter Department";
	// 	$departmentid_valid = "invalid";
	// }
	if (isset($initials) && $initials == "") {
		$error['msg'] = "Enter Initials";
		$initials_valid = "invalid";
	}
	if (isset($lname) && $lname == "") {
		$error['msg'] = "Enter Last Name";
		$lname_valid = "invalid";
	}
	if (isset($fname) && $fname == "") {
		$error['msg'] = "Enter First Name";
		$fname_valid = "invalid";
	}

	if (empty($error)) {
		$hiredate1	= "0000-00-00";
		if (isset($hiredate) && $hiredate != "") {
			$hiredate1 = convert_date_mysql_slash($hiredate);
		}
		$terminationdate1	= "0000-00-00";
		if (isset($terminationdate) && $terminationdate != "") {
			$terminationdate1 = convert_date_mysql_slash($terminationdate);
		}
		if ($cmd == 'add') {
			$sql_ee 			= "	SELECT a.* FROM employee a 
									WHERE a.subscriber_users_id 	= '" . $subscriber_users_id . "' 
									AND a.fname			= '" . $fname . "'
									AND a.lname			= '" . $lname . "'
									AND a.departmentid	= '" . $departmentid . "'
									AND a.employeeid	= '" . $employeeid . "' ";
			$result_ee 			= $db->query($conn, $sql_ee);
			$counter_ee			= $db->counter($result_ee);
			if ($counter_ee == 0) {
				$sql = "INSERT INTO employee(subscriber_users_id, fname, lname, initials, departmentid, employeeid, jobtitle, active, hiredate, terminationdate, 
																passwordprofileid, billingdepartment, email, comments, add_date, add_by, add_ip)
						VALUES('" . $subscriber_users_id . "', '" . $fname . "',  '" . $lname . "', '" . $initials . "', '" . $departmentid . "',  '" . $employeeid . "', '" . $jobtitle . "', '" . $active . "', '" . $hiredate1 . "', '" . $terminationdate1 . "', 
								'" . $passwordprofileid . "', '" . $billingdepartment . "', '" . $email . "', '" . $comments . "', '" . $add_date . "', '" . $_SESSION['username'] . "', '" . $add_ip . "')";
				// echo $sql;
				$ok = $db->query($conn, $sql);
				if ($ok) {
					$emp_id 				= mysqli_insert_id($conn);
					$fname 					= str_replace(',', '', $fname);
					$fname 					= str_replace('.', '', $fname);
					$fname 					= str_replace(' ', '', $fname);
					$fname 					= strtolower($fname);

					$lname 					= str_replace(',', '', $lname);
					$lname 					= str_replace('.', '', $lname);
					$lname 					= str_replace(' ', '', $lname);
					$lname 					= strtolower($lname);

					$username 				= $fname . $lname;
					$sql2 		= "	SELECT a.* FROM users a WHERE username = '" . $username . "' ";
					$result2 	= $db->query($conn, $sql2);
					$count2 	= $db->counter($result2);
					if ($count2 > 0) {
						$username = $username . $emp_id;
					}
					$sql3 	= "INSERT INTO users (subscriber_users_id, emp_id, username, a_password, user_type, add_date, add_ip) 
								VALUES('" . $subscriber_users_id . "', '" . $emp_id . "', '" . $username . "', 'test9', 'Sub Users', '" . $add_date . "', '" . $add_ip . "')";
					$ok = $db->query($conn, $sql3);
					if ($passwordprofileid == 1) {
						$user_id = mysqli_insert_id($conn);
						$sql1_1 = "INSERT INTO sub_users_user_roles (user_id, role_id, add_date, add_by, add_ip)
									VALUES('" . $user_id . "',  '1', '" . $add_date . "', '" . $_SESSION['username'] . "', '" . $add_ip . "')";
						$db->query($conn, $sql1_1);
					}
					$fname = $lname = $initials = $departmentid = $employeeid = $jobtitle = $active = $hiredate = $terminationdate = $passwordprofileid = $billingdepartment = $email = $comments = "";
					$msg['msg_success'] = "Employee has been added successfully.";
				} else {
					$error['msg'] = "There is Error, Please check it again OR contact Support Team.";
				}
			} else {
				$error['msg'] = "This Employee is already exist.";
			}
		} else if ($cmd == 'edit') {
			// fname lname initials departmentid  employeeid jobtitle active hiredate terminationdate billingdepartment email comments  
			check_id($db, $conn, $id, "employee", $subscriber_users_id, $selected_db_name);
			$sql_ee 			= "	SELECT a.* FROM employee a 
									WHERE a.subscriber_users_id	= '" . $subscriber_users_id . "' 
									AND a.fname			= '" . $fname . "'
									AND a.lname			= '" . $lname . "'
									AND a.departmentid	= '" . $departmentid . "'
									AND a.employeeid	= '" . $employeeid . "'
									AND a.id		   != '" . $id . "'";
			$result_ee 			= $db->query($conn, $sql_ee);
			$counter_ee			= $db->counter($result_ee);
			if ($counter_ee == 0) {
				$sql_c_up = "UPDATE employee SET	fname				= '" . $fname . "', 
													lname				= '" . $lname . "', 
													initials			= '" . $initials . "', 
													departmentid		= '" . $departmentid . "', 
													employeeid			= '" . $employeeid . "', 
													jobtitle			= '" . $jobtitle . "', 
													active				= '" . $active . "', 
													hiredate			= '" . $hiredate1 . "', 
													terminationdate		= '" . $terminationdate1 . "',  
													passwordprofileid	= '" . $passwordprofileid . "', 
													billingdepartment	= '" . $billingdepartment . "', 
													email				= '" . $email . "', 
													comments			= '" . $comments . "',  
													update_date			= '" . $add_date . "',
													update_by			= '" . $_SESSION['username'] . "',
													update_ip			= '" . $add_ip . "'
							WHERE id = '" . $id . "'  ";
				// echo $sql_c_up;
				$ok = $db->query($conn, $sql_c_up);
				if ($ok) {
					$sql_c_up = "UPDATE users SET 	enabled 		= '" . $active . "',
													update_date 	= '" . $add_date . "',
													update_by 	 	= '" . $_SESSION['username'] . "',
													update_ip 	 	= '" . $add_ip . "'
								WHERE emp_id = '" . $id . "' AND subscriber_users_id = '" . $subscriber_users_id . "' ";
					$db->query($conn, $sql_c_up);
					if ($passwordprofileid == 1) {
						$sql1_1 = "DELETE FROM sub_users_user_roles WHERE user_id = '" . $user_id . "' AND role_id = 2 ";
						$db->query($conn, $sql1_1);
						$sql2 		= "	SELECT a.* FROM sub_users_user_roles a WHERE user_id = '" . $user_id . "' AND role_id = '" . $passwordprofileid . "' ";
						$result2 	= $db->query($conn, $sql2);
						$count2 	= $db->counter($result2);
						if ($count2 == 0) {
							$sql1_1 = "INSERT INTO sub_users_user_roles (user_id, role_id, add_date, add_by, add_ip)
										VALUES('" . $user_id . "',  $passwordprofileid, '" . $add_date . "', '" . $_SESSION['username'] . "', '" . $add_ip . "')";
							$db->query($conn, $sql1_1);
						}
					} else {
						$sql1_1 = "DELETE FROM sub_users_user_roles WHERE user_id = '" . $user_id . "' AND role_id = 1 ";
						$db->query($conn, $sql1_1);
						$sql2 		= "	SELECT a.* FROM sub_users_user_roles a WHERE user_id = '" . $user_id . "' AND role_id = '" . $passwordprofileid . "' ";
						$result2 	= $db->query($conn, $sql2);
						$count2 	= $db->counter($result2);
						if ($count2 == 0) {
							$sql1_1 = "INSERT INTO sub_users_user_roles (user_id, role_id, add_date, add_by, add_ip)
										VALUES('" . $user_id . "',  $passwordprofileid, '" . $add_date . "', '" . $_SESSION['username'] . "', '" . $add_ip . "')";
							$db->query($conn, $sql1_1);
						}
					}
					$msg['msg_success'] = "Record Updated Successfully.";
				} else {
					$error['msg'] = "There is Error, record does not update, Please check it again OR contact Support Team.";
				}
			} else {
				$error['msg'] = "This Employee is already exist.";
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
							<div class="input-field col m3 s12">
								<i class="material-icons prefix">person_outline</i>
								<input id="fname" type="text" name="fname" value="<?php if (isset($fname)) {
																						echo $fname;
																					} ?>" required="" class="validate <?php if (isset($fname_valid)) {
																															echo $fname_valid;
																														} ?>">
								<label for="fname">First Name <span class="red-text">*</span></label>
							</div>
							<div class="input-field col m3 s12">
								<i class="material-icons prefix">person_outline</i>
								<input id="lname" type="text" name="lname" value="<?php if (isset($lname)) {
																						echo $lname;
																					} ?>" required="" class="validate <?php if (isset($lname_valid)) {
																															echo $lname_valid;
																														} ?>">
								<label for="lname">Last Name <span class="red-text">*</span></label>
							</div>
							<div class="input-field col m3 s12">
								<i class="material-icons prefix">person_outline</i>
								<input id="initials" type="text" name="initials" value="<?php if (isset($initials)) {
																							echo $initials;
																						} ?>" required="" class="validate <?php if (isset($initials_valid)) {
																																echo $initials_valid;
																															} ?>">
								<label for="initials">Initials <span class="red-text">*</span></label>
							</div>
							<div class="input-field col m3 s12">
								<div class="form-group">
									<i class="material-icons prefix">home</i>
									<select required id="departmentid" name="departmentid" class="form-control <?php if (isset($departmentid_valid)) {
																													echo 'is-warning';
																												} ?>">
										<option value="">Select</option>
										<?php
										$sql_c 		= " SELECT * FROM employeedepartment WHERE subscriber_users_id = '" . $subscriber_users_id . "' AND enabled = 1 ";
										//echo $sql_c;
										$result_c 	= $db->query($conn, $sql_c);
										$row_c 		= $db->fetch($result_c);
										foreach ($row_c as $data) { ?>
											<option value="<?php echo $data['id']; ?>" <?php if (isset($departmentid) && $departmentid == $data['id']) { ?> selected="selected" <?php } ?>><?php echo $data['department']; ?></option>
										<?php } ?>
									</select>
									<label for="departmentid">Department <span class="red-text">*</span></label>
								</div>
							</div>
						</div>
						<div class="row">&nbsp;&nbsp;</div>
						<div class="row">
							<div class="input-field col m3 s12">
								<i class="material-icons prefix">confirmation_number</i>
								<input id="employeeid" type="text" name="employeeid" value="<?php if (isset($employeeid)) {
																								echo $employeeid;
																							} ?>" class="validate <?php if (isset($employeeid_valid)) {
																														echo $employeeid_valid;
																													} ?>">
								<label for="employeeid">Employee ID</label>
							</div>
							<div class="input-field col m6 s12">
								<i class="material-icons prefix">assignment</i>
								<input id="jobtitle" type="text" name="jobtitle" value="<?php if (isset($jobtitle)) {
																							echo $jobtitle;
																						} ?>" class="validate <?php if (isset($jobtitle_valid)) {
																													echo $jobtitle_valid;
																												} ?>">
								<label for="jobtitle">Job Title</label>
							</div>
							<div class="input-field col m3 s12">
								<div class="form-group">
									<i class="material-icons prefix">party_mode</i>
									<select id="active" name="active" class="form-control <?php if (isset($active_valid)) {
																								echo 'is-warning';
																							} ?>">
										<option value="1" <?php if (isset($active) && $active == "1") { ?> selected="selected" <?php } ?>>Yes</option>
										<option value="0" <?php if (isset($active) && $active == "0") { ?> selected="selected" <?php } ?>>No</option>
									</select>
									<label for="active">Active</label>
								</div>
							</div>
						</div>
						<div class="row">&nbsp;&nbsp;</div>
						<div class="row">
							<div class="input-field col m3 s12">
								<i class="material-icons prefix pt-2">date_range</i>
								<label for="hiredate">Hire Date <span class="red-text">*</span></label>
								<input id="hiredate" name="hiredate" type="text" value="<?php if (isset($hiredate)) {
																							echo $hiredate;
																						} ?>" class="datepicker validate <?php if (isset($hiredate_valid)) {
																																echo $hiredate_valid;
																															} ?>">
							</div>
							<div class="input-field col m3 s12">
								<i class="material-icons prefix pt-2">date_range</i>
								<label for="terminationdate">Termination Date</label>
								<input id="terminationdate" name="terminationdate" type="text" value="<?php if (isset($terminationdate)) {
																											echo $terminationdate;
																										} ?>" class=" datepicker validate <?php if (isset($terminationdate_valid)) {
																																				echo $terminationdate_valid;
																																			} ?>">
							</div>
							<div class="input-field col m3 s12">
								<div class="form-group">
									<i class="material-icons prefix">home</i>
									<select id="billingdepartment" name="billingdepartment" class="form-control <?php if (isset($billingdepartment_valid)) {
																													echo 'is-warning';
																												} ?>">
										<option value="">Select </option>
										<?php
										$sql_c 		= " SELECT * FROM employeedepartment WHERE subscriber_users_id = '" . $subscriber_users_id . "' AND enabled = 1 ";
										//echo $sql_c;
										$result_c 	= $db->query($conn, $sql_c);
										$row_c 		= $db->fetch($result_c);
										foreach ($row_c as $data) { ?>
											<option value="<?php echo $data['id']; ?>" <?php if (isset($billingdepartment) && $billingdepartment == $data['id']) { ?> selected="selected" <?php } ?>><?php echo $data['department']; ?></option>
										<?php } ?>
										<option value="0" <?php if (isset($billingdepartment) && $billingdepartment == '0' && $billingdepartment != '') { ?> selected="selected" <?php } ?>>No Billing Department</option>
									</select>
									<label for="billingdepartment">Billing Department</label>
								</div>
							</div>
							<div class="input-field col m3 s12">
								<i class="material-icons prefix pt-2">email</i>
								<label for="email">Email</label>
								<input id="email" name="email" type="text" value="<?php if (isset($email)) {
																						echo $email;
																					} ?>" class="validate <?php if (isset($email_valid)) {
																												echo $email_valid;
																											} ?>">
							</div>
						</div>
						<div class="row">&nbsp;&nbsp;</div>
						<div class="row">
							<div class="input-field col m9 s12">
								<i class="material-icons prefix">description</i>
								<textarea id="comments" name="comments" class=" materialize-textarea validate <?php if (isset($comments_valid)) {
																													echo $comments_valid;
																												} ?> name=" comments"><?php if (isset($comments)) {
																																			echo $comments;
																																		} ?></textarea>
								<label for="comments">Comments</label>
							</div>
							<div class="input-field col m3 s12">
								<div class="form-group">
									<i class="material-icons prefix">lock_outline</i>
									<select id="passwordprofileid" name="passwordprofileid" class="form-control <?php if (isset($passwordprofileid_valid)) {
																													echo 'is-warning';
																												} ?>">
										<option value="">Please Select</option>
										<option value="1" <?php if (isset($passwordprofileid) && $passwordprofileid == "1") { ?> selected="selected" <?php } ?>>Master</option>
										<option value="2" <?php if (isset($passwordprofileid) && $passwordprofileid == "2") { ?> selected="selected" <?php } ?>>Operator</option>
									</select>
									<label for="passwordprofileid">Password Profile ID <span class="red-text">*</span></label>
								</div>
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
	<?php //*/