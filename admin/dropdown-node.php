<?php

        $db=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];
     
      
        if(isset($_SESSION['SAL_Node_Name'])){
            $nodeName = $_SESSION['SAL_Node_Name'];
        }else{
            $nodeName = "All";
        }

        if(isset($_SESSION['SAL_Node_Cd'])){
            $nodeCd = $_SESSION['SAL_Node_Cd'];
        }else{
            $nodeCd = "All";
        }

        if($nodeCd != 'All'){
            $queryNode = "SELECT
                ISNULL(Node_Cd,0) as Node_Cd,
                ISNULL(NodeName,'') as NodeName,
                ISNULL(NodeNameMar,'') as NodeNameMar,
                ISNULL(Ac_No,0) as Ac_No,
                ISNULL(Ward_No,0) as Ward_No,
                ISNULL(Address,'') as Address,
                ISNULL(Area,'') as Area
            FROM NodeMaster
            WHERE Node_Cd = $nodeCd";
            $db1=new DbOperation();
            $nodeData = $db1->ExecutveQuerySingleRowSALData($queryNode, $electionName, $developmentMode);
            $_SESSION['SAL_Node_Name'] = $nodeData["NodeName"];
            $nodeName = $_SESSION['SAL_Node_Name'];
        }
        $query = "SELECT
                ISNULL(NodeName,'') as NodeName
            FROM NodeMaster 
            WHERE IsActive = 1 
            GROUP BY ISNULL(NodeName,'')";
            // echo $query;
        $dataNode = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
?>

<!-- <div class="col-sm-12"> -->
    <div class="form-group">
        <label>Zone Office</label>
        <div class="controls">
            <select class="select2 form-control" name="node_Name" onChange="setNodeNameInSession(this.value)" >
                 <option <?php echo $nodeName == 'All' ? 'selected=true' : '';
                                if($nodeName == 'All'){
                                $_SESSION['SAL_Node_Name'] = $nodeName;
                            }
                ?> value="All">All</option>
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
                            <option selected="true" value="<?php echo $value['NodeName']; ?>"><?php echo $value["NodeName"]; ?></option>
                <?php
                          }
                          else
                          {
                ?>
                            <option value="<?php echo $value["NodeName"];?>"><?php echo $value["NodeName"];?></option>
                <?php
                          }
                      }
                  }
                ?> 
            </select>
        </div>

    </div>
<!-- </div> -->