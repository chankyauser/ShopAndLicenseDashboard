<section id="dashboard-analytics">

<?php
    
    function dateDiffInDays($date1, $date2) 
    {
        // Calculating the difference in timestamps
        $diff = strtotime($date2) - strtotime($date1);
    
        // 1 day = 24 hours
        // 24 * 60 * 60 = 86400 seconds
        return abs(round($diff / 86400));
    }

        $db=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];
        // $currentDate1 = date('Y-m-d', strtotime('-365 days'));;
        $currentDate = date('Y-m-d');
        $fromDate = "";
        $toDate = "";

        if(
            (isset($_POST['fromDate']) && !empty($_POST['fromDate'])) && 
            (isset($_POST['toDate']) && !empty($_POST['toDate']))
           ){

            $frDate = $_POST['fromDate'];
            $tDate = $_POST['toDate'];

                if($tDate < $frDate)
                {
                    $frDate = $_POST['fromDate'];
                    $tDate = $_POST['fromDate'];

                    $fromDate = $_POST['fromDate']." ".$_SESSION['StartTime'];
                    $toDate = $_POST['fromDate']." ".$_SESSION['EndTime'];
                }
                else {
                    
                    $frDate = $_POST['fromDate'];
                    $tDate = $_POST['toDate'];

                    $fromDate = $_POST['fromDate']." ".$_SESSION['StartTime'];
                    $toDate = $_POST['toDate']." ".$_SESSION['EndTime'];
                }
           }
           else {
                    $frDate = $currentDate;
                    $tDate = $currentDate;
                    $fromDate = $currentDate." ".$_SESSION['StartTime'];
                    $toDate = $currentDate." ".$_SESSION['EndTime'];
                }
        
  ?>
    <?php
    $db2=new DbOperation();
      $userName=$_SESSION['SAL_UserName'];
      $appName=$_SESSION['SAL_AppName'];
      $electionName=$_SESSION['SAL_ElectionName'];
      $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $query2 = "SELECT
            (SELECT ISNULL(count(*),0) FROM PocketMaster WHERE IsActive = 1) as PocketsTotal,
            (SELECT ISNULL(count(*),0) FROM ShopMaster WHERE IsActive = 1) as ShopsTotal,
            (SELECT 
            count(distinct(td.Shop_Cd))
            FROM TransactionDetails td 
            WHERE td.Shop_Cd is not null
            and TransStatus = 'Done') as ShopLicensee,
            (SELECT ISNULL(count(*),0) 
            FROM ShopMaster as sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            WHERE sm.IsActive = 1 
            AND nm.IsActive = 1
            AND pm.IsActive = 1 
            AND SurveyDate is not null 
            AND ( 
            ISNULL(sm.ShopStatus,'') = '' OR
            sm.ShopStatus in 
            (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' 
            AND IsActive = 1) ) ) as SurveyCompleted,
            (SELECT count(distinct(sm.Pocket_Cd)) FROM ShopMaster sm, PocketMaster pm WHERE sm.Pocket_Cd = pm.Pocket_Cd AND pm.IsCompleted = 1 AND sm.IsActive = 1) as SurveyPockets,
            (SELECT 
            sum(cast (Amount as int))
            FROM TransactionDetails td 
            WHERE td.Shop_Cd is not null
            and TransStatus = 'Done') as RevenueCollected
 ";
$dataSummary2 = $db2->ExecutveQuerySingleRowSALData($query2, $electionName, $developmentMode);

?>

    <div class="row match-height">
        <div class="col-xl-6 col-md-6 col-12">
            <div class="card card-congratulation-medal">
                <div class="card-header">
                    <h5 class="card-title">Welcome <?php echo $_SESSION['SAL_FullName']; ?>!</h5>
                    <div class="d-flex align-items-center">
                        <p class="card-text font-small-2 mr-25 mb-0"></p>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-md-6 col-sm-12 col-12 mb-2 mb-xl-0">
                            <div class="media">
                                <div class="avatar bg-light-danger p-50  mr-2">
                                    <div class="avatar-content">
                                        <i class="feather icon-pocket avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="media-body my-auto">
                                    <!-- <h4 class="font-weight-bolder mb-0">223</h4> -->
                                    <h4 class="font-weight-bolder mb-0"><?php echo $dataSummary2["PocketsTotal"]; ?></h4>
                                    <p class="card-text font-small-4 mb-0">Pockets Listed</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6 col-sm-12 col-12 mb-2 mb-sm-0">
                            <a href="home.php?p=pocket-wise-shops-list&dateFilter=All">
                                <div class="media">
                                    <div class="avatar bg-light-primary p-50  mr-2">
                                        <div class="avatar-content">
                                            <i class="feather icon-shopping-bag avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto">
                                        <!-- <h4 class="font-weight-bolder mb-0">3,230</h4> -->
                                        <h4 class="font-weight-bolder mb-0"><?php echo $dataSummary2["ShopsTotal"]; ?></h4>
                                        <p class="card-text font-small-4 mb-0">Shops Listed</p>
                                    </div>
                                </div>
                            </a>
                        </div>


                        <div class="col-xl-6 col-md-6 col-sm-12 col-12 mb-2 mb-sm-0" style="margin-top: 15px;">
                            <div class="media">
                                <div class="avatar bg-light-primary p-50  mr-2">
                                    <div class="avatar-content">
                                        <i class="feather icon-user avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="media-body my-auto">
                                    <!-- <h4 class="font-weight-bolder mb-0">2,130</h4> -->
                                    <h4 class="font-weight-bolder mb-0"><?php echo $dataSummary2["SurveyPockets"]; ?></h4>
                                    <p class="card-text font-small-4 mb-0">Pockets Completed </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6 col-sm-12 col-12 mb-2 mb-xl-0" style="margin-top: 15px;">
                            <div class="media">
                                <div class="avatar bg-light-danger p-50  mr-2">
                                    <div class="avatar-content">
                                        <i class="feather icon-map-pin avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="media-body my-auto">
                                    <!-- <h4 class="font-weight-bolder mb-0">3,230</h4> -->
                                    <h4 class="font-weight-bolder mb-0"><?php echo $dataSummary2["SurveyCompleted"]; ?></h4>
                                    <p class="card-text font-small-4 mb-0">Shops Surveyed</p>
                                </div>
                            </div>
                        </div> 
                        
                  </div>
                </div>
            </div>
        </div>
      
   
        <div class="col-xl-6 col-md-6 col-12">
            <div class="card card-statistics">
                <div class="card-header">
                    <h5 class="card-title">Revenue Statistics</h5>
                    <div class="d-flex align-items-center">
                        <p class="card-text font-small-2 mr-25 mb-0"></p>
                    </div>
                </div>
                <div class="card-body statistics-body">
                    <div class="row"> 

                        
                        <div class="col-xl-6 col-md-6 col-sm-12 col-12 mb-2 mb-sm-0">
                            <div class="media">
                                <div class="avatar bg-light-danger p-50  mr-2">
                                    <div class="avatar-content">
                                        <i class="feather icon-map-pin avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="media-body my-auto">
                                    <!-- <h4 class="font-weight-bolder mb-0">3,230</h4> -->
                                    <h4 class="font-weight-bolder mb-0"><?php echo $dataSummary2["ShopLicensee"]; ?></h4>
                                    <p class="card-text font-small-4 mb-0">Shop Licensee</p>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-xl-6 col-md-6 col-sm-12 col-12  mb-2 mb-xl-0">
                            <div class="media">
                                <div class="avatar bg-light-success p-50  mr-2">
                                    <div class="avatar-content">
                                        <i class="feather icon-dollar-sign avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="media-body my-auto">
                                    <!-- <h4 class="font-weight-bolder mb-0">₹ 9,74,500</h4> -->
                                    <h4 class="font-weight-bolder mb-0">₹ <?php echo $dataSummary2["RevenueCollected"]; ?></h4>
                                    <p class="card-text font-small-4 mb-0">Revenue Collected</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6 col-sm-12 col-12 mb-2 mb-xl-0"  style="margin-top: 15px;">
                            <a href="home.php?p=shop-license-defaulters-detail">
                                <div class="media">
                                    <div class="avatar bg-light-primary p-50 mr-2">
                                        <div class="avatar-content">
                                            <i class="feather icon-user-x avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto">
                                        <h4 class="font-weight-bolder mb-0">0</h4>
                                        <p class="text-danger font-small-4 mb-0">License Defaulters</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                         <div class="col-xl-6 col-md-6 col-sm-12 col-12 mb-2 mb-xl-0" style="margin-top: 15px;">
                            <div class="media">
                                <div class="avatar bg-light-primary p-50 mr-2">
                                    <div class="avatar-content">
                                        <i class="feather icon-user-x avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="media-body my-auto">
                                    <h4 class="font-weight-bolder mb-0">0</h4>
                                    <p class="text-success font-small-4 mb-0">Licensee Helped</p>
                                </div>
                            </div>
                        </div> 

                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        

        
      

<?php
    $db4=new DbOperation();
      $userName=$_SESSION['SAL_UserName'];
      $appName=$_SESSION['SAL_AppName'];
      $electionName=$_SESSION['SAL_ElectionName'];
      $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $query4 = "SELECT
        (select ISNULL(convert(VARCHAR,max(ShopStatusDate),121),'') From ShopMaster WHERE IsActive = 1) as LastShopStatusUpdated,
        (select ISNULL(sum(case when isnull(ShopStatus,'') = 'Verified' then 1 else 0 end),0) from ShopMaster WHERE IsActive = 1) as Verified,
        (select ISNULL(sum(case when isnull(ShopStatus,'') = 'In-Review' then 1 else 0 end),0) from ShopMaster WHERE IsActive = 1) as In_Review,
        (select ISNULL(sum(case when (isnull(ShopStatus,'') = '' OR  isnull(ShopStatus,'') = 'Pending') then 1 else 0 end),0) from ShopMaster WHERE IsActive = 1) as Pending,
        (select ISNULL(sum(case when isnull(ShopStatus,'') = 'Rejected' then 1 else 0 end),0) from ShopMaster WHERE IsActive = 1) as Rejected ";
    $dataSummary4 = $db->ExecutveQuerySingleRowSALData($query4, $electionName, $developmentMode);

?>
       <!--  <div class="col-xl-6 col-md-6 col-12">
            <div class="card card-statistics">
                <div class="card-header">
                    <h5 class="card-title">Shop : Survey Summary</h5>
                    <div class="d-flex align-items-center">
                         <p class="card-text font-small-2 mr-25 mb-0">
                            <?php 
                                if(!empty($dataSummary4["LastShopStatusUpdated"])){
                                    echo "Last Status Updated on ".date('d/m/Y h:i a',strtotime($dataSummary4["LastShopStatusUpdated"]));
                                }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="card-body statistics-body">
                    <div class="row">

                        <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                            <div class="media">
                                <div class="avatar bg-light-primary p-50  mr-2">
                                    <div class="avatar-content">
                                        <i class="feather icon-check avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="media-body my-auto">
                                    <h4 class="font-weight-bolder mb-0"><?php echo $dataSummary4["Verified"]; ?></h4>
                                    <p class="text-success font-small-4 mb-0">Verified</p>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                            <div class="media">
                                <div class="avatar bg-light-success p-50  mr-2">
                                    <div class="avatar-content">
                                        <i class="feather icon-anchor avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="media-body my-auto">
                                    <h4 class="font-weight-bolder mb-0"><?php echo $dataSummary4["Pending"]; ?></h4>
                                    <p class="text-warning font-small-4 mb-0">Pending</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6 col-sm-12 col-12"  style="margin-top:15px;">
                            <div class="media">
                                <div class="avatar bg-light-primary p-50  mr-2">
                                    <div class="avatar-content">
                                        <i class="feather icon-play avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="media-body my-auto">
                                    <h4 class="font-weight-bolder mb-0"><?php echo $dataSummary4["In_Review"]; ?></h4>
                                    <p class="text-info font-small-4 mb-0">In-Review</p>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-xl-6 col-md-6 col-sm-12 col-12"  style="margin-top:15px;">
                            <div class="media">
                                <div class="avatar bg-light-success p-50  mr-2">
                                    <div class="avatar-content">
                                        <i class="feather icon-alert-triangle avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="media-body my-auto">
                                    <h4 class="font-weight-bolder mb-0"><?php echo $dataSummary4["Rejected"]; ?></h4>
                                    <p class="text-danger font-small-4 mb-0">Rejected</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
 -->
<?php
    $db5=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $query5 = "SELECT
(SELECT ISNULL(CONVERT(VARCHAR,max(Call_DateTime),121),'') FROM CallingDetails) as LastShopCallDateTime,
(SELECT ISNULL(SUM(CASE WHEN ISNULL(sdt.Calling_Category_Cd,0) = 2 AND ISNULL(cdt.Call_Response_Cd,0) = 4 THEN 1 ELSE 0 END),0) FROM CallingDetails cdt, ScheduleDetails sdt WHERE sdt.ScheduleCall_Cd=cdt.ScheduleCall_Cd) as RVC,
(SELECT ISNULL(SUM(CASE WHEN ISNULL(sdt.Calling_Category_Cd,0) = 3 AND ISNULL(cdt.Call_Response_Cd,0) = 4 THEN 1 ELSE 0 END),0) FROM CallingDetails cdt, ScheduleDetails sdt WHERE sdt.ScheduleCall_Cd=cdt.ScheduleCall_Cd) as DCC,
(SELECT ISNULL(SUM(CASE WHEN ISNULL(sdt.Calling_Category_Cd,0) = 5 AND ISNULL(cdt.Call_Response_Cd,0) = 4 THEN 1 ELSE 0 END),0) FROM CallingDetails cdt, ScheduleDetails sdt WHERE sdt.ScheduleCall_Cd=cdt.ScheduleCall_Cd) as PCC,
(SELECT ISNULL(SUM(CASE WHEN ISNULL(sdt.Calling_Category_Cd,0) = 7 AND ISNULL(cdt.Call_Response_Cd,0) = 4 THEN 1 ELSE 0 END),0) FROM CallingDetails cdt, ScheduleDetails sdt WHERE sdt.ScheduleCall_Cd=cdt.ScheduleCall_Cd) as PRC ";
$dataSummary5 = $db5->ExecutveQuerySingleRowSALData($query5, $electionName, $developmentMode);

?>
       <!--  <div class="col-xl-6 col-md-6 col-12">
            <div class="card card-statistics">
                <div class="card-header">
                    <h5 class="card-title">Shop : Calling Summary</h5>
                    <div class="d-flex align-items-center">
                        <p class="card-text font-small-2 mr-25 mb-0">
                            <?php 
                                if(!empty($dataSummary5["LastShopCallDateTime"])){
                                    echo "Last Calling Done on ".date('d/m/Y h:i a',strtotime($dataSummary5["LastShopCallDateTime"]));
                                }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="card-body statistics-body">
                    <div class="row">

                        <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                            <div class="media">
                                <div class="avatar bg-light-primary p-50  mr-2">
                                    <div class="avatar-content">
                                        <i class="feather icon-calendar avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="media-body my-auto">
                                    <h4 class="font-weight-bolder mb-0"><?php echo ($dataSummary5["RVC"]+$dataSummary5["DCC"]); ?></h4>
                                    <p class="card-text font-small-4 mb-0">Shop Appointments</p>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                            <div class="media">
                                <div class="avatar bg-light-success p-50  mr-2">
                                    <div class="avatar-content">
                                        <i class="feather icon-dollar-sign avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="media-body my-auto">
                                    <h4 class="font-weight-bolder mb-0"><?php echo ($dataSummary5["PCC"]+$dataSummary5["PRC"]); ?></h4>
                                    <p class="card-text font-small-4 mb-0">Licence Renewal</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6 col-sm-12 col-12" style="margin-top:15px;">
                            <div class="media">
                                <div class="avatar bg-light-primary p-50  mr-2">
                                    <div class="avatar-content">
                                        <i class="feather icon-user-x avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="media-body my-auto">
                                    <h4 class="font-weight-bolder mb-0">0</h4>
                                    <p class="card-text font-small-4 mb-0">License Defaulters</p>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-xl-6 col-md-6 col-sm-12 col-12" style="margin-top:15px;">
                            <div class="media">
                                <div class="avatar bg-light-success p-50  mr-2">
                                    <div class="avatar-content">
                                        <i class="feather icon-phone-call avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="media-body my-auto">
                                    <h4 class="font-weight-bolder mb-0">0</h4>
                                    <p class="card-text font-small-4 mb-0">License Helpline</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div> -->
    </div>

 <?php

            $queryExeSurveySummary = "
                    SELECT
                    a.UserName, 
                    em.Executive_Cd,
                    em.ExecutiveName,
                    SUM(a.ShopListCount) as ShopList,
                    SUM(a.ShopSurveyCount) as ShopSurvey
                    FROM (
                        SELECT
                            AddedBy as UserName,
                            COUNT(Shop_Cd) as ShopListCount,
                            0 as ShopSurveyCount
                        FROM ShopMaster 
                        WHERE IsActive = 1
                        AND CONVERT(VARCHAR,AddedDate,120) BETWEEN '$fromDate' AND '$toDate' 
                        GROUP BY AddedBy

                        UNION ALL

                        SELECT
                            SurveyBy as UserName,
                            0 as ShopListCount,
                            COUNT(Shop_Cd) as ShopSurveyCount
                        FROM ShopMaster 
                        WHERE IsActive = 1 
                        AND CONVERT(VARCHAR,SurveyDate,120) BETWEEN '$fromDate' AND '$toDate' 
                        GROUP BY SurveyBy
                    ) a,
                    Survey_Entry_Data..User_Master um, Survey_Entry_Data..Executive_Master em 
                    WHERE a.UserName = um.UserName  AND um.Executive_Cd = em.Executive_Cd
                    GROUP BY a.UserName,em.Executive_Cd,em.ExecutiveName
                    ORDER BY ShopSurvey
            ";
            $dbExeSurvey=new DbOperation();
            // echo $queryExeSurveySummary;
            $dbExeSurveySummary = $dbExeSurvey->ExecutveQueryMultipleRowSALData($queryExeSurveySummary, $electionName, $developmentMode);

            $queryWardSurveySummary = "
                    SELECT
                    a.Node_Cd, 
                    a.Ward_No,
                    (SELECT ISNULL(IsCompleted,0) FROM PocketMaster as pmm
                    INNER JOIN NodeMaster as nmm ON nmm.Node_Cd = pmm.Node_Cd
                    WHERE nmm.IsActive=1 AND pmm.IsActive=1 AND nmm.Ward_No = a.Ward_No) as IsCompleted,
                    SUM(a.ShopListCount) as ShopList,
                    SUM(a.ShopSurveyCount) as ShopSurvey
                    FROM (
                        SELECT
                            nm.Node_Cd, nm.Ward_No,
                            COUNT(DISTINCT(sm.Shop_Cd)) as ShopListCount,
                            0 as ShopSurveyCount
                        FROM ShopMaster  sm
                        INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd and pm.IsActive = 1)
                        INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1)
                        WHERE sm.IsActive = 1 
                        AND CONVERT(VARCHAR,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' 
                        GROUP BY nm.Node_Cd, nm.Ward_No

                        UNION ALL

                        SELECT
                            nm.Node_Cd, nm.Ward_No,
                            0 as ShopListCount,
                            COUNT(DISTINCT(sm.Shop_Cd)) as ShopSurveyCount
                        FROM ShopMaster sm
                        INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd and pm.IsActive = 1)
                        INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1)
                        WHERE sm.IsActive = 1 
                        AND CONVERT(VARCHAR,sm.SurveyDate,120) BETWEEN '$fromDate' AND '$toDate' 
                        GROUP BY nm.Node_Cd, nm.Ward_No
                    ) a
                    GROUP BY a.Node_Cd,a.Ward_No
                    ORDER BY ShopSurvey
            ";
            $dbWard=new DbOperation();
            // echo $queryWardSurveySummary;
            $dbWrdSurveySummary = $dbWard->ExecutveQueryMultipleRowSALData($queryWardSurveySummary, $electionName, $developmentMode);


            $queListingDays = "SELECT CONVERT(date, sm.AddedDate, 103) AS ListingDate, UM.ExecutiveName, COUNT(*) AS Listing
            FROM dbo.ShopMaster AS sm INNER JOIN
            Survey_Entry_Data.dbo.User_Master AS UM ON sm.AddedBy = UM.UserName
            INNER JOIN PocketMaster as pm ON pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster as nm ON nm.Node_Cd = pm.Node_Cd
            WHERE sm.IsActive = 1
            AND pm.IsActive = 1
            And nm.IsActive = 1
            GROUP BY CONVERT(date, sm.AddedDate, 103), UM.ExecutiveName";

            $dbListingDays=new DbOperation();
            $listingDaysData = $dbListingDays->ExecutveQueryMultipleRowSALData($queListingDays, $electionName, $developmentMode);

            $queSurveyDays = "SELECT CONVERT(date, sm.SurveyDate, 103) AS SurveyDate, UM.ExecutiveName, COUNT(*) AS Survey
            FROM dbo.ShopMaster AS sm INNER JOIN
            Survey_Entry_Data.dbo.User_Master AS UM ON sm.SurveyBy = UM.UserName
            INNER JOIN PocketMaster as pm ON pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster as nm ON nm.Node_Cd = pm.Node_Cd
            WHERE sm.IsActive = 1
            AND pm.IsActive = 1
            And nm.IsActive = 1
            GROUP BY CONVERT(date, sm.SurveyDate, 103), UM.ExecutiveName";

            $dbSurveyDays=new DbOperation();
            $surveyDaysData = $dbSurveyDays->ExecutveQueryMultipleRowSALData($queSurveyDays, $electionName, $developmentMode);

          
            /*Over All Start*/

          $queryExeSurveyOverAllSummary = "SELECT
                    a.UserName, 
                    em.Executive_Cd,
                    em.ExecutiveName,
                    ISNULL((
                        SELECT
                            CONVERT(VARCHAR,min(AddedDate),23)
                        FROM ShopMaster 
                        WHERE IsActive = 1 AND AddedBy = a.UserName
                        AND ISNULL(CONVERT(VARCHAR,AddedDate,120),'') <> ''
                        AND AddedDate is not null
                    ),'') as MinAddedDate,
                    ISNULL((
                        SELECT
                            CONVERT(VARCHAR,max(AddedDate),23)
                        FROM ShopMaster 
                        WHERE IsActive = 1 AND AddedBy = a.UserName
                        AND ISNULL(CONVERT(VARCHAR,AddedDate,120),'') <> ''
                        AND AddedDate is not null
                    ),'') as MaxAddedDate,
                    ISNULL((
                        SELECT
                            COUNT(DISTINCT(Shop_Cd)) 
                        FROM ShopMaster 
                        WHERE IsActive = 1 AND AddedBy = a.UserName
                        AND ISNULL(CONVERT(VARCHAR,AddedDate,120),'') <> ''
                        AND AddedDate is not null
                    ),'') as ShopListCount,
                    ISNULL((
                        SELECT
                            CONVERT(VARCHAR,min(SurveyDate),23)
                        FROM ShopMaster 
                        WHERE IsActive = 1 AND SurveyBy = a.UserName
                        AND ISNULL(CONVERT(VARCHAR,SurveyDate,120),'') <> ''
                        AND SurveyDate is not null
                    ),'') as MinSurveyDate,
                    ISNULL((
                        SELECT
                            CONVERT(VARCHAR,max(SurveyDate),23)
                        FROM ShopMaster 
                        WHERE IsActive = 1 AND SurveyBy = a.UserName
                        AND ISNULL(CONVERT(VARCHAR,SurveyDate,120),'') <> ''
                        AND SurveyDate is not null
                    ),'') as MaxSurveyDate,
                    ISNULL((
                        SELECT
                            COUNT(DISTINCT(Shop_Cd)) 
                        FROM ShopMaster 
                        WHERE IsActive = 1 AND SurveyBy = a.UserName
                        AND ISNULL(CONVERT(VARCHAR,SurveyDate,120),'') <> ''
                        AND SurveyDate is not null
                    ),'') as ShopSurveyCount
                FROM(
                    SELECT
                        AddedBy as UserName
                    FROM ShopMaster 
                    WHERE IsActive = 1
                    AND ISNULL(CONVERT(VARCHAR,AddedDate,120),'') <> ''
                    AND AddedDate is not null
                    GROUP BY AddedBy

                    UNION ALL

                    SELECT
                        SurveyBy as UserName
                    FROM ShopMaster 
                    WHERE IsActive = 1 
                    AND ISNULL(CONVERT(VARCHAR,SurveyDate,120),'') <> ''
                    AND SurveyDate is not null
                    GROUP BY SurveyBy
                ) a,
                Survey_Entry_Data..User_Master um, Survey_Entry_Data..Executive_Master em 
                WHERE a.UserName = um.UserName  AND um.Executive_Cd = em.Executive_Cd
                GROUP BY a.UserName, em.Executive_Cd, em.ExecutiveName
            ";
            $dbExeSurveyOverAll=new DbOperation();
            // echo $queryExeSurveyOverAllSummary;
            $dbExeSurveyOverAllSummary = $dbExeSurveyOverAll->ExecutveQueryMultipleRowSALData($queryExeSurveyOverAllSummary, $electionName, $developmentMode);


             $queryWardSurveyOverAllSummary = "SELECT
                     a.Node_Cd, a.Ward_No,
                     ISNULL(( 
                        SELECT
                            CONVERT(VARCHAR,min(sm.AddedDate),23)
                        FROM ShopMaster sm
                        INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd and pm.IsActive = 1)
                        INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1)
                        WHERE sm.IsActive = 1 
                        AND ISNULL(CONVERT(VARCHAR,sm.AddedDate,120),'') <> ''
                        AND sm.AddedDate is not null 
                        AND nm.Node_Cd = a.Node_Cd
                     ),'') as MinAddedDate,
                     ISNULL(( 
                        SELECT
                            CONVERT(VARCHAR,max(sm.AddedDate),23)
                        FROM ShopMaster sm
                        INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd and pm.IsActive = 1)
                        INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1)
                        WHERE sm.IsActive = 1 
                        AND ISNULL(CONVERT(VARCHAR,sm.AddedDate,120),'') <> ''
                        AND sm.AddedDate is not null 
                        AND nm.Node_Cd = a.Node_Cd
                     ),'') as MaxAddedDate,
                     ISNULL(( 
                        SELECT
                            COUNT(DISTINCT(sm.Shop_Cd)) 
                        FROM ShopMaster sm
                        INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd and pm.IsActive = 1)
                        INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1)
                        WHERE sm.IsActive = 1 
                        AND ISNULL(CONVERT(VARCHAR,sm.AddedDate,120),'') <> ''
                        AND sm.AddedDate is not null 
                        AND nm.Node_Cd = a.Node_Cd
                     ),'') as ShopListCount,
                     ISNULL(( 
                        SELECT
                            CONVERT(VARCHAR,min(sm.SurveyDate),23)
                        FROM ShopMaster sm
                        INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd and pm.IsActive = 1)
                        INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1)
                        WHERE sm.IsActive = 1 
                        AND ISNULL(CONVERT(VARCHAR,sm.SurveyDate,120),'') <> ''
                        AND sm.SurveyDate is not null 
                        AND nm.Node_Cd = a.Node_Cd
                     ),'') as MinSurveyDate,
                     ISNULL(( 
                        SELECT
                            CONVERT(VARCHAR,max(sm.SurveyDate),23)
                        FROM ShopMaster sm
                        INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd and pm.IsActive = 1)
                        INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1)
                        WHERE sm.IsActive = 1 
                        AND ISNULL(CONVERT(VARCHAR,sm.SurveyDate,120),'') <> ''
                        AND sm.SurveyDate is not null 
                        AND nm.Node_Cd = a.Node_Cd
                     ),'') as MaxSurveyDate,
                     ISNULL(( 
                        SELECT
                            COUNT(DISTINCT(sm.Shop_Cd)) 
                        FROM ShopMaster sm
                        INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd and pm.IsActive = 1)
                        INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1)
                        WHERE sm.IsActive = 1 
                        AND ISNULL(CONVERT(VARCHAR,sm.SurveyDate,120),'') <> ''
                        AND sm.SurveyDate is not null 
                        AND nm.Node_Cd = a.Node_Cd
                     ),0) as ShopSurveyCount,

                     ISNULL((
                        SELECT 
                            COUNT(DISTINCT(sm.Shop_Cd))
                        FROM ShopMaster sm
                        INNER JOIN PocketMaster ON ( sm.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = a.Node_Cd WHERE sm.IsActive=1 AND sm.SurveyDate IS NOT NULL AND ( ISNULL(sm.ShopStatus,'') = '' OR sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) ) 
                        AND NodeMaster.Node_Cd = a.Node_Cd  
                    ),0) as SurveyAll,

                    ISNULL((
                        SELECT 
                            COUNT(DISTINCT(sm.Shop_Cd))
                        FROM ShopMaster sm
                        INNER JOIN PocketMaster ON ( sm.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = a.Node_Cd WHERE sm.IsActive=1 AND sm.SurveyDate IS NULL AND ( ISNULL(sm.ShopStatus,'') = '' OR sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) ) 
                        AND NodeMaster.Node_Cd = a.Node_Cd  
                    ),0) as SurveyPending,

                    ISNULL((
                        SELECT 
                            COUNT(DISTINCT(sm.Shop_Cd))
                        FROM ShopMaster sm
                        INNER JOIN PocketMaster ON ( sm.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = a.Node_Cd WHERE sm.IsActive=1 AND sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1)  
                        AND NodeMaster.Node_Cd = a.Node_Cd  
                    ),0) as DocumentDenied

                    -- ISNULL((
                    --     SELECT 
                    --         COUNT(DISTINCT(sm.Shop_Cd))
                    --     FROM ShopMaster sm
                    --     INNER JOIN PocketMaster ON ( sm.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = a.Node_Cd WHERE sm.IsActive=1 AND sm.ShopStatus = 'Verified'    
                    -- ),0) as DocumentReceived,

                    -- ISNULL((
                    --     SELECT 
                    --         COUNT(DISTINCT(sm.Shop_Cd))
                    --     FROM ShopMaster sm
                    --     INNER JOIN PocketMaster ON ( sm.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = a.Node_Cd WHERE sm.IsActive=1 AND sm.SurveyDate IS NOT NULL AND ( ISNULL(sm.ShopStatus,'') = '' OR  sm.ShopStatus = 'Pending'  )
                    -- ),0) as DocumentPending,

                    -- ISNULL((
                    --     SELECT 
                    --         COUNT(DISTINCT(sm.Shop_Cd))
                    --     FROM ShopMaster sm
                    --     INNER JOIN PocketMaster ON ( sm.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = a.Node_Cd WHERE sm.IsActive=1 AND sm.SurveyDate IS NOT NULL AND  sm.ShopStatus = 'In-Review' 
                    -- ),0) as DocumentInReview,

                    -- ISNULL((
                    --     SELECT 
                    --         COUNT(DISTINCT(sm.Shop_Cd))
                    --     FROM ShopMaster sm
                    --     INNER JOIN PocketMaster ON ( sm.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = a.Node_Cd WHERE sm.IsActive=1 AND sm.SurveyDate IS NOT NULL AND  sm.ShopStatus = 'Rejected' 
                    -- ),0) as DocumentRejected

                FROM(
                    SELECT
                        nm.Node_Cd, nm.Ward_No
                    FROM ShopMaster  sm
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd and pm.IsActive = 1)
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1)
                    WHERE sm.IsActive = 1 
                    AND ISNULL(CONVERT(VARCHAR,sm.AddedDate,120),'') <> ''
                    AND sm.AddedDate is not null 
                    GROUP BY nm.Node_Cd, nm.Ward_No

                    UNION ALL

                    SELECT
                            nm.Node_Cd, nm.Ward_No
                    FROM ShopMaster sm
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd and pm.IsActive = 1)
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1)
                    WHERE sm.IsActive = 1 
                    AND ISNULL(CONVERT(VARCHAR,sm.SurveyDate,120),'') <> ''
                    AND sm.SurveyDate is not null
                    GROUP BY nm.Node_Cd, nm.Ward_No
                    
                ) a
                GROUP BY a.Ward_No,a.Node_Cd
            ";

            $dbWardOverAll=new DbOperation();
            // echo $queryWardSurveyOverAllSummary;
            $dbWrdSurveyOverAllSummary = $dbWardOverAll->ExecutveQueryMultipleRowSALData($queryWardSurveyOverAllSummary, $electionName, $developmentMode);

            // print_r($dbWrdSurveyOverAllSummary);

            /*Over All End*/
    ?>

<form method="POST" action="home.php">
<div class="row">
    <div class="col-md-3 col-sm-12 col-12">
        <div class="form-group">
            <label for="fromDate">From Date</label>
            <input type='text' name="fromDate" value="<?php echo $frDate;?>" class="form-control pickadate-disable-forwarddates"  />
        </div>
    </div>
    <div class="col-md-3 col-sm-12 col-12">
        <div class="form-group">
            <label for="toDate">To Date</label>
            <input type='text' name="toDate" value="<?php echo $tDate;?>" class="form-control pickadate-disable-forwarddates" />
        </div>
    </div>

    <div class="col-md-1 col-sm-12 col-12 text-right">
         <div class="form-group">
            <label for="refesh" ></label>
            </br><button type="submit" name="refesh" class="btn btn-primary"><i class="feather icon-refresh-cw"></i></button>
        </div>
    </div>
</div>
</form>

    <div class="row">
        <?php
            if(sizeof($dbExeSurveySummary)>0){ 
        ?>
            <div class="col-xl-4 col-md-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Executive Listing - <?php echo date('d/m/Y',strtotime($fromDate))." - ".date('d/m/Y',strtotime($toDate)); ?></h5>
                        <div class="d-flex align-items-center">
                            <p class="card-text font-small-2 mr-25 mb-0">
                                
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <!-- <table  class="table table-striped table-bordered complex-headers zero-configuration"> -->
                                <table id="executiveListingId" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="text-align:left;">Executive Name</th>
                                        <th style="text-align:right;">Shop Count</th>
                                   </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $total = 0;
                                        $srN1 = 0;
                                        foreach ($dbExeSurveySummary as $key => $value) {
                                            
                                            if($value["ShopList"]!=0){
                                                $srN1 = $srN1 + 1;
                                                $total= $total+$value["ShopList"];
                                    ?> 
                                       <tr>
                                            <td><?php echo $value["ExecutiveName"]; ?></td>
                                            <td style="text-align:right;font-size: 1.2rem;"><a href="home.php?p=pocket-wise-shops-list&executiveCd=<?php echo $value["Executive_Cd"]; ?>&fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>&tab=listIcon&nodeId=All&pocketId=All"><?php echo $value["ShopList"]; ?></a></td>
                                        </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th style="text-align:right;font-size: 1.2rem;"><?php echo $srN1; ?> / <?php echo $total; ?></th>
                                    </tr>
                                    <tr>
                                        <th>Average</th>
                                        <th style="text-align:right;font-size: 1.2rem;"><?php if($total != 0) { echo round(( $total / $srN1 )); } else{ echo "0";} ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Executive Survey - <?php echo date('d/m/Y',strtotime($fromDate))." - ".date('d/m/Y',strtotime($toDate)); ?></h5>
                        <div class="d-flex align-items-center">
                            <p class="card-text font-small-2 mr-25 mb-0">
                                
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <!-- <table  class="table table-striped table-bordered complex-headers zero-configuration"> -->
                                <table id="executiveSurveyId" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="text-align:left;">Executive Name</th>
                                        <th style="text-align:right;">Shop Count</th>
                                   </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $total = 0;
                                        $srN2 = 0;
                                        foreach ($dbExeSurveySummary as $key => $value) {
                                            if($value["ShopSurvey"]!=0){
                                                $srN2 = $srN2 + 1;
                                                $total= $total+$value["ShopSurvey"];
                                    ?> 
                                       <tr>
                                            <td><?php echo $value["ExecutiveName"]; ?></td>
                                            <td style="text-align:right;font-size: 1.2rem;"><a href="home.php?p=pocket-wise-survey-detail&executiveCd=<?php echo $value["Executive_Cd"]; ?>&fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>&nodeId=All&pocketId=All"><?php echo $value["ShopSurvey"]; ?></a></td>
                                        </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th style="text-align:right;font-size: 1.2rem;"><?php echo $srN2; ?> / <?php echo $total; ?></th>
                                    </tr>
                                    <tr>
                                        <th>Average</th>
                                        <th style="text-align:right;font-size: 1.2rem;"><?php if($total != 0) { echo round(( $total / $srN2 ));} else { echo "0";} ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php
            if(sizeof($dbWrdSurveySummary)>0){ 
        ?>
            <div class="col-xl-4 col-md-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Ward Listing - <?php echo date('d/m/Y',strtotime($fromDate))." - ".date('d/m/Y',strtotime($toDate)); ?></h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <!-- <table  class="table table-striped table-bordered complex-headers zero-configuration"> -->
                            <table id="wardListingId" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="text-align:left;">Ward No</th>
                                        <th style="text-align:right;">Shop Count</th>
                                   </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $total=0;
                                        $srN3 = 0;
                                        foreach ($dbWrdSurveySummary as $key => $value) {
                                            if($value["ShopList"] != 0){
                                                $srN3 = $srN3 + 1;
                                                $total= $total+$value["ShopList"];
                                    ?> 
                                       <tr>
                                            <td><?php if($value["IsCompleted"] == 1) 
                                            {
                                                echo "<span style='font-weight:bold;color:green;'>"; 
                                            }
                                            else
                                            {
                                                echo "<span>"; 
                                            } ?>
                                             <?php  echo "W-".$value["Ward_No"]."</span>"; ?>
                                            </td>
                                            <td style="text-align:right;font-size: 1.2rem;"><a href="home.php?p=pocket-wise-shops-list&nodeId=<?php echo $value["Node_Cd"]; ?>&fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>&tab=listIcon"><?php echo $value["ShopList"]; ?></a></td>
                                        </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th style="text-align:right;font-size: 1.2rem;"><?php echo $srN3; ?> / <?php echo $total; ?></th>
                                    </tr>
                                    <tr>
                                        <th>Average</th>
                                        <th style="text-align:right;font-size: 1.2rem;"><?php if($total != 0) { echo round(( $total / $srN3 ));} else { echo "0";} ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Ward Survey - <?php echo date('d/m/Y',strtotime($fromDate))." - ".date('d/m/Y',strtotime($toDate)); ?></h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <!-- <table  class="table table-striped table-bordered complex-headers zero-configuration"> -->
                            <table id="wardSurveyId" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="text-align:left;">Ward No</th>
                                        <th style="text-align:right;">Shop Count</th>
                                   </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $total=0;
                                        $srN = 0;
                                        foreach ($dbWrdSurveySummary as $key => $value) {
                                            if($value["ShopSurvey"] != 0){
                                                $srN = $srN + 1;
                                                $total= $total+$value["ShopSurvey"];
                                    ?> 
                                       <tr>
                                            <td><?php 
                                            // if($value["IsCompleted"] == 1) 
                                            // {
                                            //     echo "<span style='font-weight:bold;color:green;'>"; 
                                            // }
                                            // else
                                            // {
                                            //     echo "<span>"; 
                                            // } 
                                            ?>
                                             <?php  //echo "W-".$value["Ward_No"]."</span>"; ?>
                                             <?php  echo "W-".$value["Ward_No"]; ?>
                                            </td>
                                            <td style="text-align:right;font-size: 1.2rem;"><a href="home.php?p=pocket-wise-survey-detail&nodeId=<?php echo $value["Node_Cd"]; ?>&fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>"><?php echo $value["ShopSurvey"]; ?></a></td>
                                        </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th style="text-align:right;font-size: 1.2rem;"><?php echo $srN; ?> / <?php echo $total; ?></th>
                                    </tr>
                                    <tr>
                                        <th>Average</th>
                                        <th style="text-align:right;font-size: 1.2rem;"><?php if($total != 0) { echo round(( $total / $srN ));} else { echo "0";} ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php
            if(sizeof($dbExeSurveyOverAllSummary)>0){ 
        ?>
            <div class="col-xl-4 col-md-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Executives - Shop Listing</h5>
                        <div class="d-flex align-items-center">
                            <p class="card-text font-small-2 mr-25 mb-0">
                                
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <table id="allExecutiveShopListId" class="table table-striped">
                            <!-- <table  class="table table-striped table-bordered complex-headers zero-configuration"> -->
                                <thead>                                   
                                    <tr>
                                        <th style="text-align:left;">Executive Name</th>
                                        <th style="text-align:right;">Shop Count</th>
                                   </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $total = 0;
                                        $srN = 0;
                                        foreach ($dbExeSurveyOverAllSummary as $key => $value) {
                                            if($value["ShopListCount"] !=0 ){ 
                                                $srN = $srN + 1;
                                                $total = $total+$value["ShopListCount"];
                                    ?>  
                                       <tr>
                                            <td><?php echo $value["ExecutiveName"]; ?></td>
                                            
                                            <td style="text-align:right;font-size: 1.2rem;">
                                                <a href="home.php?p=pocket-wise-shops-list&executiveCd=<?php echo $value["Executive_Cd"]; ?>&fromDate=<?php echo $value["MinAddedDate"]; ?>&toDate=<?php echo $value["MaxAddedDate"]; ?>&tab=listIcon&nodeId=All&pocketId=All"><?php echo $value["ShopListCount"]; ?></a>
                                            </td>
                                           
                                        </tr>
                                     <?php } ?>
                                <?php
                                    }
                                ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th style="text-align:right;font-size: 1.2rem;"><?php echo $srN; ?> / <?php echo $total; ?></th>
                                    </tr>
                                    <tr>
                                        <th>Average</th>
                                        <th style="text-align:right;font-size: 1.2rem;"><?php if($total != 0) { echo round(( $total / sizeof($listingDaysData) )); } else { echo "0";} ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Executives - Shop Survey</h5>
                        <div class="d-flex align-items-center">
                            <p class="card-text font-small-2 mr-25 mb-0">
                                
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <table id="allExecutiveShopSurveyId" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="text-align:left;">Executive Name</th>
                                        <th style="text-align:right;">Shop Count</th>
                                   </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $total = 0;
                                        $srN = 0;
                                        foreach ($dbExeSurveyOverAllSummary as $key => $value) {
                                            if($value["ShopSurveyCount"] !=0 ){ 
                                                $srN = $srN + 1;
                                                 $total = $total + $value["ShopSurveyCount"];
                                    ?> 
                                       <tr>
                                            <td><?php echo $value["ExecutiveName"]; ?></td>
                                            <td style="text-align:right;font-size: 1.2rem;">
                                                <a href="home.php?p=pocket-wise-survey-detail&executiveCd=<?php echo $value["Executive_Cd"]; ?>&fromDate=<?php echo $value["MinSurveyDate"]; ?>&toDate=<?php echo $value["MaxSurveyDate"]; ?>&nodeId=All&pocketId=All"><?php echo $value["ShopSurveyCount"]; ?></a>
                                            </td>
                                        </tr>
                                    <?php } 
                                        }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th style="text-align:right;font-size: 1.2rem;"><?php echo $srN; ?> / <?php echo $total; ?></th>
                                    </tr>
                                    <tr>
                                        <th>Average</th>
                                        <th style="text-align:right;font-size: 1.2rem;"><?php if($total != 0) { echo round(( $total / sizeof($surveyDaysData) )); } else { echo "0"; } ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php
            if(sizeof($dbWrdSurveyOverAllSummary)>0){ 
        ?>
            <div class="col-xl-12 col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Ward - Shop Listing & Survey</h5>
                        <div class="d-flex align-items-center">
                            <p class="card-text font-small-2 mr-25 mb-0">
                                
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- <table class="table table-striped table-bordered table-5"> -->
                            <table  class="table table-striped table-bordered complex-headers zero-configuration">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="text-align:center;">Ward</th>
                                        <th style="text-align:center;" colspan="4">Shops</th>
                                        <!-- <th></th>
                                        <th style="text-align:center;" colspan="5">Documents</th> -->
                                    </tr>
                                    <tr>
                                    
                                        <th style="text-align:center;">SrNo</th>
                                        <th style="text-align:center;">Ward No</th>

                                        <th style="text-align:right;">Listing</th>
                                        <th style="text-align:right;">Survey</th>
                                        <th style="text-align:right;">Denied</th>
                                        <th style="text-align:right;">Pending</th>
                                        <!-- <th></th>
                                        <th style="text-align:right;">Denied</th>
                                        <th style="text-align:right;">Recieved</th>
                                        <th style="text-align:right;">Pending</th>
                                        <th style="text-align:right;">In-Review</th>
                                        <th style="text-align:right;">Rejected</th> -->
                                   </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $srNo = 0;
                                        foreach ($dbWrdSurveyOverAllSummary as $key => $value) {
                                            $srNo =  $srNo+1;
                                    ?> 
                                       <tr>
                                            <td><?php echo $srNo; ?></td> 
                                            <td><?php echo "W-".$value["Ward_No"]; ?></td>
                                            <td style="text-align:right;font-size: 1.0rem;">
                                                <?php if($value["ShopListCount"] !=0 ){ ?> 
                                                    <a href="home.php?p=pocket-wise-shops-list&nodeId=<?php echo $value["Node_Cd"]; ?>&fromDate=<?php echo $value["MinAddedDate"]; ?>&toDate=<?php echo $value["MaxAddedDate"]; ?>&tab=listIcon"><?php echo $value["ShopListCount"]; ?></a>
                                                <?php }else{ ?>
                                                        <?php echo $value["ShopListCount"]; ?>
                                                <?php } ?>
                                            </td>
                                            <td style="text-align:right;font-size: 1.0rem;">
                                                <?php if($value["SurveyAll"] !=0 ){ ?> 
                                                    <a href="home.php?p=pocket-wise-survey-detail&nodeId=<?php echo $value["Node_Cd"]; ?>&fromDate=<?php echo $value["MinSurveyDate"]; ?>&toDate=<?php echo $value["MaxSurveyDate"]; ?>">
                                                        <?php echo $value["SurveyAll"]; ?>
                                                        
                                                    </a>
                                                <?php }else{ ?>
                                                        <?php echo $value["SurveyAll"]; ?>
                                                <?php } ?>
                                            </td>
                                            <td style="text-align:right;font-size: 1.0rem;">
                                                <?php echo $value["DocumentDenied"]; ?>
                                            </td>
                                            <td style="text-align:right;font-size: 1.0rem;">
                                                <?php echo $value["SurveyPending"]; ?>
                                            </td>
                                            <!-- <td style="text-align:right;font-size: 1.0rem;">
                                            </td>

                                            <td style="text-align:right;font-size: 1.0rem;">
                                                <?php //echo $value["DocumentDenied"]; ?>
                                            </td>
                                            <td style="text-align:right;font-size: 1.0rem;">
                                                <?php //echo $value["DocumentReceived"]; ?>
                                            </td>
                                            <td style="text-align:right;font-size: 1.0rem;">
                                                <?php //echo $value["DocumentPending"]; ?>
                                            </td>
                                            <td style="text-align:right;font-size: 1.0rem;">
                                                <?php //echo $value["DocumentInReview"]; ?>
                                            </td>
                                            <td style="text-align:right;font-size: 1.0rem;">
                                                <?php //echo $value["DocumentRejected"]; ?>
                                            </td> -->
                                            
                                        </tr>
                                <?php
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>


        <?php

            // $queryExeCallingSummary = "SELECT
            //     a.Executive_Cd, a.ExecutiveName, a.MobileNo,
            //     COUNT(a.Shop_Cd) AS TotalCalls,
            //     SUM(CASE WHEN a.Call_Response_Cd = 4 THEN 1 ELSE 0 END) as TotalReceived
            //     FROM (
            //         SELECT cdt.Shop_Cd,
            //             ISNULL(cdt.Executive_Cd,0) as Executive_Cd,
            //             ISNULL(em.ExecutiveName,'') as ExecutiveName,
            //             ISNULL(em.MobileNo,'') as MobileNo,
            //             ISNULL(cdt.Call_Response_Cd,0) as Call_Response_Cd
            //         FROM CallingDetails cdt,
            //         ShopMaster sm,
                    
            //         Survey_Entry_Data..Executive_Master em 
            //         WHERE CONVERT(VARCHAR,cdt.Call_DateTime,120) BETWEEN
            //         '$fromDate' AND '$toDate'
            //         AND cdt.Shop_Cd = sm.Shop_Cd
            //         AND cdt.Executive_Cd = em.Executive_Cd
            //         AND sm.IsActive = 1

            //     ) a
            //     GROUP BY a.Executive_Cd, a.ExecutiveName, a.MobileNo";
            // $dbExeCallingSummary=new DbOperation();
            // echo $queryExeCallingSummary;
            // $dbExeCallingSummary = $dbExeCallingSummary->ExecutveQueryMultipleRowSALData($queryExeCallingSummary, $electionName, $developmentMode);

            // if(sizeof($dbExeCallingSummary)>0){ 
        ?>
        <!-- <div class="col-xl-12 col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Executive Calling - <?php echo date('d/m/Y',strtotime($currentDate)); ?></h5>
                    <div class="d-flex align-items-center">
                        <p class="card-text font-small-2 mr-25 mb-0">
                            
                        </p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table  class="table table-striped table-bordered complex-headers zero-configuration">
                            <thead>
                               
                                <tr> -->
                                
                                    <!-- <th style="text-align:center;">SrNo</th> -->
                                    <!-- <th style="text-align:center;">Executive Name</th>
                                    <th style="text-align:center;">Connected Calls</th>
                                    <th style="text-align:center;">Total Calls</th>
                               </tr>
                            </thead>
                            <tbody> -->
                                <?php
                                    
                                    //$srNo = 0;
                                    //foreach ($dbExeCallingSummary as $key => $value) {
                                ?> 
                                   <!-- <tr>
                                        <!-- <td><?php //echo $srNo++; ?></td> -->
                                        <!--<td><?php echo $value["ExecutiveName"]; ?></td>
                                        <td><?php echo $value["TotalReceived"]; ?></td>
                                        <td><?php echo $value["TotalCalls"]; ?></td>
                                    </tr> -->
                            <?php
                                //}
                            ?>
                            <!-- </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> -->
        <?php //} ?>
    </div>






    <?php

             $queryPkt = "SELECT ISNULL((SELECT top (1) PocketAssignCd
                    FROM PocketAssign pa 
                    WHERE pa.PocketCd = pm.Pocket_cd
                    ORDER By pa.UpdatedDate DESC
                    ),0) as PocketAssignCd,
                ISNULL((SELECT top (1) User_Id
                    FROM Survey_Entry_Data..User_Master um
                    WHERE um.Executive_Cd = pm.SRExecutiveCd
                    AND AppName = '$appName'
                    ),0) as User_Id,
                ISNULL(pm.Pocket_Cd,0) as Pocket_Cd,
                ISNULL(pm.PocketName,'') as PocketName,
                ISNULL(pm.PocketNameMar,'') as PocketNameMar,
                ISNULL(pm.KML_FileUrl,'') as KML_FileUrl,
                ISNULL(pm.SRExecutiveCd,0) as SRExecutiveCd,
                ISNULL(convert(varchar,pm.SRAssignedDate,121),'') as SRAssignedDate,
                ISNULL(pm.IsCompleted,0) as IsCompleted,
                ISNULL(convert(varchar,pm.CompletedOn,121),'') as CompletedOn,
                ISNULL(nm.Node_Cd,0) as Node_Cd,
                ISNULL(nm.Ward_No,'') as Ward_No,
                ISNULL(nm.NodeName,'') as NodeName,
                ISNULL(em.ExecutiveName,'') as ExecutiveName,
                ISNULL(em.MobileNo,'') as MobileNo
                FROM PocketMaster pm
                LEFT JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
                LEFT JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = pm.SRExecutiveCd
                WHERE pm.IsActive = 1
                ORDER BY pm.SRAssignedDate desc
            ";
            $dbPktSummary=new DbOperation();
            
            $dbPktAssgnSummary = $dbPktSummary->ExecutveQueryMultipleRowSALData($queryPkt, $electionName, $developmentMode);

    ?>

    <div class="row">

        <div class="col-xl-12 col-md-12 col-xs-12" id="openClosePocket">
            
        </div>
    

        <div class="col-xl-12 col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Pockets Survey Status</h5>
                    <div class="d-flex align-items-center">
                        <p class="card-text font-small-2 mr-25 mb-0">
                            
                        </p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table  class="table table-striped table-bordered complex-headers zero-configuration">
                            <thead>
                               
                                <tr>
                                
                                    <th style="text-align:center;">SrNo</th>
                                    <th style="text-align:center;">Pocket Open/Close</th>
                                    <th style="text-align:center;">PocketName </th>
                                    <th style="text-align:center;">Ward</th>
                                    <th style="text-align:center;">Node</th>
                                    <th style="text-align:center;">KML File</th>
                                    <th style="text-align:center;">Executive</th>
                                    <th style="text-align:center;">Date</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center;">Action</th>
                                    
                               </tr>
                            </thead>
                            <tbody>
                                <?php
                                    
                                    $srNo = 1;
                                    foreach ($dbPktAssgnSummary as $key => $value) {
                                ?> 
                                   <tr>
                                        <td><?php echo $srNo++; ?></td>
                                        <td>
                                            <?php if($value["PocketName"] != '' & $value['PocketAssignCd'] != 0) { ?>
                                            <div class="custom-control custom-switch switch-md custom-switch-success mr-2 mb-1">
                                                <p class="mb-0"></p></br>
                                                <input type="checkbox" class="custom-control-input" id="customSwitch<?php echo $value['Pocket_Cd'];?>" 
                                                <?php if($value['IsCompleted'] == 0)
                                                {
                                                    echo "checked";
                                                } ?> 
                                                
                                                onchange="openClosePocket('<?php echo $value['User_Id']; ?>','<?php echo $value['SRExecutiveCd']; ?>','<?php echo $value['ExecutiveName']; ?>','<?php echo $value['Pocket_Cd']; ?>','<?php echo $value['PocketName']; ?>','<?php echo $value['PocketAssignCd']; ?>')">
                                                <label class="custom-control-label" for="customSwitch<?php echo $value['Pocket_Cd'];?>">
                                                    <span class="switch-text-left">Open</span>
                                                    <span class="switch-text-right">Close</span>
                                                </label>
                                            </div>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $value["PocketName"]; ?></td>
                                        <td><?php echo $value["Ward_No"]; ?></td>
                                        <td><?php echo $value["NodeName"]; ?></td>
                                        <td>
                                            <?php 
                                                if(!empty($value["KML_FileUrl"])){ echo "File Found!"; }else{ echo "Files Not Found!"; }
                                            ?>
                                        </td>
                                        <td><?php echo $value["ExecutiveName"]."<br>".$value["MobileNo"]; ?></td>
                                        <td>
                                            <?php 
                                                if($value["SRExecutiveCd"] == 0 && ($value["IsCompleted"] == 0 || $value["IsCompleted"] == 1) ){ 
                                                    echo "";
                                                }else if($value["SRExecutiveCd"] <> 0 && $value["IsCompleted"] == 0 ){ 
                                                    echo date('d/m/Y h:i a', strtotime($value["SRAssignedDate"]));
                                                }else if($value["SRExecutiveCd"] <> 0 && $value["IsCompleted"] == 1 ){ 
                                                    echo date('d/m/Y h:i a', strtotime($value["CompletedOn"]));
                                                } 
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if($value["SRExecutiveCd"] == 0 && $value["IsCompleted"] == 0 ){ ?>
                                                    <span class="badge badge-danger">Not Assigned</span>
                                               <?php  }else if($value["SRExecutiveCd"] <> 0 && $value["IsCompleted"] == 0 ){ ?>
                                                    <span class="badge badge-warning">Assigned</span>
                                               <?php  }else if( ($value["SRExecutiveCd"] <> 0 || $value["SRExecutiveCd"] == 0) && $value["IsCompleted"] == 1 ){  ?>
                                                    <span class="badge badge-success">Completed</span>
                                              <?php  } ?>
                                        </td>
                                        <td>
                                            <a href="home.php?p=pocket-master&action=edit&Pocket_Cd=<?php echo $value["Pocket_Cd"]; ?>"><i class="feather icon-edit"></i></a>
                                             <?php 
                                                if($value["SRExecutiveCd"] == 0 && $value["IsCompleted"] == 0 && !empty($value["KML_FileUrl"]) ){ ?>
                                                    <a href="home.php?p=pocket-assign&action=assign&Pocket_Cd=<?php echo $value["Pocket_Cd"]; ?>&nodeId=<?php echo $value["Node_Cd"]; ?>&nodename=<?php echo $value["NodeName"]; ?>"><i class="feather icon-layers"></i></a>
                                            <?php  } ?>
                                        </td>
                                    </tr>
                            <?php
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
