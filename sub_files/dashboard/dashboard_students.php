<?php
$sql_y 		= "	SELECT DISTINCT b.year_name, c.class_name, e.class_section_name, f.class_session_name, g.id, g.student_id, g.first_name, g.middle_name, g.last_name, g.profile_pic
                FROM ".$selected_db_name.".classes_in_year a
                INNER JOIN ".$selected_db_name.".academic_years_school b ON b.id = a.academic_year_id
                INNER JOIN ".$selected_db_name.".classes c ON c.id = a.class_id
                INNER JOIN ".$selected_db_name.".section_in_class d ON d.classes_in_year_id = a.id
                INNER JOIN ".$selected_db_name.".class_sections e ON e.id = d.section_id
                LEFT JOIN ".$selected_db_name.".class_sessions f ON f.id = d.session_id
                INNER JOIN ".$selected_db_name.".student_profile g ON g.section_detail_id = d.id 
                WHERE d.enabled 		= 1
                AND a.school_admin_id 	= '".$_SESSION["school_admin_id"]."'
                AND d.id 				= '".$section_dashboard."'
                ORDER BY g.first_name, g.middle_name, g.last_name"; //echo $sql_y;
$result_y 	= $db->query($conn, $sql_y);
$count_y 	= $db->counter($result_y);
if($count_y > 0){?>
    <div class="row">
        <?php  
        $di = 0;
        $row_y = $db->fetch($result_y);
        foreach($row_y as $data_y){
            if($data_y['profile_pic'] == "" || $data_y['profile_pic'] == NULL) $profile_pic = "no_image.png";
            else $profile_pic = $data_y['profile_pic'];
            if($di == 0){?>
                <div class="" id="breadcrumbs-wrapper">
                    <!-- Search for small screen-->
                    <div class="container">
                        <div class="row">
                            <div class="col s12 m12"> 
                                <ol class="breadcrumbs mb-0">
                                    <li class="breadcrumb-item">Students: </li>
                                    <li class="breadcrumb-item"><?php echo $data_y['class_section_name'];?> <?php echo $data_y['class_session_name'];?></li>
                                    <li class="breadcrumb-item"><?php echo $data_y['class_name'];?></li>
                                    <li class="breadcrumb-item"><?php echo $data_y['year_name'];?></li>
                                    <li class="breadcrumb-item active"><a href="home?dashboard_info=1">Years</a></li>
                                    <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>">Classes</a></li>
                                    <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>">Sections</a></li>
                                    <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>&section_dashboard=<?php echo $section_dashboard;?>">Section Details</a></li>
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
                        <img src="app-assets/images/students/<?php echo $profile_pic;?>" class="width-30 border-round z-depth-5 responsive-img" title="<?php echo $data_y['first_name'];?> <?php echo $data_y['middle_name'];?> <?php echo $data_y['last_name'];?>" alt="<?php echo $data_y['first_name'];?> <?php echo $data_y['middle_name'];?> <?php echo $data_y['last_name'];?>">
                        <p class="white-text lighten-4">
                            <h5 class="white-text lighten-4">
                                <?php nameFormat1($data_y['first_name'], $data_y['middle_name'], $data_y['last_name']);?>
                                <br>(<?php echo $data_y['student_id'];?>) 
                            </h5>
                        </p>
                    </div>
                </div>
            </div>
        <?php }?> 
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
                    WHERE d.enabled 		= 1
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
                            <div class="col s10 m6 l6">
                                <ol class="breadcrumbs mb-0">
                                    <li class="breadcrumb-item">Students: </li>
                                    <li class="breadcrumb-item"><?php echo $data_y['class_section_name'];?> <?php echo $data_y['class_session_name'];?></li>
                                    <li class="breadcrumb-item"><?php echo $data_y['class_name'];?></li>
                                    <li class="breadcrumb-item"><?php echo $data_y['year_name'];?></li>
                                    <li class="breadcrumb-item active"><a href="home?dashboard_info=1">Years</a></li>
                                    <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>">Classes</a></li>
                                    <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>">Sections</a></li>
                                    <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>&section_dashboard=<?php echo $section_dashboard;?>">Section Details</a></li>
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