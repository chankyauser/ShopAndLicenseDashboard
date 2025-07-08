
<!-- <div class="col-sm-12"> -->
<div class="form-group">
        <label>Executive Name</label>
        <div class="controls">
            <select class="select2 form-control" name="ExecutiveName" onChange="setShopListExecutiveNameInSession(this.value)" >
                 <option value="">--Select--</option>
                 <?php

                    $db=new DbOperation();
                    $userName=$_SESSION['SAL_UserName'];
                    $appName=$_SESSION['SAL_AppName'];
                    $electionName=$_SESSION['SAL_ElectionName'];
                    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

                    $Executive_Cd = 0;

                    if(isset($_SESSION['SAL_SHOP_LIST_Executive_Name_Cd'])){
                        $callingCategoryCd = $_SESSION['SAL_SHOP_LIST_Executive_Name_Cd'];
                    }
                 
                    $query = "SELECT 
                            ISNULL(Executive_Cd,0) AS Executive_Cd, 
                            ISNULL(ExecutiveName,'') AS Executive_Name
                            FROM Survey_Entry_Data..Executive_Master  
                            WHERE IsActive = 1 
                            ORDER BY Executive_Cd;";

                    $ExecutiveNamelist = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);

                    if (sizeof($ExecutiveNamelist)>0) 
                    {
                        if(!isset($_SESSION['SAL_SHOP_LIST_Executive_Name_Cd'])){
                            $_SESSION['SAL_SHOP_LIST_Executive_Name_Cd'] = $ExecutiveNamelist[0]["Executive_Cd"];
                        }
                        
                    foreach ($ExecutiveNamelist as $key => $value) 
                      {
                        
                          if($_SESSION['SAL_SHOP_LIST_Executive_Name_Cd'] == $value["Executive_Cd"])
                          {
                ?>
                            <option selected="true" value="<?php echo $value['Executive_Cd']; ?>"><?php echo $value["Executive_Name"]; ?></option>
                <?php
                          }
                          else
                          {
                ?>
                            <option value="<?php echo $value["Executive_Cd"];?>"><?php echo $value["Executive_Name"];?></option>
                <?php
                          }
                      }
                  }
                ?> 
            </select>
        </div>
    </div>
<!-- </div> -->