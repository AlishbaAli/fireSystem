<?php
$sql_y 		= "	SELECT DISTINCT b.year_name, c.class_name, h.id, h.first_name, h.middle_name, h.last_name, 
                                g1.subject_name, i.tt_day, i.time_from, i.time_to
                FROM ".$selected_db_name.".classes_in_year a
                INNER JOIN ".$selected_db_name.".academic_years_school b ON b.id = a.academic_year_id
                INNER JOIN ".$selected_db_name.".classes c ON c.id = a.class_id
                INNER JOIN ".$selected_db_name.".section_in_class d ON d.classes_in_year_id = a.id
                INNER JOIN ".$selected_db_name.".class_sections e ON e.id = d.section_id
                LEFT JOIN ".$selected_db_name.".class_sessions f ON f.id = d.session_id
                INNER JOIN ".$selected_db_name.".subjects_of_teacher g ON g.class_section_id = d.id 
                INNER JOIN ".$selected_db_name.".subjects g1 ON g1.id = g.subject_id
                INNER JOIN ".$selected_db_name.".school_users h ON h.id = g.teacher_school_user_id
                INNER JOIN ".$selected_db_name.".time_table_detail i ON i.class_section_id = g.class_section_id AND i.subject_id = g.subject_id 
                WHERE d.enabled = 1 AND g.enabled = 1 AND i.enabled = 1
                AND a.school_admin_id 	= '".$_SESSION["school_admin_id"]."'
                AND b.id 				= '".$year_dashboard."'
                AND h.id 				= '".$t_user_id."'
                ORDER BY g1.subject_name ";  //echo $sql_y;
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
                                            <div class="container">
                                                <div class="row">
                                                <div class="col s12 m12"> 
                                                        <ol class="breadcrumbs mb-0">
                                                            <li class="breadcrumb-item active">Teacher Time Table: <?php echo $data_y['first_name'];?> <?php echo $data_y['middle_name'];?> <?php echo $data_y['last_name'];?></li>
                                                            <li class="breadcrumb-item active"><?php echo $data_y['year_name'];?></li>
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
                                    $di++;
                                }
                            }?> 
                            <table id="page-length-option" class="display dataTable dtr-inline" role="grid" aria-describedby="page-length-option_info" style="width: 1539px;">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Time</th>
                                        <th>Subject</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                    $i = 0;
                                    foreach($row_y as $data_y){?>
                                        <tr>
                                            <td>
                                                <?php 
                                                if($data_y['tt_day'] == 'Monday') echo "Week Day 1: ".$data_y['tt_day'];
                                                if($data_y['tt_day'] == 'Tuesday') echo "Week Day 2: ".$data_y['tt_day'];
                                                if($data_y['tt_day'] == 'Wednesday') echo "Week Day 3: ".$data_y['tt_day'];
                                                if($data_y['tt_day'] == 'Thursday') echo "Week Day 4: ".$data_y['tt_day'];
                                                if($data_y['tt_day'] == 'Friday') echo "Week Day 5: ".$data_y['tt_day'];
                                                if($data_y['tt_day'] == 'Saturday') echo "Week Day 6: ".$data_y['tt_day'];
                                                if($data_y['tt_day'] == 'Sunday') echo "Day 7: ".$data_y['tt_day'];
                                                ?>
                                            </td> 
                                            <td><?php echo $data_y['time_from'];?> <?php echo $data_y['time_to'];?></td> 
                                            <td><?php echo $data_y['subject_name'];?></td> 
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