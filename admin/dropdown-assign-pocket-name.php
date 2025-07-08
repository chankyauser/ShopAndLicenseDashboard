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
            $node_Cd = $_SESSION['SAL_Node_Cd'] ;
        }else{
            $node_Cd = "All";
        }
       

        $nodeNameCondition = "";
        $wardCondition = "";

        if($nodeName == "All"){
            $nodeNameCondition = " AND nm.NodeName <> '' ";
        }else{
            $nodeNameCondition = " AND nm.NodeName = '$nodeName' ";
        }

        if($node_Cd == "All"){
            $wardCondition = " AND nm.Node_Cd <> '' ";
        }else{
            $wardCondition = " AND nm.Node_Cd = '$node_Cd' ";
        }

       
        $query = "SELECT ISNULL(pm.Pocket_Cd,0) as Pocket_Cd,
        ISNULL(pm.PocketName,'') as PocketName,
        ISNULL(pm.PocketNameMar,'') as PocketNameMar
        FROM PocketMaster pm 
        INNER JOIN NodeMaster AS nm ON (pm.Node_Cd = nm.Node_Cd) 
        WHERE ISNULL(pm.IsActive,0) = 1 AND ISNULL(pm.SRExecutiveCd,0) = 0 
        $nodeNameCondition
        $wardCondition
        AND pm.KML_FileUrl is not null AND pm.KML_FileUrl <> ''
        AND ( pm.IsCompleted is null OR pm.IsCompleted = 0 )
        GROUP BY pm.Pocket_Cd, pm.PocketName,pm.PocketNameMar ";
        // echo $query;
    $dataPocket = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
?>

<!-- <div class="col-sm-12"> -->
    <div class="form-group">
         <label>
        <?php if(isset($_SESSION['Form_Language']) && $_SESSION['Form_Language'] == 'English')
            {  
                echo "Pocket";
            }
            else if(isset($_SESSION['Form_Language']) && $_SESSION['Form_Language'] == 'Marathi')
            { 
                echo "पॉकेट";
            }  
        ?>
                                                
        </label>
        <div class="controls">
            <select class="select2 form-control"  name="pocketName">
                <option value="">--Select--</option>
                 <?php
                if (sizeof($dataPocket)>0) 
                {
                     if(!isset($_SESSION['SAL_Pocket_Cd'])){
                        $_SESSION['SAL_Pocket_Cd'] = $dataPocket[0]["Pocket_Cd"];
                        $Pocket_Cd = $_SESSION['SAL_Pocket_Cd'];
                     }
                    foreach ($dataPocket as $key => $value) 
                      {
                          if($Pocket_Cd == $value["Pocket_Cd"])
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