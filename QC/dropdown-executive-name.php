<?php

        $db=new DbOperation();

        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];
        $fromDate = $_SESSION['SAL_FromDate']." ".$_SESSION['StartTime'];
        $toDate = $_SESSION['SAL_ToDate']." ".$_SESSION['EndTime'];
        if($qcType=="ShopList"){
            $exeDateCondition = " CONVERT(VARCHAR,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' "; 

            $query = "SELECT ISNULL(em.Executive_Cd,0) as Executive_Cd,
                ISNULL(em.ExecutiveName,'') as ExecutiveName
            FROM Survey_Entry_Data..Executive_Master em 
            INNER JOIN Survey_Entry_Data..User_Master um on (um.Executive_Cd=em.Executive_Cd AND um.AppName = '$appName')
            INNER JOIN ShopMaster sm on ( $exeDateCondition AND sm.IsActive = 1 AND sm.AddedBy=um.UserName   )
            GROUP BY em.Executive_Cd, em.ExecutiveName
            ORDER BY ExecutiveName
            ";
       }else if($qcType=="ShopSurvey"){
            $exeDateCondition = " CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$fromDate' AND '$toDate'  "; 
            
            $query = "SELECT ISNULL(em.Executive_Cd,0) as Executive_Cd,
                ISNULL(em.ExecutiveName,'') as ExecutiveName
            FROM Survey_Entry_Data..Executive_Master em 
            INNER JOIN Survey_Entry_Data..User_Master um on (um.Executive_Cd=em.Executive_Cd AND um.AppName = '$appName')
            INNER JOIN ShopTracking st on ( $exeDateCondition AND st.ST_Status = 1 AND st.ST_Exec_Cd=em.Executive_Cd   )
            INNER JOIN CallingCategoryMaster ccm on (ccm.Calling_Category_Cd = st.Calling_Category_Cd
                AND ccm.Calling_Type = 'Survey' AND ccm.QC_Type in ('ShopSurvey')
            )
            GROUP BY em.Executive_Cd, em.ExecutiveName
            ORDER BY ExecutiveName
            ";
            
       }else if($qcType=="ShopDocument"){
            $exeDateCondition = " CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$fromDate' AND '$toDate'  "; 
            
            $query = "SELECT ISNULL(em.Executive_Cd,0) as Executive_Cd,
                ISNULL(em.ExecutiveName,'') as ExecutiveName
            FROM Survey_Entry_Data..Executive_Master em 
            INNER JOIN Survey_Entry_Data..User_Master um on (um.Executive_Cd=em.Executive_Cd AND um.AppName = '$appName')
            INNER JOIN ShopTracking st on ( $exeDateCondition AND st.ST_Status = 1 AND st.ST_Exec_Cd=em.Executive_Cd   )
            INNER JOIN CallingCategoryMaster ccm on (ccm.Calling_Category_Cd = st.Calling_Category_Cd
                AND ccm.Calling_Type = 'Survey' AND ccm.QC_Type in ('ShopDocument')
            )
            GROUP BY em.Executive_Cd, em.ExecutiveName
            ORDER BY ExecutiveName
            ";
       }else if($qcType=="ShopCalling"){
            $exeDateCondition = " CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$fromDate' AND '$toDate'  "; 
            
            $query = "SELECT ISNULL(em.Executive_Cd,0) as Executive_Cd,
                ISNULL(em.ExecutiveName,'') as ExecutiveName
            FROM Survey_Entry_Data..Executive_Master em 
            INNER JOIN Survey_Entry_Data..User_Master um on (um.Executive_Cd=em.Executive_Cd AND um.AppName = '$appName')
            INNER JOIN ShopTracking st on ( $exeDateCondition AND st.ST_Status = 1 AND st.ST_Exec_Cd=em.Executive_Cd   )
            INNER JOIN CallingDetails cd on ( CONVERT(VARCHAR,cd.Call_DateTime,120) BETWEEN '$fromDate' AND '$toDate' AND st.ScheduleCall_Cd = cd.ScheduleCall_Cd AND cd.Call_Response_Cd = 4 AND ISNULL(cd.AudioFile_Url,'') <> '' )
            GROUP BY em.Executive_Cd, em.ExecutiveName
            ORDER BY ExecutiveName
            ";
       }

                
    $dataExecutive = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
?>

<!-- <div class="col-sm-12"> -->
    <div class="form-group">
         <label>Executive Name</label>
        <div class="controls">
            <select class="select2 form-control"  name="Shop_Executive_Id" id="Shop_Executive_Id" >
                
                    <option <?php echo $shopExecutiveCd == 'All' ? 'selected=true' : '';
                                if($shopExecutiveCd == 'All'){
                                $_SESSION['SAL_Executive_Cd'] = $shopExecutiveCd;
                            }
                ?> value="All">All</option>
               
                 <?php
                if (sizeof($dataExecutive)>0) 
                {
                    foreach ($dataExecutive as $key => $value) 
                      {
                          if($shopExecutiveCd == $value["Executive_Cd"])
                          {
                ?>
                            <option selected="true" value="<?php echo $value['Executive_Cd']; ?>"><?php echo $value["ExecutiveName"]; ?></option>
                <?php
                          }
                          else
                          {
                ?>
                            <option value="<?php echo $value["Executive_Cd"];?>"><?php echo $value["ExecutiveName"]; ?></option>
                <?php
                          }
                      }
                  }
                ?> 
            </select>
        </div>

    </div>
<!-- </div> -->