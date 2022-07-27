<?php
///////////////////////// Assign DB to User ////////////////////////////
$sql2                     = " SELECT * FROM all_databases_live WHERE total_current_users < limit_no_of_users ORDER BY id ASC LIMIT 1 ";
$result2                  = $db->query($conn, $sql2);
$row2                     = $db->fetch($result2);
$selected_db_name         = $row2[0]['db_name'];
$db_id                    = $row2[0]['id'];
$total_current_users      = $row2[0]['total_current_users'] + 1;

$sql_db    = "UPDATE all_databases_live SET total_current_users = '" . $total_current_users . "' WHERE id = '" . $db_id . "' ";
$db->query($conn, $sql_db);
