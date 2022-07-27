<?php
if (isset($test_on_local) && $test_on_local == 1) {
	$first_name 				= "Aftab";
	$user_type 					= "Sub Users";
	$last_name 					= "Tunio";
	$email 						= "aftabatunio22a@gmail.com";
	$phone_no 					= "34343434";
	$username 					= "aftabtunio2";
	$a_password 				= "aftabtunio";
	$date_of_birth 				= "01/05/1992";
}
if (!isset($module)) {
	require_once('../../../conf/functions.php');
	disallow_direct_school_directory_access();
}
$db 					= new mySqlDB;
$selected_db_name 		= $_SESSION["db_name"];
$subscriber_users_id 	= $_SESSION["subscriber_users_id"];
$user_id 				= $_SESSION["user_id"];
if ($cmd == 'edit') {
	$title_heading = "Update Sub User";
	$button_val = "Save";
}
if ($cmd == 'add') {
	$title_heading 	= "Create New Sub User";
	$button_val 	= "Create";
	$id 			= "";
}
if (isset($cmd_detail) && $cmd_detail == 'delete') {
	$sql_ee2 	= " DELETE FROM sub_users_user_roles WHERE id = '" . $detail_id . "' AND user_id = '" . $id . "' ";
	$ok_del = $db->query($conn, $sql_ee2);
	if ($ok_del) {
		$msg['msg_success'] = "Role has been removed.";
	}
}
if ($cmd == 'edit' && isset($id)) {
	$sql_ee 	= "SELECT a.*, b.fname, b.lname, b.email, b.employeeid, c.department
					FROM users a 
					LEFT JOIN employee b ON b.id = a.emp_id
					LEFT JOIN employeedepartment c ON c.id = b.departmentid
					WHERE a.id = '" . $id . "' 
					AND a.subscriber_users_id ='" . $subscriber_users_id . "' 
					"; //echo $sql_ee;
	$result_ee 	= $db->query($conn, $sql_ee);
	$row_ee 	= $db->fetch($result_ee);

	$first_name 				= $row_ee[0]['fname'];
	$last_name 					= $row_ee[0]['lname'];
	$email 						= $row_ee[0]['email'];
	$employeeid					= $row_ee[0]['employeeid'];
	$department					= $row_ee[0]['department'];
	$username 					= $row_ee[0]['username'];
	$user_type					= $row_ee[0]['user_type'];
	$a_password 				= $row_ee[0]['a_password'];
}
extract($_POST);
foreach ($_POST as $key => $value) {
	if (!is_array($value)) {
		$data[$key] = remove_special_character(trim(htmlspecialchars(strip_tags(stripslashes($value)), ENT_QUOTES, 'UTF-8')));
		$$key = $data[$key];
	}
}
if (isset($is_Submit2) && $is_Submit2 == 'Y') {
	if (isset($add_role_id) && $add_role_id == "") {
		$error['msg'] 		= "Please Select Role";
		$add_role_id_valid = "invalid";
	}
	if (empty($error)) {
		$sql1_2		= "	SELECT * FROM sub_users_user_roles WHERE user_id = '" . $id . "' AND role_id = '" . $add_role_id . "' ";
		$result1_2 	= $db->query($conn, $sql1_2);
		$count2_2 	= $db->counter($result1_2);
		if ($count2_2 > 0) {
			$error['msg'] = "Sorry! This Role is already exist";
			$add_role_id_valid = "invalid";
		} else {
			$sql1_1 = "INSERT INTO sub_users_user_roles (user_id, role_id, add_date, add_by, add_ip)
						VALUES('" . $id . "',  '" . $add_role_id . "', '" . $add_date . "', '" . $_SESSION['username'] . "', '" . $add_ip . "')";
			$ok = $db->query($conn, $sql1_1);
			if ($ok) {
				$msg['msg_success'] = "Role has been assigned.";
				$add_role_id 	= "";
			} else {
				$error['msg'] = "There is Error, Please check it again OR contact Support Team.";
			}
		}
	}
}
if (isset($is_Submit) && $is_Submit == 'Y') {
	if (isset($user_type) && $user_type == "") {
		$error['msg'] 	= "Please Select User Type";
		$user_type_valid = "invalid";
	}
	if (isset($a_password) && strlen($a_password) < 5) {
		$error['msg'] 	= "Password should be greater than 4 characters.";
		$a_password_valid = "invalid";
	}
	if (isset($a_password) && $a_password == "") {
		$error['msg'] 	= "Please Enter Password";
		$a_password_valid = "invalid";
	}
	if (isset($username) && $username == "") {
		$error['msg'] 	= "Please Enter Username";
		$username_valid = "invalid";
	}
	if ($cmd == 'edit') {
		$sql1 		= "	SELECT * FROM users 
							WHERE username = '" . $username . "' AND id != '" . $id . "' ";
		$result1 	= $db->query($conn, $sql1);
		$count2 	= $db->counter($result1);
		if ($count2 > 0) {
			$error['msg'] 	= "Sorry! This username is not available in the System, try another.";
			$username_valid = "invalid";
		}
	}
	if (empty($error)) {
		if ($cmd == 'edit') {
			check_id($db, $conn, $id, "users");
			$sql_c_up = "UPDATE users SET 	a_password 					= '" . $a_password . "', 
											username 					= '" . $username . "', 

											update_date 				= '" . $add_date . "',
											update_by 					= '" . $_SESSION['username'] . "',
											update_ip 					= '" . $add_ip . "'
						WHERE id = '" . $id . "'   ";
			$ok = $db->query($conn, $sql_c_up);
			if ($ok) {
				$msg['msg_success'] = "Record Updated Successfully.";
			} else {
				$error['msg'] = "There is Error, record does not update, Please check it again OR contact Support Team.";
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
		<div class="col s12 m12 l12">
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
					<form method="post" autocomplete="off">
						<input type="hidden" name="is_Submit" value="Y" />
						<input type="hidden" name="cmd" value="<?php if (isset($cmd)) echo $cmd; ?>" />
						<div class="row">
							<div class="input-field col m4 s12">
								<i class="material-icons prefix pt-2">person_outline</i>
								<input id="username" type="text" required="" name="username" value="<?php if (isset($username)) {
																										echo $username;
																									} ?>">
								<label for="username">Username</label>
							</div>
							<div class="input-field col m4 s12">
								<i class="material-icons prefix pt-2">lock_outline</i>
								<input id="a_password" type="password" required="" name="a_password" value="<?php if (isset($a_password)) {
																												echo $a_password;
																											} ?>" class="validate <?php if (isset($a_password_valid)) {
																																		echo $a_password_valid;
																																	} ?>">
								<label for="a_password">Password</label>
							</div>
							<div class="input-field col m4 s12">
								<i class="material-icons prefix pt-2">person_outline</i>
								<select name="user_type" id="user_type" <?php if ($cmd == 'edit') { ?> disabled <?php } ?> class="validate <?php if (isset($user_type_valid)) {
																																				echo $user_type_valid;
																																			} ?>">
									<option value="Sub Users" <?php if (isset($user_type) && $user_type == "Sub Users") { ?> selected="selected" <?php } ?>>Sub Users</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="input-field col m4 s12">
								<i class="material-icons prefix pt-2">person_outline</i>
								<input id="first_name" type="text" readonly value="<?php echo $first_name . " " . $last_name; ?>">
								<label for="first_name">Full Name</label>
							</div>
							<div class="input-field col m4 s12">
								<i class="material-icons prefix pt-2">mail_outline</i>
								<input id="email" type="email" readonly name="email" required="" value="<?php if (isset($email)) {
																											echo $email;
																										} ?>" class="validate <?php if (isset($email_valid)) {
																																	echo $email_valid;
																																} ?>">
								<label for="email">Email</label>
							</div>
							<div class="input-field col m4 s12">
								<i class="material-icons prefix pt-2">mail_outline</i>
								<input id="employeeid" type="text" readonly name="employeeid" required="" value="<?php if (isset($employeeid)) {
																														echo $employeeid;
																													} ?>" class="validate <?php if (isset($employeeid_valid)) {
																																				echo $employeeid_valid;
																																			} ?>">
								<label for="employeeid">Emp ID</label>
							</div>
						</div>
						<div class="row">
							<div class="row">
								<div class="input-field col m6 s12">
									<button class="btn cyan waves-effect waves-light right" type="submit" name="action"><?php echo $button_val; ?>
										<i class="material-icons right">send</i>
									</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				<?php //include('sub_files/right_sidebar.php');
				?>
			</div>
		</div>
		<?php
		if ($cmd == 'edit') { ?>
			<div class="col s6 m6 l6">
				<div id="Form-advance" class="card card card-default scrollspy">
					<div class="card-content">
						<h4 class="card-title">Role Assign Entry</h4>
						<form method="post" action="">
							<input type="hidden" name="is_Submit2" value="Y" />
							<input type="hidden" name="cmd" value="<?php if (isset($cmd)) echo $cmd; ?>" />
							<input type="hidden" name="id" value="<?php if (isset($id)) echo $id; ?>" />
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<select required id="add_role_id" name="add_role_id" class="form-control  class=" validate <?php if (isset($add_role_id_valid)) {
																																		echo $add_role_id_valid;
																																	} ?>">
											<option value="">Select Role</option>
											<?php //required
											$sql_c 		= " SELECT * FROM sub_users_roles a WHERE a.enabled = 1  AND a.subscriber_users_id = '" . $subscriber_users_id . "' ";
											//echo $sql_c;
											$result_c 	= $db->query($conn, $sql_c);
											$row_c 		= $db->fetch($result_c);
											foreach ($row_c as $data) { ?>
												<option value="<?php echo $data['id']; ?>" <?php if (isset($add_role_id) && $add_role_id == $data['id']) { ?> selected="selected" <?php } ?>><?php echo $data['role_name']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group">
										<button class="btn cyan waves-effect waves-light right" type="submit" name="action">
											Add Role
											<i class="material-icons right">send</i>
										</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		<?php }
		if (isset($id) && $id > 0) { ?>
			<div class="col s12 m6 l12">
				<div id="Form-advance" class="card card card-default scrollspy">
					<?php
					$sql_cl = "	SELECT b.*, a.role_name
								FROM sub_users_roles a
								INNER JOIN sub_users_user_roles b ON b.role_id = a.id
								WHERE a.enabled = 1 
								AND b.enabled = 1
								AND b.user_id = '" . $id . "'";
					//echo $sql_cl;
					$result_cl 	= $db->query($conn, $sql_cl);
					$count_cl 	= $db->counter($result_cl);
					if (isset($count_cl) && $count_cl > 0) { ?>
						<div class="card subscriber-list-card animate fadeRight">
							<div class="card-content pb-1">
								<h4 class="card-title mb-0">List of all Roles</h4>
							</div>
							<table class="subscription-table responsive-table highlight">
								<thead>
									<tr>
										<th>S.No</th>
										<th>Role Name</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$prev_patient_id = 0;
									$row_cl = $db->fetch($result_cl);
									$i = 0;
									foreach ($row_cl as $data2) {
										$i = $i + 1; ?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo ucwords(strtolower($data2['role_name'])); ?></td>
											<td>
												<a class="waves-effect waves-light  btn gradient-45deg-red-pink box-shadow-none border-round mr-1 mb-1" href="?string=<?php echo encrypt("module=" . $module . "&page=add&cmd=edit&id=" . $id . "&cmd_detail=delete&detail_id=" . $data2['id']) ?>" onclick="return confirm('Are you sure! You want to Remove this Role?')">
													Delete
												</a>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					<?php } ?>
					<?php include('sub_files/right_sidebar.php'); ?>
				</div>
			</div>
		<?php } ?>
	</div><br><br>
	<!-- END: Page Main-->