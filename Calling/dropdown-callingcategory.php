
<!-- <div class="col-sm-12"> -->
<div class="form-group">
        <label>Calling Category</label>
        <div class="controls">
            <select class="select2 form-control" name="CallingCategory" onChange="setShopListCallingCategoryInSession(this.value)" >
                <?php 

                    $callingCategoryCd = "All";

                    if(isset($_SESSION['SAL_SHOP_LIST_Calling_Category_Cd'])){
                        $callingCategoryCd = $_SESSION['SAL_SHOP_LIST_Calling_Category_Cd'];
                    }
                
                    if( !isset($_GET['p']) || isset($_GET['p']) &&
                        (  
                                $_GET['p'] == 'shop-survey-detail'
                            ||  $_GET['p'] == 'shop-license-tracking'
                            ||  $_GET['p'] == 'pocket-wise-survey-summary'
                            ||  $_GET['p'] == 'pocket-assign'
                        )
                    ){
                ?>
                        <option <?php echo $callingCategoryCd == 'All' ? 'selected=true' : '';
                                if($callingCategoryCd == 'All'){
                                $_SESSION['SAL_SHOP_LIST_Calling_Category_Cd'] = $callingCategoryCd;
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

                    $db=new DbOperation();
                    $userName=$_SESSION['SAL_UserName'];
                    $appName=$_SESSION['SAL_AppName'];
                    $electionName=$_SESSION['SAL_ElectionName'];
                    $developmentMode=$_SESSION['SAL_DevelopmentMode'];
                    
                 
                    $query = "SELECT 
                        ISNULL(Calling_Category_Cd,0) as Calling_Category_Cd,
                        ISNULL(Calling_Category,'') as Calling_Category
                        FROM CallingCategoryMaster
                        WHERE IsActive = 1 AND Calling_Type = 'Calling'
                        ORDER BY SrNo";

                    $dataCallingCategory = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);

                    if (sizeof($dataCallingCategory)>0) 
                    {
                        if(!isset($_SESSION['SAL_SHOP_LIST_Calling_Category_Cd'])){
                            $_SESSION['SAL_SHOP_LIST_Calling_Category_Cd'] = $dataCallingCategory[0]["Calling_Category_Cd"];
                            $callingCategoryCd = $_SESSION['SAL_SHOP_LIST_Calling_Category_Cd'];
                        }
                        
                    foreach ($dataCallingCategory as $key => $value) 
                      {
                        
                          if($callingCategoryCd == $value["Calling_Category_Cd"])
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