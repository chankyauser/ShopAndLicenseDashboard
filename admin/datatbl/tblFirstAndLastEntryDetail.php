 <?php 

        $db=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];
         
        if(isset($_SESSION['SAL_SHOP_QC_Type']) && !empty($_SESSION['SAL_SHOP_QC_Type'])){
            $filterType = $_SESSION['SAL_SHOP_QC_Type'];
        }

        if(isset($_SESSION['SAL_Calling_Date']) && !empty($_SESSION['SAL_Calling_Date'])){
            $DateFormat = $_SESSION['SAL_Calling_Date'];
        }

        $FirstAndLastEntryReport = array();

        if($filterType == 'ShopList'){
            $Countquery = "SELECT sm.AddedBy, um.ExecutiveName, um.Mobile, um.User_Id, 
            ISNULL((SELECT CONVERT(VARCHAR, MIN(AddedDate), 22) AS AddedDate FROM ShopMaster WHERE AddedBy = sm.AddedBy 
            AND CONVERT(VARCHAR, AddedDate, 23) = '$DateFormat' GROUP BY AddedBy),'') AS MinDate, 
            ISNULL((SELECT CONVERT(VARCHAR, MAX(AddedDate), 22) AS AddedDate FROM ShopMaster WHERE AddedBy = sm.AddedBy 
            AND CONVERT(VARCHAR, AddedDate, 23) = '$DateFormat' GROUP BY AddedBy),'') AS MaxDate,
            ISNULL((SELECT COUNT(DISTINCT(Shop_Cd))  FROM ShopMaster WHERE AddedBy = sm.AddedBy 
            AND CONVERT(VARCHAR, AddedDate, 23) = '$DateFormat' GROUP BY AddedBy),0) AS ShopCount
            
            FROM ShopMaster AS sm 
            INNER JOIN Survey_Entry_Data..User_Master AS um ON (sm.AddedBy = um.UserName) 
            WHERE CONVERT(VARCHAR, sm.AddedDate, 23) = '$DateFormat'
            GROUP BY sm.AddedBy, um.ExecutiveName, um.Mobile, um.User_Id;";
        }else if($filterType == 'ShopSurvey'){
            $Countquery = "SELECT sm.SurveyBy, um.ExecutiveName, um.Mobile, um.User_Id, 
            ISNULL((SELECT CONVERT(VARCHAR, MIN(SurveyDate), 22) AS SurveyDate FROM ShopMaster WHERE SurveyBy = sm.SurveyBy 
            AND CONVERT(VARCHAR, SurveyDate, 23) = '$DateFormat' GROUP BY SurveyBy),'') AS MinDate, 
            ISNULL((SELECT CONVERT(VARCHAR, MAX(SurveyDate), 22) AS SurveyDate FROM ShopMaster WHERE SurveyBy = sm.SurveyBy 
            AND CONVERT(VARCHAR, SurveyDate, 23) = '$DateFormat' GROUP BY SurveyBy),'') AS MaxDate,
            ISNULL((SELECT COUNT(DISTINCT(Shop_Cd)) FROM ShopMaster WHERE SurveyBy = sm.SurveyBy 
            AND CONVERT(VARCHAR, SurveyDate, 23) = '$DateFormat' GROUP BY SurveyBy),0) AS ShopCount
            FROM ShopMaster AS sm 
            INNER JOIN Survey_Entry_Data..User_Master AS um ON (sm.SurveyBy = um.UserName) 
            WHERE CONVERT(VARCHAR, sm.SurveyDate, 23) = '$DateFormat'
            GROUP BY sm.SurveyBy, um.ExecutiveName, um.Mobile, um.User_Id;";
        }else if($filterType == 'ShopCalling'){
            $Countquery = "SELECT cd.AddedByUser, um.ExecutiveName, um.Mobile, um.User_Id, 
            ISNULL((SELECT CONVERT(VARCHAR, MIN(AddedDate), 22) AS AddedDate FROM CallingDetails WHERE AddedByUser = cd.AddedByUser 
            AND CONVERT(VARCHAR, AddedDate, 23) = '$DateFormat' GROUP BY AddedByUser),'') AS MinDate, 
            ISNULL((SELECT CONVERT(VARCHAR, MAX(AddedDate), 22) AS AddedDate FROM CallingDetails WHERE AddedByUser = cd.AddedByUser 
            AND CONVERT(VARCHAR, AddedDate, 23) = '$DateFormat' GROUP BY AddedByUser),'') AS MaxDate, 
            ISNULL((SELECT COUNT(DISTINCT(Shop_Cd)) FROM CallingDetails WHERE AddedByUser = cd.AddedByUser 
            AND CONVERT(VARCHAR, AddedDate, 23) = '$DateFormat' GROUP BY AddedByUser),0) AS ShopCount 
            FROM CallingDetails AS cd 
            INNER JOIN Survey_Entry_Data..User_Master AS um ON (cd.AddedByUser = um.UserName) 
            WHERE CONVERT(VARCHAR, cd.AddedDate, 23) = '$DateFormat'
            GROUP BY cd.AddedByUser, um.ExecutiveName, um.Mobile, um.User_Id;";
        }else if($filterType == 'ShopQC'){
            $Countquery = "SELECT qd.QC_UpdatedByUser, um.ExecutiveName, um.Mobile, um.User_Id,
            ISNULL((SELECT CONVERT(VARCHAR, MIN(QC_UpdatedDate), 22) AS QC_UpdatedDate FROM QCDetails WHERE QC_UpdatedByUser = qd.QC_UpdatedByUser 
            AND CONVERT(VARCHAR, QC_UpdatedDate, 23) = '$DateFormat' GROUP BY QC_UpdatedByUser),'') AS MinDate, 
            ISNULL((SELECT CONVERT(VARCHAR, MAX(QC_UpdatedDate), 22) AS QC_UpdatedDate FROM QCDetails WHERE QC_UpdatedByUser = qd.QC_UpdatedByUser 
            AND CONVERT(VARCHAR, QC_UpdatedDate, 23) = '$DateFormat' GROUP BY QC_UpdatedByUser),'') AS MaxDate, 
            ISNULL((SELECT COUNT(DISTINCT(Shop_Cd)) FROM QCDetails WHERE QC_UpdatedByUser = qd.QC_UpdatedByUser 
            AND CONVERT(VARCHAR, QC_UpdatedDate, 23) = '$DateFormat' GROUP BY QC_UpdatedByUser),0) AS ShopCount 
            FROM QCDetails AS qd 
            INNER JOIN Survey_Entry_Data..User_Master AS um ON (qd.QC_UpdatedByUser = um.UserName) 
            WHERE CONVERT(VARCHAR, qd.QC_UpdatedDate, 23) = '$DateFormat'
            GROUP BY qd.QC_UpdatedByUser, um.ExecutiveName, um.Mobile, um.User_Id;";
        }
            
        // echo $Countquery;
        $FirstAndLastEntryReport = $db->ExecutveQueryMultipleRowSALData($Countquery, $electionName, $developmentMode);

?>


    <div class="row">
        <div class="col-12">
            <div class="card">
               <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table  class="table table-striped table-bordered complex-headers zero-configuration">
                             
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Executive Name</th>
                                        <th>Mobile No</th>
                                        <th>First Entry</th>
                                        <th>Last Entry</th>
                                        <th>Shop Count</th>
                                        <th>Loss Of Hrs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $srNo = 1;
                                        $totalShops = 0;
                                        foreach ($FirstAndLastEntryReport as $key => $value) {
                                            $totalShops = $totalShops + $value["ShopCount"];
                                            $date1 = date_create($value['MinDate']);
                                            $MinDate =  date_format($date1,"g:i A");

                                            $date2 = date_create($value['MaxDate']);
                                            $MaxDate =  date_format($date2,"g:i A");                                               
                                            $User_Id = $value['User_Id'];
                                        ?> 
                                            <tr>
                                                <td><?php echo $srNo++; ?></td>
                                                <td><?php echo $value["ExecutiveName"]; ?></td>
                                                <td><?php echo $value["Mobile"]; ?></td>
                                                <td><?php echo $MinDate; ?></td>
                                                <td><?php echo $MaxDate; ?></td>
                                                <td><?php if($value["ShopCount"]<21 && $filterType=="ShopSurvey"){ ?> <span class="badge badge-danger"><?php echo $value["ShopCount"]; ?></span> <?php }else{  ?> <?php echo $value["ShopCount"]; ?>  <?php } ?> </td>
                                                <td><a href="home.php?p=shop-loss-of-hours-details&User_Id=<?php echo $User_Id; ?>&date=<?php echo $DateFormat; ?>&filterType=<?php echo $filterType; ?>"><button class="btn btn-primary">View</button></td>
                                            </tr>
                                        <?php
                                        }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Executive Name</th>
                                        <th>Mobile No</th>
                                        <th>First Entry</th>
                                        <th>Last Entry</th>
                                        <th><?php echo $totalShops; ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
