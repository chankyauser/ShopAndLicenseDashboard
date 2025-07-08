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
            ISNULL(NodeName,'') as NodeName,
            ISNULL(Area,'') as Area
            FROM NodeMaster 
            WHERE IsActive = 1 
            GROUP BY ISNULL(NodeName,''), 
            ISNULL(Area,'') ";
            // echo $query;
      $dataNode = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
?>

<!-- <div class="col-sm-12"> -->
    <div class="form-group">
        <label>Zone Office</label>
        <div class="controls">
            <select class="select2 form-control" name="node_Name" onChange="setNodeNameInSession(this.value)" >
            <?php 
                    if( isset($_GET['p']) &&
                        (   
                            $_GET['p'] == 'tree-census-list' ||
                            $_GET['p'] == 'shop-survey-details' ||
                            $_GET['p'] == 'shop-calling-details' || 
                            $_GET['p'] == 'shop-license-details' ||
                            $_GET['p'] == 'shop-license-defaulter-details' 
                        )
                    ){  
                ?>
                    <option <?php echo $nodeName == 'All' ? 'selected=true' : '';
                            if($nodeName == 'All'){
                                $_SESSION['TREE_NodeName'] = $nodeName;     
                            }
                ?> value="All">All</option>
                <?php 
                    }else{
                ?>
                    <option value="">--Select--</option>
                <?php
                    } 
                ?>
                 <?php
                if (sizeof($dataNode)>0) 
                {
                    foreach ($dataNode as $key => $value) 
                      {
                         if(!isset($_SESSION['SAL_Node_Name'])){
                            $_SESSION['SAL_Node_Name'] = $dataNode[0]["NodeName"];
                        }else if(empty($_SESSION['SAL_Node_Name'])){
                            $_SESSION['SAL_Node_Name'] = $dataNode[0]["NodeName"];
                        }
                        
                          if($_SESSION['SAL_Node_Name'] == $value["NodeName"])
                          {
                ?>
                            <option selected="true" value="<?php echo $value['NodeName']; ?>"><?php echo $value["NodeName"].", ".$value["Area"]; ?></option>
                <?php
                          }
                          else
                          {
                ?>
                            <option value="<?php echo $value["NodeName"];?>"><?php echo $value["NodeName"].", ".$value["Area"];?></option>
                <?php
                          }
                      }
                  }
                ?> 
            </select>
        </div>

    </div>
<!-- </div> -->