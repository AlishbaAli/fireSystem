<?php
if (isset($test_on_local) && $test_on_local == 1) {
	if ($cmd != 'edit') {
		$company_name				= "name";
		$csaccountnum			= "434343";
		$streetnumber			= "streetnumber";
		$streetname				= "streetname";
		$suite					= "suite";
		$zipcode				= "zipcode";
		$phonenumber 			= "034555555555555";
		$secondphonenumber 		= "034555555555555";
		$salesmanid 			= "3";
		$lasteditorid 			= "5";
		$billingnumber 			= "4545451";
		$comment 				= "comment";
		$dateoflastservice 		= "01/01/2022";
		$cityid					= "1";
		$stateid				= "1";
		$typeofsystemid 		= "1";
		$taxid 					= "2";
		$specialinstructionsid	= "1";
	}
	$operatorid 			= "7";
	$contact				= "Aftab";
	$problem 				= "problem";
	$complete 				= "1";
	$completedby 			= "7";
	$completiondate 		= "01/01/2022";
	$supplemented 			= "1";
	$supplementedby 		= "7";
	$supplementeddate 		= "01/01/2022";
	$lasteditorid2 			= "5";
	$pendingparts 			= "1";
	$datewoscheduled 		= "01/01/2022";
	$wotimelength 			= "10";
	$assigntoid 			= "5";
	$repeatcall 			= "1";
	$dateofservice 			= "01/01/2022";
	$laborbilltocustomer	= "10";
	$partsbilltocustomer	= "20";
	$comment2 				= "work order comment";

	$workorderid 			= 13988;
	$technicianid 			= 7;
	$laborhours 			= 2.5;
	$partsused				= "partsused";
	$contacted				= "contacted";
	$timein_date 			= "01/01/2022";
	$timeout_date 			= "01/02/2022";
	$timein_time			= "10:00 AM";
	$timeout_time			= "10:00 AM";
	$laboramount 			= 200;
	$partsamount 			= 200;
	$workdone 				= "workdone workdone workdone workdone workdone workdone workdone workdone workdone workdone";
	$contractdate=date('Y/m/d');
	$contractexpirationdate=date('Y/m/d');
}
if (!isset($module)) {
	require_once('../../../conf/functions.php');
	disallow_direct_school_directory_access();
}
$db 					= new mySqlDB;
$selected_db_name 		= $_SESSION["db_name"];
$subscriber_users_id 	= $_SESSION["subscriber_users_id"];
$user_id 				= $_SESSION["user_id"];
if (!isset($_SESSION['csrf_session'])) {
	$_SESSION['csrf_session'] = session_id();
}
$btn2 = "Add";
$btn3 = "Add";
$btn4 = "Add";
if (!isset($cmd2)) {
	$cmd2 = "add";
}
if (isset($cmd2) && $cmd2 == 'edit') {
	$btn2 = "Save";
}
if (!isset($cmd3)) {
	$cmd3 = "add";
}
if (isset($cmd3) && $cmd3 == 'edit') {
	$btn3 = "Save";
}
if (!isset($cmd4)) {
	$cmd4 = "add";
}
if (isset($cmd4) && $cmd4 == 'edit') {
	$btn4 = "Save";
}


extract($_POST);

foreach ($_POST as $key => $value) {
	if (!is_array($value)) {
		$data[$key] = remove_special_character(trim(htmlspecialchars(strip_tags(stripslashes($value)), ENT_QUOTES, 'UTF-8')));
		$$key = $data[$key];
	}
}
include('tab1_code.php');
include('tab2_code.php');
include('tab3_code.php');
include('tab4_code.php');

if ($cmd == 'edit') {
	$title_heading = "Edit  Customer Profile";
	$button_val = "Save";
}
if ($cmd == 'add') {
	$title_heading 	= "Create New Customer";
	$button_val 	= "Create";
	$id 			= "";
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
						<div class="col s10 m10 20">
							<h5 class="breadcrumbs-title mt-0 mb-0"><span><?php echo $title_heading; ?></span></h5>
							<ol class="breadcrumbs mb-0">
								<li class="breadcrumb-item"><?php echo $title_heading; ?>
								</li>
								<li class="breadcrumb-item"><a href="?string=<?php echo encrypt("module=" . $module . "&page=listing") ?>">List</a></li>
							</ol>
						</div>
						<div class="col m2 s12 m2 4">
							<a class="btn waves-effect waves-light green darken-1 breadcrumbs-btn right" href="?string=<?php echo encrypt("module=" . $module . "&page=listing") ?>" data-target="dropdown1">
								List
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col m12 s12">
			<div class="container">
				<!-- Account settings -->
				<section class="tabs-vertical mt-1 section">
					<div class="row">
						<div class="col l3 s12">
							<!-- tabs  -->
							<div class="card-panel">
								<ul class="tabs">
									<li class="tab">
										<a href="#general" class="<?php if (isset($active_tab) && $active_tab == 'tab1') {
																		echo "active";
																	} ?>">
											<i class="material-icons">person_outline</i>
											<span>Profile</span>
										</a>
									</li>
									<li class="tab">
										<a href="#info" class="<?php if (!isset($active_tab) || (isset($active_tab) && $active_tab == 'tab2')) {
																	echo "active";
																} ?>">
											<i class="material-icons">add_shopping_cart</i>
											<span>Work Orders</span>
										</a>
									</li>
									<li class="tab">
										<a href="#tab3" class="<?php if (!isset($active_tab) || (isset($active_tab) && $active_tab == 'tab3')) {
																	echo "active";
																} ?>">
											<i class="material-icons">content_paste</i>
											<span>Work Orders Done</span>
										</a>
									</li>
									<li class="tab">
										<a href="#tab4" class="<?php if (!isset($active_tab) || (isset($active_tab) && $active_tab == 'tab4')) {
																	echo "active";
																} ?>">
											<i class="material-icons">content_paste</i>
											<span>Contracts</span>
										</a>
									</li>
									<li class="indicator" style="left: 0px; right: 0px;"></li>
									<?php
									if (isset($id) && $id > 0) { ?>
										<br><br><br>
										<a class="" href="?string=<?php echo encrypt("module=" . $module . "&page=add&cmd=add&active_tab=tab1") ?>">
											Add New Customer
										</a>
										<?php
										if (isset($cmd2) && $cmd2 != "add") { ?><br>
											<a class="" href="?string=<?php echo encrypt("module=" . $module . "&page=add&cmd=edit&id=" . $id . "&cmd2=add&active_tab=tab2") ?>">
												Add New Work Order
											</a>
										<?php }
										if (isset($cmd3) && $cmd3 != "add") { ?><br>
											<a class="" href="?string=<?php echo encrypt("module=" . $module . "&page=add&cmd=edit&id=" . $id . "&cmd3=add&active_tab=tab3") ?>">
												New Work Order Done
											</a>
									<?php }
									} ?>
								</ul>
							</div>
						</div>
						<div class="col l9 s12">
							<?php
							if (isset($error['msg'])) { ?>
								<div class="card-panel">
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
								</div>
							<?php } else if (isset($msg['msg_success'])) { ?>
								<div class="card-panel">
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
								</div>
							<?php } ?>
							<!-- tabs content -->
							<!--General Tab Begin-->
							<div id="general" style="display: <?php if (isset($active_tab) && $active_tab == 'tab1') {
																	echo "block";
																} else {
																	echo "none";
																} ?>;">
								<div class="card-panel">
									<form class="infovalidate" action="" method="post" enctype="multipart/form-data">
										<input type="hidden" name="is_submit_profile" value="Y" />
										<input type="hidden" name="cmd" value="<?php if (isset($cmd)) echo $cmd; ?>" />
										<input type="hidden" name="id" value="<?php if (isset($id)) echo $id; ?>" />
										<input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
																							echo encrypt($_SESSION['csrf_session']);
																						} ?>">
										<input type="hidden" name="active_tab" value="tab1" />
										<div class="divider mb-1 mt-1"></div>
										<h4>Profile</h4>
										<div class="row">
											<div class="input-field col m4 s12">
												<i class="material-icons prefix pt-2">person_outline</i>
												<input id="company_name" type="text" name="company_name" id="company_name" value="<?php if (isset($company_name)) {
																																		echo $company_name;
																																	} ?>" class="validate <?php if (isset($company_name_valid)) {
																																								echo $company_name_valid;
																																							} ?>">
												<label for="company_name">Company Name</label>
											</div>
											<div class="input-field col m4 s12">
												<i class="material-icons prefix pt-2">person_outline</i>
												<input id="csaccountnum" type="text" name="csaccountnum" id="csaccountnum" value="<?php if (isset($csaccountnum)) {
																																		echo $csaccountnum;
																																	} ?>" class="validate <?php if (isset($csaccountnum_valid)) {
																																								echo $csaccountnum_valid;
																																							} ?>">
												<label for="csaccountnum">Cs Account Num</label>
											</div>
											<div class="input-field col m4 s12">
												<i class="material-icons prefix pt-2">location_on</i>
												<input id="streetnumber" type="text" name="streetnumber" id="streetnumber" value="<?php if (isset($streetnumber)) {
																																		echo $streetnumber;
																																	} ?>" class="validate <?php if (isset($streetnumber_valid)) {
																																								echo $streetnumber_valid;
																																							} ?>">
												<label for="streetnumber">Street Number</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col m4 s12">
												<i class="material-icons prefix pt-2">location_on</i>
												<input id="streetname" type="text" name="streetname" id="streetname" value="<?php if (isset($streetname)) {
																																echo $streetname;
																															} ?>" class="validate <?php if (isset($streetname_valid)) {
																																						echo $streetname_valid;
																																					} ?>">
												<label for="streetname">Street Name</label>
											</div>
											<div class="input-field col m4 s12">
												<i class="material-icons prefix pt-2">location_on</i>
												<input id="suite" type="text" name="suite" id="suite" value="<?php if (isset($suite)) {
																													echo $suite;
																												} ?>" class="validate <?php if (isset($suite_valid)) {
																																			echo $suite_valid;
																																		} ?>">
												<label for="suite">Suite</label>
											</div>
											<div class="input-field col m4 s12">
												<i class="material-icons prefix pt-2">location_on</i>
												<input id="zipcode" type="text" name="zipcode" id="zipcode" value="<?php if (isset($zipcode)) {
																														echo $zipcode;
																													} ?>" class="validate <?php if (isset($zipcode_valid)) {
																																				echo $zipcode_valid;
																																			} ?>">
												<label for="zipcode">Zipcode</label>
											</div>
										</div>
										<div class="row"> &nbsp;</div>
										<div class="row">
											<div class="input-field col m4 s12">
												<i class="material-icons prefix pt-2">phone</i>
												<input id="phonenumber" type="text" name="phonenumber" id="phonenumber" value="<?php if (isset($phonenumber)) {
																																	echo $phonenumber;
																																} ?>" class="validate <?php if (isset($phonenumber_valid)) {
																																							echo $phonenumber_valid;
																																						} ?>">
												<label for="phonenumber">Phone Number</label>
											</div>
											<div class="input-field col m4 s12">
												<i class="material-icons prefix pt-2">phone</i>
												<input id="secondphonenumber" type="text" name="secondphonenumber" id="secondphonenumber" value="<?php if (isset($secondphonenumber)) {
																																						echo $secondphonenumber;
																																					} ?>" class="validate <?php if (isset($secondphonenumber_valid)) {
																																												echo $secondphonenumber_valid;
																																											} ?>">
												<label for="secondphonenumber">Second Phone Number</label>
											</div>
											<div class="input-field col m4 s12">
												<i class="material-icons prefix pt-2">person_outline</i>
												<?php
												$sql1 = " SELECT * FROM employee WHERE active = 1 AND subscriber_users_id = '" . $subscriber_users_id . "' ";
												$result1 = $db->query($conn, $sql1);
												$count1 = $db->counter($result1);
												?>
												<select id="salesmanid" name="salesmanid" class="validate select2 browser-default select2-hidden-accessible <?php if (isset($salesmanid_valid)) {
																																								echo "is-warning";
																																							} ?>">
													<option value="">Select Salesman</option>
													<?php
													if ($count1 > 0) {
														$row1 = $db->fetch($result1);
														foreach ($row1 as $data) { ?>
															<option value="<?php echo $data["id"] ?>" <?php if (isset($salesmanid) && $salesmanid == $data["id"]) { ?> selected="selected" <?php } ?>><?php echo $data["fname"]; ?> <?php echo $data["lname"]; ?> (Salesman)</option>
													<?php }
													} ?>
												</select>
											</div>
										</div>
										<div class="row"> &nbsp;</div>
										<div class="row">
											<div class="input-field col m6 s12">
												<?php
												$sql1 = " SELECT * FROM employee WHERE active = 1 AND subscriber_users_id = '" . $subscriber_users_id . "' ";
												$result1 = $db->query($conn, $sql1);
												$count1 = $db->counter($result1);
												?>
												<select id="lasteditorid" name="lasteditorid" class="validate select2 browser-default select2-hidden-accessible <?php if (isset($lasteditorid_valid)) {
																																									echo "is-warning";
																																								} ?>">
													<option value="">Select Last Editor</option>
													<?php
													if ($count1 > 0) {
														$row1 = $db->fetch($result1);
														foreach ($row1 as $data) { ?>
															<option value="<?php echo $data["id"] ?>" <?php if (isset($lasteditorid) && $lasteditorid == $data["id"]) { ?> selected="selected" <?php } ?>><?php echo $data["fname"]; ?> <?php echo $data["lname"]; ?> (Editor)</option>
													<?php }
													} ?>
												</select>
											</div>
											<div class="input-field col m6 s12">
												<i class="material-icons prefix pt-2">person_outline</i>
												<input id="billingnumber" type="text" name="billingnumber" id="billingnumber" value="<?php if (isset($billingnumber)) {
																																			echo $billingnumber;
																																		} ?>" class="validate <?php if (isset($billingnumber_valid)) {
																																									echo $billingnumber_valid;
																																								} ?>">
												<label for="billingnumber">Billing Number</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col m12 s12">
												<i class="material-icons prefix">description</i>
												<textarea id="comment" class="materialize-textarea validate <?php if (isset($comment_valid)) {
																												echo $comment_valid;
																											} ?>" name="comment"><?php if (isset($comment)) {
																																		echo $comment;
																																	} ?></textarea>
												<label for="comment">Comment</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col m4 s12">
												<i class="material-icons prefix pt-2">date_range</i>
												<label for="dateoflastservice">Date of Last Service (d/m/Y) <span class="red-text">*</span></label>
												<input id="dateoflastservice" name="dateoflastservice" type="text" class="datepicker" value="<?php if (isset($dateoflastservice)) {
																																					echo $dateoflastservice;
																																				} ?>" class="validate <?php if (isset($dateoflastservice_valid)) {
																																											echo $dateoflastservice_valid;
																																										} ?>">
											</div>
											<div class="input-field col m4 s12">
												<i class="material-icons prefix pt-2">location_on</i>
												<select name="cityid" id="cityid" class="validate <?php if (isset($cityid_valid)) {
																										echo $cityid_valid;
																									} ?>">
													<?php
													$query3		= " SELECT * FROM city ";
													$result3 	= $db->query($conn, $query3);
													$row_cl3 	= $db->fetch($result3); ?>
													<option>Select</option>
													<?php
													foreach ($row_cl3 as $data1) { ?>
														<option value="<?php echo $data1["id"] ?>" <?php if (isset($cityid) && $cityid == $data1["id"]) { ?> selected="selected" <?php } ?>><?php echo $data1["city"]; ?></option>
													<?php } ?>
												</select>
												<label for="cityid">Cities</label>
											</div>
											<div class="input-field col m4 s12">
												<i class="material-icons prefix pt-2">location_on</i>
												<select name="stateid" id="stateid" class="validate <?php if (isset($stateid_valid)) {
																										echo $stateid_valid;
																									} ?>">
													<?php
													$query3		= " SELECT * FROM state ";
													$result3 	= $db->query($conn, $query3);
													$row_cl3 	= $db->fetch($result3); ?>
													<option>Select</option>
													<?php
													foreach ($row_cl3 as $data2) { ?>
														<option value="<?php echo $data2["id"] ?>" <?php if (isset($stateid) && $stateid == $data2["id"]) { ?> selected="selected" <?php } ?>><?php echo $data2["state"]; ?></option>
													<?php } ?>
												</select>
												<label for="stateid">State</label>
											</div>
										</div>
										<div class="row"> &nbsp;</div>
										<div class="row">
											<div class="input-field col m3 s12">
												<i class="material-icons prefix pt-2">select_all</i>
												<select name="taxid" id="taxid" class="validate <?php if (isset($taxid_valid)) {
																									echo $taxid_valid;
																								} ?>">
													<?php
													$query3		= " SELECT * FROM tax ";
													$result3 	= $db->query($conn, $query3);
													$row_cl3 	= $db->fetch($result3); ?>
													<option>Select</option>
													<?php
													foreach ($row_cl3 as $data1) { ?>
														<option value="<?php echo $data1["id"] ?>" <?php if (isset($taxid) && $taxid == $data1["id"]) { ?> selected="selected" <?php } ?>><?php echo $data1["taxamount"]; ?></option>
													<?php } ?>
												</select>
												<label for="taxid">Tax</label>
											</div>
											<div class="input-field col m3 s12">
												<i class="material-icons prefix pt-2">select_all</i>
												<select name="typeofsystemid" id="typeofsystemid" class="validate <?php if (isset($typeofsystemid_valid)) {
																														echo $typeofsystemid_valid;
																													} ?>">
													<?php
													$query3		= " SELECT * FROM typeofsystem ";
													$result3 	= $db->query($conn, $query3);
													$row_cl3 	= $db->fetch($result3); ?>
													<option>Select</option>
													<?php
													foreach ($row_cl3 as $data2) { ?>
														<option value="<?php echo $data2["id"] ?>" <?php if (isset($typeofsystemid) && $typeofsystemid == $data2["id"]) { ?> selected="selected" <?php } ?>><?php echo $data2["typeofsystem"]; ?></option>
													<?php } ?>
												</select>
												<label for="typeofsystemid">Type Of System</label>
											</div>
											<div class="input-field col m6 s12">
												<i class="material-icons prefix pt-2">select_all</i>
												<select name="specialinstructionsid" id="specialinstructionsid" class="validate <?php if (isset($specialinstructionsid_valid)) {
																																	echo $specialinstructionsid_valid;
																																} ?>">
													<?php
													$query3		= " SELECT * FROM specialinstructions ";
													$result3 	= $db->query($conn, $query3);
													$row_cl3 	= $db->fetch($result3); ?>
													<option>Select</option>
													<?php
													foreach ($row_cl3 as $data2) { ?>
														<option value="<?php echo $data2["id"] ?>" <?php if (isset($specialinstructionsid) && $specialinstructionsid == $data2["id"]) { ?> selected="selected" <?php } ?>><?php echo $data2["specialinstructions"]; ?></option>
													<?php } ?>
												</select>
												<label for="specialinstructionsid">Special in structions</label>
											</div>
										</div>
										<div class="row"> &nbsp;</div>
										<div class="row">
											<div class="input-field col m4 s12">&nbsp;</div>
											<div class="input-field col m4 s12">
												<button class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col m12 s12" type="submit" name="action"><?php echo $button_val; ?></button>
											</div>
											<div class="input-field col m4 s12">&nbsp;</div>
										</div>
										<div class="col m4 s12"></div>
									</form>
								</div>
							</div>
							<!--General Tab End-->


							<!--Info Tab Begin-->

							<!--  start  -->


							<!--Info Tab Begin-->
							<div id="info" class="active" style="display: <?php if (!isset($active_tab) || (isset($active_tab) && $active_tab == 'tab2')) {
																				echo "block";
																			} else {
																				echo "none";
																			} ?>;">
								<div class="card-panel">
									<!--	<form class="infovalidate" action="?string=<? php // echo encrypt("module=" . $module . "&page=add_edit&cmd=edit&id=" . $id . "&cmd2=" . $cmd2 . "&detail_id=" . $detail_id . "&active_tab=tab2") 
																						?>" method="post">-->
									<form class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&page=add&cmd=edit&id=" . $id . "&cmd2=" . $cmd2 . "&detail_id=" . $detail_id . "&active_tab=tab2") ?>" method="post">
										<input type="hidden" name="is_Submit_tab2" value="Y" />
										<input type="hidden" name="cmd" value="<?php if (isset($cmd)) echo $cmd; ?>" />
										<input type="hidden" name="id" value="<?php if (isset($id)) echo $id; ?>" />
										<input type="hidden" name="cmd2" value="<?php if (isset($cmd2)) echo $cmd2; ?>" />
										<input type="hidden" name="detail_id" value="<?php if (isset($detail_id)) echo $detail_id; ?>" />
										<input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
																							echo encrypt($_SESSION['csrf_session']);
																						} ?>">
										<input type="hidden" name="active_tab" value="tab2" />
										<h4>Work Order </h4>
										<div class="row">
											<div class="input-field col m6 s12">
												<?php
												$sql1 = " SELECT * FROM employee WHERE active = 1 AND subscriber_users_id = '" . $subscriber_users_id . "' ";
												$result1 = $db->query($conn, $sql1);
												$count1 = $db->counter($result1);
												?>
												<select id="operatorid" name="operatorid" class="validate select2 browser-default select2-hidden-accessible <?php if (isset($operatorid_valid)) {
																																								echo "is-warning";
																																							} ?>">
													<option value="">Select Operator</option>
													<?php
													if ($count1 > 0) {
														$row1 = $db->fetch($result1);
														foreach ($row1 as $data) { ?>
															<option value="<?php echo $data["id"] ?>" <?php if (isset($operatorid) && $operatorid == $data["id"]) { ?> selected="selected" <?php } ?>><?php echo $data["fname"]; ?> <?php echo $data["lname"]; ?> <b>(Operator)</b></option>
													<?php }
													} ?>
												</select>
											</div>
											<div class="input-field col m6 s12">
												<i class="material-icons prefix">person_outline</i>
												<input id="contact" type="text" name="contact" value="<?php if (isset($contact)) {
																											echo $contact;
																										} ?>" class="validate <?php if (isset($contact_valid)) {
																																	echo $contact_valid;
																																} ?>" required>
												<label for="contact">Contact Name</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col m12 s12">
												<i class="material-icons prefix">description</i>
												<textarea id="problem" class="materialize-textarea validate <?php if (isset($problem_valid)) {
																												echo $problem_valid;
																											} ?>" name="problem"><?php if (isset($problem)) {
																																		echo $problem;
																																	} ?></textarea>
												<label for="problem">Problem</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col m6 s12">
												<i class="material-icons prefix">timer</i>
												<input id="wotimelength" type="number" name="wotimelength" class="<?php if (isset($wotimelength_valid)) {
																														echo $wotimelength_valid;
																													} ?>" value="<?php if (isset($wotimelength)) {
																																		echo $wotimelength;
																																	} ?>">
												<label for="wotimelength"> Work Time Length </label>
											</div>
											<div class="input-field col m3 s12 ">
												<i class="material-icons prefix">date_range</i>
												<input id="datewoscheduled" type="text" name="datewoscheduled" class="datepicker <?php if (isset($datewoscheduled_valid)) {
																																		echo $datewoscheduled_valid;
																																	} ?>" value="<?php if (isset($datewoscheduled)) {
																																						echo $datewoscheduled;
																																					} ?>">
												<label for="datewoscheduled"> Work Schedule Date</label>
											</div>
											<div class="input-field col m3 s12 ">
												<i class="material-icons prefix">access_time</i>
												<input id="timewoscheduled" type="text" name="timewoscheduled" class="timepicker <?php if (isset($timewoscheduled_valid)) {
																																		echo $timewoscheduled_valid;
																																	} ?>" value="<?php if (isset($timewoscheduled)) {
																																						echo $timewoscheduled;
																																					} ?>">
												<label for="timewoscheduled"> Work Schedule Time</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col m2 s12">
												<i class="material-icons prefix pt-2">done</i>
												<select id="complete" name="complete" class="validate <?php if (isset($complete_valid)) {
																											echo $complete_valid;
																										} ?>">
													<option value="0" <?php if (isset($complete) && $complete == "0") { ?> selected="selected" <?php } ?>>No</option>
													<option value="1" <?php if (isset($complete) && $complete == "1") { ?> selected="selected" <?php } ?>>Yes</option>
												</select>
												<label for="complete">Complete</label>
											</div>
											<div class="input-field col m4 s12">
												<?php
												$sql1 = " SELECT * FROM employee WHERE active = 1 AND subscriber_users_id = '" . $subscriber_users_id . "' ";
												$result1 = $db->query($conn, $sql1);
												$count1 = $db->counter($result1);
												?>
												<select id="completedby" name="completedby" class="validate select2 browser-default select2-hidden-accessible <?php if (isset($completedby_valid)) {
																																									echo "is-warning";
																																								} ?>">
													<option value="">Select Completed By</option>
													<?php
													if ($count1 > 0) {
														$row1 = $db->fetch($result1);
														foreach ($row1 as $data) { ?>
															<option value="<?php echo $data["id"] ?>" <?php if (isset($completedby) && $completedby == $data["id"]) { ?> selected="selected" <?php } ?>><?php echo $data["fname"]; ?> <?php echo $data["lname"]; ?> (Completed)</option>
													<?php }
													} ?>
												</select>
											</div>
											<div class="input-field col m3 s12 ">
												<i class="material-icons prefix">date_range</i>
												<input id="completiondate" type="text" name="completiondate" class="datepicker <?php if (isset($completiondate_valid)) {
																																	echo $completiondate_valid;
																																} ?>" value="<?php if (isset($completiondate)) {
																																					echo $completiondate;
																																				} ?>">
												<label for="completiondate"> Completion Date</label>
											</div>
											<div class="input-field col m3 s12 ">
												<i class="material-icons prefix">access_time</i>
												<input id="completiontime" type="text" name="completiontime" class="timepicker <?php if (isset($completiontime_valid)) {
																																	echo $completiontime_valid;
																																} ?>" value="<?php if (isset($completiontime)) {
																																					echo $completiontime;
																																				} ?>">
												<label for="completiontime"> Completion Time</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col m2 s12">
												<i class="material-icons prefix pt-2">ac_unit</i>
												<select id="supplemented" name="supplemented" class="validate <?php if (isset($supplemented_valid)) {
																													echo $supplemented_valid;
																												} ?>">
													<option value="0" <?php if (isset($supplemented) && $supplemented == "0") { ?> selected="selected" <?php } ?>>No</option>
													<option value="1" <?php if (isset($supplemented) && $supplemented == "1") { ?> selected="selected" <?php } ?>>Yes</option>
												</select>
												<label for="supplemented">Supplemented</label>
											</div>
											<div class="input-field col m4 s12">
												<?php
												$sql1 = " SELECT * FROM employee WHERE active = 1 AND subscriber_users_id = '" . $subscriber_users_id . "' ";
												$result1 = $db->query($conn, $sql1);
												$count1 = $db->counter($result1);
												?>
												<select id="supplementedby" name="supplementedby" class="validate select2 browser-default select2-hidden-accessible <?php if (isset($supplementedby_valid)) {
																																										echo "is-warning";
																																									} ?>">
													<option value="">Select Supplemented By</option>
													<?php
													if ($count1 > 0) {
														$row1 = $db->fetch($result1);
														foreach ($row1 as $data) { ?>
															<option value="<?php echo $data["id"] ?>" <?php if (isset($supplementedby) && $supplementedby == $data["id"]) { ?> selected="selected" <?php } ?>><?php echo $data["fname"]; ?> <?php echo $data["lname"]; ?> (Supplemented)</option>
													<?php }
													} ?>
												</select>
											</div>
											<div class="input-field col m3 s12 ">
												<i class="material-icons prefix">date_range</i>
												<input id="supplementeddate" type="text" name="supplementeddate" class="datepicker <?php if (isset($supplementeddate_valid)) {
																																		echo $supplementeddate_valid;
																																	} ?>" value="<?php if (isset($supplementeddate)) {
																																						echo $supplementeddate;
																																					} ?>">
												<label for="supplementeddate"> Supplemented Date</label>
											</div>
											<div class="input-field col m3 s12 ">
												<i class="material-icons prefix">access_time</i>
												<input id="supplementedtime" type="text" name="supplementedtime" class="timepicker <?php if (isset($supplementedtime_valid)) {
																																		echo $supplementedtime_valid;
																																	} ?>" value="<?php if (isset($supplementedtime)) {
																																						echo $supplementedtime;
																																					} ?>">
												<label for="supplementedtime"> Supplemented Time</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col m6 s12">
												<?php
												$sql1 = " SELECT * FROM employee WHERE active = 1 AND subscriber_users_id = '" . $subscriber_users_id . "' ";
												$result1 = $db->query($conn, $sql1);
												$count1 = $db->counter($result1);
												?>
												<select id="lasteditorid2" name="lasteditorid2" class="validate select2 browser-default select2-hidden-accessible <?php if (isset($lasteditorid2_valid)) {
																																										echo "is-warning";
																																									} ?>">
													<option value="">Select Last Editor</option>
													<?php
													if ($count1 > 0) {
														$row1 = $db->fetch($result1);
														foreach ($row1 as $data) { ?>
															<option value="<?php echo $data["id"] ?>" <?php if (isset($lasteditorid2) && $lasteditorid2 == $data["id"]) { ?> selected="selected" <?php } ?>><?php echo $data["fname"]; ?> <?php echo $data["lname"]; ?> (Last Editor)</option>
													<?php }
													} ?>
												</select>
											</div>
											<div class="input-field col m6 s12">
												<i class="material-icons prefix pt-2">pets</i>
												<select id="pendingparts" name="pendingparts" class="validate <?php if (isset($pendingparts_valid)) {
																													echo $pendingparts_valid;
																												} ?>">
													<option value="0" <?php if (isset($pendingparts) && $pendingparts == "0") { ?> selected="selected" <?php } ?>>No</option>
													<option value="1" <?php if (isset($pendingparts) && $pendingparts == "1") { ?> selected="selected" <?php } ?>>Yes</option>
												</select>
												<label for="pendingparts">Pending Parts</label>
											</div>
										</div>
										<div class="row">

											<div class="input-field col m6 s12">
												<?php
												$sql1 = " SELECT * FROM employee WHERE active = 1 AND subscriber_users_id = '" . $subscriber_users_id . "' ";
												$result1 = $db->query($conn, $sql1);
												$count1 = $db->counter($result1);
												?>
												<select id="assigntoid" name="assigntoid" class="validate select2 browser-default select2-hidden-accessible <?php if (isset($assigntoid_valid)) {
																																								echo "is-warning";
																																							} ?>">
													<option value="">Select Assigned</option>
													<?php
													if ($count1 > 0) {
														$row1 = $db->fetch($result1);
														foreach ($row1 as $data) { ?>
															<option value="<?php echo $data["id"] ?>" <?php if (isset($assigntoid) && $assigntoid == $data["id"]) { ?> selected="selected" <?php } ?>><?php echo $data["fname"]; ?> <?php echo $data["lname"]; ?> (Assigned)</option>
													<?php }
													} ?>
												</select>
											</div>
											<div class="input-field col m6 s12">
												<i class="material-icons prefix pt-2">pets</i>
												<select id="repeatcall" name="repeatcall" class="validate <?php if (isset($repeatcall_valid)) {
																												echo $repeatcall_valid;
																											} ?>">
													<option value="0" <?php if (isset($repeatcall) && $repeatcall == "0") { ?> selected="selected" <?php } ?>>No</option>
													<option value="1" <?php if (isset($repeatcall) && $repeatcall == "1") { ?> selected="selected" <?php } ?>>Yes</option>
												</select>
												<label for="repeatcall">Repeat Call</label>
											</div>
										</div>

										<div class="row">
											<div class="input-field col m4 s12">
												<i class="material-icons prefix">date_range</i>
												<input id="dateofservice" type="text" name="dateofservice" class="datepicker <?php if (isset($dateofservice_valid)) {
																																	echo $dateofservice_valid;
																																} ?>" value="<?php if (isset($dateofservice)) {
																																					echo $dateofservice;
																																				} ?>">
												<label for="dateofservice"> Date of Service </label>
											</div>
											<div class="input-field col m4 s12">
												<i class="material-icons prefix">attach_money</i>
												<input id="laborbilltocustomer" type="text" name="laborbilltocustomer" value="<?php if (isset($laborbilltocustomer)) {
																																	echo $laborbilltocustomer;
																																} ?>" class="validate <?php if (isset($laborbilltocustomer_valid)) {
																																							echo $laborbilltocustomer_valid;
																																						} ?>">
												<label for="laborbilltocustomer"> Labor Amount</label>
											</div>
											<div class="input-field col m4 s12">
												<i class="material-icons prefix">attach_money</i>
												<input id="partsbilltocustomer" type="text" name="partsbilltocustomer" value="<?php if (isset($partsbilltocustomer)) {
																																	echo $partsbilltocustomer;
																																} ?>" class="validate <?php if (isset($partsbilltocustomer_valid)) {
																																							echo $partsbilltocustomer_valid;
																																						} ?>">
												<label for="partsbilltocustomer"> Parts Bill Amount </label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col m12 s12">
												<i class="material-icons prefix">description</i>
												<textarea id="comment2" class="materialize-textarea validate <?php if (isset($comment2_valid)) {
																													echo $comment2_valid;
																												} ?>" name="comment2"><?php if (isset($comment2)) {
																																			echo $comment2;
																																		} ?></textarea>
												<label for="comment2">Comment</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col m4 s12"></div>
											<div class="input-field col m4 s12">
												<button class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col m12 s12" type="submit" name="add"><?php echo $btn2; ?></button>
											</div>
											<div class="input-field col m4 s12"></div>
										</div>

									</form>
								</div>

								<?php ///*
								?>
								<div class="section section-data-tables">
									<div class="row">
										<div class="col m12 s12">
											<div class="card">
												<div class="card-content">
													<div class="row">
														<div class="col m12 s12">
															<?php
															$sql_cl1 		= "	SELECT 	CONCAT(b.fname, ' ', b.lname) AS operator_name,
																						CONCAT(c.fname, ' ', c.lname) AS assign_to_name, a.*
																				FROM workorders a
																				LEFT JOIN employee b ON b.id = a.operatorid
																				LEFT JOIN employee c ON c.id = a.assigntoid
																				WHERE a.customerinfoid = '" . $id . "'";
															///echo $sql_cl1;
															$result_cl1 	= $db->query($conn, $sql_cl1);
															$count_cl1 		= $db->counter($result_cl1);
															if ($count_cl1 > 0) { ?>
																<table class="display">
																	<thead>
																		<tr>
																			<th>Work Order No </th>
																			<th>Date</th>
																			<th>Operator</th>
																			<th>Contact</th>
																			<th>Problem</th>
																			<th>Assigned To</th>
																			<th>Labor Amount</th>
																			<th>Parts Bill Amount</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																		$i = 0;
																		if ($count_cl1 > 0) {
																			$row_cl1 = $db->fetch($result_cl1);
																			foreach ($row_cl1 as $data) { ?>
																				<tr>
																					<td><?php echo $data['id']; ?></td>
																					<td>
																						<?php
																						if ($data['createdondate'] == "0000-00-00 00:00:00") {
																							$createdondate = "";
																						} else {
																							$createdondate = dateformat3($data['createdondate']);
																						}
																						echo $createdondate; ?>
																					</td>
																					<td><?php echo $data['operator_name']; ?></td>
																					<td><?php echo $data['contact']; ?></td>
																					<td><?php echo $data['problem']; ?></td>
																					<td><?php echo $data['assign_to_name']; ?></td>
																					<td><?php echo $data['laborbilltocustomer']; ?></td>
																					<td><?php echo $data['partsbilltocustomer']; ?></td>
																					<td>
																						<a class="" href="?string=<?php echo encrypt("module=" . $module . "&page=add&cmd=edit&cmd2=edit&active_tab=tab2&id=" . $id . "&detail_id=" . $data['id']) ?>">
																							<i class="material-icons dp48">edit</i>
																						</a>
																						<?php /*?>
																						&nbsp;&nbsp;
																						<a class="" href="?string=<?php echo encrypt("module=" . $module . "&page=add&cmd=edit&cmd2=delete&active_tab=tab2&id=" . $id . "&detail_id=" . $data['id']) ?>" onclick="return confirm('Are you sure, You want to delete this record?')">
																							<i class="material-icons dp48">delete</i>
																						</a>
																						<?php */ ?>
																					</td>
																				</tr>
																		<?php
																				$i++;
																			}
																		} ?>
																	</tbody>
																</table>
															<?php } ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="content-overlay"></div>
									<!-- Multi Select -->
								</div>
								<?php //*/ 
								?>
							</div>
							<!--Info Tab End-->

							<!--Tab3 Begin-->
							<div id="tab3" class="active" style="display: <?php if (!isset($active_tab) || (isset($active_tab) && $active_tab == 'tab3')) {
																				echo "block";
																			} else {
																				echo "none";
																			} ?>;">
								<div class="card-panel">
									<form class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&page=add&cmd=edit&id=" . $id . "&cmd3=" . $cmd3 . "&detail_id=" . $detail_id . "&active_tab=tab3") ?>" method="post">
										<input type="hidden" name="is_Submit_tab3" value="Y" />
										<input type="hidden" name="cmd" value="<?php if (isset($cmd)) echo $cmd; ?>" />
										<input type="hidden" name="id" value="<?php if (isset($id)) echo $id; ?>" />
										<input type="hidden" name="cmd3" value="<?php if (isset($cmd3)) echo $cmd3; ?>" />
										<input type="hidden" name="detail_id" value="<?php if (isset($detail_id)) echo $detail_id; ?>" />
										<input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
																							echo encrypt($_SESSION['csrf_session']);
																						} ?>">
										<input type="hidden" name="active_tab" value="tab3" />
										<h4>Work Order Done </h4>
										<div class="row">
											<div class="input-field col m12 s12">
												<?php
												$sql1 = "SELECT CONCAT(b.fname, ' ', b.lname) AS operator_name,
																CONCAT(c.fname, ' ', c.lname) AS assign_to_name, a.*
														FROM workorders a
														LEFT JOIN employee b ON b.id = a.operatorid 
														LEFT JOIN employee c ON c.id = a.assigntoid 
														WHERE a.customerinfoid = '" . $id . "' 
														AND a.enabled = 1 ";
												// echo $sql1;
												$result1 = $db->query($conn, $sql1);
												$count1 = $db->counter($result1);
												?>
												<select id="workorderid" name="workorderid" class="validate select2 browser-default select2-hidden-accessible <?php if (isset($workorderid_valid)) {
																																									echo "is-warning";
																																								} ?>">
													<option value="">Select Work Order</option>
													<?php
													if ($count1 > 0) {
														$row1 = $db->fetch($result1);
														foreach ($row1 as $data) { ?>
															<option value="<?php echo $data["id"] ?>" <?php if (isset($workorderid) && $workorderid == $data["id"]) { ?> selected="selected" <?php } ?>>Work Order No: <?php echo $data["id"] ?> - Date: <?php echo dateformat3($data["createdondate"]); ?> - Operator: <?php echo $data["operator_name"]; ?> - Assigned To: <?php echo $data["assign_to_name"]; ?></option>
													<?php }
													} ?>
												</select>
											</div>
											<div class="input-field col m6 s12">
												<?php
												$sql1 = " SELECT * FROM employee WHERE active = 1 AND subscriber_users_id = '" . $subscriber_users_id . "' ";
												$result1 = $db->query($conn, $sql1);
												$count1 = $db->counter($result1);
												?>
												<select id="technicianid" name="technicianid" class="validate select2 browser-default select2-hidden-accessible <?php if (isset($technicianid_valid)) {
																																									echo "is-warning";
																																								} ?>">
													<option value="">Select Technician</option>
													<?php
													if ($count1 > 0) {
														$row1 = $db->fetch($result1);
														foreach ($row1 as $data) { ?>
															<option value="<?php echo $data["id"] ?>" <?php if (isset($technicianid) && $technicianid == $data["id"]) { ?> selected="selected" <?php } ?>>Technician: <?php echo $data["fname"]; ?> <?php echo $data["lname"]; ?></option>
													<?php }
													} ?>
												</select>
											</div>
											<div class="input-field col m6 s12">
												<i class="material-icons prefix">access_time</i>
												<input id="laborhours" type="text" name="laborhours" value="<?php if (isset($laborhours)) {
																												echo $laborhours;
																											} ?>" class="validate <?php if (isset($laborhours_valid)) {
																																		echo $laborhours_valid;
																																	} ?>" required>
												<label for="laborhours">Labor Hours</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col m6 s12">
												<i class="material-icons prefix">pie_chart_outlined</i>
												<input id="contacted" type="text" name="contacted" value="<?php if (isset($contacted)) {
																												echo $contacted;
																											} ?>" class="validate <?php if (isset($contacted_valid)) {
																																		echo $contacted_valid;
																																	} ?>">
												<label for="contacted">Contacted</label>
											</div>
											<div class="input-field col m3 s12 ">
												<i class="material-icons prefix">date_range</i>
												<input id="timein_date" type="text" name="timein_date" class="datepicker <?php if (isset($timein_date_valid)) {
																																echo $timein_date_valid;
																															} ?>" value="<?php if (isset($timein_date)) {
																																				echo $timein_date;
																																			} ?>">
												<label for="timein_date"> Time In Date</label>
											</div>
											<div class="input-field col m3 s12 ">
												<i class="material-icons prefix">access_time</i>
												<input id="timein_time" type="text" name="timein_time" class="timepicker <?php if (isset($timein_time_valid)) {
																																echo $timein_time_valid;
																															} ?>" value="<?php if (isset($timein_time)) {
																																				echo $timein_time;
																																			} ?>">
												<label for="timein_time"> Time In Time</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col m6 s12">
												<i class="material-icons prefix">pie_chart_outlined</i>
												<input id="partsused" type="text" name="partsused" value="<?php if (isset($partsused)) {
																												echo $partsused;
																											} ?>" class="validate <?php if (isset($partsused_valid)) {
																																		echo $partsused_valid;
																																	} ?>">
												<label for="partsused">Parts Used</label>
											</div>
											<div class="input-field col m3 s12 ">
												<i class="material-icons prefix">date_range</i>
												<input id="timeout_date" type="text" name="timeout_date" class="datepicker <?php if (isset($timeout_date_valid)) {
																																echo $timeout_date_valid;
																															} ?>" value="<?php if (isset($timeout_date)) {
																																				echo $timeout_date;
																																			} ?>">
												<label for="timeout_date"> Time Out Date</label>
											</div>
											<div class="input-field col m3 s12 ">
												<i class="material-icons prefix">access_time</i>
												<input id="timeout_time" type="text" name="timeout_time" class="timepicker <?php if (isset($timeout_time_valid)) {
																																echo $timeout_time_valid;
																															} ?>" value="<?php if (isset($timeout_time)) {
																																				echo $timeout_time;
																																			} ?>">
												<label for="timeout_time"> Time Out Time</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col m6 s12">
												<?php
												$sql1 = " SELECT * FROM employee WHERE active = 1 AND subscriber_users_id = '" . $subscriber_users_id . "' ";
												$result1 = $db->query($conn, $sql1);
												$count1 = $db->counter($result1);
												?>
												<select id="operatorid" name="operatorid" class="validate select2 browser-default select2-hidden-accessible <?php if (isset($operatorid_valid)) {
																																								echo "is-warning";
																																							} ?>">
													<option value="">Select Operator</option>
													<?php
													if ($count1 > 0) {
														$row1 = $db->fetch($result1);
														foreach ($row1 as $data) { ?>
															<option value="<?php echo $data["id"] ?>" <?php if (isset($operatorid) && $operatorid == $data["id"]) { ?> selected="selected" <?php } ?>>Operator: <?php echo $data["fname"]; ?> <?php echo $data["lname"]; ?></option>
													<?php }
													} ?>
												</select>
											</div>
											<div class="input-field col m3 s12">
												<i class="material-icons prefix">attach_money</i>
												<input id="laboramount" type="text" name="laboramount" value="<?php if (isset($laboramount)) {
																													echo $laboramount;
																												} ?>" class="validate <?php if (isset($laboramount_valid)) {
																																			echo $laboramount_valid;
																																		} ?>">
												<label for="laboramount">Labor Amount</label>
											</div>
											<div class="input-field col m3 s12">
												<i class="material-icons prefix">attach_money</i>
												<input id="partsamount" type="text" name="partsamount" value="<?php if (isset($partsamount)) {
																													echo $partsamount;
																												} ?>" class="validate <?php if (isset($partsamount_valid)) {
																																			echo $partsamount_valid;
																																		} ?>">
												<label for="partsamount">Parts Amount</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col m12 s12">
												<i class="material-icons prefix">description</i>
												<textarea id="workdone" class="materialize-textarea validate <?php if (isset($workdone_valid)) {
																													echo $workdone_valid;
																												} ?>" name="workdone"><?php if (isset($workdone)) {
																																			echo $workdone;
																																		} ?></textarea>
												<label for="workdone">Worddone Detail</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col m4 s12"></div>
											<div class="input-field col m4 s12">
												<button class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col m12 s12" type="submit" name="add"><?php echo $btn3; ?></button>
											</div>
											<div class="input-field col m4 s12"></div>
										</div>

									</form>
								</div>

								<?php ///*
								?>
								<div class="section section-data-tables">
									<div class="row">
										<div class="col m12 s12">
											<div class="card">
												<div class="card-content">
													<div class="row">
														<div class="col m12 s12">
															<?php
															$sql_cl1 = " SELECT CONCAT(b.fname, ' ', b.lname) AS operator_name, CONCAT(d.fname, ' ', d.lname) AS technician_name,
																				CONCAT(c.fname, ' ', c.lname) AS assign_to_name, a.*, b1.id AS workorder_done_id, b1.laborhours, 
																				b1.timein, b1.timeout
																		FROM workorders a
																		INNER JOIN workdone b1 ON b1.workorderid = a.id
																		LEFT JOIN employee b ON b.id = a.operatorid
																		LEFT JOIN employee c ON c.id = a.assigntoid
																		LEFT JOIN employee d ON d.id = b1.technicianid
																		WHERE a.customerinfoid = '" . $id . "'";
															//echo $sql_cl1;
															$result_cl1 	= $db->query($conn, $sql_cl1);
															$count_cl1 		= $db->counter($result_cl1);
															if ($count_cl1 > 0) { ?>
																<table class="display">
																	<thead>
																		<tr>
																			<th>Work Order No </th>
																			<th>Technician</th>
																			<th>Labor Amount</th>
																			<th>Time</th>
																			<th>Action</th>
																			<th>Print</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																		$i = 0;
																		if ($count_cl1 > 0) {
																			$row_cl1 = $db->fetch($result_cl1);
																			foreach ($row_cl1 as $data) { ?>
																				<tr>
																					<td><?php echo $data['id']; ?></td>
																					<td><?php echo $data['technician_name']; ?></td>
																					<td><?php echo $data['laborhours']; ?></td>
																					<td>
																						<?php if ($data['timein'] != "") echo "IN: &nbsp;&nbsp;&nbsp;&nbsp;" . dateformat1_with_time_USA($data['timein']) . "<br>"; ?>
																						<?php if ($data['timein'] != "") echo "OUT: " . dateformat1_with_time_USA($data['timeout']); ?>
																					</td>
																					<td>
																						<a class="" href="?string=<?php echo encrypt("module=" . $module . "&page=add&cmd=edit&cmd3=edit&active_tab=tab3&id=" . $id . "&detail_id=" . $data['workorder_done_id']) ?>">
																							<i class="material-icons dp48">edit</i>
																						</a>
																						<?php /*?>
																						&nbsp;&nbsp;
																						<a class="" href="?string=<?php echo encrypt("module=" . $module . "&page=add&cmd=edit&cmd2=delete&active_tab=tab2&id=" . $id . "&detail_id=" . $data['id']) ?>" onclick="return confirm('Are you sure, You want to delete this record?')">
																							<i class="material-icons dp48">delete</i>
																						</a>
																						<?php */ ?>
																					</td>
																					<td>
																						<form method="post" action="components/<?php echo $module_folder_directory; ?><?php echo $module; ?>/pdf_create_files.php" target="_blank">
																							<input type="hidden" name="module" value="<?php echo $module; ?>">
																							<input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>">
																							<button type="submit" title="View Voucher" class=" waves-effect waves-light brown darken-1  btn gradient-45deg-light-green-cyan box-shadow-none border-round mr-1 mb-1">
																								<i class="material-icons dp48">print</i>
																							</button>
																						</form>
																					</td>
																				</tr>
																		<?php
																				$i++;
																			}
																		} ?>
																	</tbody>
																</table>
															<?php } ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="content-overlay"></div>
									<!-- Multi Select -->
								</div>
								<?php //*/ 
								?>
							</div>
							<!--Tab3 End-->

							<!--Tab4 Begin-->
							<div id="tab4" class="active" style="display: <?php if (!isset($active_tab) || (isset($active_tab) && $active_tab == 'tab4')) {
																				echo "block";
																			} else {
																				echo "none";
																			} ?>;">
								<div class="card-panel">
									<form class="infovalidate" action="?string=<?php echo encrypt("module=" . $module . "&page=add&cmd=edit&id=" . $id . "&cmd4=" . $cmd4 . "&detail_id=" . $detail_id . "&active_tab=tab4") ?>" method="post">
										<input type="hidden" name="is_Submit_tab4" value="Y" />
										<input type="hidden" name="cmd" value="<?php if (isset($cmd)) echo $cmd; ?>" />
										<input type="hidden" name="id" value="<?php if (isset($id)) echo $id; ?>" />
										<input type="hidden" name="cmd4" value="<?php if (isset($cmd4)) echo $cmd4; ?>" />
										<input type="hidden" name="detail_id" value="<?php if (isset($detail_id)) echo $detail_id; ?>" />
										<input type="hidden" name="csrf_token" value="<?php if (isset($_SESSION['csrf_session'])) {
																							echo encrypt($_SESSION['csrf_session']);
																						} ?>">
										<input type="hidden" name="active_tab" value="tab4" />
										<h4>Contracts </h4>
										<div class="row">
											
											<div class="input-field col m6 s12">
												<i class="material-icons prefix pt-2">person_outline</i>
												<input readonly  type="text" id="csaccountnum" value="<?php if (isset($csaccountnum)) {
																																		echo $csaccountnum;
																																	} ?>" class="validate <?php if (isset($csaccountnum_valid)) {
																																								echo $csaccountnum_valid;
																																							} ?>">
												<label for="csaccountnum">Cs Account Num</label>
											</div>
										</div>
										<div class="row">
										<div class="input-field col m3 s12 ">
												<i class="material-icons prefix">date_range</i>
												<input id="contractdate" type="text" name="contractdate" class="datepicker <?php if (isset($contractdate_valid)) {
																																echo $contractdate_valid;
																															} ?>" value="<?php if (isset($contractdate)) {
																																				echo $contractdate;
																																			} ?>">
												<label for="contractdate"> Contract Date</label>
											</div>
											<div class="input-field col m3 s12 ">
												<i class="material-icons prefix">date_range</i>
												<input id="contractexpirationdate" type="text" name="contractexpirationdate" class="datepicker <?php if (isset($contractexpirationdate_valid)) {
																																echo $contractexpirationdate_valid;
																															} ?>" value="<?php if (isset($contractexpirationdate)) {
																																				echo $contractexpirationdate;
																																			} ?>">
												<label for="contractexpirationdate"> Contract Expiration Date</label>
											</div>
										</div>
										
										<div class="row">
											<div class="input-field col m4 s12"></div>
											<div class="input-field col m4 s12">
												<button class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col m12 s12" type="submit" name="add"><?php echo $btn4; ?></button>
											</div>
											<div class="input-field col m4 s12"></div>
										</div>

									</form>
								</div>

								<?php ///*
								?>
								<div class="section section-data-tables">
									<div class="row">
										<div class="col m12 s12">
											<div class="card">
												<div class="card-content">
													<div class="row">
														<div class="col m12 s12">
															<?php
															$sql_cl1 = " SELECT id, customerinfoid, csaccountnum, contractdate, contractexpirationdate FROM contracts
																WHERE customerinfoid = '" . $id . "'";
																		
															//echo $sql_cl1;
															$result_cl1 	= $db->query($conn, $sql_cl1);
															$count_cl1 		= $db->counter($result_cl1);
															if ($count_cl1 > 0) { ?>
																<table id="page-length-option"  class="display">
																	<thead>
																		<tr>
																			
																			<th>Contract Date</th>
																			<th>Contract Expiration Date</th>
																			<th>Action</th>
																			<!-- <th>Print</th> -->
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																		$i = 0;
																		if ($count_cl1 > 0) {
																			$row_cl1 = $db->fetch($result_cl1);
																			foreach ($row_cl1 as $data) { ?>
																				<tr>
																					
																					<td><?php echo $data['contractdate']; ?></td>
																					<td><?php echo $data['contractexpirationdate']; ?></td>
																					
																					<td>
																						<a class="" href="?string=<?php echo encrypt("module=" . $module . "&page=add&cmd=edit&cmd4=edit&active_tab=tab4&id=" . $id . "&detail_id=" . $data['id']) ?>">
																							<i class="material-icons dp48">edit</i>
																						</a>
																					
																					</td>
																					<!-- <td>
																						<form method="post" action="components/<?php echo $module_folder_directory; ?><?php echo $module; ?>/pdf_create_files.php" target="_blank">
																							<input type="hidden" name="module" value="<?php echo $module; ?>">
																							<input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>">
																							<button type="submit" title="View Voucher" class=" waves-effect waves-light brown darken-1  btn gradient-45deg-light-green-cyan box-shadow-none border-round mr-1 mb-1">
																								<i class="material-icons dp48">print</i>
																							</button>
																						</form>
																					</td> -->
																				</tr>
																		<?php
																				$i++;
																			}
																		} ?>
																	</tbody>
																</table>
															<?php } ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="content-overlay"></div>
									<!-- Multi Select -->
								</div>
								<?php //*/ 
								?>
							</div>
							<!--Tab4 End-->
						</div>
					</div>
				</section>
				<?php include('sub_files/right_sidebar.php'); ?>
			</div>
		</div>
	</div><br><br>
	<!-- END: Page Main-->