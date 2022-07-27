<?php
$report_data = '<table class="first" cellpadding="2">
<tbody>
    <tr>  
        <td width="30px">
            <img src="../../../app-assets/images/logo/' . $company_logo . '" style="height: 60px;" alt="' . $company_name . '" title="' . $company_name . '">
        </td>
        <td width="40%">
            <h2>' . $company_name . '</h2>
        </td>
        <td width="15%"> 
            <barcode code="1111111111" type="C39" size="0.5" height="1" />
            &nbsp;&nbsp; Voucher No: 3333333333333
        </td>
        <td width="35%" rowspan="2">ddddrer ddfd</td>
    </tr>
    <tr>
        <td colspan="3" align="center" style="font-size: 10px;">COURSE FEES VOUCHER (Bank\'s Copy)</td>
    <tr>
</tbody>
</table> ';
$report_data .= ' <table class="top" cellpadding="1">
<tbody>
    <tr>   
        <td><b>Voucher Date: </b> Date 33333</td>  
        <td><b>Course: </b> ABC </td>
        <td><b>Student Name: </b> ABC</td>
        <td><b>Student ID: </b> ABC</td> 
    </tr>
</tbody>
</table> 
<table style="width:100%;">
<tr>
    <td style="width:100%;">
        <table class="first" cellpadding="1" style="width:100%;">
            <thead>
                <tr>
                    <th colspan="2">Current Billing Details</th>
                </tr>
            </thead>
            <tbody> ';
/////////////////////////////////////////// Detail ////////////////////////////////////////////
/*
$sql_cl3 = ""; //echo $sql_cl3;die;
$result_c3     = $db->query($conn, $sql_cl3);
$count_c3     = $db->counter($result_c3);
if ($count_c3 > 0) {
    $row_ee3        = $db->fetch($result_c3);
    $total_sum        = 0;
    $fee_rows        = 7;
    foreach ($row_ee3 as $data_ee3) {
        $fee_rows++;
        $fee_name        = $data_ee3['fee_name'];
        $fee_type        = $data_ee3['fee_type'];
        $fee_amount        = $data_ee3['fee_amount'];
        $total_sum        = $total_sum + $fee_amount;
        $report_data .= '<tr>  
                            <td style="width:70%; color: #000; font-weight: normal;">' . $fee_name . '</td>
                            <td style="width:30%; color: #000; font-weight: normal;" align="right">' . number_format($fee_amount, 2) . '</td>
                        </tr> ';
    }
}
$total_fee        = $total_sum;
*/
$report_data .= ' 
                <tr>  
                    <td style="width:70%;" align="left">Total Fees </td>
                    <td style="width:30%; font-size: 10px;" align="right">33434343</td>
                </tr>  
                <tr>
                    <td style="width:100%; font-size: 10px;" colspan="2">AAAA ONLY</td>
                </tr> 
            </tbody>
        </table>
    </td>
</tr> 
</table>
<table class="top" cellpadding="1">
    <tbody> 
        <tr>  
            <td style="width:20%;"></td>
            <td style="width:40%;"><br><b>Depositor Sign ______________________</b></td>
            <td style="width:40%;"><br><b>Authorized by Sign ______________________</b></td>
        </tr> 
    </tbody>
</table> 
<div style="width:100%;   border-bottom: 1px dashed;  margin-bottom: 20px;">&nbsp;</div>';  //echo $report_data;die;
