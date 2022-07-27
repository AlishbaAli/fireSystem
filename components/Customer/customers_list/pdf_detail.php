<?php
$report_data = '<table class="first" cellpadding="2">
                    <tbody>
                        <tr>  
                            <td height="80px" width="2%">
                                <img src="../../../app-assets/images/logo/' . $company_logo . '"  alt="' . $company_name . '" title="' . $company_name . '">
                            </td>
                            <td width="58%">
                                <h2>' . $company_name . '</h2>
                            </td>
                            <td width="40%" align="center" class="withborders" rowspan="2"><span class="uic">Service Order</span><br> <b>' . $workorder_id . '</td>
                        </tr>
                    </tbody>
                </table> <br>';
$report_data .= ' <table class="top" cellpadding="1">
                    <tbody>
                        <tr>   
                            <td width="25%"></td>  
                            <td width="25%"></td>
                            <td width="25%"><b></b> RM</td>
                            <td width="25%"><b> </b> ' . $createdondate . '  </td> 
                        </tr>
                    </tbody>
                </table> 
                <table style="width:100%;">
                    <tbody>
                        <tr>
                            <td height="80px"  width="100%" class="withborders">
                                <table >
                                    <tbody> 
                                        <tr>     
                                            <td width="33%">
                                                <table>
                                                    <tr><td><span class="uic"><b>' . $cust_name . ' C/O &nbsp; </span></td></tr>
                                                    <tr><td>' . $suite . ', ' . $streetnumber . ', ' . $streetname . ', ' . $city_name . ', ' . $state_name . '</td></tr>
                                                    <tr><td>' . $zipcode . '</td></tr>
                                                    <tr><td>' . $phonenumber . '</td></tr>
                                                </table>
                                            </td>
                                            <td width="33%">
                                                <table>
                                                    <tr><td align="right">Central #</td></tr>
                                                    <tr><td align="right">Billing #</td></tr>
                                                    <tr><td align="right">Salesman</td></tr>
                                                    <tr><td align="right">Type of System</td></tr>
                                                </table>
                                            </td>
                                            <td width="33%">
                                                <table>
                                                    <tr><td>......</td></tr>
                                                    <tr><td>......</td></tr>
                                                    <tr><td>......</td></tr>
                                                    <tr><td>......</td></tr>
                                                </table>
                                            </td> 
                                        </tr>
                                    </tbody>
                                </table> 
                            </td>     
                        </tr> 
                    </tbody>
                </table>
                <br>
                <span> <b> <u>Account Comments </span> <br>' . $comments . ' <br><br>
                <table>
                    <tbody>  
                        <tr>  
                            <td style="width: 30%;"><span> <b>Contact:</td>
                            <td>' . $contact . '</td>
                        </tr>  
                    </tbody>
                </table> <br><br>
                <span> <b> <u> SERVICE REQUEST </span> <br> ' . $problem . '
              
                <div style="width:100%;   border-bottom: 1px dashed;  margin-bottom: 20px;">&nbsp;</div>';  //echo $report_data;die;

            // <table style="width:100%;" class="bord" >
            //     <thead>
            //         <tr>
            //             <th width="50%"></th>
            //             <th width="10%"></th>
            //             <th width="10%"></th>
            //             <th width="10%"></th>
            //             <th width="10%"></th>
            //         </tr>
            //     </thead>
            //     <tbody>
            //         <tr>  
            //             <td>. </td>
            //             <td>. </td>
            //             <td>. </td>
            //             <td>. </td>
            //             <td>. </td>
            //             </tr>
            //             <tr>  
            //             <td>. </td>
            //             <td>. </td>
            //             <td>. </td>
            //             <td>. </td>
            //             <td>. </td>
            //             </tr>
            //             <tr>  
            //             <td>. </td>
            //             <td>. </td>
            //             <td>. </td>
            //             <td>. </td>
            //             <td>. </td>
            //             </tr>
            //             <tr>  
            //             <td>. </td>
            //             <td>. </td>
            //             <td>. </td>
            //             <td>. </td>
            //             <td>. </td>
            //         </tr>
            //     </tbody>
            // </table>