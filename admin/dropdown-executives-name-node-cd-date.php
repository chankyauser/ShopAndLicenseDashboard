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
        if(isset($_GET['node_Name'])){
            $nodeName = $_GET['node_Name'];
            $_SESSION['SAL_Node_Name'] = $nodeName;
        }
    }else {
        $nodeName = "All";
        $_SESSION['SAL_Node_Name'] = $nodeName;
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

    if(isset($_GET['pocketCd'])){
        $pocketCd = $_GET['pocketCd'];
        $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
    }else if(isset($_SESSION['SAL_Pocket_Cd'])){
        $pocketCd = $_SESSION['SAL_Pocket_Cd'];
    }else if(isset($_GET['pocketId'])){
        $pocketCd = $_GET['pocketId'];
        $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
    }else{
        $pocketCd = "All";
        $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
    }
    
    if(isset($_GET['executiveCd'])){
        $executiveCd = $_GET['executiveCd'];
        $_SESSION['SAL_Executive_Cd'] = $executiveCd;
    }else if(isset($_SESSION['SAL_Executive_Cd'])){
        $executiveCd = $_SESSION['SAL_Executive_Cd'];
    }else{
        $executiveCd = "All";
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

    if($pocketCd == 'All'){
        $pcktCondition = "  ";
    }else{
        $pcktCondition = " AND sm.Pocket_Cd = $pocketCd ";
    }

    $fromDate = $from_Date." ".$_SESSION['StartTime'];;
    $toDate = $to_Date." ".$_SESSION['EndTime'];

       $query = "SELECT
            ISNULL(sm.SRExecutive_Cd,0) as Executive_Cd, 
            ISNULL(em.ExecutiveName,'')  as ExecutiveName,
            ISNULL(lm.Mobile_No,'')  as MobileNo,
            COUNT(distinct(sm.Shop_Cd)) as ShopCount
            FROM LoginMaster lm
            INNER JOIN ShopMaster sm on (sm.SRExecutive_Cd = lm.Executive_Cd
                AND lm.User_Type like '%Executive%'
                AND CONVERT(VARCHAR, sm.SurveyDate, 120) BETWEEN '$fromDate' AND '$toDate'
                AND sm.IsActive = 1  )
            INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = lm.Executive_Cd
            INNER JOIN PocketMaster pm on ( pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
            INNER JOIN NodeMaster nm on ( nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
            WHERE pm.IsActive = 1 
            $nodeCondition
            $nodeNameCondition
            $pcktCondition
            GROUP BY sm.SRExecutive_Cd, em.ExecutiveName,lm.Mobile_No
            ORDER BY ExecutiveName ASC;";
        $db1=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];
        // echo $query;
        $dataExecutiveSummary = $db1->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
?>

<!-- <div class="col-sm-12"> -->
     <div class="form-group">
        <label>Survey Executive</label>
        <div class="controls">
            <?php 
               
            ?>
            <select class="select2 form-control" name="executive_Name"
                
            
            >
                 <option <?php echo $executiveCd == 'All' ? 'selected=true' : '';
                                if($executiveCd == 'All'){
                                $_SESSION['SAL_Executive_Cd'] = $executiveCd;
                            }
                ?> value="All">All</option>
                 <?php
                if (sizeof($dataExecutiveSummary)>0) 
                {
                    foreach ($dataExecutiveSummary as $key => $value) 
                      {
                           if($_SESSION['SAL_Executive_Cd'] == $value["Executive_Cd"])
                          {
                    ?>
                            <option selected="true" value="<?php echo $value['Executive_Cd']; ?>"><?php echo $value["ExecutiveName"]." ( ".$value["ShopCount"]." )"; ?></option>
                    <?php
                          }
                          else
                          {
                ?>
                            <option value="<?php echo $value["Executive_Cd"];?>"><?php echo $value["ExecutiveName"]." ( ".$value["ShopCount"]." )";?></option>
                <?php
                          }
                      }
                  }else{
                    $executiveCd = "All";
                    $_SESSION['SAL_Executive_Cd'] = $executiveCd;
                  }
                ?> 
            </select>
        </div>
    </div>
<!-- </div> -->