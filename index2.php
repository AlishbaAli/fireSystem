<?php
$module_js = "";
$dashboard_section_classes 	= "card gradient-shadow gradient-45deg-red-pink border-radius-3 animate fadeUp";
$test_on_local 				= 1;
include('path.php');
include($directory_path . "conf/session_start.php");
include($directory_path . "conf/connection.php");
include($directory_path . "conf/functions.php");
$db 	= new mySqlDB;
if (isset($_SESSION["username"]) && isset($_SESSION["user_id"]) && isset($_SESSION["schoolDirectory"]) && $_SESSION["schoolDirectory"] == 'fireg' &&  isset($_SESSION["project_name"]) && $_SESSION["project_name"] == $project_name) {
} else {
	header("location: signin");
	exit();
}
$module = "";
$sql_d 			= "SELECT * FROM subscribers_users WHERE id = '" . $_SESSION["subscriber_users_id"] . "' AND enabled = 1 ";
//echo $sql_d; die;
$result_d 		= $db->query($conn, $sql_d);
$count_d		= $db->counter($result_d);

if ($count_d == 0) {
	header("location: 404");
	exit();
} else {
	$row_d							= $db->fetch($result_d);
	$company_name_disp				= $row_d[0]['company_name'];
	$company_logo_disp				= $row_d[0]['company_logo'];
	if ($company_logo_disp == "") {
		$company_logo_disp = "no_image.png";
	}
}
if ($_SERVER['HTTP_HOST'] == 'localhost') {
	$selected_db_name 			= $selected_for_test_on_local;
}
$_SESSION["db_name"] 	= $selected_db_name;
$company_name_array		= explode(" ", $company_name_disp);
extract($_REQUEST);
if (isset($_SESSION["username"]) && isset($_SESSION["user_id"]) && isset($_SESSION["schoolDirectory"]) && $_SESSION["schoolDirectory"] == 'fireg' &&  isset($_SESSION["project_name"]) && $_SESSION["project_name"] == $project_name) {

	$pageTitle = "FireG, Inc. Panel Dashboard"; ?>
	<!DOCTYPE html>
	<html class="loading" lang="en" data-textdirection="ltr">
	<!-- BEGIN: Head-->

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo $directory_path; ?>app-assets/images/favicon/favicon-32x32.png">

		<!-- Comment if there is no internet -->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

		<!-- BEGIN: VENDOR CSS-->
		<link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/vendors/vendors.min.css">
		<link rel="stylesheet" href="<?php echo $directory_path; ?>app-assets/vendors/select2/select2.min.css" type="text/css">
		<link rel="stylesheet" href="<?php echo $directory_path; ?>app-assets/vendors/select2/select2-materialize.css" type="text/css">

		<link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/vendors/data-tables/css/jquery.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/vendors/data-tables/css/select.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/vendors/animate-css/animate.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/vendors/chartist-js/chartist.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/vendors/chartist-js/chartist-plugin-tooltip.css">
		<!-- END: VENDOR CSS-->
		<!-- BEGIN: Page Level CSS-->
		<link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/css/themes/vertical-modern-menu-template/materialize.css">

		<link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/vendors/flag-icon/css/flag-icon.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/vendors/dropify/css/dropify.min.css">

		<!-- END: Page Level CSS-->
		<link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/css/themes/vertical-modern-menu-template/materialize.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/css/pages/page-users.min.css">

		<link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/css/themes/vertical-modern-menu-template/style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/css/pages/data-tables.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/css/pages/dashboard-modern.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/css/pages/intro.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/css/pages/form-select2.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/css/pages/page-account-settings.min.css">
		<!-- BEGIN: Custom CSS-->
		<link rel="stylesheet" type="text/css" href="<?php echo $directory_path; ?>app-assets/css/custom/custom.css">
		<!-- END: Page Level CSS-->

		<!-- Comment if there is no internet -->
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

		<style type="text/css">
			.slider_image_table tbody tr {
				cursor: all-scroll;
			}

			.departments_table tbody tr {
				cursor: all-scroll;
			}

			.popular_departments_table tbody tr {
				cursor: all-scroll;
			}

			.website_all_sub_sections tbody tr {
				cursor: all-scroll;
			}

			.website_upcoming_events_table tbody tr {
				cursor: all-scroll;
			}

			.website_course_advisor_table tbody tr {
				cursor: all-scroll;
			}
		</style>
		<?php
		$parm1 = "";
		$parm2 = "";
		$parm3 = "";
		check_session_exist4($db, $conn, $_SESSION["user_id"], $_SESSION["username"], $_SESSION["user_type"], $_SESSION["db_name"], $parm2, $parm3);
		/*
		$nav_layout 	= "sidenav-main nav-collapsible sidenav-light sidenav-active-square nav-collapsed";
		$top_nav_layout = "navbar-main navbar-color nav-collapsible navbar-dark gradient-45deg-indigo-purple no-shadow nav-collapsed";
		$nav_check 		= "radio_button_unchecked";
		$page_width 	= "main-full";
		*/

		// This is if sidebar show default for all pages ////////////
		/////////////////////////////////////////////////////////////
		$nav_layout = "sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light sidenav-active-square";
		$page_width = "";
		$nav_check 	= "radio_button_checked";
		$top_nav_layout = "navbar-main navbar-color nav-collapsible sideNav-lock navbar-dark gradient-45deg-indigo-purple no-shadow";
		/////////////////////////////////////////////////////////////

		// module page
		if (isset($string)) {
			//die;
			$parm 				= "?string=" . $string;
			$string 			= decrypt($string);
			$string_explode 	= explode('&', $string);

			$module 			= "";
			$page 				= "";
			$detail_id 			= "";
			$editmaster 		= "";
			$action 			= "";
			foreach ($string_explode as $value) {
				$string_data_explode = explode('=', $value);
				if ($string_data_explode[0] == 'module') {
					$module 			= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'module_folder') {
					$module_folder 			= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'page') {
					$page 				= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'cmd') {
					$cmd 				= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'cmd2') {
					$cmd2 				= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'cmd3') {
					$cmd3 				= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'cmd4') {
					$cmd4 				= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'cmd5') {
					$cmd5 				= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'cmd6') {
					$cmd6 				= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'cmd7') {
					$cmd7 				= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'cmd8') {
					$cmd8 				= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'cmd9') {
					$cmd9 				= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'cmd10') {
					$cmd10 				= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'cmd_detail') {
					$cmd_detail 		= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'id') {
					$id 				= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'detail_id') {
					$detail_id 			= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'class_section_id') {
					$class_section_id 	= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'editmaster') {
					$editmaster 		= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'marks_id') {
					$marks_id 			= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'subject_id') {
					$subject_id 		= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'student_profile_id') {
					$student_profile_id = $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'prev_date') {
					$prev_date 			= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'active_tab') {
					$active_tab 		= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'msg_main') {
					$msg_main 			= $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'msg_success') {
					$msg['msg_success'] = $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'error_msg') {
					$error['msg'] = $string_data_explode[1];
				}
				if ($string_data_explode[0] == 'error_msg2') {
					$error2['msg'] = $string_data_explode[1];
				}

				if ($string_data_explode[0] == 'action') {
					$action	= $string_data_explode[1];
				}
				$sql_md 		= "SELECT * FROM menus WHERE folder_name = '" . $module . "' ORDER BY id DESC LIMIT 1 ";
				$result_md 		= $db->query($conn, $sql_md);
				$count_md		= $db->counter($result_md);
				if ($count_md > 0) {
					$module_folder 				= "";
					$row_md						= $db->fetch($result_md);
					$layout_type				= $row_md[0]["layout_type"];
					$module_folder				= $row_md[0]["module_folder"];
					$menu_id					= $row_md[0]["id"];
					$_SESSION["module_folder"] 	= $module_folder;
					if ($module_folder != "") {
						$module_folder_directory = $module_folder . "/";
					} else {
						$module_folder_directory = "";
					}
					if ($layout_type == 'nav-collapsible') {
						$nav_layout = "sidenav-main nav-collapsible sidenav-light sidenav-active-square nav-collapsed";
						$page_width = "main-full";
						$nav_check 	= "radio_button_unchecked";
						$top_nav_layout = "navbar-main navbar-color nav-collapsible navbar-dark gradient-45deg-indigo-purple no-shadow nav-collapsed";
					} else {
						$nav_layout = "sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light sidenav-active-square";
						$page_width = "";
						$nav_check 	= "radio_button_checked";
						$top_nav_layout = "navbar-main navbar-color nav-collapsible sideNav-lock navbar-dark gradient-45deg-indigo-purple no-shadow";
					}
				} else {
					$nav_layout = "sidenav-main nav-collapsible sidenav-light sidenav-active-square nav-collapsed";
					$page_width = "main-full";
					$nav_check 	= "radio_button_unchecked";
					$top_nav_layout = "navbar-main navbar-color nav-collapsible navbar-dark gradient-45deg-indigo-purple no-shadow nav-collapsed";
				}
				if (isset($page) && $page == 'listing') {
					$nav_layout = "sidenav-main nav-collapsible sidenav-light sidenav-active-square nav-collapsed";
					$page_width = "main-full";
					$nav_check 	= "radio_button_unchecked";
					$top_nav_layout = "navbar-main navbar-color nav-collapsible navbar-dark gradient-45deg-indigo-purple no-shadow nav-collapsed";
				}
			}
			$sub_page 	= "components/" . $module_folder . "/" . $module . "/" . $module . "-" . $page . ".php";
			$module_js 	= "components/" . $module_folder . "/" . $module . "/" . $module . ".js";
			$check_module_permission = "";
			$check_module_permission = check_module_permission($db, $conn, $module, $_SESSION["user_id"], $_SESSION["user_type"]);
			$pageTitle 	= $check_module_permission;
			if ($check_module_permission == "") {
				header("location: signout");
			}
		} else {
			$parm = "?url=";
			$sub_page = 'components/main_content.php';
		}
		$allow_password_change	= 1;
		//sidebar-collapse    this is css class to hide side bar
		?>
		<title><?php echo $pageTitle; ?> | <?php echo PROJECT_TITLE2; ?></title>
	</head>
	<!-- END: Head-->

	<body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-modern-menu" data-col="2-columns">
		<!-- BEGIN: Header-->
		<?php
		include('sub_files/header.php');
		?>
		<!-- END: Header-->

		<!-- BEGIN: SideNav-->
		<?php include('sub_files/sidebar.php');  ?>
		<!-- END: SideNav-->
		<!-- BEGIN: Page Main-->
		<?php
		include($sub_page);
		?>
		<!-- END: Page Main-->
		<!-- Theme Customizer -->

		<!-- BEGIN: Footer-->
		<?php include("sub_files/footer.php"); ?>
		<!-- END: Footer-->
		<!-- BEGIN VENDOR JS-->
		<script src="<?php echo $directory_path; ?>app-assets/js/vendors.min.js"></script>
		<!-- BEGIN VENDOR JS-->
		<script src="<?php echo $directory_path; ?>app-assets/vendors/select2/select2.full.min.js"></script>
		<!-- BEGIN PAGE VENDOR JS-->
		<script src="<?php echo $directory_path; ?>app-assets/vendors/chartjs/chart.min.js"></script>
		<script src="<?php echo $directory_path; ?>app-assets/vendors/chartist-js/chartist.min.js"></script>
		<script src="<?php echo $directory_path; ?>app-assets/vendors/chartist-js/chartist-plugin-tooltip.js"></script>
		<script src="<?php echo $directory_path; ?>app-assets/vendors/chartist-js/chartist-plugin-fill-donut.min.js"></script>
		<!-- END PAGE VENDOR JS-->

		<!-- BEGIN PAGE VENDOR JS-->
		<script src="<?php echo $directory_path; ?>app-assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo $directory_path; ?>app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js"></script>
		<script src="<?php echo $directory_path; ?>app-assets/vendors/data-tables/js/dataTables.select.min.js"></script>
		<!-- END PAGE VENDOR JS-->
		<!-- BEGIN THEME  JS-->
		<script src="<?php echo $directory_path; ?>app-assets/js/plugins.js"></script>
		<script src="<?php echo $directory_path; ?>app-assets/js/search.js"></script>
		<script src="<?php echo $directory_path; ?>app-assets/js/custom/custom-script.js"></script>
		<script src="<?php echo $directory_path; ?>app-assets/js/scripts/customizer.js"></script>
		<!-- END THEME  JS-->
		<!-- BEGIN PAGE LEVEL JS-->
		<script src="<?php echo $directory_path; ?>app-assets/js/scripts/dashboard-modern.js"></script>
		<!-- END PAGE LEVEL JS-->
		<!-- Alert -->
		<script src="<?php echo $directory_path; ?>app-assets/js/scripts/ui-alerts.min.js"></script>
		<!-- BEGIN PAGE LEVEL JS-->
		<script src="<?php echo $directory_path; ?>app-assets/js/scripts/page-users.min.js"></script>
		<!-- BEGIN PAGE LEVEL JS-->
		<script src="<?php echo $directory_path; ?>app-assets/js/scripts/data-tables.js"></script>
		<!-- END PAGE LEVEL JS-->

		<script src="<?php echo $directory_path; ?>app-assets/vendors/dropify/js/dropify.min.js"></script>
		<script src="<?php echo $directory_path; ?>app-assets/js/scripts/form-file-uploads.min.js"></script>
		<script src="<?php echo $directory_path; ?>app-assets/js/scripts/form-select2.min.js"></script>
		<script src="<?php echo $directory_path; ?>app-assets/ckeditor/ckeditor.js"></script>
		<script src="<?php echo $directory_path; ?>assets/js/material-dialog.min.js"></script>
		<!-- END PAGE LEVEL JS-->
		<!-- END PAGE LEVEL JS-->
		<?php if ($module == 'fees' || $module == 'website_slider' || $module == 'departments' || $module == 'website_popular_departments' || $module == 'website_all_sub_sections' || $module == 'website_upcoming_events' || $module == 'website_course_advisor') { ?>
			<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<?php } ?>
	</body>

	</html>
<?php
	mysqli_close($conn);
} else {
	header("location: signin");
}
//if(isset($module) && ($module == 'roles' || $module == 'classes_in_year' || $module == 'subjects_in_class')){
?>
<script language="JavaScript">
	$(".checkbox").click(function() {
		var className = $(this).attr('class');
		var result = className.split(" ");
		$.each(result, function(key, value) {
			if (value != 'checkbox') {
				$("#" + value).prop("checked", true);
			}
		});
		var menu_id = $(this).attr("id");
		if ($(this).prop("checked")) {
			$("." + menu_id).prop("checked", true);
		} else {
			$("." + menu_id).prop("checked", false);
		}
	});
	$("#all_checked").click(function() {
		if ($(this).prop("checked")) {
			$(".checkbox").prop("checked", true);
		} else {
			$(".checkbox").prop("checked", false);
		}
	});
</script>
<?php //}
if (isset($module) && ($module == 'sub_user_roles')) { ?>
	<script language="JavaScript">
		$(".checkbox").click(function() {
			var className = $(this).attr('class');
			var result = className.split(" ");
			$.each(result, function(key, value) {
				if (value != 'checkbox') {
					$("#" + value).prop("checked", true);
				}
			});
			var menu_id = $(this).attr("id");
			if ($(this).prop("checked")) {
				$("." + menu_id).prop("checked", true);
			} else {
				$("." + menu_id).prop("checked", false);
			}
		});
		$("#all_checked").click(function() {
			if ($(this).prop("checked")) {
				$(".checkbox").prop("checked", true);
			} else {
				$(".checkbox").prop("checked", false);
			}
		});
	</script>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.timepicker').timepicker();
	});
</script>
<?php if (isset($module)) { ?>
	<script type="text/javascript">
		function change_status(e, record_id) {
			var value = $(e).html();
			value = $.trim(value);
			if (value == 'Enable') {
				value2 = 'Disable';
				value = '0';

			} else if (value == 'Disable') {
				value2 = 'Enable';
				value = '1';
			} else if (value == 'Show') {
				value = 'Disable';
				value2 = 'Hide';
			} else if (value == 'Hide') {
				value = 'Enable';
				value2 = 'Show';
			} else if (value == 'Yes') {
				value2 = 'No';
				value = '0';

			} else if (value == 'No') {
				value2 = 'Yes';
				value = '1';
			}
			MaterialDialog.dialog(
				"Do you want to change the status of the record?", {
					title: "",
					modalType: "modal-fixed-footer", // Can be empty, modal-fixed-footer or bottom-sheet
					buttons: {
						// Use by default close and confirm buttons
						close: {
							className: "blue",
							text: "Cancel",
							callback: function() {}
						},
						confirm: {
							className: "red",
							text: "Yes",
							modalClose: true,
							callback: function() {
								var module = "<?php echo $module; ?>";
								$.post('components/<?php echo $module_folder_directory; ?><?php echo $module; ?>/index.php', {
									record_id: record_id,
									type: "update",
									module: module,
									value: value
								}, function(res) {
									if (res) {
										$(e).html(value2)
									}
								});
							}
						}
					}
				}
			);
		}
	</script>
<?php }
if (file_exists($module_js)) { ?>
	<script src="<?php echo $directory_path . $module_js; ?>"></script>
<?php } ?>