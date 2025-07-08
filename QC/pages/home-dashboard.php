

<div class="content-body">
    <section id="dashboard-analytics">

    <?php
            if(!isset($_SESSION['SAL_SHOP_QC_Type'])){
                $qcType = "ShopList";
                $_SESSION['SAL_SHOP_QC_Type'] = $qcType;
            }else{
                $qcType = $_SESSION['SAL_SHOP_QC_Type'];
            }
            if(!isset($_SESSION['SAL_SHOP_QC_Filter'])){
                $qcFilter = "Pending";
                $_SESSION['SAL_SHOP_QC_Filter'] = $qcFilter;
            }else{
                $qcFilter = $_SESSION['SAL_SHOP_QC_Filter'];
            }
        
                      

            $currentDate = date('Y-m-d');
            $curDate = date('Y');
            $fromDate = date('Y-m-d', strtotime('-7 days'));
            $toDate = $currentDate;
            if(!isset($_SESSION['SAL_FromDate'])){
                $_SESSION['SAL_FromDate'] = $fromDate ;
            }else{
                $fromDate  = $_SESSION['SAL_FromDate'];
            }

            if(!isset($_SESSION['SAL_ToDate'])){
                $_SESSION['SAL_ToDate'] = $toDate;
            }else{
                $toDate = $_SESSION['SAL_ToDate'];
            }

            

            $db=new DbOperation();
            $userName=$_SESSION['SAL_UserName'];
            $appName=$_SESSION['SAL_AppName'];
            $electionName=$_SESSION['SAL_ElectionName'];
            $developmentMode=$_SESSION['SAL_DevelopmentMode'];

            
            $executiveCd = 0;
            $userId = $_SESSION['SAL_UserId'];
            if($userId != 0){
                $exeData = $db->ExecutveQuerySingleRowSALData("SELECT Executive_Cd FROM LoginMaster WHERE User_Cd = $userId ", $electionName, $developmentMode);
                if(sizeof($exeData)>0){
                    $executiveCd = $exeData["Executive_Cd"];
                }
            }else{
                session_unset();
                session_destroy();
                header('Location:../index.php?p=login');
            }

?>

 
        <div class="row">

            <?php 

            foreach ($qcTypeArray as $key => $qcTypeValue) {
                $QCPendingData = array();
                $qcType = $qcTypeValue["QC_Type"];
                if($qcType=='ShopList'){
                    $query = "SELECT
                        'Shop Listing' as QC_Title,
                        'ShopList' as QC_Type,
                        'Pending' as QC_Filter,
                        ISNULL((SELECT CONVERT(VARCHAR,Min(AddedDate),23)
                        FROM ShopMaster WHERE IsActive = 1
                        AND AddedDate IS NOT NULL
                        AND ( QC_Flag IS NULL OR QC_Flag = 0 ) ),'') AS MinDate,
                        ISNULL((SELECT CONVERT(VARCHAR,MAX(AddedDate),23)
                        FROM ShopMaster WHERE IsActive = 1
                        AND AddedDate IS NOT NULL
                        AND ( QC_Flag IS NULL OR QC_Flag = 0 ) ),'') AS MaxDate,
                        ISNULL((SELECT COUNT(Shop_Cd)
                        FROM ShopMaster WHERE IsActive = 1
                        AND AddedDate IS NOT NULL
                        AND ( QC_Flag IS NULL OR QC_Flag = 0 ) ),0) AS QCPending
                        ";
                    $dbQC=new DbOperation();
                    $QCPendingData = $dbQC->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
                }else if($qcType=='ShopSurvey'){
                    $query = "SELECT
                        'Shop Survey' as QC_Title,
                        'ShopSurvey' as QC_Type,
                        'Pending' as QC_Filter,
                        ISNULL((SELECT CONVERT(VARCHAR,Min(st.ST_DateTime),23)
                            FROM ScheduleDetails sd 
                            INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                AND st.ST_Status = 1 AND st.ST_DateTime is not NULL
                            )
                            INNER JOIN ShopMaster sm on (sd.Shop_Cd = sm.Shop_Cd
                                AND sd.CallingDate is not NULL AND sm.IsActive = 1
                                AND ( ISNULL(sm.ShopStatus,'') = '' OR sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )
                            )
                            LEFT JOIN QCDetails qd on (qd.ScheduleCall_Cd=sd.ScheduleCall_Cd 
                            AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopSurvey' )
                            INNER JOIN CallingCategoryMaster ccm on (ccm.Calling_Category_Cd = sd.Calling_Category_Cd
                                AND ccm.Calling_Type = 'Survey' AND ccm.QC_Type in ('ShopSurvey')
                            )
                            WHERE qd.QC_Detail_Cd IS NULL 

                        ),'') AS MinDate,
                        ISNULL((SELECT CONVERT(VARCHAR,MAX(st.ST_DateTime),23)
                            FROM ScheduleDetails sd 
                            INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                AND st.ST_Status = 1 AND st.ST_DateTime is not NULL
                            )
                            INNER JOIN ShopMaster sm on (sd.Shop_Cd = sm.Shop_Cd
                                AND sd.CallingDate is not NULL AND sm.IsActive = 1
                                AND ( ISNULL(sm.ShopStatus,'') = '' OR sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )
                            )
                            LEFT JOIN QCDetails qd on (qd.ScheduleCall_Cd=sd.ScheduleCall_Cd 
                            AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopSurvey' )
                            INNER JOIN CallingCategoryMaster ccm on (ccm.Calling_Category_Cd = sd.Calling_Category_Cd
                                AND ccm.Calling_Type = 'Survey' AND ccm.QC_Type in ('ShopSurvey')
                            )
                            WHERE qd.QC_Detail_Cd IS NULL
                        ),'') AS MaxDate,
                        ISNULL((SELECT COUNT(sd.ScheduleCall_Cd)
                            FROM ScheduleDetails sd 
                            INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                AND st.ST_Status = 1 AND st.ST_DateTime is not NULL
                            )
                            INNER JOIN ShopMaster sm on (sd.Shop_Cd = sm.Shop_Cd
                                AND sd.CallingDate is not NULL AND sm.IsActive = 1
                                AND ( ISNULL(sm.ShopStatus,'') = '' OR sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )
                            )
                            LEFT JOIN QCDetails qd on (qd.ScheduleCall_Cd=sd.ScheduleCall_Cd 
                            AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopSurvey' )
                            INNER JOIN CallingCategoryMaster ccm on (ccm.Calling_Category_Cd = sd.Calling_Category_Cd
                                AND ccm.Calling_Type = 'Survey' AND ccm.QC_Type in ('ShopSurvey')
                            )
                            WHERE qd.QC_Detail_Cd IS NULL 
                        ),0) AS QCPending
                        ";
                        // echo $query;
                    $dbQC=new DbOperation();
                    $QCPendingData = $dbQC->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
                }else if($qcType=='ShopDocument'){
                    $query = "SELECT
                        'Shop Document' as QC_Title,
                        'ShopDocument' as QC_Type,
                        'Pending' as QC_Filter,
                        ISNULL((SELECT CONVERT(VARCHAR,Min(st.ST_DateTime),23)
                            FROM ScheduleDetails sd 
                            INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                AND st.ST_Status = 1 AND st.ST_DateTime is not NULL
                            )
                            INNER JOIN ShopMaster sm on (sd.Shop_Cd = sm.Shop_Cd
                                AND sd.CallingDate is not NULL AND sm.IsActive = 1
                                AND ( ISNULL(sm.ShopStatus,'') = '' OR sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )
                            )
                            LEFT JOIN QCDetails qd on (qd.ScheduleCall_Cd=sd.ScheduleCall_Cd 
                            AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopDocument' )
                            INNER JOIN CallingCategoryMaster ccm on (ccm.Calling_Category_Cd = sd.Calling_Category_Cd
                                AND ccm.Calling_Type = 'Survey' AND ccm.QC_Type in ('ShopDocument')
                            )
                            WHERE qd.QC_Detail_Cd IS NULL
                        ),'') AS MinDate,
                        ISNULL((SELECT CONVERT(VARCHAR,MAX(st.ST_DateTime),23)
                            FROM ScheduleDetails sd 
                            INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                AND st.ST_Status = 1 AND st.ST_DateTime is not NULL
                            )
                            INNER JOIN ShopMaster sm on (sd.Shop_Cd = sm.Shop_Cd
                                AND sd.CallingDate is not NULL AND sm.IsActive = 1
                                AND ( ISNULL(sm.ShopStatus,'') = '' OR sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )
                            )
                            LEFT JOIN QCDetails qd on (qd.ScheduleCall_Cd=sd.ScheduleCall_Cd 
                            AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopDocument' )
                            INNER JOIN CallingCategoryMaster ccm on (ccm.Calling_Category_Cd = sd.Calling_Category_Cd
                                AND ccm.Calling_Type = 'Survey' AND ccm.QC_Type in ('ShopDocument')
                            )
                            WHERE qd.QC_Detail_Cd IS NULL
                        ),'') AS MaxDate,
                        ISNULL((SELECT COUNT(sd.ScheduleCall_Cd)
                            FROM ScheduleDetails sd 
                            INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                AND st.ST_Status = 1 AND st.ST_DateTime is not NULL
                            )
                            INNER JOIN ShopMaster sm on (sd.Shop_Cd = sm.Shop_Cd
                                AND sd.CallingDate is not NULL AND sm.IsActive = 1
                                AND ( ISNULL(sm.ShopStatus,'') = '' OR sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )
                            )
                            LEFT JOIN QCDetails qd on (qd.ScheduleCall_Cd=sd.ScheduleCall_Cd 
                            AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopDocument' )
                            INNER JOIN CallingCategoryMaster ccm on (ccm.Calling_Category_Cd = sd.Calling_Category_Cd
                                AND ccm.Calling_Type = 'Survey' AND ccm.QC_Type in ('ShopDocument')
                            )
                            WHERE qd.QC_Detail_Cd IS NULL 
                        ),0) AS QCPending
                        ";
                    $dbQC=new DbOperation();
                    $QCPendingData = $dbQC->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
                }else if($qcType=='ShopCalling'){
                    $query = "SELECT
                        'Shop Calling' as QC_Title,
                        'ShopCalling' as QC_Type,
                        'Pending' as QC_Filter,
                        ISNULL((SELECT CONVERT(VARCHAR,Min(cd.Call_DateTime),23)
                        FROM CallingDetails cd
                        INNER JOIN  ShopMaster sm  on ( sm.Shop_Cd = cd.Shop_Cd 
                            AND sm.IsActive=1
                            AND ( cd.QC_Flag IS NULL OR cd.QC_Flag = 0 ) 
                            AND cd.Call_Response_Cd = 4
                            AND ISNULL(cd.AudioFile_Url,'') <> '') 
                        ),'') AS MinDate,
                        ISNULL((SELECT CONVERT(VARCHAR,MAX(cd.Call_DateTime),23)
                        FROM CallingDetails cd
                        INNER JOIN  ShopMaster sm  on ( sm.Shop_Cd = cd.Shop_Cd 
                            AND sm.IsActive=1
                            AND ( cd.QC_Flag IS NULL OR cd.QC_Flag = 0 ) 
                            AND cd.Call_Response_Cd = 4
                            AND ISNULL(cd.AudioFile_Url,'') <> '') 
                        ),'') AS MaxDate,
                        ISNULL((SELECT COUNT(cd.Calling_Cd)
                        FROM CallingDetails cd
                        INNER JOIN  ShopMaster sm  on ( sm.Shop_Cd = cd.Shop_Cd 
                            AND sm.IsActive=1
                            AND ( cd.QC_Flag IS NULL OR cd.QC_Flag = 0 ) 
                            AND cd.Call_Response_Cd = 4
                            AND ISNULL(cd.AudioFile_Url,'') <> '')
                        ),0) AS QCPending
                        ";
                    $dbQC=new DbOperation();
                    $QCPendingData = $dbQC->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
                }
                 
            ?>  


                <?php
                    if(sizeof($QCPendingData)>0){
                ?>
                    <div class="col-xl-3 col-md-3 col-sm-12 col-12">
                        <a href="home.php?p=shop-qc-list&qcType=<?php echo $QCPendingData["QC_Type"];?>&qcFilter=<?php echo $QCPendingData["QC_Filter"];?>&minDate=<?php echo $QCPendingData["MinDate"];?>&maxDate=<?php echo $QCPendingData["MaxDate"];?>">    
                            <div class="card bg-primary">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="avatar bg-light-danger p-50  mr-2">
                                            <div class="avatar-content">
                                                <i class="feather icon-shopping-bag avatar-icon p-50  mr-2"></i>
                                            </div>  
                                        </div>
                                        <div class="media-body my-auto">
                                            <h4 class="text-white font-weight-bolder mb-0"><?php echo $QCPendingData["QC_Title"];?></h4>
                                            <p class="text-white font-medium-2 mb-0"><?php echo $QCPendingData['QCPending'];?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php
                    }
                ?>

            <?php 
                }
            ?>
        </div>


        <div class="row">
            <?php 

            $fromDate = $_SESSION['SAL_FromDate']." ".$_SESSION['StartTime'];
            $toDate = $_SESSION['SAL_ToDate']." ".$_SESSION['EndTime'];
            if($executiveCd == '0'){
                $qcExecutiveCondition = " ";
            }else{
                $qcExecutiveCondition = " AND qd.Executive_Cd = $executiveCd ";
            }
                $query="SELECT
                        CONVERT(VARCHAR,qd.QC_DateTime,23) AS QC_Date
                    FROM QCDetails qd
                    WHERE CONVERT(VARCHAR,qd.QC_DateTime,120) BETWEEN '$fromDate' AND '$toDate'
                    $qcExecutiveCondition
                    GROUP BY CONVERT(VARCHAR,qd.QC_DateTime,23) 
                    ORDER BY CONVERT(VARCHAR,qd.QC_DateTime,23) DESC";
                    // echo $query;
                $dbQC=new DbOperation();
                $QCSummaryData = $dbQC->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);

                if($executiveCd != '0'){
                    $db4=new DbOperation();
                    $query4 ="SELECT 
                    em.ExecutiveName
                    FROM LoginMaster lm 
                    INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = lm.Executive_Cd
                    WHERE lm.Executive_Cd = $executiveCd";
                    $dataExecutive= $db4->ExecutveQuerySingleRowSALData($query4, $electionName, $developmentMode);
                }

            ?>
            <div class="col-xl-12 col-md-12 col-xs-12">
                <div class="card">
                            <div class="row">
                                <div class="col-xl-11 col-md-11 col-xs-11">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                        Shop QC Summary - <?php echo $dataExecutive["ExecutiveName"]; ?>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered complex-headers zero-configuration" width="100%">
                                        <thead>
                                            <tr>
                                            
                                                <th style="text-align:center;">Sr<br>No</th>
                                                <th style="text-align:left;">QC Date</th>
                                                <?php
                                                    foreach ($qcTypeArray as $key => $qcTypeValue) {
                                                        $qcTitle = $qcTypeValue["QC_Title"];
                                                        $qcType = $qcTypeValue["QC_Type"];
                                                ?>
                                                    <th style="text-align:center;"><?php echo $qcTitle; ?></th>
                                                <?php
                                                    }
                                                ?>
                                                <!-- <th style="text-align:center;">Total</th>  -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $srno = 1;
                                            foreach($QCSummaryData as $value){
                                            $qcDate = $value["QC_Date"];        
                                            ?>
                                            <tr>
                                                <td><?php echo $srno++; ?></td>
                                                <td>
                                                    <?php  echo date('d/m/Y',strtotime($qcDate)); ?>  
                                                </td>
                                                <?php 
                                                    $qcTypeRowTotal = 0;
                                                    foreach ($qcTypeArray as $key => $qcTypeValue) {
                                                        $qcTitle = $qcTypeValue["QC_Type"];
                                                        $qcType = $qcTypeValue["QC_Type"];
                                                        $qcTypeRowCount = 0;
                                                        $queryQC = "SELECT 
                                                            ISNULL((
                                                                SELECT
                                                                    COUNT(DISTINCT(qd.Shop_Cd))
                                                                FROM QCDetails qd
                                                                WHERE CONVERT(VARCHAR,qd.QC_DateTime,120) 
                                                                BETWEEN '$qcDate'+' 00:00:00' 
                                                                AND '$qcDate'+' 23:59:59'
                                                                AND qd.QC_Type = '$qcType'
                                                                $qcExecutiveCondition
                                                            ),0) AS QC_Count";
                                                            // echo $queryQC;
                                                        $dbQCC=new DbOperation();
                                                        $QC_CountData = $dbQCC->ExecutveQuerySingleRowSALData($queryQC, $electionName, $developmentMode);
                                                        $qcTypeRowCount = $QC_CountData["QC_Count"];
                                                        $qcTypeRowTotal = $qcTypeRowTotal + $qcTypeRowCount;
                                                ?>
                                                    <td style="text-align:center;">
                                                       <?php echo $qcTypeRowCount; ?> 
                                                    </td>
                                                <?php
                                                    }
                                                ?>
                                                <!-- <td><?php echo $qcTypeRowTotal; ?></td> -->
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>


        


    </section>


</div>