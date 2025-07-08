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

    if(isset($_GET['Calling_Category_Cd'])){
        $Calling_Category_Cd = $_GET['Calling_Category_Cd'];
        $_SESSION['SAL_Calling_Category_Cd'] = $Calling_Category_Cd;
    }else if(isset($_SESSION['SAL_Calling_Category_Cd'])){
        $Calling_Category_Cd = $_SESSION['SAL_Calling_Category_Cd'];    
    }else{
        $Calling_Category_Cd = 0;  
    }

    $fromDate = $from_Date." ".$_SESSION['StartTime'];
    $toDate = $to_Date." ".$_SESSION['EndTime'];

       $query = "SELECT 
       ISNULL(Calling_Category_Cd, 0) as Calling_Category_Cd,
       ISNULL(Calling_Category, 0) as Calling_Category,
       ISNULL(Calling_Type, 0) as Calling_Type
       FROM CallingCategoryMaster
       WHERE IsActive = 1
       AND Calling_Type = 'Calling';";

            $db1=new DbOperation();
            $userName=$_SESSION['SAL_UserName'];
            $appName=$_SESSION['SAL_AppName'];
            $electionName=$_SESSION['SAL_ElectionName'];
            $developmentMode=$_SESSION['SAL_DevelopmentMode'];
         $dataCallingCategory = $db1->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
?>

<!-- <div class="col-sm-12"> -->
     <div class="form-group">
        <label>Calling Category</label>
        <div class="controls">
            <?php 
               
            ?>
            <select class="select2 form-control" name="calling_Category" style="height:35px;">
                 <option value="">--Select--</option>
                 <?php
                if (sizeof($dataCallingCategory)>0) 
                {
                    foreach ($dataCallingCategory as $key => $value) 
                      {
                          if((isset($_GET['Calling_Category_Cd']) && $_GET['Calling_Category_Cd'] == $value["Calling_Category_Cd"]))
                          {
                    ?>
                            <option selected="true" value="<?php echo $value['Calling_Category_Cd']; ?>"><?php echo $value["Calling_Category"]; ?></option>
                    <?php
                          }else if($_SESSION['SAL_Calling_Category_Cd'] == $value["Calling_Category_Cd"])
                          {
                    ?>
                            <option selected="true" value="<?php echo $value['Calling_Category_Cd']; ?>"><?php echo $value["Calling_Category"]; ?></option>
                    <?php
                          }
                          else
                          {
                ?>
                            <option value="<?php echo $value["Calling_Category_Cd"];?>"><?php echo $value["Calling_Category"];?></option>
                <?php
                          }
                      }
                  }
                ?> 
            </select>
        </div>
    </div>
<!-- </div> -->