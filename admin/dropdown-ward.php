<?php

        $db=new DbOperation();

        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];

        $nodeName = "";
        if(isset($_SESSION['SAL_Node_Name'])){
            $nodeName = $_SESSION['SAL_Node_Name'];
        }
        $nodeCd = "";
        if(isset($_SESSION['SAL_Node_Cd'])){
            $nodeCd = $_SESSION['SAL_Node_Cd'];
        }else{
            $nodeCd = "All";
        }
        $Ward_No = "";
        if(isset($_SESSION['SAL_Ward_No'])){
            $Ward_No = $_SESSION['SAL_Ward_No'];
        }
        
        $query = "SELECT ISNULL(Node_Cd,0) as Node_Cd,
        ISNULL(Ward_No,0) as Ward_No,
        ISNULL(NodeName,'') as NodeName  
        FROM NodeMaster 
        WHERE ISNULL(IsActive,0) = 1 
        AND ISNULL(NodeName,'') = '$nodeName' ";
        
    $dataWard = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
?>

<!-- <div class="col-sm-12"> -->
    <div class="form-group">
         <label>Ward</label>
        <div class="controls">
            <select class="select2 form-control"  name="Ward_No"

                <?php 
                    if( isset($_GET['p']) &&
                        (  $_GET['p'] == 'shops-assign'
                            ||  $_GET['p'] == 'shop-survey-detail'
                            ||  $_GET['p'] == 'shop-license-tracking'
                            ||  $_GET['p'] == 'pocket-wise-survey-summary'
                            ||  $_GET['p'] == 'pocket-assign'
                        )
                    ){  
                ?>
                    onChange="setWardInSession(this.value)"
                <?php 
                    } 
                ?>
            
            >
                <?php 
                    if( isset($_GET['p']) &&
                        (  
                                $_GET['p'] == 'shop-survey-detail'
                            ||  $_GET['p'] == 'shop-license-tracking'
                            ||  $_GET['p'] == 'pocket-wise-survey-summary'
                            ||  $_GET['p'] == 'pocket-assign'
                        )
                    ){  
                ?>
                    <option <?php echo $nodeCd == 'All' ? 'selected=true' : '';
                                if($nodeCd == 'All'){
                                $_SESSION['SAL_Node_Cd'] = $nodeCd;
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
                if (sizeof($dataWard)>0) 
                {
                    foreach ($dataWard as $key => $value) 
                      {
                          if($nodeCd == $value["Node_Cd"])
                          {
                ?>
                            <option selected="true" value="<?php echo $value['Node_Cd']; ?>,<?php echo $value['Ward_No']; ?>"><?php echo $value["Ward_No"]; ?></option>
                <?php
                          }
                          else
                          {
                ?>
                            <option value="<?php echo $value["Node_Cd"];?>,<?php echo $value['Ward_No']; ?>"><?php echo $value["Ward_No"];?></option>
                <?php
                          }
                      }
                  }
                ?> 
            </select>
        </div>

    </div>
<!-- </div> -->