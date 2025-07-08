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
      $nodeName = "";
      if(isset($_SESSION['SAL_Node_Name'])){
        $nodeName = $_SESSION['SAL_Node_Name'];
      }
      $query = "SELECT
            ISNULL(Node_Cd,0) as Node_Cd,
            ISNULL(NodeName,'') as NodeName,
            ISNULL(NodeNameMar,'') as NodeNameMar,
            ISNULL(Ac_No,0) as Ac_No,
            ISNULL(Ward_No,0) as Ward_No,
            ISNULL(Address,'') as Address,
            ISNULL(Area,'') as Area
            FROM NodeMaster 
            WHERE IsActive = 1 AND NodeName = '$nodeName' ";
      $dataNode = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
?>

<!-- <div class="col-sm-12"> -->
    <div class="form-group">
        <label>Ward No</label>
        <div class="controls">
            <select class="select2 form-control" name="node_Cd"
                <?php 
                    if( isset($_GET['p']) &&
                        $_GET['p'] == 'call-assign' ||
                        $_GET['p'] == 'survey-assign' ||
                        $_GET['p'] == 'login-master' 
                    ){  
                ?>
                    onChange="setNodeCdAndWardNoInSession(this.value)"
                <?php 
                    }else if( isset($_GET['p']) &&
                        $_GET['p'] == 'pocket-wise-survey-detail' 
                    ){
                ?>
                        onChange="setPocketNameByNodeCdWithDateRange(this.value)"
                <?php 
                    }else if( isset($_GET['p']) &&
                        $_GET['p'] == 'executive-wise-survey-detail' 
                    ){
                ?>
                        onChange="setExecutiveNameByNodeCdWithDateRange(this.value)"
                <?php 
                    }else{
                        ?>
                    onChange="setNodeCdAndWardNoInSessionWORefresh(this.value)"
                <?php 
                    }
                ?>
            
            >
                 <option value="">--Select--</option>
                 <?php
                if (sizeof($dataNode)>0) 
                {
                    if(!isset($_SESSION['SAL_Node_Cd'])){
                        $_SESSION['SAL_Node_Cd'] = $dataNode[0]["Node_Cd"];
                    }

                    foreach ($dataNode as $key => $value) 
                      {
                          if($_SESSION['SAL_Node_Cd'] == $value["Node_Cd"])
                          {
                ?>
                            <option selected="true" value="<?php echo $value['Node_Cd']; ?>"><?php echo $value["Ward_No"]; ?></option>
                <?php
                          }
                          else
                          {
                ?>
                            <option value="<?php echo $value["Node_Cd"];?>"><?php echo $value["Ward_No"];?></option>
                <?php
                          }
                      }
                  }
                ?> 
            </select>
        </div>

    </div>
<!-- </div> -->