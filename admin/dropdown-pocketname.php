<?php

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];
    $nodeCd = 0;
    if(isset($_SESSION['SAL_Node_Cd'])){
        $nodeCd = $_SESSION['SAL_Node_Cd'];
    }
    $query = "SELECT
        ISNULL(Pocket_Cd,0) as Pocket_Cd,
        ISNULL(Node_Cd,0) as Node_Cd,
        ISNULL(PocketName,'') as PocketName,
        ISNULL(PocketNameMar,'') as PocketNameMar
        FROM PocketMaster  
        WHERE Node_Cd = $nodeCd AND IsActive = 1";
      $dataPocket = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
?>

<!-- <div class="col-sm-12"> -->
    <div class="form-group">
        <label>Pocket Name</label>
        <div class="controls">
            <select class="select2 form-control" name="pocket_Name"
               
            
            >
                 <option value="">--Select--</option>
                 <?php
                if (sizeof($dataPocket)>0) 
                {
                    foreach ($dataPocket as $key => $value) 
                      {
                          if($_SESSION['SAL_Pocket_Cd'] == $value["Pocket_Cd"])
                          {
                ?>
                            <option selected="true" value="<?php echo $value['Pocket_Cd']; ?>"><?php echo $value["PocketName"]." ".$value["PocketNameMar"]; ?></option>
                <?php
                          }
                          else
                          {
                ?>
                            <option value="<?php echo $value["Pocket_Cd"];?>"><?php echo $value["PocketName"]." ".$value["PocketNameMar"];?></option>
                <?php
                          }
                      }
                  }
                ?> 
            </select>
        </div>

    </div>
<!-- </div> -->