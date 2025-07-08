<?php

        $db=new DbOperation();

        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];

        $nodeName = "All";
        if(isset($_SESSION['SAL_Node_Name'])){
            $nodeName = $_SESSION['SAL_Node_Name'];
        }else{
            $_SESSION['SAL_Node_Name'] = $nodeName;
        }
        $nodeCd = "All";
        if(isset($_SESSION['SAL_Node_Cd'])){
            $nodeCd = $_SESSION['SAL_Node_Cd'];
        }else{
            $_SESSION['SAL_Node_Cd'] = $nodeCd;
        }
        $Ward_No = "";
        if(isset($_SESSION['SAL_Ward_No'])){
            $Ward_No = $_SESSION['SAL_Ward_No'];
        }
        if($nodeName == 'All'){
            $nodeCondition = " ";
        }else{
            $nodeCondition = " AND ISNULL(NodeName,'') = '$nodeName'  ";
        }
        $query = "SELECT ISNULL(Node_Cd,0) as Node_Cd,
        ISNULL(Ward_No,0) as Ward_No,
        ISNULL(NodeName,'') as NodeName, 
        ISNULL(Area,'') as Area  
        FROM NodeMaster 
        WHERE ISNULL(IsActive,0) = 1 
        ORDER BY Ward_No
        ";
        
    $dataWard = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
?>

<!-- <div class="col-sm-12"> -->
    <div class="form-group">
         <label>Ward</label>
        <div class="controls">
            <select class="select2 form-control"  name="Ward_No">
                
                    <option <?php echo $nodeCd == 'All' ? 'selected=true' : '';
                                if($nodeCd == 'All'){
                                $_SESSION['SAL_Node_Cd'] = $nodeCd;
                            }
                ?> value="All">All</option>
               
                 <?php
                if (sizeof($dataWard)>0) 
                {
                    foreach ($dataWard as $key => $value) 
                      {
                          if($nodeCd == $value["Node_Cd"])
                          {
                            $_SESSION['SAL_Ward_No'] = $value['Ward_No'];
                            $_SESSION['SAL_Node_Name'] = $value['NodeName'];
                ?>
                            <option selected="true" value="<?php echo $value['Node_Cd']; ?>"><?php echo $value["Ward_No"]." - ".$value["NodeName"]." - ".$value["Area"]; ?></option>
                <?php
                          }
                          else
                          {
                ?>
                            <option value="<?php echo $value["Node_Cd"];?>"><?php echo $value["Ward_No"]." - ".$value["NodeName"]." - ".$value["Area"];?></option>
                <?php
                          }
                      }
                  }
                ?> 
            </select>
        </div>

    </div>
<!-- </div> -->