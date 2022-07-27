<?php
if (!isset($module)) {
	require_once('../../../conf/functions.php');
	disallow_direct_school_directory_access();
}
$db = new mySqlDB;
$selected_db_name 		= $_SESSION["db_name"];
$subscriber_users_id 	= $_SESSION["subscriber_users_id"];
$user_id 				= $_SESSION["user_id"];

if (isset($cmd) && $cmd == 'disabled') {
	$sql_c_upd = "UPDATE employee set enabled 		= 0,
									  active 		= 0,
									  update_date 	= '" . $add_date . "' ,
									  update_by 	= '" . $_SESSION['username'] . "' ,
									  update_ip 	= '" . $add_ip . "'
				WHERE id = '" . $id . "' AND subscriber_users_id = '" . $subscriber_users_id . "' ";
	$enabe_ok = $db->query($conn, $sql_c_upd);
	if ($enabe_ok) {
		$sql_c_up = "UPDATE users SET 	enabled 		= '0',
										update_date 	= '" . $add_date . "',
										update_by 	 	= '" . $_SESSION['username'] . "',
										update_ip 	 	= '" . $add_ip . "'
					WHERE emp_id = '" . $id . "' AND subscriber_users_id = '" . $subscriber_users_id . "' ";
		$db->query($conn, $sql_c_up);
		$msg_success = "Employee has been deactived.";
		header("location: ?string=" . encrypt("module=" . $module . "&page=listing&msg_success=" . $msg_success));
	} else {
		$error['msg'] = "There is Error, record does not update, Please check it again OR contact Support Team.";
	}
}
if (isset($cmd) && $cmd == 'enabled') {
	$sql_c_upd = "UPDATE employee set 	enabled		= 1,
										active 		= 1,
										update_date = '" . $add_date . "' ,
										update_by 	= '" . $_SESSION['username'] . "' ,
										update_ip 	= '" . $add_ip . "'
				WHERE id = '" . $id . "' 
				AND subscriber_users_id='" . $subscriber_users_id . "' ";
	$enabe_ok = $db->query($conn, $sql_c_upd);
	if ($enabe_ok) {
		$sql_c_up = "UPDATE users SET 	enabled 		= '1',
										update_date 	= '" . $add_date . "',
										update_by 	 	= '" . $_SESSION['username'] . "',
										update_ip 	 	= '" . $add_ip . "'
					WHERE emp_id = '" . $id . "' AND subscriber_users_id = '" . $subscriber_users_id . "' ";
		$db->query($conn, $sql_c_up);
		$msg_success = "User has been actived successfully.";
		header("location: ?string=" . encrypt("module=" . $module . "&page=listing&msg_success=" . $msg_success));
	}
}
$sql_cl 				= "	SELECT b.department, c.profilename, a.*
							FROM employee a
							LEFT JOIN employeedepartment b ON b.id = a.departmentid
							LEFT JOIN passwordprofile c ON c.id = a.passwordprofileid 
							WHERE a.subscriber_users_id = '" . $subscriber_users_id . "'
							ORDER BY a.enabled DESC, a.id DESC ";
//echo $sql_cl;
$result_cl 				= $db->query($conn, $sql_cl);
$count_cl 				= $db->counter($result_cl);
$page_heading 			= "Employees";
?>
<!-- BEGIN: Page Main-->
<div id="main" class="<?php echo $page_width; ?>">
	<div class="row">
		<div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
		<div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
			<!-- Search for small screen-->
			<div class="container">
				<div class="row">
					<div class="col s10 m6 l6">
						<h5 class="breadcrumbs-title mt-0 mb-0"><span><?php echo $page_heading; ?></span></h5>
						<ol class="breadcrumbs mb-0">
							<li class="breadcrumb-item"><a href="home">Home</a>
							</li>
							</li>
							<li class="breadcrumb-item active">List</li>
						</ol>
					</div>
					<div class="col s2 m6 l6">
						<a class="btn waves-effect waves-light green darken-1 breadcrumbs-btn right" href="?string=<?php echo encrypt("module=" . $module . "&page=add&cmd=add") ?>" data-target="dropdown1">
							Add New
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="col s12">
			<div class="container">
				<div class="section section-data-tables">
					<!-- Page Length Options -->
					<div class="row">
						<div class="col s12">
							<div class="card">
								<div class="card-content">
									<?php
									if (isset($msg['msg_success'])) { ?>
										<div class="card-alert card green lighten-5">
											<div class="card-content green-text">
												<p><?php echo $msg['msg_success']; ?></p>
											</div>
											<button type="button" class="close green-text" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">×</span>
											</button>
										</div>
									<?php } ?>
									<h4 class="card-title"><?php echo $page_heading; ?></h4>
									<div class="row">
										<div class="col s12">
											<table id="page-length-option" class="display">
												<thead>
													<tr>
														<th width="5%">S.No</th>
														<th>Full Name</th>
														<th>Email</th>
														<th>Emp ID</th>
														<th>Job Title</th>
														<th>Department</th>
														<th>Hire Date</th>
														<th>Active</th>
														<th width="12%">Actions</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$i = 0;
													if ($count_cl > 0) {
														$row_cl = $db->fetch($result_cl);
														foreach ($row_cl as $data) {
															$id	= $data['id']; ?>
															<tr data-id="<?php echo $id; ?>">
																<td><?php echo $i + 1; ?></td>
																<td><?php echo $data['fname']; ?> <?php echo $data['lname']; ?></td>
																<td><?php echo $data['email']; ?></td>
																<td><?php echo $data['employeeid']; ?></td>
																<td><?php echo $data['jobtitle']; ?></td>
																<td><?php echo $data['department']; ?></td>
																<td>
																	<?php
																	if ($data['hiredate'] == "0000-00-00 00:00:00") {
																		$hiredate = "";
																	} else {
																		$hiredate = dateformat3($data['hiredate']);
																	}
																	echo $hiredate; ?>
																</td>
																<td style="color: <?php if ($data['active'] == 0) { ?> red <?php } else { ?> green <?php } ?>;">
																	<a style="color: <?php if ($data['active'] == 0) { ?> red <?php } else { ?> green <?php } ?>;" href="javascript:void(0)" onclick="change_status(this,'<?php echo $id ?>')"><?php echo ($data['active'] == '1') ? 'Yes' : 'No'; ?></a>
																</td>
																<td class="text-align-center">
																	<?php if ($data['enabled'] == 1) { ?>
																		&nbsp;&nbsp;
																		<a href="?string=<?php echo encrypt("module=" . $module . "&page=add&cmd=edit&id=" . $data['id']) ?>">
																			<i class="material-icons dp48">edit</i>
																		</a>
																	<?php }
																	if ($data['enabled'] == 0) { ?>
																		<a class="" href="?string=<?php echo encrypt("module=" . $module . "&page=listing&cmd=enabled&id=" . $data['id']) ?>">
																			<i class="material-icons dp48">add</i>
																		</a> &nbsp;&nbsp;
																	<?php } else if ($data['enabled'] == 1) { ?>
																		<a class="" href="?string=<?php echo encrypt("module=" . $module . "&page=listing&cmd=disabled&id=" . $data['id']) ?>" onclick="return confirm('Are you sure, You want to delete this record?')">
																			<i class="material-icons dp48">delete</i>
																		</a>&nbsp;&nbsp;
																	<?php } ?>
																</td>
															</tr>
													<?php
															$i++;
														}
													} ?>
												<tfoot>
													<tr>
														<th width="5%">S.No</th>
														<th>Full Name</th>
														<th>Email</th>
														<th>Emp ID</th>
														<th>Job Title</th>
														<th>Department</th>
														<th>Hire Date</th>
														<th>Active</th>
														<th width="12%">Actions</th>
													</tr>
												</tfoot>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Multi Select -->
				</div><!-- START RIGHT SIDEBAR NAV -->

				<?php include('sub_files/right_sidebar.php'); ?>
			</div>

			<div class="content-overlay"></div>
		</div>
	</div>
</div>