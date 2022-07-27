<?php
$sql_y 		= "	SELECT * FROM ".$selected_db_name.".academic_years_school a 
                WHERE enabled = 1 AND school_admin_id = '".$_SESSION["school_admin_id"]."' ORDER BY year_name ";
$result_y 	= $db->query($conn, $sql_y); //echo $sql_y;
$count_y 	= $db->counter($result_y);
if($count_y > 0){?>
    <div class="row">
        <?php 
        $row_y = $db->fetch($result_y);
        foreach($row_y as $data_y){?> 
            <a href="?year_dashboard=<?php echo $data_y['id'];?>" class="">
                <div class="col s12 m2">
                    <div class="card gradient-shadow dashboard_button_bg border-radius-3 animate fadeUp">
                        <div class="card-content center">
                            <h5 class="white-text lighten-4"><?php echo $data_y['year_name'];?></h5>
                        </div>
                    </div>
                </div>
            </a>
        <?php } ?>  
    </div>
<?php }?>