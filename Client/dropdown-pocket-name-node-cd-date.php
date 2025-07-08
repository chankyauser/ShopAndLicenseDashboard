<?php

      $db=new DbOperation();
      $userName=$_SESSION['SAL_UserName'];
      $appName=$_SESSION['SAL_AppName'];
      $electionName=$_SESSION['SAL_ElectionName'];
      $developmentMode=$_SESSION['SAL_DevelopmentMode'];
      $node_Cd = 0;
      if(isset($_SESSION['SAL_Node_Cd'])){
        $node_Cd = $_SESSION['SAL_Node_Cd'];
      }else if(isset($_GET['nodeCd'])){
        $node_Cd = $_GET['nodeCd'];
        $_SESSION['SAL_Node_Cd'] = $node_Cd;
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

    $fromDate = $from_Date." ".$_SESSION['StartTime'];;
    $toDate = $to_Date." ".$_SESSION['EndTime'];

       $query = "SELECT COALESCE(pm.Pocket_Cd, 0) as Pocket_Cd,
                    COALESCE(pm.PocketName, '') as PocketName
                    FROM PocketMaster as pm
                    INNER JOIN ShopMaster as sm 
                    ON pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1
                    WHERE pm.IsActive = 1 AND pm.Node_Cd = $node_Cd AND pm.Node_Cd <> 0 
                    AND CONVERT(VARCHAR, sm.PLCreatedDate ,120) BETWEEN '$fromDate' AND '$toDate' 
                    GROUP BY pm.Pocket_Cd, pm.PocketName ORDER BY pm.Pocket_Cd DESC;";
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
                 <option value="">--Select--</option>
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
                  }
                ?> 
            </select>
        </div>
    </div>
<!-- </div> -->