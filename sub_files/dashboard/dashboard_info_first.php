<?php
$nav_layout = "sidenav-main nav-collapsible sidenav-light sidenav-active-square nav-collapsed";
$page_width = "main-full";
$nav_check 	= "radio_button_unchecked";
$top_nav_layout = "navbar-main navbar-color nav-collapsible navbar-dark gradient-45deg-indigo-purple no-shadow nav-collapsed";
if(!isset($module)){
	require_once('../../conf/functions.php');
	disallow_direct_school_directory_access();
}
$db 				= new mySqlDB;
$selected_db_name 	= $_SESSION["db_name"];
$school_admin_id 	= $_SESSION["school_admin_id"];
$school_user_id 	= $_SESSION["user_id"];
extract($_REQUEST);
foreach($_POST as $key => $value){
	if(!is_array($value)) {
		$data[$key]= remove_special_character(trim(htmlspecialchars(strip_tags(stripslashes($value)), ENT_QUOTES, 'UTF-8')));
		$$key = $data[$key];
	}
}
$sql_cl 	= "	SELECT * FROM ".$selected_db_name.".academic_years_school a 
                WHERE enabled = 1 AND school_admin_id = '".$_SESSION["school_admin_id"]."' 
                ORDER BY year_name  DESC";
$result_cl 	 = $db->query($conn, $sql_cl);
$count_cl 	 = $db->counter($result_cl);
if($count_cl == 0){ $error['msg'] = "Sorry!, No role found.";} 
$page_heading = "Academic Years and Classes";?>
	<!-- BEGIN: Page Main-->
  <div class="row">
	<div class="col s12">
	  <div class="container">
		<div class="section section-data-tables">
		  <!-- Page Length Options -->
 			  <div class="card">
				<div class="card-content">
                <table id="page-length-option" class="display">
                    <thead>
                        <tr>
                            <th class="text-align-center" width="5%">S.No</th>
                            <th class="text-align-center">Academic Year</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($count_cl > 0){
                            $i = 0;
                            $row_cl = $db->fetch($result_cl);
                            foreach($row_cl as $data){
                                $id = $data['id'];  
                                $i = $i+1;?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td>
                                        <a class="waves-effect waves-light  btn gradient-45deg-light-blue-cyan box-shadow-none border-round mr-1 mb-1" href="?year_dashboard=<?php echo $id;?>" class="">
                                            <?php echo $data['year_name'];?>
                                        </a>
                                        </td>
                                    </td>
                                </tr>
                            <?php }
                        }?>
                    </tbody>
                </table>  
			</div>
		  </div>
		  <!-- Multi Select -->
		</div><!-- START RIGHT SIDEBAR NAV -->
		<?php include('sub_files/right_sidebar.php');?>
	  </div>
	  <div class="content-overlay"></div>
	</div>
</div>