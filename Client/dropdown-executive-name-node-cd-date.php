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

       $query = "SELECT COALESCE(pm.PLExecutive_Cd, 0) as PLExecutive_Cd,
                    COALESCE(em.FullName, '') as ExecutiveName
                    FROM PocketMaster as pm
                    INNER JOIN ExecutiveMaster em
                    ON em.Executive_Cd = pm.PLExecutive_Cd
                    INNER JOIN ShopMaster as sm 
                    ON pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1
                    WHERE pm.IsActive = 1 AND pm.Node_Cd = $node_Cd AND pm.Node_Cd <> 0 
                    AND CONVERT(VARCHAR, sm.PLCreatedDate ,120) BETWEEN '$fromDate' AND '$toDate' 
                    GROUP BY pm.PLExecutive_Cd, em.FullName ORDER BY em.FullName ASC;";
                    $db1=new DbOperation();
                       $userName=$_SESSION['SAL_UserName'];
            $appName=$_SESSION['SAL_AppName'];
            $electionName=$_SESSION['SAL_ElectionName'];
            $developmentMode=$_SESSION['SAL_DevelopmentMode'];
         $dataPocketExecutiveSummary = $db1->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
?>

<!-- <div class="col-sm-12"> -->
     <div class="form-group">
        <label>Executive Name</label>
        <div class="controls">
            <?php 
               
            ?>
            <select class="select2 form-control" name="executive_Name"
                
            
            >
                 <option value="">--Select--</option>
                 <?php
                if (sizeof($dataPocketExecutiveSummary)>0) 
                {
                    if(!isset($_SESSION['SAL_PLExecutive_Cd'])){
                        $_SESSION['SAL_PLExecutive_Cd'] =  $dataPocketExecutiveSummary[0]["PLExecutive_Cd"];
                    }

                    foreach ($dataPocketExecutiveSummary as $key => $value) 
                      {
                          if($_SESSION['SAL_PLExecutive_Cd'] == $value["PLExecutive_Cd"])
                          {
                    ?>
                            <option selected="true" value="<?php echo $value['PLExecutive_Cd']; ?>"><?php echo $value["ExecutiveName"]; ?></option>
                    <?php
                          }
                          else
                          {
                ?>
                            <option value="<?php echo $value["PLExecutive_Cd"];?>"><?php echo $value["ExecutiveName"];?></option>
                <?php
                          }
                      }
                  }
                ?> 
            </select>
        </div>
    </div>
<!-- </div> -->