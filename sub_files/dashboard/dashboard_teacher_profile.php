<?php
$sql_y 		= "	SELECT a.*, b.reg_status, c.major_subject, d.education_level
                FROM ".$selected_db_name.".school_users a 
                LEFT JOIN school_status b ON b.id = a.reg_status
                LEFT JOIN majors_in_degree c ON c.id = a.major_subject
                LEFT JOIN education_levels d ON d.id = a.education_level
                WHERE a.school_admin_id = '".$_SESSION["school_admin_id"]."'
                AND a.id 				= '".$t_user_id."'   ";  //echo $sql_y;
$result_y 	= $db->query($conn, $sql_y);
$count_y 	= $db->counter($result_y);
if($count_y > 0){?>
    <div class="row">
        <div class="col s12">
            <div class="container">
		        <div class="section section-data-tables">
                    <div class="card">
				        <div class="card-content">

                            <div class="" id="breadcrumbs-wrapper">
                                <div class="container">
                                    <div class="row">
                                        <div class="col s12 m12"> 
                                            <ol class="breadcrumbs mb-0">
                                                <li class="breadcrumb-item active">Teacher Profile</li>
                                                <li class="breadcrumb-item active"><a href="home?dashboard_info=1">Years</a></li>
                                                <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>">Classes</a></li>
                                                <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>">Sections</a></li>
                                                <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>&section_dashboard=<?php echo $section_dashboard;?>">Section Detail</a></li>
                                                <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>&section_dashboard=<?php echo $section_dashboard;?>&teacher=1">Teachers</a></li>
                                                <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>&section_dashboard=<?php echo $section_dashboard;?>&teacher=1&t_user_id=<?php echo $t_user_id;?>">Teacher Details</a></li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <?php  
                            $di = 0;
                            $row_y = $db->fetch($result_y);
                            foreach($row_y as $data_y){ 
                                
                                $teacher_name_full 			= $data_y['first_name']." ".$data_y['middle_name']." ".$data_y['last_name'];
                                $teacher_picture 			= $data_y['profile_pic'];
                                $teacher_id 				= $data_y['id'];
                                $t_username 				= $data_y['username'];
                                $t_email 					= $data_y['email'];
                                $t_phone_no 				= $data_y['phone_no'];
                                $t_date_of_birth 			= dateformat1($data_y['date_of_birth']);
                                $t_gender 					= $data_y['gender'];
                                $t_education_level 			= $data_y['education_level'];
                                $t_u_degree 				= $data_y['u_degree'];
                                $t_major_subject 			= $data_y['major_subject'];
                                $t_emergency_contact_name	= $data_y['emergency_contact_name'];
                                $t_emergency_contact_number	= $data_y['emergency_contact_number']; ?>

                                <div class="card-panel"> 
                                    <div class="divider mb-1 mt-1"></div> 
                                    <div class="row"> 
                                        <div class="col s6">
                                            <div class="input-field">
                                                <label for="uname" class="active">Username</label>
                                                <input type="text" id="t_username" name="t_username" readonly value="<?php echo $t_username;?>" data-error=".errorTxt1">
                                                <small class="errorTxt1"></small>
                                            </div>
                                        </div>
                                        <div class="col s6">
                                            <div class="input-field">
                                                <label for="uname" class="active">Email</label>
                                                <input type="text" id="t_email" name="t_email" readonly value="<?php echo $t_email;?>" data-error=".errorTxt1">
                                                <small class="errorTxt1"></small>
                                            </div>
                                        </div>
                                        <div class="col s6">
                                            <div class="input-field">
                                            <label for="uname" class="active">Phone</label>
                                            <input type="text" id="t_phone_no" name="t_phone_no" readonly value="<?php echo $t_phone_no;?>" data-error=".errorTxt1">
                                            <small class="errorTxt1"></small>
                                            </div>
                                        </div>
                                        <div class="col s6">
                                            <div class="input-field">
                                                <label for="uname" class="active">Date of Birth</label>
                                                <input type="text" id="t_date_of_birth" name="t_date_of_birth" readonly value="<?php echo $t_date_of_birth;?>" data-error=".errorTxt1">
                                                <small class="errorTxt1"></small>
                                            </div>
                                        </div>
                                        <div class="col s6">
                                            <div class="input-field">
                                                <label for="uname" class="active">Gender</label>
                                                <input type="text" id="t_gender" name="t_gender" readonly value="<?php echo $t_gender;?>" data-error=".errorTxt1">
                                                <small class="errorTxt1"></small>
                                            </div>
                                        </div>
                                        <div class="col s6">
                                            <div class="input-field">
                                                <label for="uname" class="active">Education Level</label>
                                                <input type="text" id="t_education_level" name="t_education_level" readonly value="<?php echo $t_education_level;?>" data-error=".errorTxt1">
                                                <small class="errorTxt1"></small>
                                            </div>
                                        </div>
                                        <div class="col s6">
                                            <div class="input-field">
                                                <label for="uname" class="active">Degree</label>
                                                <input type="text" id="t_u_degree" name="t_u_degree" readonly value="<?php echo $t_u_degree;?>" data-error=".errorTxt1">
                                                <small class="errorTxt1"></small>
                                            </div>
                                        </div>
                                        <div class="col s6">
                                            <div class="input-field">
                                                <label for="uname" class="active">Major Subject</label>
                                                <input type="text" id="t_major_subject" name="t_major_subject" readonly value="<?php echo $t_major_subject;?>" data-error=".errorTxt1">
                                                <small class="errorTxt1"></small>
                                            </div>
                                        </div>
                                        <div class="col s6">
                                            <div class="input-field">
                                                <label for="uname" class="active">Emergency Contact Person</label>
                                                <input type="text" id="t_emergency_contact_name" name="t_emergency_contact_name" readonly value="<?php echo $t_emergency_contact_name;?>" data-error=".errorTxt1">
                                                <small class="errorTxt1"></small>
                                            </div>
                                        </div>
                                        <div class="col s6">
                                            <div class="input-field">
                                                <label for="uname" class="active">Emergency Contact Number</label>
                                                <input type="text" id="t_emergency_contact_number" name="t_emergency_contact_number" readonly value="<?php echo $t_emergency_contact_number;?>" data-error=".errorTxt1">
                                                <small class="errorTxt1"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            <?php }?> 	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }
else{
    $sql_y 		= "	SELECT DISTINCT h.id, h.first_name, h.middle_name, h.last_name
                    FROM ".$selected_db_name.".school_users h 
                    WHERE h.enabled 		= 1
                    AND h.school_admin_id 	= '".$_SESSION["school_admin_id"]."'
                    AND h.id 				= '".$t_user_id."'"; //echo $sql_y;
    $result_y 	= $db->query($conn, $sql_y);
    $count_y 	= $db->counter($result_y);
    if($count_y > 0){?>
        <div class="row">
            <?php 
            $row_y = $db->fetch($result_y);
            foreach($row_y as $data_y){?> 
                <div class="" id="breadcrumbs-wrapper">
                    <div class="container">
                        <div class="row">
                        <div class="col s12 m12"> 
                                <ol class="breadcrumbs mb-0">
                                    <li class="breadcrumb-item active">Classes: <?php echo $data_y['first_name'];?> <?php echo $data_y['middle_name'];?> <?php echo $data_y['last_name'];?></li>
                                    <li class="breadcrumb-item active"><a href="home?dashboard_info=1">Years</a></li>
                                    <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>">Classes</a></li>
                                    <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>">Sections</a></li>
                                    <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>&section_dashboard=<?php echo $section_dashboard;?>">Section Detail</a></li>
                                    <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>&section_dashboard=<?php echo $section_dashboard;?>&teacher=1">Teachers</a></li>
                                    <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>&section_dashboard=<?php echo $section_dashboard;?>&teacher=1&t_user_id=<?php echo $t_user_id;?>">Teacher Details</a></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div> 
            <?php }?>
            <div class="col s12 m12">
                <div class="<?php echo $dashboard_section_classes;?>">
                    <div class="card-content center">
                        <p class="white-text lighten-4">No data found</p>
                    </div>
                </div>
            </div>
        </div>
    <?php }
    else{?>
        <div class="row">
            <div class="col s12 m12">
                <div class="<?php echo $dashboard_section_classes;?>">
                    <div class="card-content center">
                        <p class="white-text lighten-4">No data found</p>
                    </div>
                </div>
            </div>
        </div>
    <?php }
}?>