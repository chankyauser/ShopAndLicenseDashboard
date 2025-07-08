<!-- <div class="col-sm-12"> -->
    <div class="form-group">
        <label><?php  if($callingType == 'Survey'){ ?> Survey  <?php  }else if($callingType == 'Calling'){ ?> Calling <?php } ?>  Category</label>
        <div class="controls">
            <select class="select2 form-control" name="calling_Category" onChange="setCallingCategoryInSession(this.value)" required>
                 <option value="">--Select--</option>
                 <?php

                    $db=new DbOperation();
                    $userName=$_SESSION['SAL_UserName'];
                    $appName=$_SESSION['SAL_AppName'];
                    $electionName=$_SESSION['SAL_ElectionName'];
                    $developmentMode=$_SESSION['SAL_DevelopmentMode'];
                    $callingCategoryCd = 0;
                    if(isset($_SESSION['SAL_Calling_Category_Cd'])){
                        $callingCategoryCd = $_SESSION['SAL_Calling_Category_Cd'];
                    }
                 
                    $query = "SELECT 
                        ISNULL(Calling_Category_Cd,0) as Calling_Category_Cd,
                        ISNULL(Calling_Category,'') as Calling_Category
                        FROM CallingCategoryMaster
                        WHERE IsActive = 1 AND Calling_Type = '$callingType'
                        ORDER BY SrNo";
                    $dataCallingCategory = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
                    if (sizeof($dataCallingCategory)>0) 
                    {
                        if(!isset($_SESSION['SAL_Calling_Category_Cd'])){
                            $_SESSION['SAL_Calling_Category_Cd'] = $dataCallingCategory[0]["Calling_Category_Cd"];
                        }
                        
                    foreach ($dataCallingCategory as $key => $value) 
                      {
                        
                          if($_SESSION['SAL_Calling_Category_Cd'] == $value["Calling_Category_Cd"])
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