<?php
$sql_y 		= "	SELECT DISTINCT b.year_name, c.class_name, e.class_section_name, f.class_session_name, 
                        g.subject_id, g1.subject_name, h.*
                FROM ".$selected_db_name.".classes_in_year a
                INNER JOIN ".$selected_db_name.".academic_years_school b ON b.id = a.academic_year_id
                INNER JOIN ".$selected_db_name.".classes c ON c.id = a.class_id
                INNER JOIN ".$selected_db_name.".section_in_class d ON d.classes_in_year_id = a.id
                INNER JOIN ".$selected_db_name.".class_sections e ON e.id = d.section_id
                LEFT JOIN ".$selected_db_name.".class_sessions f ON f.id = d.session_id
                INNER JOIN ".$selected_db_name.".subjects_in_course g ON g.classes_in_year_id = a.id 
                INNER JOIN ".$selected_db_name.".subjects g1 ON g1.id = g.subject_id
                INNER JOIN ".$selected_db_name.".student_profile h ON h.section_detail_id = d.id AND h.admin_status = 2  
                WHERE d.enabled = 1 AND a.enabled = 1 AND g.enabled = 1 AND g1.enabled = 1
                AND a.school_admin_id 	= '".$_SESSION["school_admin_id"]."'
                AND d.id 				= '".$section_dashboard."'
                AND g1.id 				= '".$attendance_of_subject."'
                ORDER BY g1.subject_name"; //echo $sql_y;
$result_y 	= $db->query($conn, $sql_y);
$count_y 	= $db->counter($result_y);
if($count_y > 0){?>
    <div class="row">
        <div class="col s12">
            <div class="container">
		        <div class="section section-data-tables">
                    <div class="card">
				        <div class="card-content">
                            <?php  
                            $di = 0;
                            $row_y = $db->fetch($result_y);
                            foreach($row_y as $data_y){
                                if($di == 0){?>
                                    <div class="" id="breadcrumbs-wrapper">
                                        <!-- Search for small screen-->
                                        <div class="container">
                                            <div class="row">
                                                <div class="col s12 m12"> 
                                                    <ol class="breadcrumbs mb-0">
                                                        <li class="breadcrumb-item">Attendance: </li>
                                                        <li class="breadcrumb-item"><?php echo $data_y['subject_name'];?></li>
                                                        <li class="breadcrumb-item"><?php echo $data_y['class_section_name'];?> <?php echo $data_y['class_session_name'];?></li>
                                                        <li class="breadcrumb-item"><?php echo $data_y['class_name'];?></li>
                                                        <li class="breadcrumb-item"><?php echo $data_y['year_name'];?></li>
                                                        <li class="breadcrumb-item active"><a href="home?dashboard_info=1">Years</a></li>
                                                        <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>">Classes</a></li>
                                                        <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>">Sections</a></li>
                                                        <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>&section_dashboard=<?php echo $section_dashboard;?>">Section Details</a></li>
                                                        <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>&section_dashboard=<?php echo $section_dashboard;?>&attendance=1">Attendance Subjects</a></li>
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                    $di++;
                                }
                            }?>
                
                            <table id="page-length-option" class="display dataTable dtr-inline" role="grid" aria-describedby="page-length-option_info" style="width: 1539px;">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Student Detail</th>
                                        <th>Presents</th>
                                        <th>Absend</th>
                                        <th>Leave</th>
                                        <th>Total Days</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                    $i = 0;
                                    foreach($row_y as $data_y){
                                        $subject_id             = $data_y['subject_id'];
                                        $student_profile_id     = $data_y['id'];
                                        $presents = $absents    = $leaves = $total_days = "0";
                                        $sql_att 	= "	SELECT a.attendance, COUNT(*) AS total_days
                                                        FROM ".$selected_db_name.".student_subject_attendance a
                                                        WHERE a.school_admin_id 	= '".$_SESSION["school_admin_id"]."'
                                                        AND a.class_section_id		='".$section_dashboard."'
                                                        AND a.subject_id 			='".$subject_id."'
                                                        AND a.student_profile_id	='".$student_profile_id."'
                                                        AND a.enabled 				= 1
                                                        GROUP BY a.attendance
                                                        ORDER BY a.id DESC "; //echo $sql_att;exit;
                                        $result_att 	= $db->query($conn, $sql_att);
                                        $count_att 	= $db->counter($result_att);
                                        if($count_att >0 ){
                                            $row_att = $db->fetch($result_att);
                                            foreach($row_att as $data_att){
                                                if($data_att['attendance'] == '1'){
                                                    $presents 	= $data_att['total_days'];
                                                    $total_days = $total_days+$presents;
                                                }
                                                else if($data_att['attendance'] == '2'){
                                                    $absents = $data_att['total_days'];
                                                    $total_days = $total_days+$absents;
                                                }
                                                else if($data_att['attendance'] == '3'){
                                                    $leaves = $data_att['total_days'];
                                                    $total_days = $total_days+$leaves;
                                                }
                                            }
                                        } 
                                        $presents_perc = $absents_perc = $leaves_perc = "0";
                                        if($total_days > 0){
                                            $presents_perc = round((($presents/$total_days)*100));
                                            $absents_perc = round((($absents/$total_days)*100));
                                            $leaves_perc = round((($leaves/$total_days)*100));
                                        }?> 
                                        <tr>
                                            <td><?php echo $i+1;?></td> 
                                            <td>
                                                <?php nameFormat1($data_y['first_name'], $data_y['middle_name'], $data_y['last_name']);?>
                                                <br>
                                                (<?php echo $data_y['student_id'];?>)
                                            </td> 
                                            <td><?php echo $presents." (".$presents_perc."%)";?></td> 
                                            <td><?php echo $absents." (".$absents_perc."%)";?></td> 
                                            <td><?php echo $leaves." (".$leaves_perc."%)";?></td>  
                                            <td><?php echo $total_days;?></td> 
                                        </tr>
                                        <?php 
                                        $i++;
                                    }?> 
                                    </tbody>
                            </table>	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }
else{
    $sql_y 		= "	SELECT DISTINCT b.year_name, c.class_name, e.class_section_name, f.class_session_name
                    FROM ".$selected_db_name.".classes_in_year a
                    INNER JOIN ".$selected_db_name.".academic_years_school b ON b.id = a.academic_year_id
                    INNER JOIN ".$selected_db_name.".classes c ON c.id = a.class_id
                    INNER JOIN ".$selected_db_name.".section_in_class d ON d.classes_in_year_id = a.id
                    INNER JOIN ".$selected_db_name.".class_sections e ON e.id = d.section_id
                    LEFT JOIN ".$selected_db_name.".class_sessions f ON f.id = d.session_id
                    WHERE d.enabled = 1 AND a.enabled = 1
                    AND a.school_admin_id 	= '".$_SESSION["school_admin_id"]."'
                    AND d.id 				= '".$section_dashboard."' "; //echo $sql_y;
    $result_y 	= $db->query($conn, $sql_y);
    $count_y 	= $db->counter($result_y);
    if($count_y > 0){?>
        <div class="row">
            <?php 
            $row_y = $db->fetch($result_y);
            foreach($row_y as $data_y){?>  
                <div class="" id="breadcrumbs-wrapper">
                    <!-- Search for small screen-->
                    <div class="container">
                        <div class="row">
                            <div class="col s12 m12"> 
                                <ol class="breadcrumbs mb-0">
                                    <li class="breadcrumb-item">Attendance: </li>
                                    <li class="breadcrumb-item"><?php echo $data_y['class_section_name'];?> <?php echo $data_y['class_session_name'];?></li>
                                    <li class="breadcrumb-item"><?php echo $data_y['class_name'];?></li>
                                    <li class="breadcrumb-item"><?php echo $data_y['year_name'];?></li>
                                    <li class="breadcrumb-item active"><a href="home?dashboard_info=1">Years</a></li>
                                    <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>">Classes</a></li>
                                    <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>">Sections</a></li>
                                    <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>&section_dashboard=<?php echo $section_dashboard;?>">Section Details</a></li>
                                    <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>&section_dashboard=<?php echo $section_dashboard;?>&attendance=1">Attendance Subjects</a></li>
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