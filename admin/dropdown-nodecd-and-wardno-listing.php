<?php

      $db=new DbOperation();
      $userName=$_SESSION['SAL_UserName'];
      $appName=$_SESSION['SAL_AppName'];
      $electionName=$_SESSION['SAL_ElectionName'];
      $developmentMode=$_SESSION['SAL_DevelopmentMode'];
      
      if(isset($_SESSION['SAL_Node_Cd'])){
        $nodeCd = $_SESSION['SAL_Node_Cd'];
      }else{
        $nodeCd = "All";
      }
      
      if(isset($_SESSION['SAL_Node_Name'])){
        $nodeName = $_SESSION['SAL_Node_Name'];
      }else{
        $nodeName = "All";
      }
      if($nodeName == 'All'){
        $node_Condition  = " NodeMaster.NodeName <> '' ";
      }else{
        $node_Condition = " NodeMaster.NodeName = '$nodeName' ";
      }

       
        $query = "SELECT COUNT(DISTINCT(ShopMaster.Shop_Cd))  as ShopCount,
                    ISNULL(NodeMaster.Node_Cd,0) as Node_Cd,
                    ISNULL(NodeMaster.NodeName,'') as NodeName,
                    ISNULL(NodeMaster.NodeNameMar,'') as NodeNameMar,
                    ISNULL(NodeMaster.Ac_No,0) as Ac_No,
                    ISNULL(NodeMaster.Ward_No,0) as Ward_No,
                    ISNULL(NodeMaster.Address,'') as Address,
                    ISNULL(NodeMaster.Area,'') as Area
                    FROM NodeMaster 
                    INNER JOIN PocketMaster on ( PocketMaster.Node_Cd = NodeMaster.Node_Cd  AND $node_Condition )
                    INNER JOIN ShopMaster on ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND ShopMaster.IsActive = 1  
                      )
                    WHERE NodeMaster.IsActive = 1 
                    GROUP BY NodeMaster.Node_Cd, NodeMaster.NodeName,
                    NodeMaster.NodeNameMar, NodeMaster.Ac_No,
                    NodeMaster.Ward_No, NodeMaster.Address, NodeMaster.Area
                    ORDER BY NodeMaster.Ward_No ";
                                                // echo $query;
      $dataNode = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
?>

<!-- <div class="col-sm-12"> -->
    <div class="form-group">
        <label>Ward No</label>
        <div class="controls">
            <select class="select2 form-control" name="node_Cd" onChange="setNodeCdAndWardNoInSession(this.value)" >

                <option <?php echo $nodeCd == 'All' ? 'selected=true' : '';
                                if($nodeCd == 'All'){
                                $_SESSION['SAL_Node_Cd'] = $nodeCd;
                            }
                ?> value="All">All</option>
               
                 
                 <?php
                if (sizeof($dataNode)>0) 
                {
                    if(!isset($_SESSION['SAL_Node_Cd'])){
                        $_SESSION['SAL_Node_Cd'] = $dataNode[0]["Node_Cd"];
                        $_SESSION['SAL_Ward_No'] = $dataNode[0]["Ward_No"];
                    }

                    foreach ($dataNode as $key => $value) 
                      {
                          if($_SESSION['SAL_Node_Cd'] == $value["Node_Cd"])
                          {
                            $_SESSION['SAL_Ward_No'] = $value["Ward_No"];
                ?>
                            <option selected="true" value="<?php echo $value['Node_Cd']; ?>"><?php echo $value["Ward_No"].", ".$value["Area"]; ?></option>
                <?php
                          }
                          else
                          {
                ?>
                            <option value="<?php echo $value["Node_Cd"];?>"><?php echo $value["Ward_No"].", ".$value["Area"];?></option>
                <?php
                          }
                      }
                  }
                ?> 
            </select>
        </div>

    </div>
<!-- </div> -->