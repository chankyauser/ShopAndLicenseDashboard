<?php

        $db=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];

        if(isset($_GET['fromDate'])){
            $from_Date = $_GET['fromDate'];
            $_SESSION['SAL_FromDate'] = $from_Date;
        }else if(isset($_SESSION['SAL_FromDate'])){
            $from_Date = $_SESSION['SAL_FromDate'];
        }

        if(isset($_GET['toDate'])){
            $to_Date = $_GET['toDate'];
            $_SESSION['SAL_ToDate'] = $from_Date;
        }else if(isset($_SESSION['SAL_ToDate'])){
            $to_Date = $_SESSION['SAL_ToDate'];
        }

        $fromDate = $from_Date." ".$_SESSION['StartTime'];
        $toDate = $to_Date." ".$_SESSION['EndTime'];

        if($nodeCd == 'All'){
            $nodeCondition = " AND pm.Node_Cd <> ''  "; 
        }else{
            $nodeCondition = " AND pm.Node_Cd = $nodeCd AND pm.Node_Cd <> ''  "; 
        }

        if($nodeName == 'All'){
            $nodeNameCondition = " AND nm.NodeName <> '' ";
        }else{
            $nodeNameCondition = " AND nm.NodeName = '$nodeName' ";
        }

        $query = "SELECT 
                ISNULL(cccm.Calling_Category_Cd,0) as Calling_Category_Cd,
                ISNULL(cccm.Calling_Category,'') as Calling_Category,
                ISNULL(cccm.Calling_Type, '') as  Calling_Type,
                ISNULL((
                    SELECT COUNT(DISTINCT(scd.ScheduleCall_Cd))
                    FROM ScheduleDetails scd,
                    CallingCategoryMaster ccm,
                    ShopMaster sm,
                    PocketMaster pm,
                    NodeMaster nm
                    WHERE ccm.Calling_Category_Cd = cccm.Calling_Category_Cd
                    AND scd.Calling_Category_Cd = ccm.Calling_Category_Cd
                    AND scd.Shop_Cd = sm.Shop_Cd
                    AND sm.Pocket_Cd = pm.Pocket_Cd
                    AND sm.IsActive = 1 AND pm.IsActive = 1
                    $nodeNameCondition
                    $nodeCondition
                ),0) as ScheduledCallsCount,
                ISNULL((
                    SELECT COUNT(DISTINCT(scd.ScheduleCall_Cd))
                    FROM ScheduleDetails scd
                    LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = scd.ScheduleCall_Cd
                    LEFT JOIN CallingCategoryMaster ccm on ccm.Calling_Category_Cd=st.Calling_Category_Cd
                    INNER JOIN ShopMaster sm on ( sm.Shop_Cd =scd.Shop_Cd AND sm.IsActive = 1 )
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
                    WHERE st.AssignDate is null
                    AND scd.Calling_Category_Cd = cccm.Calling_Category_Cd
                    $nodeNameCondition
                    $nodeCondition
                ),0) as NotAssignedCallsCount,
                ISNULL((
                    SELECT COUNT(DISTINCT(scd.ScheduleCall_Cd))
                    FROM ScheduleDetails scd,
                    ShopTracking st,
                    CallingCategoryMaster ccm,
                    ShopMaster sm,
                    PocketMaster pm,
                    NodeMaster nm
                    WHERE st.AssignDate is not null
                    AND st.ScheduleCall_Cd = scd.ScheduleCall_Cd
                    AND ccm.Calling_Category_Cd = cccm.Calling_Category_Cd
                    AND scd.Calling_Category_Cd = ccm.Calling_Category_Cd
                    AND scd.Shop_Cd = sm.Shop_Cd
                    AND sm.Pocket_Cd = pm.Pocket_Cd
                    AND sm.IsActive = 1 AND pm.IsActive = 1
                    $nodeNameCondition
                    $nodeCondition
                ),0) as AssignedCallsCount,
                ISNULL((
                    SELECT COUNT(DISTINCT(scd.ScheduleCall_Cd))
                    FROM ScheduleDetails scd,
                    ShopTracking st,
                    CallingCategoryMaster ccm,
                    ShopMaster sm,
                    PocketMaster pm,
                    NodeMaster nm
                    WHERE st.AssignDate is not null
                    AND st.ST_Status = 1
                    AND st.ScheduleCall_Cd = scd.ScheduleCall_Cd
                    AND ccm.Calling_Category_Cd = cccm.Calling_Category_Cd
                    AND scd.Calling_Category_Cd = ccm.Calling_Category_Cd
                    AND scd.Shop_Cd = sm.Shop_Cd
                    AND sm.Pocket_Cd = pm.Pocket_Cd
                    AND sm.IsActive = 1 AND pm.IsActive = 1
                    $nodeNameCondition
                    $nodeCondition
                ),0) as CompletedCallsCount,
                ISNULL((
                    SELECT COUNT(DISTINCT(cdt.Calling_Cd))
                    FROM CallingDetails cdt, 
                    ScheduleDetails scd,
                    ShopTracking st,
                    CallingCategoryMaster ccm,
                    ShopMaster sm,
                    PocketMaster pm,
                    NodeMaster nm
                    WHERE CONVERT(VARCHAR,cdt.Call_DateTime,120) 
                    BETWEEN '$fromDate' AND '$toDate'
                    AND cdt.Call_Response_Cd = 4
                    AND st.ST_Status = 1
                    AND ccm.Calling_Category_Cd = cccm.Calling_Category_Cd
                    AND cdt.ScheduleCall_Cd = scd.ScheduleCall_Cd
                    AND st.ScheduleCall_Cd = scd.ScheduleCall_Cd
                    AND scd.Calling_Category_Cd = ccm.Calling_Category_Cd
                    AND scd.Shop_Cd = sm.Shop_Cd
                    AND sm.Pocket_Cd = pm.Pocket_Cd
                    AND sm.IsActive = 1 AND pm.IsActive = 1
                    $nodeNameCondition
                    $nodeCondition
                ),0) as ConnectedCallsCount,
                ISNULL((
                    SELECT COUNT(DISTINCT(cdt.Calling_Cd))
                    FROM CallingDetails cdt, 
                    ScheduleDetails scd,
                    ShopTracking st,
                    CallingCategoryMaster ccm,
                    ShopMaster sm,
                    PocketMaster pm,
                    NodeMaster nm
                    WHERE CONVERT(VARCHAR,cdt.Call_DateTime,120) 
                    BETWEEN '$fromDate' AND '$toDate'
                    AND cdt.Call_Response_Cd <> 4
                    AND st.ST_Status = 1
                    AND ccm.Calling_Category_Cd = cccm.Calling_Category_Cd
                    AND cdt.ScheduleCall_Cd = scd.ScheduleCall_Cd
                    AND st.ScheduleCall_Cd = scd.ScheduleCall_Cd
                    AND scd.Calling_Category_Cd = ccm.Calling_Category_Cd
                    AND scd.Shop_Cd = sm.Shop_Cd
                    AND sm.Pocket_Cd = pm.Pocket_Cd
                    AND sm.IsActive = 1 AND pm.IsActive = 1
                    $nodeNameCondition
                    $nodeCondition
                ),0) as NotConnectedCallsCount
                FROM CallingCategoryMaster cccm 
                WHERE cccm.Calling_Type = 'Calling';";
                // echo $query;
        $CallingSummaryCountData = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
        // print_r($CallingSummaryCountData);
        
       ?> 
       <div class="row">
            <?php 
                // $subTotalCalling = 0;
                foreach($CallingSummaryCountData AS $CallingCountData)
                {
                    // $subTotalCalling = $subTotalCalling + $CallingCountData['TotalCallsCount'];
            ?>

                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">

                        <h4><?php echo $CallingCountData['Calling_Category'];?></h4>

                        <div class="row">
                            
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex align-items-start pb-0">
                                        <div>
                                            <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($CallingCountData["NotConnectedCallsCount"]); ?></h2>
                                            <label>Not Connected Calls </label>
                                        </div>
                                        <!-- <div class="avatar bg-rgba-danger p-50 m-0">
                                            <div class="avatar-content">
                                                <i class="feather icon-x-square text-danger font-medium-5"></i>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex align-items-start pb-0">
                                        <div>
                                            <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($CallingCountData["ConnectedCallsCount"]); ?></h2>
                                            <label>Connected Calls </label>
                                        </div>
                                       <!--  <div class="avatar bg-rgba-danger p-50 m-0">
                                            <div class="avatar-content">
                                                <i class="feather icon-smartphone text-danger font-medium-5"></i>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex align-items-start pb-0">
                                        <div>
                                            <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($CallingCountData["CompletedCallsCount"]); ?></h2>
                                            <label>Calling Completed </label>
                                        </div>
                                        <!-- <div class="avatar bg-rgba-success p-50 m-0">
                                            <div class="avatar-content">
                                                <i class="feather icon-square-check text-success font-medium-5"></i>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex align-items-start pb-0">
                                        <div>
                                            <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($CallingCountData["AssignedCallsCount"]); ?></h2>
                                            <label>Assigned Calls </label>
                                        </div>
                                        <!-- <div class="avatar bg-rgba-success p-50 m-0">
                                            <div class="avatar-content">
                                                <i class="feather icon-square-check text-success font-medium-5"></i>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex align-items-start pb-0">
                                        <div>
                                            <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($CallingCountData["NotAssignedCallsCount"]); ?></h2>
                                            <label>Not Assigned Calls </label>
                                        </div>
                                        <!-- <div class="avatar bg-rgba-success p-50 m-0">
                                            <div class="avatar-content">
                                                <i class="feather icon-square-check text-success font-medium-5"></i>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex align-items-start pb-0">
                                        <div>
                                            <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($CallingCountData["ScheduledCallsCount"]); ?></h2>
                                            <label>Scheduled Calls</label>
                                        </div>
                                        <!-- <div class="avatar bg-rgba-info p-50 m-0">
                                            <div class="avatar-content">
                                                <i class="feather icon-alert-shopping-bag text-info font-medium-5"></i>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                       <!--  <div class="card bg-primary">
                            <div class="card-body">
                                <div class="media">
                                    <div class="avatar bg-light-danger p-50  mr-2">
                                        <div class="avatar-content">
                                            <i class="feather icon-shopping-bag avatar-icon p-50  mr-2"></i>
                                        </div>  
                                    </div>
                                    <div class="media-body my-auto">
                                        <h4 class="text-white font-weight-bolder mb-0"><?php //echo $CallingCountData['TotalCallsCount']."/".$CallingCountData["AssignedCallsCount"]."/".$CallingCountData["ScheduledCallsCount"];?></h4>
                                        <p class="text-white font-medium-2 mb-0"></p>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
            <?php   
                } 
            ?>
        </div> 
                
<?php 
    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $query = "SELECT 
            ISNULL(ccm.Calling_Category_Cd,0) as Calling_Category_Cd,
            ISNULL(ccm.Calling_Category,'') as Calling_Category,
            ISNULL(ccm.Calling_Type, '') as  Calling_Type
            FROM CallingCategoryMaster ccm 
            WHERE ccm.Calling_Type = 'Calling';";

    $strCategory = "";
    $CallingSummaryColumns = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
    if(sizeof($CallingSummaryColumns)>0){
        foreach ($CallingSummaryColumns as $key => $value) {
            $strCategory .= "[". $value["Calling_Category_Cd"]."],";
        }    
    }
    $strCategory = substr($strCategory, 0, -1);
   

    $query1 = "SELECT * FROM (
        SELECT Call_Date,Calling_Category_Cd,Calling_Cd
        FROM View_CallingDetails 
        WHERE CONVERT(VARCHAR,Call_DateTime,120) 
        BETWEEN '$fromDate' AND '$toDate'
        AND Call_Response_Cd = 4) as SourceTable 
        PIVOT(COUNT(Calling_Cd) FOR Calling_Category_Cd in (
            $strCategory
        ) 
    ) AS PivotTable;";
        // echo $query1;

    $CallingSummaryTableData = $db->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);
    // print_r($CallingSummaryTableData);
?>



<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="tab-content pt-1">
                        <div class="tab-pane active" id="home-just" role="tabpanel" aria-labelledby="home-tab-justified">
                          
                                    <div class="row">
                                        <div class="col-12">
                                          
                                                    <div class="table-responsive">
                                                        <!-- <table class="table table-striped dataex-html5-selectors"> -->
                                                        <table class="table table-striped table-bordered complex-headers ">
                                                            <thead>
                                                            
                                                                <tr>
                                                                    <th>Sr No</th>
                                                                    <th>Calling Date</th>
                                                                <?php foreach($CallingSummaryColumns as $ColumnNames){ ?>
                                                                    <th><?php echo $ColumnNames['Calling_Category'];?></th>
                                                                <?php } ?>
                                                                    <th>Total</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                
                                                            </thead>
                                                            
                                                            <tbody>

                                                            <?php 
                                                                $srNo = 0;
                                                                foreach ($CallingSummaryTableData as $value) {  
                                                                    $srNo = $srNo + 1;  
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $srNo; ?></td>
                                                                    <td><?php echo date('d/m/Y',strtotime($value["Call_Date"])); ?></td>
                                                                    <?php 
                                                                        $totalPerDate = 0;
                                                                        foreach($CallingSummaryColumns as $ColumnNames){ 
                                                                            $categoryCd = $ColumnNames['Calling_Category_Cd'];
                                                                            $totalPerDate = $totalPerDate + $value[$categoryCd];
                                                                    ?>
                                                                        <td><?php echo $value[$categoryCd];?></td>
                                                                    <?php } ?>
                                                                    <td><?php echo $totalPerDate; ?></td>
                                                                    <td><a href="home.php?p=calling-detail&callingDate=<?php echo $value["Call_Date"] ?>"> <button type="button" name="refesh" class="btn btn-primary">View</button></td> </a>
                                                                </tr>
                                                            <?php } ?>

                                                            
                                                              
                                                            </tbody>

                                                            <tfoot>
                                                                <tr>
                                                                    <th colspan="2">Total</th>
                                                                    <?php  foreach($CallingSummaryCountData AS $CallingCountData) { ?>
                                                                    <th><?php echo $CallingCountData['TotalCallsCount'];?></th>
                                                                    <?php } ?>
                                                                    <th><?php echo $subTotalCalling; ?></th>
                                                                    <th></th>
                                                                </tr>
                                                            </tfoot>

                                                        </table>
                                                    </div>
                                        </div>
                                    </div>
                            
                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    