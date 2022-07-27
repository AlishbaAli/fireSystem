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
	$title_heading = "Edit Phone Number Type";
	$button_val = "Edit";
}
if ($cmd == 'add') {
	$title_heading 	= "Add Phone Number Type";
	$button_val 	= "Add";
	$id 			= "";
}
if ($cmd == 'edit' && isset($id)) {
	$sql_ee 			= "	SELECT a.* FROM phonenumbertype a WHERE a.id = '" . $id . "' AND a.subscriber_users_id = '" . $subscriber_users_id . "'   ";
	$result_ee 			= $db->query($conn, $sql_ee);
	$row_ee 			= $db->fetch($result_ee);
	$phonenumbertype	=  $row_ee[0]['phonenumbertype'];
	$duplicatesallowed	=  $row_ee[0]['duplicatesallowed'];
	$comment			=  $row_ee[0]['comment'];
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
	if (isset($phonenumbertype) && $phonenumbertype == "") {
		$error['msg'] = "Enter Phone Number Type";
		$phonenumbertype_valid = "invalid";
	}
	if (isset($duplicatesallowed) && $duplicatesallowed == "") {
		$error['msg'] = "Enter Parts Warranty";
		$duplicatesallowed_valid = "invalid";
	}

	if (empty($error)) {
		if ($cmd == 'add') {
			$sql_ee 			= "	SELECT a.* FROM phonenumbertype a 
									WHERE a.subscriber_users_id 	= '" . $subscriber_users_id . "' 
									AND a.phonenumbertype			= '" . $phonenumbertype . "' ";
			$result_ee 			= $db->query($conn, $sql_ee);
			$counter_ee			= $db->counter($result_ee);
			if ($counter_ee == 0) {
				$sql = "INSERT INTO phonenumbertype(subscriber_users_id, phonenumbertype, duplicatesallowed,  comment,  add_date, add_by, add_ip)
						VALUES('" . $subscriber_users_id . "', '" . $phonenumbertype . "',  '" . $duplicatesallowed . "',  '" . $comment . "', 
																									'" . $add_date . "', '" . $_SESSION['username'] . "', '" . $add_ip . "')";
				// echo $sql;
				$ok = $db->query($conn, $sql);
				if ($ok) {
					$phonenumbertype = $duplicatesallowed = $comment = "";
					$msg['msg_success'] = "Phone Number Type has been added successfully.";
				} else {
					$error['msg'] = "There is Error, Please check it again OR contact Support Team.";
				}
			} else {
				$error['msg'] = "This Phone Number Type is already exist.";
			}
		} else if ($cmd == 'edit') {
			check_id($db, $conn, $id, "phonenumbertype", $subscriber_users_id, $selected_db_name);
			$sql_ee 			= "	SELECT a.* FROM phonenumbertype a 
									WHERE a.subscriber_users_id	= '" . $subscriber_users_id . "' 
									AND a.phonenumbertype			= '" . $phonenumbertype . "'
									AND a.id 				   != '" . $id . "'";
			$result_ee 			= $db->query($conn, $sql_ee);
			$counter_ee			= $db->counter($result_ee);
			if ($counter_ee == 0) {
				$sql_c_up = "UPDATE phonenumbertype SET	phonenumbertype		= '" . $phonenumbertype . "', 
													duplicatesallowed	= '" . $duplicatesallowed . "', 
													comment				= '" . $comment . "', 
													update_date			= '" . $add_date . "',
													update_by			= '" . $_SESSION['username'] . "',
													update_ip			= '" . $add_ip . "'
							WHERE id = '" . $id . "'  ";
				//echo $sql_c_up;
				$ok = $db->query($conn, $sql_c_up);
				if ($ok) {
					$msg['msg_success'] = "Record Updated Successfully.";
				} else {
					$error['msg'] = "There is Error, record does not update, Please check it again OR contact Support Team.";
				}
			} else {
				$error['msg'] = "This Phone Number Type is already exist.";
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
								<input id="phonenumbertype" type="text" name="phonenumbertype" value="<?php if (isset($phonenumbertype)) {
																											echo $phonenumbertype;
																										} ?>" required="" class="validate <?php if (isset($phonenumbertype_valid)) {
																																				echo $phonenumbertype_valid;
																																			} ?>">
								<label for="phonenumbertype">Phone Number Type</label>
							</div>
							<div class="input-field col m6 s12">
								<i class="material-icons prefix pt-2">add</i>
								<select name="duplicatesallowed" id="duplicatesallowed" class="validate <?php if (isset($duplicatesallowed_valid)) {
																											echo $duplicatesallowed_valid;
																										} ?>">
									<option value="">Select Duplicate Allow</option>
									<option value="1" <?php if (isset($duplicatesallowed) && $duplicatesallowed == "1") { ?> selected="selected" <?php } ?>>Yes</option>
									<option value="0" <?php if (isset($duplicatesallowed) && $duplicatesallowed == "0") { ?> selected="selected" <?php } ?>>No</option>
								</select>
								<label for="phonenumbertype"> Duplicate Allow</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col m12 s12">
								<i class="material-icons prefix">description</i>
								<textarea id="comment" name="comment" class=" materialize-textarea validate <?php if (isset($comment_valid)) {
																												echo $comment_valid;
																											} ?> name=" comment"><?php if (isset($comment)) {
																																		echo $comment;
																																	} ?></textarea>
								<label for="comment">Comment</label>
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