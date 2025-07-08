<?php

      $db=new DbOperation();
      $userName=$_SESSION['SAL_UserName'];
      $appName=$_SESSION['SAL_AppName'];
      $electionName=$_SESSION['SAL_ElectionName'];
      $developmentMode=$_SESSION['SAL_DevelopmentMode'];
      
    if(isset($_SESSION['SAL_Node_Cd'])){
        $nodeCd = $_SESSION['SAL_Node_Cd'];
    }else if(isset($_GET['nodeCd'])){
        $nodeCd = $_GET['nodeCd'];
        $_SESSION['SAL_Node_Cd'] = $nodeCd;
    }else{
        $nodeCd = "All";
        $_SESSION['SAL_Node_Cd'] = $nodeCd;
    }

    if(isset($_SESSION['SAL_Node_Name'])){
        $nodeName = $_SESSION['SAL_Node_Name'];
    }else{
        $nodeName = "All";
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

    $query = "SELECT COALESCE(cdt.Executive_Cd, 0) as Executive_Cd,
    COALESCE(em.ExecutiveName, '') as ExecutiveName,
    COALESCE(em.MobileNo, '') as MobileNo, 
    COALESCE(CONVERT(VARCHAR,cdt.Call_DateTime,23),'') as Call_Date,
    COALESCE(SUM(CASE WHEN cdt.Call_Response_Cd = 4 THEN 1 ELSE 0 END),0) as ConnectedCount,
    COALESCE(COUNT(DISTINCT(cdt.Calling_Cd)),0) as CallCount
    FROM ShopTracking st 
    INNER JOIN LoginMaster lm on ( lm.Executive_Cd = st.AssignExec_Cd AND lm.User_Type like '%Calling%' )
    INNER JOIN ScheduleDetails scd on ( 
        scd.ScheduleCall_Cd = st.ScheduleCall_Cd AND scd.Shop_Cd = st.Shop_Cd 
    )
    INNER JOIN CallingDetails cdt on (  st.AssignExec_Cd = cdt.Executive_Cd
        AND  st.ScheduleCall_Cd  = cdt.ScheduleCall_Cd 
        AND CONVERT(VARCHAR,cdt.Call_DateTime,120) BETWEEN '$fromDate' AND '$toDate'
    )
    INNER JOIN ShopMaster sm on st.Shop_Cd = sm.Shop_Cd
    INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = st.AssignExec_Cd
    INNER JOIN Call_Response_Master crm on crm.Call_Response_Cd = cdt.Call_Response_Cd
    INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
    INNER JOIN NodeMaster nm on pm.Node_Cd = nm.Node_Cd
    WHERE sm.IsActive = 1 AND pm.IsActive = 1
    $nodeCondition
    $nodeNameCondition
    GROUP BY cdt.Executive_Cd,  em.ExecutiveName, em.MobileNo,
    CONVERT(VARCHAR,cdt.Call_DateTime,23)
    ORDER BY em.ExecutiveName ASC, Call_Date DESC;";
    
    // echo $query; 

    $db1=new DbOperation();
    $dataCallingExecutiveSummary = $db1->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
    // print_r($dataCallingExecutiveSummary);

    if (sizeof($dataCallingExecutiveSummary)>0) 
    {
        if(!isset($_SESSION['SAL_CC_Executive_Cd'])){
            $_SESSION['SAL_CC_Executive_Cd'] =  $dataCallingExecutiveSummary[0]["Executive_Cd"];
            $executiveCd = $_SESSION['SAL_CC_Executive_Cd'];
        }
    }
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Shop Calling Executives </h4>
                <h4 class="card-title" style="margin-right:15px;"><?php if(isset($_SESSION['SAL_Ward_No'])){ echo "Ward No : ".$_SESSION['SAL_Ward_No'];   } ?></h4>
            </div>

            <div class="card-content">
                <div class="card-body">
                    <table  class="table row-grouping">
                        <thead>
                            <!-- <th>SrNo</th> -->
                            <th width="40%">Call Date</th>
                            <th>Connected Counts</th>
                            <th>Executive Name</th>
                            <th>Not Connected Counts</th>
                            <th>Call Counts</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                    <?php 
                        $srNo = 0;
                         foreach ($dataCallingExecutiveSummary as $key => $valueExe) {
                            $srNo = $srNo + 1;
                   ?>
                            <tr>
                                <!-- <td><?php //echo $srNo; ?></td> -->
                                <td><?php echo date('d/m/Y',strtotime($valueExe["Call_Date"])); ?></td>
                                <td><?php echo $valueExe["ConnectedCount"]; ?></td>
                                <td><?php echo $valueExe["ExecutiveName"]." (".$valueExe["MobileNo"].")"; ?></td>
                                <td><?php echo ($valueExe["CallCount"]-$valueExe["ConnectedCount"]); ?></td>
                                <td><?php echo $valueExe["CallCount"]; ?></td>
                                <td><a href="home.php?p=calling-detail&callingDate=<?php echo $valueExe["Call_Date"] ?>&executiveId=<?php echo $valueExe["Executive_Cd"] ?>"><button class="btn btn-primary">View</button></td>
                            
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