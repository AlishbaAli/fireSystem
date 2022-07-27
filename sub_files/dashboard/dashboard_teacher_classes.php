<?php
$sql_y 		= "	SELECT DISTINCT b.year_name, c.class_name, h.id, h.first_name, h.middle_name, h.last_name
                FROM ".$selected_db_name.".classes_in_year a
                INNER JOIN ".$selected_db_name.".academic_years_school b ON b.id = a.academic_year_id
                INNER JOIN ".$selected_db_name.".classes c ON c.id = a.class_id
                INNER JOIN ".$selected_db_name.".section_in_class d ON d.classes_in_year_id = a.id
                INNER JOIN ".$selected_db_name.".class_sections e ON e.id = d.section_id
                LEFT JOIN ".$selected_db_name.".class_sessions f ON f.id = d.session_id
                INNER JOIN ".$selected_db_name.".subjects_of_teacher g ON g.class_section_id = d.id 
                INNER JOIN ".$selected_db_name.".subjects g1 ON g1.id = g.subject_id
                INNER JOIN ".$selected_db_name.".school_users h ON h.id = g.teacher_school_user_id
                WHERE d.enabled = 1 AND g.enabled = 1
                AND a.school_admin_id 	= '".$_SESSION["school_admin_id"]."'
                AND b.id 				= '".$year_dashboard."'
                AND h.id 				= '".$t_user_id."'
                ORDER BY c.class_name ";  //echo $sql_y;
$result_y 	= $db->query($conn, $sql_y);
$count_y 	= $db->counter($result_y);
if($count_y > 0){?>
    <div class="row">
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
                                    <li class="breadcrumb-item active">Classes: <?php echo $data_y['first_name'];?> <?php echo $data_y['middle_name'];?> <?php echo $data_y['last_name'];?></li>
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
            }?>
            <div class="col s12 m3">
                <div class="<?php echo $dashboard_section_classes;?>">
                    <div class="card-content center">
                        <h5 class="white-text lighten-4">
                            <?php echo $data_y['class_name'];?>
                        </h5>
                        <img src="app-assets/images/icon/class.png" class="width-20 z-depth-5 responsive-img" alt="<?php echo $data_y['class_name'];?>" title="<?php echo $data_y['class_name'];?>" />
                    </div>
                </div>
            </div>
        <?php }?> 
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