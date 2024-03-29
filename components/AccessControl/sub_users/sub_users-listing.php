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
	$sql_c_upd = "UPDATE users set enabled = 0,
											update_date = '" . $add_date . "' ,
											update_by 	= '" . $_SESSION['username'] . "' ,
											update_ip 	= '" . $add_ip . "'
				WHERE id = '" . $id . "' ";
	$enabe_ok = $db->query($conn, $sql_c_upd);
	if ($enabe_ok) {
		$msg['msg_success'] = "User has been deactived.";
	} else {
		$error['msg'] = "There is Error, record does not update, Please check it again OR contact Support Team.";
	}
}
if (isset($cmd) && $cmd == 'enabled') {
	$sql_c_upd = "UPDATE users set enabled = 1,
										update_date = '" . $add_date . "' ,
										update_by 	= '" . $_SESSION['username'] . "' ,
										update_ip 	= '" . $add_ip . "'
				WHERE id = '" . $id . "' 
				AND subscriber_users_id='" . $subscriber_users_id . "' ";
	$enabe_ok = $db->query($conn, $sql_c_upd);
	if ($enabe_ok) {
		$msg['msg_success'] = "User has been actived successfully.";
	}
}
$sql_cl = "	SELECT a.*, b.fname, b.lname, b.email, b.employeeid, c.department
			FROM users a 
			LEFT JOIN employee b ON b.id = a.emp_id
			LEFT JOIN employeedepartment c ON c.id = b.departmentid
			WHERE a.user_type != 'Admin' 
			AND a.subscriber_users_id ='" . $subscriber_users_id . "'
			ORDER BY a.enabled DESC, a.id DESC ";
// echo $sql_cl;
$result_cl 	= $db->query($conn, $sql_cl);
$count_cl 	= $db->counter($result_cl);
$page_heading = "List of Sub Users";
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
									if (isset($error['msg'])) { ?>
										<div class="row">
											<div class="col 24 s12">
												<div class="card-alert card red lighten-5">
													<div class="card-content red-text">
														<p><?php echo $error['msg']; ?></p>
													</div>
													<button type="button" class="close red-text" data-dismiss="alert" aria-label="Close">
														<span aria-hidden="true">×</span>
													</button>
												</div>
											</div>
										</div>
									<?php } else if (isset($msg['msg_success'])) { ?>
										<div class="row">
											<div class="col 24 s12">
												<div class="card-alert card green lighten-5">
													<div class="card-content green-text">
														<p><?php echo $msg['msg_success']; ?></p>
													</div>
													<button type="button" class="close green-text" data-dismiss="alert" aria-label="Close">
														<span aria-hidden="true">×</span>
													</button>
												</div>
											</div>
										</div>
									<?php } ?>

									<h4 class="card-title"><?php echo $page_heading; ?></h4>
									<div class="row">
										<div class="col s12">
											<table id="page-length-option" class="display">
												<thead>
													<tr>
														<th>S.No</th>
														<th>Full Name</th>
														<th>Emp ID</th>
														<th>Department</th>
														<th>Username</th>
														<th>User Type</th>
														<th>Email</th>
														<th>Status</th>
														<th>Actions</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$i = 0;
													if ($count_cl > 0) {
														$row_cl = $db->fetch($result_cl);
														foreach ($row_cl as $data) { ?>
															<tr>
																<td><?php echo $i + 1; ?></td>
																<td><?php echo $data['fname'] . " " . $data['lname']; ?></td>
																<td><?php echo $data['employeeid']; ?></td>
																<td><?php echo $data['department']; ?></td>
																<td><?php echo $data['username']; ?></td>
																<td><?php echo $data['user_type']; ?></td>
																<td><?php echo $data['email']; ?></td>
																<td>
																	<?php
																	if ($data['enabled'] == 1) { ?>
																		<span class="chip green lighten-5">
																			<span class="green-text">Active</span>
																		</span>
																	<?php } else if ($data['enabled'] == 0) { ?>
																		<span class="chip red lighten-5"><span class="red-text">Disabled</span></span>
																	<?php } ?>
																</td>
																<td class="text-align-center">
																	<?php
																	if ($data['enabled'] == 1) { ?>
																		<a class="" href="?string=<?php echo encrypt("module=" . $module . "&page=add&cmd=edit&id=" . $data['id']) ?>">
																			<i class="material-icons dp48">edit</i>
																		</a> &nbsp;&nbsp;
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
													<?php $i++;
														}
													} ?>
												<tfoot>
													<tr>
														<th>S.No</th>
														<th>Full Name</th>
														<th>Emp ID</th>
														<th>Department</th>
														<th>Username</th>
														<th>User Type</th>
														<th>Email</th>
														<th>Status</th>
														<th>Actions</th>
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