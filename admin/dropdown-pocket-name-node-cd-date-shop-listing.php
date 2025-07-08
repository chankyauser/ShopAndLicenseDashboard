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

       $query = "SELECT COALESCE(pm.Pocket_Cd, 0) as Pocket_Cd,
                    COALESCE(pm.PocketName, '') as PocketName,
                    COALESCE(pm.KML_FileUrl, '') as KML_FileUrl
                    FROM PocketMaster as pm
                    INNER JOIN ShopMaster as sm 
                    ON pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1
                    INNER JOIN NodeMaster nm on pm.Node_Cd = nm.Node_Cd
                    WHERE pm.IsActive = 1 
                    $nodeCondition
                    $nodeNameCondition
                    AND CONVERT(VARCHAR, sm.AddedDate ,120) BETWEEN '$fromDate' AND '$toDate' 
                    AND CONVERT(VARCHAR, sm.PlCreatedDate ,120) BETWEEN '$fromDate' AND '$toDate' 
                    GROUP BY pm.Pocket_Cd, pm.PocketName, pm.KML_FileUrl 
                    ORDER BY pm.Pocket_Cd DESC;";  
            // echo $query;
        $db1=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];
        $dataPocketSummary = $db1->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
?>

<!-- <div class="col-sm-12"> -->
     <div class="form-group">
        <label>Pocket Name</label>
        <div class="controls">
            <?php 
               
            ?>
            <select class="select2 form-control" name="pocket_Name"
                
            
            >
                 <option <?php echo $pocketCd == 'All' ? 'selected=true' : '';
                                if($pocketCd == 'All'){
                                $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
                            }
                ?> value="All">All</option>
                 <?php
                if (sizeof($dataPocketSummary)>0) 
                {
                    foreach ($dataPocketSummary as $key => $value) 
                      {
                          if((isset($_GET['pocketId']) && $_GET['pocketId'] == $value["Pocket_Cd"]))
                          {
                    ?>
                            <option selected="true" value="<?php echo $value['Pocket_Cd']; ?>"><?php echo $value["PocketName"]; ?></option>
                    <?php
                          }else if($_SESSION['SAL_Pocket_Cd'] == $value["Pocket_Cd"])
                          {
                    ?>
                            <option selected="true" value="<?php echo $value['Pocket_Cd']; ?>"><?php echo $value["PocketName"]; ?></option>
                    <?php
                          }
                          else
                          {
                ?>
                            <option value="<?php echo $value["Pocket_Cd"];?>"><?php echo $value["PocketName"];?></option>
                <?php
                          }
                      }
                  }else{
                    $pocketCd = "All";
                    $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
                  }
                ?> 
            </select>
        </div>
    </div>
<!-- </div> -->