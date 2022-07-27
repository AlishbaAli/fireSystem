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
                INNER JOIN ".$selected_db_name.".lesson_plans h ON h.section_detail_id = d.id AND h.subject_id = g1.id
                WHERE d.enabled = 1 AND a.enabled = 1 AND g.enabled = 1 AND g1.enabled = 1 AND h.enabled = 1 
                AND a.school_admin_id 	= '".$_SESSION["school_admin_id"]."'
                AND d.id 				= '".$section_dashboard."'
                AND g1.id 				= '".$lesson_plan_of_subject."'
                AND h.status_id = 2
                ORDER BY h.id DESC"; //echo $sql_y;
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
                                                        <li class="breadcrumb-item">Lesson Plan: </li>
                                                        <li class="breadcrumb-item"><?php echo $data_y['subject_name'];?></li>
                                                        <li class="breadcrumb-item"><?php echo $data_y['class_section_name'];?> <?php echo $data_y['class_session_name'];?></li>
                                                        <li class="breadcrumb-item"><?php echo $data_y['class_name'];?></li>
                                                        <li class="breadcrumb-item"><?php echo $data_y['year_name'];?></li>
                                                        <li class="breadcrumb-item active"><a href="home?dashboard_info=1">Years</a></li>
                                                        <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>">Classes</a></li>
                                                        <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>">Sections</a></li>
                                                        <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>&section_dashboard=<?php echo $section_dashboard;?>">Section Details</a></li>
                                                        <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>&section_dashboard=<?php echo $section_dashboard;?>&lesson_plan=1">Lesson Plan Subjects</a></li>
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                    $di++;
                                }
                            }?> 
                            <div class="card-panel"> 
                                <div class="row">  
                                    <?php  
                                    $i = 0;
                                    foreach($row_y as $data_y){ 
                                        $lesson_title 			= $data_y['lesson_title']; 
                                        $lesson_number 			= $data_y['lesson_number']; 
                                        $lesson_goal 			= $data_y['lesson_goal']; 
                                        $learning_objective 	= $data_y['learning_objective']; 
                                        $lesson_purpose 		= $data_y['lesson_purpose']; 
                                        $key_questions 			= $data_y['key_questions']; 
                                        $lesson_materials 		= $data_y['lesson_materials']; 
                                        $lesson_notes 			= $data_y['lesson_notes'];  
                                        $status_id 				= $data_y['status_id'];  ?>

                                        
                                        <div class="row"> 
                                            <div class="input-field col m10 s12">
                                                <i class="material-icons prefix">subtitles</i>
                                                <input id="lesson_title" type="text" readonly name = "lesson_title" value="<?php if(isset($lesson_title)){ echo $lesson_title; }?>" required="" class="validate <?php if(isset($lesson_title_valid)){ echo $lesson_title_valid;}?>" >
                                                <label for="lesson_title">Title</label>
                                            </div>
                                            <div class="input-field col m2 s12">
                                                <?php 
                                                if($data_y['lesson_file'] !=""){?>
                                                    <div class = "file-field input-field">
                                                        <a download="" href="app-assets/lesson_plans/<?php echo $data_y['lesson_file'];?>" class="btn-small btn-light-indigo" title="Attachment">
                                                            <i class="material-icons">attachment</i>
                                                        </a>
                                                    </div>   
                                                <?php }?>
                                            </div>
                                        </div>
                                        <div class="row"> 
                                            <div class="input-field col m2 s12">
                                                <div class = "file-field input-field">
                                                    <b>Goal: </b><br>
                                                    <?php echo $lesson_goal;?> 
                                                </div>    
                                            </div>
                                        </div>
                                        <div class="row"> 
                                            <div class="input-field col m2 s12">
                                                <div class = "file-field input-field">
                                                    <b>Learning Objective: </b><br>
                                                    <?php echo $learning_objective;?> 
                                                </div>    
                                            </div>
                                        </div>
                                        <div class="row"> 
                                            <div class="input-field col m2 s12">
                                                <div class = "file-field input-field">
                                                    <b>Purpose/Rationale: </b><br>
                                                    <?php echo $lesson_purpose;?> 
                                                </div>    
                                            </div>
                                        </div>
                                        <div class="row"> 
                                            <div class="input-field col m2 s12">
                                                <div class = "file-field input-field">
                                                    <b>Key Questions:</b><br>
                                                    <?php echo $key_questions;?> 
                                                </div>    
                                            </div>
                                        </div>
                                        <div class="row"> 
                                            <div class="input-field col m2 s12">
                                                <div class = "file-field input-field">
                                                    <b>Materials?Resources:</b><br>
                                                    <?php echo $lesson_notes;?> 
                                                </div>    
                                            </div>
                                        </div>
                                        <div class="row"> 
                                            <div class="input-field col m2 s12">
                                                <div class = "file-field input-field">
                                                    <b>Notes:</b><br>
                                                    <?php echo $lesson_materials;?> 
                                                </div>    
                                            </div>
                                        </div>
                                        <?php 
                                        $i++;
                                    }?> 
                                </div>
                            </div> 	
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
                                    <li class="breadcrumb-item">Lesson Plan: </li>
                                    <li class="breadcrumb-item"><?php echo $data_y['class_section_name'];?> <?php echo $data_y['class_session_name'];?></li>
                                    <li class="breadcrumb-item"><?php echo $data_y['class_name'];?></li>
                                    <li class="breadcrumb-item"><?php echo $data_y['year_name'];?></li>
                                    <li class="breadcrumb-item active"><a href="home?dashboard_info=1">Years</a></li>
                                    <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>">Classes</a></li>
                                    <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>">Sections</a></li>
                                    <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>&section_dashboard=<?php echo $section_dashboard;?>">Section Details</a></li>
                                    <li class="breadcrumb-item active"><a href="home?year_dashboard=<?php echo $year_dashboard;?>&class_dashboard=<?php echo $class_dashboard;?>&section_dashboard=<?php echo $section_dashboard;?>&lesson_plan=1">Lesson Plan Subjects</a></li>
                                </ol>Lesson Plan
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