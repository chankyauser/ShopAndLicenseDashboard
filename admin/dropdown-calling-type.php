<!-- <div class="col-sm-12"> -->
    <div class="form-group">
        <label>Assign Type</label>
        <div class="controls">
            <select class="select2 form-control" name="calling_Type"
                <?php if(isset($_GET['assignExeCd']) &&  isset($_GET['action']) && $_GET['action'] == 'transfer'){ ?>
                        disabled
                <?php }else if(isset($_GET['assignExeCd']) &&  isset($_GET['action']) && $_GET['action'] == 'edit'){ ?>
                        disabled
                <?php }else{   ?>
                     onChange="setCallingTypeInSession(this.value)" 
                <?php } ?>
            >
                 <option value="">--Select--</option>
                 <?php

                    $db=new DbOperation();
                    $userName=$_SESSION['SAL_UserName'];
                    $appName=$_SESSION['SAL_AppName'];
                    $electionName=$_SESSION['SAL_ElectionName'];
                    $developmentMode=$_SESSION['SAL_DevelopmentMode'];
                    $query = "SELECT
                        ISNULL(Calling_Type,'') as Calling_Type
                        FROM CallingCategoryMaster
                        WHERE IsActive = 1
                        GROUP BY Calling_Type";
                    $dataCallingType = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
                    if (sizeof($dataCallingType)>0) 
                    {
                        if(!isset($_SESSION['SAL_Calling_Type'])){
                            $_SESSION['SAL_Calling_Type'] = $dataCallingType[0]["Calling_Type"];
                        }
                        
                    foreach ($dataCallingType as $key => $value) 
                      {
                        
                          if($_SESSION['SAL_Calling_Type'] == $value["Calling_Type"])
                          {
                ?>
                            <option selected="true" value="<?php echo $value['Calling_Type']; ?>"><?php echo $value["Calling_Type"]; ?></option>
                <?php
                          }
                          else
                          {
                ?>
                            <option value="<?php echo $value["Calling_Type"];?>"><?php echo $value["Calling_Type"];?></option>
                <?php
                          }
                      }
                  }
                ?> 
            </select>
        </div>
    </div>
<!-- </div> -->