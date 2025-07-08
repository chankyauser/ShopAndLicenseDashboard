<?php
if(isset($_GET['nodeCd'])){
    session_start();
    include '../../api/includes/DbOperation.php';
}
    $db1=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    if(isset($_GET['nodeCd'])){
        $nodeCd = $_GET['nodeCd'];
        $_SESSION['SAL_Node_Cd'] = $nodeCd;
    }else if(isset($_SESSION['SAL_Node_Cd'])){
        $nodeCd = $_SESSION['SAL_Node_Cd'];
    }
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

    if($nodeCd == 'All'){
        $nodeCondition = " AND pm.Node_Cd <> 0  "; 
    }else{
        $nodeCondition = " AND pm.Node_Cd = $nodeCd AND pm.Node_Cd <> 0  "; 
    }

    if($nodeName == 'All'){
        $nodeNameCondition = " AND nm.NodeName <> '' ";
    }else{
        $nodeNameCondition = " AND nm.NodeName = '$nodeName' ";
    }

    $fromDate = $from_Date." ".$_SESSION['StartTime'];;
    $toDate = $to_Date." ".$_SESSION['EndTime'];
    $query = "SELECT COALESCE(a.Pocket_Cd, 0) as Pocket_Cd, COALESCE(pmm.Node_Cd, 0) as Node_Cd, 
                CASE WHEN pmm.IsCompleted IS NULL THEN 'Pending' ELSE CASE WHEN COALESCE(pmm.IsCompleted, 0) = 0 THEN 'On going' ELSE 'Completed' END END as IsCompleted,
                COALESCE(nmm.Ward_No, 0) as Ward_No, COALESCE(nmm.NodeName, '') as NodeName, COALESCE(nmm.Area, '') as WardArea,
                ISNULL((
                    SELECT
                        TOP 1 CONVERT(varchar, sm.SurveyDate, 5)
                    FROM ShopMaster sm
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.AddedDate IS NOT NULL AND sm.SurveyDate IS NOT NULL )
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Ward_No = nmm.Ward_No)
                ),0) as WardSurveyStartDate,
				ISNULL((
                    SELECT
                        TOP 1 CONVERT(varchar, sm.SurveyDate, 5)
                    FROM ShopMaster sm
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.AddedDate IS NOT NULL AND sm.SurveyDate IS NOT NULL )
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Ward_No = nmm.Ward_No)
                    ORDER BY CONVERT(varchar, sm.SurveyDate, 5) DESC ),0) as WardSurveyEndDate,
                COALESCE(nmm.Ward_No, 0) as Ward_No, COALESCE(nmm.NodeName, '') as NodeName, COALESCE(nmm.Area, '') as WardArea,
                COALESCE(pmm.PocketName, '') as PocketName, COALESCE(pmm.PocketNameMar, '') as PocketNameMar,
                ISNULL(( SELECT COUNT(sm.Shop_Cd) FROM ShopMaster sm WHERE sm.Pocket_Cd = a.Pocket_Cd AND sm.IsActive=1 AND sm.AddedDate IS NOT NULL),0) as ShopListed, 
                ISNULL((SELECT COUNT(sm.Shop_Cd) FROM ShopMaster sm WHERE sm.Pocket_Cd = a.Pocket_Cd AND sm.IsActive=1 AND sm.SurveyDate IS NOT NULL),0) as SurveyAll, 
                ISNULL((SELECT COUNT(sm.Shop_Cd) FROM ShopMaster sm INNER JOIN PocketMaster pm on pm.Pocket_Cd=sm.Pocket_Cd 
                    INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd WHERE sm.Pocket_Cd = a.Pocket_Cd AND sm.IsActive=1 
                    AND CONVERT(VARCHAR, sm.SurveyDate, 120) BETWEEN '$fromDate' AND '$toDate'
                    $nodeNameCondition
                    $nodeCondition
                 ),0) as SurveyDone,
                 ISNULL((SELECT  STRING_AGG(a.ExecutiveName,', ') 
                    FROM ( SELECT em.ExecutiveName FROM ShopMaster sm INNER JOIN PocketMaster pm on pm.Pocket_Cd=sm.Pocket_Cd 
                    INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd INNER JOIN Survey_Entry_Data..User_Master um on (um.UserName = sm.SurveyBy AND um.AppName = '$appName' ) INNER JOIN Survey_Entry_Data..Executive_Master em on (um.Executive_Cd = em.Executive_Cd AND um.AppName = '$appName' ) WHERE sm.Pocket_Cd = a.Pocket_Cd AND sm.IsActive=1 
                    AND CONVERT(VARCHAR, sm.SurveyDate, 120) BETWEEN '$fromDate' AND '$toDate'
                    $nodeNameCondition
                    $nodeCondition
                    GROUP BY em.ExecutiveName  
                ) a ),'') as ExecutiveNames
            FROM ( SELECT sm.Pocket_Cd 
                FROM PocketMaster as pm INNER JOIN ShopMaster as sm on ( pm.Pocket_Cd = sm.Pocket_Cd 
                AND sm.IsActive = 1 AND pm.Node_Cd <> 0 ) 
                INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd 
                WHERE pm.IsActive = 1 AND nm.NodeName <> '' 
                GROUP BY sm.Pocket_Cd 
            ) as a 
            INNER JOIN PocketMaster pmm on pmm.Pocket_Cd = a.Pocket_Cd 
            INNER JOIN NodeMaster nmm on nmm.Node_Cd = pmm.Node_Cd 
            GROUP BY a.Pocket_Cd, pmm.Node_Cd, nmm.Ward_No, nmm.NodeName, nmm.Area, pmm.PocketName, pmm.PocketNameMar, pmm.IsCompleted;";
        
        // echo $query;
    $dataPocketMapAndListSummary = $db1->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);

      
?>

 <?php 
    if(sizeof($dataPocketMapAndListSummary)>0){
?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered complex-headers">
                            <!-- <table class="table row-grouping"> -->
                                <thead>
                                    <tr>
                                        <th colspan="6">Pocket Detail</th>
                                        <th colspan="2">Survey : <?php echo date('d/m/Y',strtotime($from_Date))." - ".date('d/m/Y',strtotime($to_Date));  ?></th>
                                        <th colspan="4">Survey OverAll</th>
                                    </tr>
                                    <tr>
                                        <th>SrNo</th>
                                        <th>Pocket </th>
                                        <th>Ward</th>
                                        <th>Survey Status</th>
                                        <th>Survey Start Date</th>
                                        <th>Survey End Date</th>
                                        <th>Executive</th>
                                        <th>Survey</th>
                                        <th>Listed </th>
                                        <th>Completed</th>
                                        <th>Pending</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $srNo=0;
                                        $totalSurveyShops=0;
                                        $totalShopsListed=0;
                                        $totalShopsSurvey=0;
                                        $totalShopsPending=0;
                                        foreach ($dataPocketMapAndListSummary as $key => $value) {
                                            $srNo = $srNo + 1;
                                             $totalSurveyShops = $totalSurveyShops + $value["SurveyDone"];
                                             $totalShopsListed = $totalShopsListed + $value["ShopListed"];
                                             $totalShopsSurvey = $totalShopsSurvey + $value["SurveyAll"];
                                             $totalShopsPending = $totalShopsPending + ($value["ShopListed"]-$value["SurveyAll"]);
                                   ?> 
                                        <tr>
                                            <td><?php echo $srNo; ?></td>
                                            <td><?php echo $value["PocketName"]; ?></td>
                                            <td><?php echo $value["Ward_No"]." - ".$value["WardArea"].", ".$value["NodeName"]; ?></td>
                                            <td><?php echo $value["IsCompleted"]; ?></td>
                                            <td><?php echo $value["WardSurveyStartDate"]; ?></td>
                                            <td><?php echo $value["WardSurveyEndDate"]; ?></td>
                                            <td><?php echo $value["ExecutiveNames"]; ?></td>
                                            <td><?php echo $value["SurveyDone"]; ?></td>
                                            <td><?php echo $value["ShopListed"]; ?></td>
                                            <td><?php echo $value["SurveyAll"]; ?></td>
                                            <td><?php echo ($value["ShopListed"]-$value["SurveyAll"]); ?></td>
                                            <td>
                                                <a href="home.php?p=pocket-wise-survey-detail&nodeId=<?php echo $value["Node_Cd"];?>&pocketId=<?php echo $value["Pocket_Cd"];?>&tab=mapIcon"><i class="feather icon-map-pin mr-50 font-medium-3"></i></a>
                                                <a href="home.php?p=pocket-wise-survey-detail&nodeId=<?php echo $value["Node_Cd"];?>&pocketId=<?php echo $value["Pocket_Cd"];?>&tab=listIcon"><i class="feather icon-list mr-50 font-medium-3"></i></a>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                   ?>
                                <tfoot>
                                    <tr>
                                        <th colspan="7">Total</th>
                                        <th><?php echo $totalSurveyShops; ?></th>
                                        <th><?php echo $totalShopsListed; ?></th>
                                        <th><?php echo $totalShopsSurvey; ?></th>
                                        <th><?php echo $totalShopsPending; ?></th>
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

<?php 
    }
?>

