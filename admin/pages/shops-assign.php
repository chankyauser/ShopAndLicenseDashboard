 <style type="text/css">
     .avatar .avatar-content .avatar-icon {
        font-size: 2.2rem;
    }
    .btn {
        padding: 0.9rem 1rem;
    }
   
 </style>

<section id="dashboard-analytics">

<?php 
        if(!isset($_SESSION['SAL_ShopAssign_Filter_Type'])){
            $shopAssignFilterType = "New";
            $_SESSION['SAL_ShopAssign_Filter_Type'] = $shopAssignFilterType;
        }else{
            $shopAssignFilterType = $_SESSION['SAL_ShopAssign_Filter_Type'];
        }

        if(!isset($_SESSION['SAL_Calling_Type'])){
            $callingType = "Survey";
            $_SESSION['SAL_Calling_Type'] = $callingType;
        }else{
            $callingType = $_SESSION['SAL_Calling_Type'];
        }
        
        // $currentDate = date('Y-m-d');
        // $curDate = date('Y');
        // $assign_date = $currentDate;

        $assign_date = '';
        if(isset($_GET['assignDate'])){
            $assign_date = $_GET['assignDate'];
        }else{
            if(!isset($_SESSION['SAL_Assign_Date'])){
                $currentDate = date('Y-m-d');
                $curDate = date('Y');
                $assign_date = $currentDate;
            }else{
                $assign_date = $_SESSION['SAL_Assign_Date'];
            }
            
        }

        // if($assign_date < date('Y-m-d')){
        //     $assign_date = date('Y-m-d');
        //     $_SESSION['SAL_Assign_Date'] = $assign_date;
        // }

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
        
        if(isset($_SESSION['SAL_Calling_Category_Cd'])){
            $callingCategoryCd = $_SESSION['SAL_Calling_Category_Cd'];
        }

        if($nodeName == 'All'){
            $nodeNameCondition = " AND nm.NodeName <> '' ";
        }else{
            $nodeNameCondition = " AND nm.NodeName = '$nodeName' ";
        }

        if($nodeCd == 'All'){
            $nodeWardCondition = " AND pm.Node_Cd <> '' ";
        }else{
            $nodeWardCondition = " AND pm.Node_Cd = $nodeCd ";
        }

    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">
                    <h4 class="card-title">Survey Assign</h4>
                </div> -->
                <div class="card-content">
                    <div class="card-body">
                       
                            <div class="row">
                                <input type="hidden" name="electionName" value="<?php echo $electionName; ?>">
                                <div class="col-md-3 col-12">
                                    <?php include 'dropdown-node.php'; ?>
                                </div>
                                <div class="col-md-3 col-12">
                                    <?php include 'dropdown-nodecd-and-wardno.php'; ?>
                                </div>
                                <div class="col-xs-12 col-md-3 col-xl-3">
                                    <div class="form-group">
                                        <label>Filter Type</label>
                                        <div class="controls"> 
                                            <select class="select2 form-control" name="shopAssignFilterType" onchange="setShopAssignFilterType(this.value)">
                                                <option <?php echo $shopAssignFilterType == 'New' ? 'selected' : '' ; ?> value="New">New</option>  
                                                <?php if(isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) && ( $_SESSION['SAL_UserType']== 'Admin' ) && ( $_SESSION['SAL_ElectionName']== 'PCMC' ) ){ ?> 
                                                    <option <?php echo $shopAssignFilterType == 'SurveyShopReVisitUsingQuery' ? 'selected' : '' ; ?> value="SurveyShopReVisitUsingQuery">Shop Survey Re-Visit Using Query</option>
                                                    <option <?php echo $shopAssignFilterType == 'ShopDocumentReVisitUsingQuery' ? 'selected' : '' ; ?> value="ShopDocumentReVisitUsingQuery">Shop Document Re-Visit Using Query</option>
                                                <?php } ?>
                                                    <option <?php echo $shopAssignFilterType == 'InvalidMobilePhoto' ? 'selected' : '' ; ?> value="InvalidMobilePhoto">Invalid Mobile, Photo, Documents</option>

                                                    <option <?php echo $shopAssignFilterType == 'DocumentsDenied' ? 'selected' : '' ; ?> value="DocumentsDenied">Documents Denied</option>

                                                    <option <?php echo $shopAssignFilterType == 'NoDocument' ? 'selected' : '' ; ?> value="NoDocument">No Document Collected</option>
                                                    
													<option <?php echo $shopAssignFilterType == 'QCDocumentPending' ? 'selected' : '' ; ?> value="QCDocumentPending">QC - Document Pending</option>
                                                <?php if(isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) && ( $_SESSION['SAL_UserType']== 'Admin' ) && ( $_SESSION['SAL_ElectionName']== 'PCMC' ) ){ ?> 
                                                    

                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <?php include 'dropdown-calling-type.php'; ?>
                                </div>
                                <div class="col-md-4 col-12" style="display: none;">
                                    <?php //include 'dropdown-calling-category.php'; ?>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="assign_date">Assign Date</label>
                                        <input type='text' name="assign_date" value="<?php echo $assign_date;?>" class="form-control pickadate-disable-assigndates" onchange="setAssignDateInSession()"  />
                                    </div>
                                </div>
                                
                                
                                <div class="col-md-4 col-12">
                                    <?php include 'dropdown-assign-executive-name.php'; ?>
                                </div>
                                <div class="col-md-1 col-12">
                                    <div class="form-group">
                                        <label for="shops">Shops</label>
                                        <input type="text" class="form-control" name="shopsAssignCount" value="" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" required>
                                    </div>
                                </div>

                                <div class="col-md-3 col-12"  style="margin-top: 25px;">
                                    <div class="form-group">
                                        <label for="pockets">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <?php if($shopAssignFilterType == "New"){ ?>
                                                <button id="submitProcessSurveyShopTrackingFlagBtnId" type="button" name="refesh" class="btn btn-primary" onclick="setProcessSurveyShopTrackingFlag('<?php echo $shopAssignFilterType; ?>')" style="display: none;" >Survey Process</button>
                                        <?php 

                                            }elseif($shopAssignFilterType == "SurveyShopReVisitUsingQuery"){ 

                                                  if(isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) && ( $_SESSION['SAL_UserType']== 'Admin' ) && ( $_SESSION['SAL_ElectionName']== 'PCMC' ) ){ 
                                                $dataProcessScheduling = array();
                                                $db=new DbOperation();
                                                $userName=$_SESSION['SAL_UserName'];
                                                $appName=$_SESSION['SAL_AppName'];
                                                $electionName=$_SESSION['SAL_ElectionName'];
                                                $developmentMode=$_SESSION['SAL_DevelopmentMode'];
                                                $query="SELECT 
                                                            ISNULL(COUNT(DISTINCT(t.Shop_Cd)),0) as ShopCount
                                                        FROM(
                                                            SELECT sm.Shop_Cd, sm.ShopName, sm.ShopKeeperMobile, sm.ShopKeeperName, sm.ShopOutsideImage1, sm.ShopOutsideImage2, pm.Pocket_Cd,ShopStatus,shopStatusDate,shopStatusRemark,SurveyDate,NM.Ward_No,sm.SRExecutive_Cd,sm.SRAssignedDate,sm.IsActive, sm.Surveyby

                                                            FROM shopmaster as sm 
                                                            inner join PocketMaster as PM on PM.Pocket_Cd = sm.Pocket_Cd
                                                            inner join nodemaster as NM on PM.Node_Cd = NM.Node_Cd
                                                            --where sm.surveyby ='AMIRODDIN_S'
                                                            where sm.surveyby ='BHUSHAN_P16'
                                                            AND MONTH(SurveyDate) = 12
                                                            AND sm.IsActive = 1
                                                            AND ( 
                                                                ISNULL(sm.ShopStatus,'') = '' OR 
                                                                sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                                                            )
                                                            $nodeNameCondition
                                                            $nodeWardCondition
                                                           -- order by SurveyDate desc
                                                        ) as t
                                                        LEFT JOIN ScheduleDetails sd on (
                                                            t.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assign_date' 
                                                            AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                                                FROM CallingCategoryMaster WHERE Calling_Type = 'Survey')

                                                            --AND t.surveyby ='AMIRODDIN_S'
                                                            AND t.surveyby ='BHUSHAN_P16'
                                                            AND MONTH(SurveyDate) = 12
                                                            AND t.IsActive = 1 
                                                            AND ( 
                                                                 ISNULL(t.ShopStatus,'') = '' OR 
                                                                t.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                                                            )
                                                            AND sd.CallReason in ( '2nd Premise Visit' , 'Re-Collect Shop Documents' )
                                                        )
                                                        INNER JOIN PocketMaster pm on (pm.Pocket_Cd = t.Pocket_Cd)
                                                        INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                                                        LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                                        WHERE sd.ScheduleCall_Cd IS NULL 
                                                        $nodeNameCondition
                                                        $nodeWardCondition
                                                    ";
                                                    // echo $query;
                                                $dataProcessScheduling = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
                                                    if(sizeof($dataProcessScheduling)>0){
                                                        if($dataProcessScheduling["ShopCount"]>0){
                                            ?>
                                                <button id="submitProcessScheduleShopsBtnId" type="button" name="refesh" class="btn btn-primary" onclick="setProcessScheduleShops('<?php echo $shopAssignFilterType; ?>')" ><?php echo $dataProcessScheduling["ShopCount"]; ?> Process Scheduling</button>

                                                <?php
                                                        }
                                                    }
                                                ?>

                                            <?php } ?>
                                        <?php }elseif($shopAssignFilterType == "InvalidMobilePhoto"){ 

                                                if(isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) && ( $_SESSION['SAL_UserType']== 'Admin' ) ){ 
                                                    $dataProcessScheduling = array();
                                                    $db=new DbOperation();
                                                    $userName=$_SESSION['SAL_UserName'];
                                                    $appName=$_SESSION['SAL_AppName'];
                                                    $electionName=$_SESSION['SAL_ElectionName'];
                                                    $developmentMode=$_SESSION['SAL_DevelopmentMode'];
                                                    $query="SELECT 
                                                            ISNULL(COUNT(t.Shop_Cd),0) as ShopCount
                                                        FROM(
                                                            SELECT
                                                                sm.Shop_Cd,
                                                                ( SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopSurvey') As SD_Calling_Category_Cd, '2nd Premise Visit' as CallReason,
                                                                (CASE WHEN (sm.ShopKeeperMobile IS NULL OR LEFT(sm.ShopKeeperMobile, 1) NOT IN (6,7,8,9) OR LEN(sm.ShopKeeperMobile) != 10 ) then 'Enter Mobile Number' else '' end) as Remark1, 
                                                                --CASE WHEN ( ISNULL(sm.ShopKeeperName,'') = '' ) then 'Enter Shop Keeper Name' else '' end as Remark2,
                                                                COALESCE(CASE WHEN ( ISNULL(sm.ShopKeeperName,'') = '' AND ( ISNULL(sm.ShopAddress_1,'') = '' OR ISNULL(sm.ShopAddress_2,'') = '' )  ) then 'Enter Shop Keeper Name And Address'  WHEN ( ISNULL(sm.ShopAddress_1,'') = '' OR ISNULL(sm.ShopAddress_2,'') = '' ) THEN 'Enter Shop Address' ELSE '' END,'') as Remark2,
                                                                CASE WHEN ( sm.ShopOutsideImage1 IS NULL AND sm.ShopOutsideImage2 IS NULL ) then 'Upload Shop Outside Photo' else '' end as Remark3,
                                                                sm.ShopOutsideImage1,sm.ShopOutsideImage2,sm.ShopKeeperMobile,sm.ShopKeeperName,sm.IsActive, sm.Pocket_Cd,sm.ShopName,sm.ShopStatus,sm.SurveyDate
                                                            FROM ShopMaster sm 
                                                            INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                                                            INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                                                            WHERE sm.IsActive = 1 
                                                            AND ( 
                                                                --ISNULL(sm.ShopStatus,'') = '' OR 

                                                                    sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                                                                ) 
                                                            AND sm.SurveyDate IS NOT NULL AND CONVERT(VARCHAR,sm.SurveyDate,23) < '$assign_date' 
                                                            AND ( 
                                                                    (sm.ShopKeeperMobile IS NULL OR ISNULL(sm.ShopKeeperMobile,'') = '' OR LEFT(sm.ShopKeeperMobile, 1) NOT IN (6,7,8,9) OR LEN(sm.ShopKeeperMobile) != 10 )
                                                                    OR 
                                                                    ( sm.ShopOutsideImage1 IS NULL AND sm.ShopOutsideImage2 IS NULL )  
                                                                    OR 
                                                                    ( ISNULL(sm.ShopKeeperName,'') = '' )  
                                                                    OR 
                                                                    ( ISNULL(sm.ShopAddress_1,'') = '' OR ISNULL(sm.ShopAddress_2,'') = '' )
                                                                )
                                                            $nodeNameCondition
                                                            $nodeWardCondition    
                                                        --ORDER BY sm.SurveyDate 
                                                        ) as t
                                                        LEFT JOIN ScheduleDetails sd on (
                                                            t.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assign_date' 
                                                            AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                                                FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopSurvey')
                                                            AND ( 
                                                                 --ISNULL(t.ShopStatus,'') = '' OR 
                                                                t.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                                                            )
                                                            AND t.SurveyDate IS NOT NULL AND CONVERT(VARCHAR,t.SurveyDate,23) < '$assign_date' 
                                                            AND sd.CallReason in ( '2nd Premise Visit' , 'Re-Collect Shop Documents' )
                                                            AND t.IsActive = 1
                                                        )
                                                        INNER JOIN PocketMaster pm on (pm.Pocket_Cd = t.Pocket_Cd)
                                                        INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                                                        LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                                        WHERE sd.ScheduleCall_Cd IS NULL
                                                        $nodeNameCondition
                                                        $nodeWardCondition 
                                                    ";
                                                    // echo $query;
                                                $dataProcessScheduling = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
                                                    if(sizeof($dataProcessScheduling)>0){
                                                        if($dataProcessScheduling["ShopCount"]>0){
                                            ?>
                                                <button id="submitProcessScheduleShopsBtnId" type="button" name="refesh" class="btn btn-primary" onclick="setProcessScheduleShops('<?php echo $shopAssignFilterType; ?>')" ><?php echo $dataProcessScheduling["ShopCount"]; ?> Process Scheduling</button>

                                                <?php
                                                        }
                                                    }
                                                ?>

                                            <?php } ?>
                                        <?php }else if($shopAssignFilterType == "NoDocument"){

                                                if(isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) && ( $_SESSION['SAL_UserType']== 'Admin' ) ){ 
                                                    $dataProcessScheduling = array();
                                                    $db=new DbOperation();
                                                    $userName=$_SESSION['SAL_UserName'];
                                                    $appName=$_SESSION['SAL_AppName'];
                                                    $electionName=$_SESSION['SAL_ElectionName'];
                                                    $developmentMode=$_SESSION['SAL_DevelopmentMode'];
                                                    $query="SELECT 
                                                            ISNULL(COUNT(t.Shop_Cd),0) as ShopCount
                                                        FROM(
                                                            SELECT
                                                                sm.Shop_Cd,
                                                                ( SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopDocument') As SD_Calling_Category_Cd, 'Re-Collect Shop Documents' as CallReason,
                                                                 'Documents are pending'  as Remark,
                                                                sm.ShopOutsideImage1,sm.ShopOutsideImage2,sm.ShopKeeperMobile,sm.ShopKeeperName,sm.IsActive, sm.Pocket_Cd,sm.ShopName,sm.ShopStatus,sm.SurveyDate
                                                            FROM ShopMaster sm 
                                                            INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                                                            INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                                                            WHERE sm.IsActive = 1 
                                                             AND ( 
                                                                    ISNULL(sm.ShopStatus,'') <> 'Verified' AND sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND ApplicationStatus <> 'Verified' AND IsActive = 1) AND (SELECT COUNT(Shop_Cd) FROM ShopDocuments WHERE Shop_Cd = sm.Shop_Cd AND IsActive = 1 ) = 0 
                                                                ) 
                                                            AND sm.SurveyDate IS NOT NULL AND CONVERT(VARCHAR,sm.SurveyDate,23) < '$assign_date'
                                                            AND ( 
                                                                ( ISNULL(sm.ShopKeeperMobile,'') <> '' AND sm.ShopKeeperMobile IS NOT NULL AND LEFT(sm.ShopKeeperMobile, 1) IN (6,7,8,9) AND LEN(sm.ShopKeeperMobile) = 10 )
                                                                AND 
                                                                ( sm.ShopOutsideImage1 IS NOT NULL  )  
                                                                AND 
                                                                ( ISNULL(sm.ShopKeeperName,'') <> '' AND ( ISNULL(sm.ShopAddress_1,'') <> '' AND ISNULL(sm.ShopAddress_2,'') <> '' )  )  
                                                                 AND 
                                                                ( ISNULL(sm.ShopName,'') <> '' AND ISNULL(sm.ShopCategory,'') <> ''  AND ISNULL(sm.BusinessCat_Cd,0) <> 0  AND ISNULL(sm.ShopArea_Cd,0) <> 0 )  
                                                                AND 
                                                                ( ISNULL(sm.ShopAddress_1,'') <> '' AND ISNULL(sm.ShopAddress_2,'') <> '' )  
                                                                --OR 
                                                                --( ISNULL(sm.MaleEmp,0) = 0 OR ISNULL(sm.FemaleEmp,0) = 0 OR ISNULL(sm.OtherEmp,0) = 0) 
                                                            )
                                                            $nodeNameCondition
                                                            $nodeWardCondition
                                                        --ORDER BY sm.SurveyDate 
                                                        ) as t
                                                        LEFT JOIN ScheduleDetails sd on (
                                                            t.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assign_date' 
                                                            AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                                                FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopDocument')
                                                            AND ( 
                                                                 --ISNULL(t.ShopStatus,'') = '' OR 
                                                                t.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                                                            )
                                                            AND t.SurveyDate IS NOT NULL AND CONVERT(VARCHAR,t.SurveyDate,23) < '$assign_date' 
                                                            AND sd.CallReason in ( 'Re-Collect Shop Documents' )
                                                            AND t.IsActive = 1
                                                        )
                                                        INNER JOIN PocketMaster pm on (pm.Pocket_Cd = t.Pocket_Cd)
                                                        INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                                                        LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                                        WHERE sd.ScheduleCall_Cd IS NULL
                                                        $nodeNameCondition
                                                        $nodeWardCondition
                                                    ";
                                                    // echo $query;
                                                $dataProcessScheduling = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
                                                    if(sizeof($dataProcessScheduling)>0){
                                                        if($dataProcessScheduling["ShopCount"]>0){
                                            ?>
                                                <button id="submitProcessScheduleShopsBtnId" type="button" name="refesh" class="btn btn-primary" onclick="setProcessScheduleShops('<?php echo $shopAssignFilterType; ?>')" ><?php echo $dataProcessScheduling["ShopCount"]; ?> Process Scheduling</button>

                                                <?php
                                                        }
                                                    }
                                                ?>

                                            <?php } ?>

                                        <?php }else if($shopAssignFilterType == "QCDocumentPending"){
                                                 if(isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) && ( $_SESSION['SAL_UserType']== 'Admin' ) ){ 
                                                    $dataProcessScheduling = array();
                                                    $db=new DbOperation();
                                                    $userName=$_SESSION['SAL_UserName'];
                                                    $appName=$_SESSION['SAL_AppName'];
                                                    $electionName=$_SESSION['SAL_ElectionName'];
                                                    $developmentMode=$_SESSION['SAL_DevelopmentMode'];
                                                    $query="SELECT 
                                                            ISNULL(COUNT(t.Shop_Cd),0) as ShopCount
                                                        FROM(
                                                            SELECT
                                                                sm.Shop_Cd,
                                                                ( SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopDocument') As SD_Calling_Category_Cd, 'Re-Collect Shop Documents' as CallReason,
                                                                 'Documents are pending'  as Remark,
                                                                sm.ShopOutsideImage1,sm.ShopOutsideImage2,sm.ShopKeeperMobile,sm.ShopKeeperName,sm.IsActive, sm.Pocket_Cd,sm.ShopName,sm.ShopStatus,sm.SurveyDate
                                                            FROM ShopMaster sm 
                                                            INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                                                            INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                                                            WHERE sm.IsActive = 1 
                                                             AND ( 
                                                                ISNULL(sm.ShopStatus,'') <> 'Verified' AND sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND ApplicationStatus <> 'Verified' AND IsActive = 1) AND (SELECT COUNT(Shop_Cd) FROM ShopDocuments WHERE Shop_Cd = sm.Shop_Cd AND IsActive = 1 ) <> 0 
                                                                ) 
                                                            AND sm.SurveyDate IS NOT NULL AND CONVERT(VARCHAR,sm.SurveyDate,23) < '$assign_date'
                                                            AND ( 
                                                                ( ISNULL(sm.ShopKeeperMobile,'') <> '' AND sm.ShopKeeperMobile IS NOT NULL AND LEFT(sm.ShopKeeperMobile, 1) IN (6,7,8,9) AND LEN(sm.ShopKeeperMobile) = 10 )
                                                                AND 
                                                                ( sm.ShopOutsideImage1 IS NOT NULL  )  
                                                                AND 
                                                                ( ISNULL(sm.ShopKeeperName,'') <> '' AND ( ISNULL(sm.ShopAddress_1,'') <> '' AND ISNULL(sm.ShopAddress_2,'') <> '' )  )  
                                                                 AND 
                                                                ( ISNULL(sm.ShopName,'') <> '' AND ISNULL(sm.ShopCategory,'') <> ''  AND ISNULL(sm.BusinessCat_Cd,0) <> 0  AND ISNULL(sm.ShopArea_Cd,0) <> 0 )  
                                                                AND 
                                                                ( ISNULL(sm.ShopAddress_1,'') <> '' AND ISNULL(sm.ShopAddress_2,'') <> '' )  
                                                                --OR 
                                                                --( ISNULL(sm.MaleEmp,0) = 0 OR ISNULL(sm.FemaleEmp,0) = 0 OR ISNULL(sm.OtherEmp,0) = 0)  
                                                                
                                                            )
                                                            

                                                            $nodeNameCondition
                                                            $nodeWardCondition
                                                        --ORDER BY sm.SurveyDate 
                                                        ) as t
                                                        LEFT JOIN ScheduleDetails sd on (
                                                            t.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assign_date' 
                                                            AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                                                FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopDocument')
                                                            AND ( 
                                                                 --ISNULL(t.ShopStatus,'') = '' OR 
                                                                t.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                                                            )
                                                            AND t.SurveyDate IS NOT NULL AND CONVERT(VARCHAR,t.SurveyDate,23) < '$assign_date' 
                                                            AND sd.CallReason in ( 'Re-Collect Shop Documents' )
                                                            AND t.IsActive = 1
                                                        )
                                                        INNER JOIN PocketMaster pm on (pm.Pocket_Cd = t.Pocket_Cd)
                                                        INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                                                        LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                                        WHERE sd.ScheduleCall_Cd IS NULL
                                                        $nodeNameCondition
                                                        $nodeWardCondition
                                                    ";
                                                    // echo $query;
                                                $dataProcessScheduling = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
                                                    if(sizeof($dataProcessScheduling)>0){
                                                        if($dataProcessScheduling["ShopCount"]>0){
                                            ?>
                                                <button id="submitProcessScheduleShopsBtnId" type="button" name="refesh" class="btn btn-primary" onclick="setProcessScheduleShops('<?php echo $shopAssignFilterType; ?>')" ><?php echo $dataProcessScheduling["ShopCount"]; ?> Process Scheduling</button>

                                                <?php
                                                        }
                                                    }
                                                ?>

                                            <?php } ?>

                                        <?php }elseif($shopAssignFilterType == "DocumentsDenied"){

                                                  if(isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) && ( $_SESSION['SAL_UserType']== 'Admin' )  ){ 
                                                $dataProcessScheduling = array();
                                                $db=new DbOperation();
                                                $userName=$_SESSION['SAL_UserName'];
                                                $appName=$_SESSION['SAL_AppName'];
                                                $electionName=$_SESSION['SAL_ElectionName'];
                                                $developmentMode=$_SESSION['SAL_DevelopmentMode'];
                                                $query="SELECT 
                                                            ISNULL(COUNT(DISTINCT(t.Shop_Cd)),0) as ShopCount
                                                        FROM(
                                                            SELECT sm.Shop_Cd, sm.ShopName, sm.ShopKeeperMobile, sm.ShopKeeperName, sm.ShopOutsideImage1, sm.ShopOutsideImage2, pm.Pocket_Cd,ShopStatus,shopStatusDate,shopStatusRemark,SurveyDate,NM.Ward_No,sm.SRExecutive_Cd,sm.SRAssignedDate,sm.IsActive, sm.Surveyby

                                                            FROM shopmaster as sm 
                                                            inner join PocketMaster as PM on PM.Pocket_Cd = sm.Pocket_Cd
                                                            inner join nodemaster as NM on PM.Node_Cd = NM.Node_Cd
                                                            where sm.IsActive = 1
                                                            AND (
                                                                sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1) 
                                                            )
                                                            $nodeNameCondition
                                                            $nodeWardCondition
                                                           -- order by SurveyDate desc
                                                        ) as t
                                                        LEFT JOIN ScheduleDetails sd on (
                                                            t.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assign_date' 
                                                            AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                                                FROM CallingCategoryMaster WHERE Calling_Type = 'Survey')
                                                            AND t.IsActive = 1 
                                                            AND (  
                                                                t.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1) 
                                                            )
                                                            AND sd.CallReason in ( '2nd Premise Visit' , 'Re-Collect Shop Documents' )
                                                        )
                                                        INNER JOIN PocketMaster pm on (pm.Pocket_Cd = t.Pocket_Cd)
                                                        INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                                                        LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                                        WHERE sd.ScheduleCall_Cd IS NULL
                                                        $nodeNameCondition
                                                        $nodeWardCondition 
                                                    ";
                                                    // echo $query;
                                                $dataProcessScheduling = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
                                                    if(sizeof($dataProcessScheduling)>0){
                                                        if($dataProcessScheduling["ShopCount"]>0){
                                            ?>
                                                <button id="submitProcessScheduleShopsBtnId" type="button" name="refesh" class="btn btn-primary" onclick="setProcessScheduleShops('<?php echo $shopAssignFilterType; ?>')" ><?php echo $dataProcessScheduling["ShopCount"]; ?> Process Scheduling</button>

                                                <?php
                                                        }
                                                    }
                                                ?>

                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <input type="hidden" class="form-control" name="pocketsCount" value="" disabled>
                                <input type="hidden" class="form-control" name="shopsCount" value="" disabled>
                                

                                <div class="col-md-1 col-12 text-right" >
                                     <div class="form-group">
                                        <input type="hidden" class="form-control" name="multiplePockets" >
                                        <label for="refesh"></label>
                                        <button id="submitShopsAssignBtnId" type="button" name="refesh" class="btn btn-primary" onclick="setAssignShopsToExecutiveByPockets()" >Assign</button>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-12 col-xl-12" >
                                    <img id="idAssignShopsLoading" src="app-assets/images/loader/loading.gif" style="display: none;" height="64" width="64" />
                                    <span id="idAssignShopsMsgSuccess" class="btn btn-success" style="display: none;"></span>
                                    <span id="idAssignShopsMsgFailure" class="btn btn-danger" style="display: none;"></span>
                                </div>
                            </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        $dataSurveyAssignSummary = array();
        $db3=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];


            // $query3 = "SELECT 
            //     ISNULL(sm.Pocket_Cd,0) as Pocket_Cd,
            //     ISNULL(pm.PocketName,'') as PocketName,
            //     ISNULL(pm.Node_Cd,0) as Node_Cd,
            //     sum(case when (sm.SRExecutive_Cd <> 0) then 1 else 0 end) as Assigned,
            //     sum(case when (sm.SRExecutive_Cd is null or sm.SRExecutive_Cd = 0) then 1 else 0 end) as NotAssigned,
            //     count(sm.Shop_Cd) as ShopCount

            //     FROM ShopMaster sm 
            //     LEFT JOIN PocketMaster pm
            //     ON sm.Pocket_Cd = pm.Pocket_Cd
            //     LEFT JOIN NodeMaster nm
            //     ON nm.Node_Cd = pm.Node_Cd
            //     INNER JOIN ScheduleDetails sd 
            //     ON sd.Shop_Cd = sm.Shop_Cd
            //     WHERE CONVERT(VARCHAR,sd.CallingDate,23) = '$assign_date'
            //     $nodeNameCondition
            //     $nodeWardCondition
            //     AND sm.SRAssignedDate is null
            //     AND sd.Calling_Category_Cd = $callingCategoryCd
            //     GROUP BY sm.Pocket_Cd, pm.Node_Cd, pm.PocketName 
            //     having sum(case when (sm.SRExecutive_Cd is null or sm.SRExecutive_Cd = 0) then 1 else 0 end) > 0
            //     ";
        $dataSurveyAssignSummary = array();

        if($shopAssignFilterType=="New"){

            $query3 = "SELECT
                        a.Pocket_Cd, pm.PocketName,nm.Ward_No,nm.NodeName,
                        COUNT(DISTINCT(a.Shop_Cd)) as ShopCount
                FROM (
                    SELECT 
                       sd.ScheduleCall_Cd, sd.Shop_Cd, sd.Calling_Category_Cd,
                      sm.Pocket_Cd
                    FROM ScheduleDetails sd
                    INNER JOIN ShopMaster sm on (
                            sm.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assign_date' 
                            AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                FROM CallingCategoryMaster WHERE Calling_Type = '$callingType')
                            AND ( ISNULL(sm.ShopStatus,'') = '' OR sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )
                            AND sm.SurveyDate IS NULL
                            AND sm.IsActive = 1
                        )
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                    LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                    WHERE st.ScheduleCall_Cd IS NULL
                    $nodeNameCondition
                    $nodeWardCondition
                ) a,
                PocketMaster pm, NodeMaster nm
                WHERE pm.Pocket_Cd = a.Pocket_Cd
                AND nm.Node_Cd = pm.Node_Cd
                 
                GROUP BY a.Pocket_Cd,pm.PocketName,
                nm.Ward_No,nm.NodeName
                ORDER BY nm.Ward_No ";
                $dataSurveyAssignSummary = $db3->ExecutveQueryMultipleRowSALData($query3, $electionName, $developmentMode);
        }else if($shopAssignFilterType=="SurveyShopReVisitUsingQuery"){
            if($callingType=="Survey"){
                $query3 = "SELECT
                        a.Pocket_Cd, pm.PocketName,nm.Ward_No,nm.NodeName,
                        COUNT(DISTINCT(a.Shop_Cd)) as ShopCount
                FROM (
                    SELECT 
                       sd.ScheduleCall_Cd, sd.Shop_Cd, sd.Calling_Category_Cd,
                      sm.Pocket_Cd
                    FROM ScheduleDetails sd
                    INNER JOIN ShopMaster sm on (
                            sm.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assign_date' 
                            AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                FROM CallingCategoryMaster WHERE Calling_Type = '$callingType')

                            --AND sm.surveyby ='AMIRODDIN_S'
                            AND sm.surveyby ='BHUSHAN_P16'
                            AND MONTH(sm.SurveyDate) = 12
                            AND sm.IsActive = 1 
                            AND ( 
                                 ISNULL(sm.ShopStatus,'') = '' OR 
                                sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                            )
                            AND sd.CallReason in ( '2nd Premise Visit' , 'Re-Collect Shop Documents' )
                        )
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                    LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                    WHERE st.ScheduleCall_Cd IS NULL
                    $nodeNameCondition
                    $nodeWardCondition
                ) a,
                PocketMaster pm, NodeMaster nm
                WHERE pm.Pocket_Cd = a.Pocket_Cd
                AND nm.Node_Cd = pm.Node_Cd
                 
                GROUP BY a.Pocket_Cd,pm.PocketName,
                nm.Ward_No,nm.NodeName
                ORDER BY nm.Ward_No ";
                $dataSurveyAssignSummary = $db3->ExecutveQueryMultipleRowSALData($query3, $electionName, $developmentMode);
            }
        }else if($shopAssignFilterType=="InvalidMobilePhoto"){
            if($callingType=="Survey"){
                $query3 = "SELECT
                        a.Pocket_Cd, pm.PocketName,nm.Ward_No,nm.NodeName,
                        COUNT(DISTINCT(a.Shop_Cd)) as ShopCount
                FROM (
                    SELECT 
                       sd.ScheduleCall_Cd, sd.Shop_Cd, sd.Calling_Category_Cd,
                      sm.Pocket_Cd
                    FROM ScheduleDetails sd
                    INNER JOIN ShopMaster sm on (
                            sm.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assign_date' 
                            AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                FROM CallingCategoryMaster WHERE Calling_Type = '$callingType')
                            AND ( 
                                --ISNULL(sm.ShopStatus,'') = '' OR 
                                sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                                )
                            AND sm.SurveyDate IS NOT NULL
                            AND ( 
                                    (sm.ShopKeeperMobile IS NULL OR ISNULL(sm.ShopKeeperMobile,'') = '' OR LEFT(sm.ShopKeeperMobile, 1) NOT IN (6,7,8,9) OR LEN(sm.ShopKeeperMobile) != 10 )
                                    OR 
                                    ( sm.ShopOutsideImage1 IS NULL AND sm.ShopOutsideImage2 IS NULL ) 
                                    OR 
                                    ( ISNULL(sm.ShopKeeperName,'') = '' )  
                                    OR 
                                    ( ISNULL(sm.ShopAddress_1,'') = '' OR ISNULL(sm.ShopAddress_2,'') = '' )
                                )
                            AND sd.CallReason in ( '2nd Premise Visit' , 'Re-Collect Shop Documents' )
                            AND sm.IsActive = 1
                        )
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                    LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                    WHERE st.ScheduleCall_Cd IS NULL
                    $nodeNameCondition
                    $nodeWardCondition
                ) a,
                PocketMaster pm, NodeMaster nm
                WHERE pm.Pocket_Cd = a.Pocket_Cd
                AND nm.Node_Cd = pm.Node_Cd
                 
                GROUP BY a.Pocket_Cd,pm.PocketName,
                nm.Ward_No,nm.NodeName
                ORDER BY nm.Ward_No ";
                $dataSurveyAssignSummary = $db3->ExecutveQueryMultipleRowSALData($query3, $electionName, $developmentMode);
            }
        }else if($shopAssignFilterType=="NoDocument"){
            if($callingType=="Survey"){
                $query3 = "SELECT
                        a.Pocket_Cd, pm.PocketName,nm.Ward_No,nm.NodeName,
                        COUNT(DISTINCT(a.Shop_Cd)) as ShopCount
                FROM (
                    SELECT 
                       sd.ScheduleCall_Cd, sd.Shop_Cd, sd.Calling_Category_Cd,
                      sm.Pocket_Cd
                    FROM ScheduleDetails sd
                    INNER JOIN ShopMaster sm on (
                            sm.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assign_date' 
                            AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                FROM CallingCategoryMaster WHERE Calling_Type = '$callingType')
                            AND ( 
                                    ISNULL(sm.ShopStatus,'') <> 'Verified' AND sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND ApplicationStatus <> 'Verified' AND IsActive = 1) AND (SELECT COUNT(Shop_Cd) FROM ShopDocuments WHERE Shop_Cd = sm.Shop_Cd AND IsActive = 1 ) = 0  
                                )
                            AND sm.SurveyDate IS NOT NULL
                            AND ( 
                                (ISNULL(sm.ShopKeeperMobile,'') <> '' AND sm.ShopKeeperMobile IS NOT NULL AND LEFT(sm.ShopKeeperMobile, 1) IN (6,7,8,9) AND LEN(sm.ShopKeeperMobile) = 10 )
                                AND 
                                ( sm.ShopOutsideImage1 IS NOT NULL  )  
                                AND 
                                ( ISNULL(sm.ShopKeeperName,'') <> '' AND ( ISNULL(sm.ShopAddress_1,'') <> '' AND ISNULL(sm.ShopAddress_2,'') <> '' )  )  
                                 AND 
                                ( ISNULL(sm.ShopName,'') <> '' AND ISNULL(sm.ShopCategory,'') <> ''  AND ISNULL(sm.BusinessCat_Cd,0) <> 0  AND ISNULL(sm.ShopArea_Cd,0) <> 0 )  
                                AND 
                                ( ISNULL(sm.ShopAddress_1,'') <> '' AND ISNULL(sm.ShopAddress_2,'') <> '' )  
                                --OR 
                                --( ISNULL(sm.MaleEmp,0) = 0 OR ISNULL(sm.FemaleEmp,0) = 0 OR ISNULL(sm.OtherEmp,0) = 0)
                            )
                            AND sd.CallReason in ( 'Re-Collect Shop Documents' )
                            AND sm.IsActive = 1
                        )
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                    LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                    WHERE st.ScheduleCall_Cd IS NULL 
                    $nodeNameCondition
                    $nodeWardCondition
                ) a,
                PocketMaster pm, NodeMaster nm
                WHERE pm.Pocket_Cd = a.Pocket_Cd
                AND nm.Node_Cd = pm.Node_Cd
                 
                GROUP BY a.Pocket_Cd,pm.PocketName,
                nm.Ward_No,nm.NodeName
                ORDER BY nm.Ward_No ";
                $dataSurveyAssignSummary = $db3->ExecutveQueryMultipleRowSALData($query3, $electionName, $developmentMode);
            }
        }else if($shopAssignFilterType=="QCDocumentPending"){
            if($callingType=="Survey"){
                $query3 = "SELECT
                        a.Pocket_Cd, pm.PocketName,nm.Ward_No,nm.NodeName,
                        COUNT(DISTINCT(a.Shop_Cd)) as ShopCount
                FROM (
                    SELECT 
                       sd.ScheduleCall_Cd, sd.Shop_Cd, sd.Calling_Category_Cd,
                      sm.Pocket_Cd
                    FROM ScheduleDetails sd
                    INNER JOIN ShopMaster sm on (
                            sm.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assign_date' 
                            AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                FROM CallingCategoryMaster WHERE Calling_Type = '$callingType')
                            AND ( 
                                ISNULL(sm.ShopStatus,'') <> 'Verified' AND sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND ApplicationStatus <> 'Verified' AND IsActive = 1) AND (SELECT COUNT(Shop_Cd) FROM ShopDocuments WHERE Shop_Cd = sm.Shop_Cd AND IsActive = 1 ) <> 0 
                                )
                            AND sm.SurveyDate IS NOT NULL
                            AND ( 
                                (ISNULL(sm.ShopKeeperMobile,'') <> '' AND sm.ShopKeeperMobile IS NOT NULL AND LEFT(sm.ShopKeeperMobile, 1) IN (6,7,8,9) AND LEN(sm.ShopKeeperMobile) = 10 )
                                AND 
                                ( sm.ShopOutsideImage1 IS NOT NULL  )  
                                AND 
                                ( ISNULL(sm.ShopKeeperName,'') <> '' AND ( ISNULL(sm.ShopAddress_1,'') <> '' AND ISNULL(sm.ShopAddress_2,'') <> '' )  )  
                                 AND 
                                ( ISNULL(sm.ShopName,'') <> '' AND ISNULL(sm.ShopCategory,'') <> ''  AND ISNULL(sm.BusinessCat_Cd,0) <> 0  AND ISNULL(sm.ShopArea_Cd,0) <> 0 )  
                                AND 
                                ( ISNULL(sm.ShopAddress_1,'') <> '' AND ISNULL(sm.ShopAddress_2,'') <> '' )  
                                --OR 
                                --( ISNULL(sm.MaleEmp,0) = 0 OR ISNULL(sm.FemaleEmp,0) = 0 OR ISNULL(sm.OtherEmp,0) = 0)  
                            )
                            
                            AND sd.CallReason in ( 'Re-Collect Shop Documents' )
                            AND sm.IsActive = 1
                        )
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                    LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                    WHERE st.ScheduleCall_Cd IS NULL 
                    $nodeNameCondition
                    $nodeWardCondition
                ) a,
                PocketMaster pm, NodeMaster nm
                WHERE pm.Pocket_Cd = a.Pocket_Cd
                AND nm.Node_Cd = pm.Node_Cd
                 
                GROUP BY a.Pocket_Cd,pm.PocketName,
                nm.Ward_No,nm.NodeName
                ORDER BY nm.Ward_No ";
                $dataSurveyAssignSummary = $db3->ExecutveQueryMultipleRowSALData($query3, $electionName, $developmentMode);
            }
        }else if($shopAssignFilterType=="DocumentsDenied"){
            if($callingType=="Survey"){
                $query3 = "SELECT
                        a.Pocket_Cd, pm.PocketName,nm.Ward_No,nm.NodeName,
                        COUNT(DISTINCT(a.Shop_Cd)) as ShopCount
                FROM (
                    SELECT 
                       sd.ScheduleCall_Cd, sd.Shop_Cd, sd.Calling_Category_Cd,
                      sm.Pocket_Cd
                    FROM ScheduleDetails sd
                    INNER JOIN ShopMaster sm on (
                            sm.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assign_date' 
                            AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                FROM CallingCategoryMaster WHERE Calling_Type = '$callingType')
                            AND sm.IsActive = 1 
                            AND (
                                sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1) 
                            )
                            AND sd.CallReason in ( '2nd Premise Visit' , 'Re-Collect Shop Documents' )
                        )
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                    LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                    WHERE st.ScheduleCall_Cd IS NULL
                    $nodeNameCondition
                    $nodeWardCondition
                ) a,
                PocketMaster pm, NodeMaster nm
                WHERE pm.Pocket_Cd = a.Pocket_Cd
                AND nm.Node_Cd = pm.Node_Cd
                 
                GROUP BY a.Pocket_Cd,pm.PocketName,
                nm.Ward_No,nm.NodeName
                ORDER BY nm.Ward_No";
                $dataSurveyAssignSummary = $db3->ExecutveQueryMultipleRowSALData($query3, $electionName, $developmentMode);
            }
        }

    ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><?php if($shopAssignFilterType=="InvalidMobilePhoto"){ ?> Invalid ShopKeeper Name or Mobile And Shop Outside Photo - <?php }else if($shopAssignFilterType=="SurveyShopReVisitUsingQuery"){ ?> Survey Re-Visit Using Query - <?php }else if($shopAssignFilterType=="NoDocument"){ ?> Survey but No Documents Collected - <?php }else if($shopAssignFilterType=="QCDocumentPending"){ ?> QC Done But Documents Pending - <?php }else if($shopAssignFilterType=="DocumentsDenied"){ ?> Documents Denied - <?php }else{ }  ?>  Shops Assigning for <?php echo $callingType; ?>  -  <?php echo date('d/m/Y',strtotime($assign_date)); ?>
                    </h5>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table  class="table table-striped table-bordered complex-headers">
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Pocket Name</th>
                                        <th>Ward No</th>
                                        <th>Zone Office</th>
                                        <th>Shops</th>
                                        <?php 
                                           // if($callingType != "Calling"){
                                        ?>
                                            <!-- <th>Action</th> -->
                                        <?php
                                          //  }
                                        ?>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $totalShops = 0;
                                        foreach ($dataSurveyAssignSummary as $key => $value) {
                                            $totalShops = $totalShops + $value["ShopCount"];
                                    ?>
                                        <tr>
                                            <td> 
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" value="<?php echo $value["Pocket_Cd"]; ?>,<?php echo $value["ShopCount"]; ?>" name="assignPockets" onclick="setSelectMultiplePockets()" >
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </td>
                                            <td><?php echo $value["PocketName"]; ?></td>
                                            <td><?php echo "W-".$value["Ward_No"]; ?></td>
                                            <td><?php echo $value["NodeName"]; ?></td>
                                            <td><?php echo $value["ShopCount"]; ?></td>
                                            <?php 
                                                //if($callingType != "Calling"){
                                            ?>
                                                <!-- <td>
                                                    <a href="home.php?p=shops-assign-list&assignDate=<?php echo $assign_date; ?>&pocktCd=<?php echo $value["Pocket_Cd"]; ?>&action=assign" ><i class="feather icon-layers" style="font-size: 1.5rem;color:#c90d41;" title="Assign Shops"></i></a>
                                                </td> -->
                                            <?php
                                                //}
                                            ?>
                                        </tr>
                                    
                                    <?php
                                        }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4"></th>
                                        <th><?php echo $totalShops; ?></th>
                                        <!-- <th colspan="1"></th> -->
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
           

    <?php
        $dataAssignExeSummary = array();

        if($callingType=='Survey'){
            $assignExecutives = "SELECT SRExecutive_Cd as Executive_Cd
                        FROM ShopMaster sm 
                        WHERE CONVERT(VARCHAR,sm.SRAssignedDate,23) = '$assign_date'
                        GROUP BY SRExecutive_Cd";
        }else if($callingType=='Calling'){
            $assignExecutives = "SELECT CCExecutive_Cd as Executive_Cd
                        FROM ShopMaster sm 
                        WHERE CONVERT(VARCHAR,sm.CCAssignedDate,23) = '$assign_date'
                        GROUP BY CCExecutive_Cd";
        }else if($callingType=='Collection'){
            $assignExecutives = "SELECT CPExecutive_Cd as Executive_Cd
                        FROM ShopMaster sm 
                        WHERE CONVERT(VARCHAR,sm.CPAssignedDate,23) = '$assign_date'
                        GROUP BY CPExecutive_Cd";
        }

        $query4 = "SELECT
                    a.Executive_Cd,em.ExecutiveName,
                    em.MobileNo, lm.User_Type,
                    COUNT(DISTINCT(a.Pocket_Cd)) as PocketCount,
                    COUNT(DISTINCT(a.Shop_Cd)) as ShopCount,
                    COUNT(DISTINCT(a.ST_StatusPocket)) as PocketsCompleted,
                    COUNT(DISTINCT(a.ST_StatusShop)) as ShopsCompleted,
                    ISNULL(CONVERT(VARCHAR,MAX(a.ST_DateTime),121),'') as LastActiveTime
                FROM
                (
                    SELECT 
                        t.Executive_Cd,
                        st.AssignDate,
                        st.ScheduleCall_Cd,
                        st.Shop_Cd,
                        st.Calling_Category_Cd, st.ST_DateTime,
                        CASE WHEN st.ST_Status = 1 then st.Shop_Cd ELSE NULL END as ST_StatusShop,
                        CASE WHEN st.ST_Status = 1 then sm.Pocket_Cd ELSE NULL END as ST_StatusPocket,
                    sm.Pocket_Cd
                    FROM(
                        $assignExecutives
                    ) as t,
                    ShopTracking st, ScheduleDetails sd,
                    ShopMaster sm, PocketMaster pm 
                    WHERE CONVERT(VARCHAR,st.AssignDate,23) = '$assign_date'
                    AND st.AssignExec_Cd = t.Executive_Cd
                    AND st.Calling_Category_Cd in ( SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = '$callingType' )
                    AND sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                    AND sm.Shop_Cd = st.Shop_Cd
                    AND pm.Pocket_Cd = sm.Pocket_Cd
                   
                    AND sm.IsActive = 1
                ) a
                INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = a.Executive_Cd
                INNER JOIN LoginMaster lm on lm.Executive_Cd = a.Executive_Cd
                GROUP BY a.Executive_Cd,em.ExecutiveName, em.MobileNo, lm.User_Type";
        $dataAssignExeSummary = $db3->ExecutveQueryMultipleRowSALData($query4, $electionName, $developmentMode);

        // if($shopAssignFilterType == "New"){
        //     $query4 = "SELECT
        //             a.AssignExec_Cd as Executive_Cd,em.ExecutiveName,
        //             em.MobileNo, lm.User_Type,
        //             COUNT(DISTINCT(a.Pocket_Cd)) as PocketCount,
        //             COUNT(DISTINCT(a.Shop_Cd)) as ShopCount,
        //             COUNT(DISTINCT(a.ST_StatusPocket)) as PocketsCompleted,
        //             COUNT(DISTINCT(a.ST_StatusShop)) as ShopsCompleted,
        //             ISNULL(CONVERT(VARCHAR,MAX(a.ST_DateTime),121),'') as LastActiveTime
        //         FROM
        //         (
        //             SELECT st.ScheduleCall_Cd,
        //             st.Shop_Cd, st.AssignExec_Cd, 
        //             st.Calling_Category_Cd, st.ST_DateTime,
        //             CASE WHEN st.ST_Status = 1 then st.Shop_Cd ELSE NULL END as ST_StatusShop,
        //             CASE WHEN st.ST_Status = 1 then sm.Pocket_Cd ELSE NULL END as ST_StatusPocket,
        //             sm.Pocket_Cd
        //             FROM ShopTracking st,
        //             ShopMaster sm, PocketMaster pm 
        //             WHERE CONVERT(VARCHAR,st.AssignDate,23) = '$assign_date'
        //             AND sm.Shop_Cd = st.Shop_Cd
        //             AND pm.Pocket_Cd = sm.Pocket_Cd
        //             AND st.Calling_Category_Cd in (SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = '$callingType')
        //             AND ( ISNULL(sm.ShopStatus,'') = '' OR sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )
        //             AND sm.IsActive = 1
        //         ) a
        //         INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = a.AssignExec_Cd
        //         INNER JOIN LoginMaster lm on lm.Executive_Cd = a.AssignExec_Cd
        //         GROUP BY a.AssignExec_Cd,em.ExecutiveName, em.MobileNo, lm.User_Type";
        
        //     $dataAssignExeSummary = $db3->ExecutveQueryMultipleRowSALData($query4, $electionName, $developmentMode);
        // }else if($shopAssignFilterType == "SurveyShopReVisitUsingQuery"){
        //     if($callingType == "Survey"){
        //         $query4 = "SELECT
        //             a.AssignExec_Cd as Executive_Cd,em.ExecutiveName,
        //             em.MobileNo, lm.User_Type,
        //             COUNT(DISTINCT(a.Pocket_Cd)) as PocketCount,
        //             COUNT(DISTINCT(a.Shop_Cd)) as ShopCount,
        //             COUNT(DISTINCT(a.ST_StatusPocket)) as PocketsCompleted,
        //             COUNT(DISTINCT(a.ST_StatusShop)) as ShopsCompleted,
        //             ISNULL(CONVERT(VARCHAR,MAX(a.ST_DateTime),121),'') as LastActiveTime
        //         FROM
        //         (
        //             SELECT st.ScheduleCall_Cd,
        //             st.Shop_Cd, st.AssignExec_Cd, 
        //             st.Calling_Category_Cd, st.ST_DateTime,
        //             CASE WHEN st.ST_Status = 1 then st.Shop_Cd ELSE NULL END as ST_StatusShop,
        //             CASE WHEN st.ST_Status = 1 then sm.Pocket_Cd ELSE NULL END as ST_StatusPocket,
        //             sm.Pocket_Cd
        //             FROM ShopTracking st, ScheduleDetails sd,
        //             ShopMaster sm, PocketMaster pm 
        //             WHERE CONVERT(VARCHAR,st.AssignDate,23) = '$assign_date'
        //             AND sd.ScheduleCall_Cd = st.ScheduleCall_Cd
        //             AND sm.Shop_Cd = st.Shop_Cd
        //             AND pm.Pocket_Cd = sm.Pocket_Cd
        //             AND st.Calling_Category_Cd in ( SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' )
        //             --AND sm.surveyby ='AMIRODDIN_S'
        //             AND sm.surveyby ='BHUSHAN_P16'
        //             AND MONTH(sm.SurveyDate) = 12
        //             AND sm.IsActive = 1 
        //             AND ( 
        //                  ISNULL(sm.ShopStatus,'') = '' OR 
        //                 sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
        //             )
        //             AND sd.CallReason in ( '2nd Premise Visit' , 'Re-Collect Shop Documents' )
        //         ) a
        //         INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = a.AssignExec_Cd
        //         INNER JOIN LoginMaster lm on lm.Executive_Cd = a.AssignExec_Cd
        //         GROUP BY a.AssignExec_Cd,em.ExecutiveName, em.MobileNo, lm.User_Type";
        
        //         $dataAssignExeSummary = $db3->ExecutveQueryMultipleRowSALData($query4, $electionName, $developmentMode);
        //     }
                
        // }else if($shopAssignFilterType == "InvalidMobilePhoto"){
        //     if($callingType == "Survey"){
        //         $query4 = "SELECT
        //             a.AssignExec_Cd as Executive_Cd,em.ExecutiveName,
        //             em.MobileNo, lm.User_Type,
        //             COUNT(DISTINCT(a.Pocket_Cd)) as PocketCount,
        //             COUNT(DISTINCT(a.Shop_Cd)) as ShopCount,
        //             COUNT(DISTINCT(a.ST_StatusPocket)) as PocketsCompleted,
        //             COUNT(DISTINCT(a.ST_StatusShop)) as ShopsCompleted,
        //             ISNULL(CONVERT(VARCHAR,MAX(a.ST_DateTime),121),'') as LastActiveTime
        //         FROM
        //         (
        //             SELECT st.ScheduleCall_Cd,
        //             st.Shop_Cd, st.AssignExec_Cd, 
        //             st.Calling_Category_Cd, st.ST_DateTime,
        //             CASE WHEN st.ST_Status = 1 then st.Shop_Cd ELSE NULL END as ST_StatusShop,
        //             CASE WHEN st.ST_Status = 1 then sm.Pocket_Cd ELSE NULL END as ST_StatusPocket,
        //             sm.Pocket_Cd
        //             FROM ShopTracking st, ScheduleDetails sd,
        //             ShopMaster sm, PocketMaster pm 
        //             WHERE CONVERT(VARCHAR,st.AssignDate,23) = '$assign_date'
        //             AND sd.ScheduleCall_Cd = st.ScheduleCall_Cd
        //             AND sm.Shop_Cd = st.Shop_Cd
        //             AND pm.Pocket_Cd = sm.Pocket_Cd
        //             AND st.Calling_Category_Cd in ( SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' )
        //             AND ( 
        //                 --ISNULL(sm.ShopStatus,'') = '' OR 
        //                 sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
        //             )
        //             AND sm.SurveyDate IS NOT NULL
        //             AND sd.CallReason in ( '2nd Premise Visit' , 'Re-Collect Shop Documents' )
        //             AND sm.IsActive = 1
        //         ) a
        //         INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = a.AssignExec_Cd
        //         INNER JOIN LoginMaster lm on lm.Executive_Cd = a.AssignExec_Cd
        //         GROUP BY a.AssignExec_Cd,em.ExecutiveName, em.MobileNo, lm.User_Type";
        
        //         $dataAssignExeSummary = $db3->ExecutveQueryMultipleRowSALData($query4, $electionName, $developmentMode);
        //     }
                
        // }else if($shopAssignFilterType == "NoDocument"){
        //     if($callingType == "Survey"){
        //         $query4 = "SELECT
        //             a.AssignExec_Cd as Executive_Cd,em.ExecutiveName,
        //             em.MobileNo, lm.User_Type,
        //             COUNT(DISTINCT(a.Pocket_Cd)) as PocketCount,
        //             COUNT(DISTINCT(a.Shop_Cd)) as ShopCount,
        //             COUNT(DISTINCT(a.ST_StatusPocket)) as PocketsCompleted,
        //             COUNT(DISTINCT(a.ST_StatusShop)) as ShopsCompleted,
        //             ISNULL(CONVERT(VARCHAR,MAX(a.ST_DateTime),121),'') as LastActiveTime
        //         FROM
        //         (
        //             SELECT st.ScheduleCall_Cd,
        //             st.Shop_Cd, st.AssignExec_Cd, 
        //             st.Calling_Category_Cd, st.ST_DateTime,
        //             CASE WHEN st.ST_Status = 1 then st.Shop_Cd ELSE NULL END as ST_StatusShop,
        //             CASE WHEN st.ST_Status = 1 then sm.Pocket_Cd ELSE NULL END as ST_StatusPocket,
        //             sm.Pocket_Cd
        //             FROM ShopTracking st, ScheduleDetails sd,
        //             ShopMaster sm, PocketMaster pm 
        //             WHERE CONVERT(VARCHAR,st.AssignDate,23) = '$assign_date'
        //             AND sd.ScheduleCall_Cd = st.ScheduleCall_Cd
        //             AND sm.Shop_Cd = st.Shop_Cd
        //             AND pm.Pocket_Cd = sm.Pocket_Cd
        //             AND st.Calling_Category_Cd in ( SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopDocument' )
        //             AND ( 
        //                     ISNULL(sm.ShopStatus,'') <> 'Verified' AND sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND ApplicationStatus <> 'Verified' AND IsActive = 1) AND (SELECT COUNT(Shop_Cd) FROM ShopDocuments WHERE Shop_Cd = sm.Shop_Cd AND IsActive = 1 ) = 0  
        //             )
        //             AND sm.SurveyDate IS NOT NULL
        //             AND ( 
        //                 ( ISNULL(sm.ShopKeeperMobile,'') <> '' AND sm.ShopKeeperMobile IS NOT NULL AND LEFT(sm.ShopKeeperMobile, 1) IN (6,7,8,9) AND LEN(sm.ShopKeeperMobile) = 10 )
        //                 AND 
        //                 ( sm.ShopOutsideImage1 IS NOT NULL  )  
        //                 AND 
        //                 ( ISNULL(sm.ShopKeeperName,'') <> '' AND ( ISNULL(sm.ShopAddress_1,'') <> '' AND ISNULL(sm.ShopAddress_2,'') <> '' )  )  
        //                  AND 
        //                 ( ISNULL(sm.ShopName,'') <> '' AND ISNULL(sm.ShopCategory,'') <> ''  AND ISNULL(sm.BusinessCat_Cd,0) <> 0  AND ISNULL(sm.ShopArea_Cd,0) <> 0 )  
        //                 AND 
        //                 ( ISNULL(sm.ShopAddress_1,'') <> '' AND ISNULL(sm.ShopAddress_2,'') <> '' )  
        //                 --OR 
        //                 --( ISNULL(sm.MaleEmp,0) = 0 OR ISNULL(sm.FemaleEmp,0) = 0 OR ISNULL(sm.OtherEmp,0) = 0) 
        //             )
        //             AND sd.CallReason in ( 'Re-Collect Shop Documents' )
        //             AND sm.IsActive = 1
        //         ) a
        //         INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = a.AssignExec_Cd
        //         INNER JOIN LoginMaster lm on lm.Executive_Cd = a.AssignExec_Cd
        //         GROUP BY a.AssignExec_Cd,em.ExecutiveName, em.MobileNo, lm.User_Type";
        
        //         $dataAssignExeSummary = $db3->ExecutveQueryMultipleRowSALData($query4, $electionName, $developmentMode);
        //     }
                
        // }else if($shopAssignFilterType == "QCDocumentPending"){
        //     if($callingType == "Survey"){
        //         $query4 = "SELECT
        //             a.AssignExec_Cd as Executive_Cd,em.ExecutiveName,
        //             em.MobileNo, lm.User_Type,
        //             COUNT(DISTINCT(a.Pocket_Cd)) as PocketCount,
        //             COUNT(DISTINCT(a.Shop_Cd)) as ShopCount,
        //             COUNT(DISTINCT(a.ST_StatusPocket)) as PocketsCompleted,
        //             COUNT(DISTINCT(a.ST_StatusShop)) as ShopsCompleted,
        //             ISNULL(CONVERT(VARCHAR,MAX(a.ST_DateTime),121),'') as LastActiveTime
        //         FROM
        //         (
        //             SELECT st.ScheduleCall_Cd,
        //             st.Shop_Cd, st.AssignExec_Cd, 
        //             st.Calling_Category_Cd, st.ST_DateTime,
        //             CASE WHEN st.ST_Status = 1 then st.Shop_Cd ELSE NULL END as ST_StatusShop,
        //             CASE WHEN st.ST_Status = 1 then sm.Pocket_Cd ELSE NULL END as ST_StatusPocket,
        //             sm.Pocket_Cd
        //             FROM ShopTracking st, ScheduleDetails sd,
        //             ShopMaster sm, PocketMaster pm 
        //             WHERE CONVERT(VARCHAR,st.AssignDate,23) = '$assign_date'
        //             AND sd.ScheduleCall_Cd = st.ScheduleCall_Cd
        //             AND sm.Shop_Cd = st.Shop_Cd
        //             AND pm.Pocket_Cd = sm.Pocket_Cd
        //             AND st.Calling_Category_Cd in ( SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopDocument' )
        //             AND ( 
        //                 ISNULL(sm.ShopStatus,'') <> 'Verified' AND sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND ApplicationStatus <> 'Verified' AND IsActive = 1) AND (SELECT COUNT(Shop_Cd) FROM ShopDocuments WHERE Shop_Cd = sm.Shop_Cd AND IsActive = 1 ) <> 0 
        //             )
        //             AND sm.SurveyDate IS NOT NULL
        //             AND ( 
        //                 ( ISNULL(sm.ShopKeeperMobile,'') <> '' AND sm.ShopKeeperMobile IS NOT NULL AND LEFT(sm.ShopKeeperMobile, 1) IN (6,7,8,9) AND LEN(sm.ShopKeeperMobile) = 10 )
        //                 AND 
        //                 ( sm.ShopOutsideImage1 IS NOT NULL  )  
        //                 AND 
        //                 ( ISNULL(sm.ShopKeeperName,'') <> '' AND ( ISNULL(sm.ShopAddress_1,'') <> '' AND ISNULL(sm.ShopAddress_2,'') <> '' )  )  
        //                  AND 
        //                 ( ISNULL(sm.ShopName,'') <> '' AND ISNULL(sm.ShopCategory,'') <> ''  AND ISNULL(sm.BusinessCat_Cd,0) <> 0  AND ISNULL(sm.ShopArea_Cd,0) <> 0 )  
        //                 AND 
        //                 ( ISNULL(sm.ShopAddress_1,'') <> '' AND ISNULL(sm.ShopAddress_2,'') <> '' )  
        //                 --OR 
        //                 --( ISNULL(sm.MaleEmp,0) = 0 OR ISNULL(sm.FemaleEmp,0) = 0 OR ISNULL(sm.OtherEmp,0) = 0)  
        //             )
        //             AND sd.CallReason in ( 'Re-Collect Shop Documents' )
        //             AND sm.IsActive = 1
        //         ) a
        //         INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = a.AssignExec_Cd
        //         INNER JOIN LoginMaster lm on lm.Executive_Cd = a.AssignExec_Cd
        //         GROUP BY a.AssignExec_Cd,em.ExecutiveName, em.MobileNo, lm.User_Type";
        
        //         $dataAssignExeSummary = $db3->ExecutveQueryMultipleRowSALData($query4, $electionName, $developmentMode);
        //     }
                
        // }else if($shopAssignFilterType == "DocumentsDenied"){
        //     if($callingType == "Survey"){
        //         $query4 = "SELECT
        //             a.AssignExec_Cd as Executive_Cd,em.ExecutiveName,
        //             em.MobileNo, lm.User_Type,
        //             COUNT(DISTINCT(a.Pocket_Cd)) as PocketCount,
        //             COUNT(DISTINCT(a.Shop_Cd)) as ShopCount,
        //             COUNT(DISTINCT(a.ST_StatusPocket)) as PocketsCompleted,
        //             COUNT(DISTINCT(a.ST_StatusShop)) as ShopsCompleted,
        //             ISNULL(CONVERT(VARCHAR,MAX(a.ST_DateTime),121),'') as LastActiveTime
        //         FROM
        //         (
        //             SELECT st.ScheduleCall_Cd,
        //             st.Shop_Cd, st.AssignExec_Cd, 
        //             st.Calling_Category_Cd, st.ST_DateTime,
        //             CASE WHEN st.ST_Status = 1 then st.Shop_Cd ELSE NULL END as ST_StatusShop,
        //             CASE WHEN st.ST_Status = 1 then sm.Pocket_Cd ELSE NULL END as ST_StatusPocket,
        //             sm.Pocket_Cd
        //             FROM ShopTracking st, ScheduleDetails sd,
        //             ShopMaster sm, PocketMaster pm 
        //             WHERE CONVERT(VARCHAR,st.AssignDate,23) = '$assign_date'
        //             AND sd.ScheduleCall_Cd = st.ScheduleCall_Cd
        //             AND sm.Shop_Cd = st.Shop_Cd
        //             AND pm.Pocket_Cd = sm.Pocket_Cd
        //             AND st.Calling_Category_Cd in ( SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' )
        //             AND sm.IsActive = 1 
        //             AND (
        //                 sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1) 
        //             )
        //             AND sd.CallReason in ( '2nd Premise Visit' , 'Re-Collect Shop Documents' )
        //         ) a
        //         INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = a.AssignExec_Cd
        //         INNER JOIN LoginMaster lm on lm.Executive_Cd = a.AssignExec_Cd
        //         GROUP BY a.AssignExec_Cd,em.ExecutiveName, em.MobileNo, lm.User_Type";
        //         echo $query4;
        //         $dataAssignExeSummary = $db3->ExecutveQueryMultipleRowSALData($query4, $electionName, $developmentMode);
        //     }
                
        // }
    ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><?php if($shopAssignFilterType=="InvalidMobilePhoto"){ ?> Invalid ShopKeeper Name or Mobile And Shop Outside Photo - <?php }else if($shopAssignFilterType=="SurveyShopReVisitUsingQuery"){ ?> Shop Survey Re-Visit Using Query - <?php }else if($shopAssignFilterType=="NoDocument"){ ?> Survey but No Documents Collected - <?php }else if($shopAssignFilterType=="QCDocumentPending"){ ?> QC Done But Documents Pending - <?php }else if($shopAssignFilterType=="DocumentsDenied"){ ?> Documents Denied - <?php }else{ }  ?> Executive <?php echo $callingType; ?> Summary - <?php echo date('d/m/Y',strtotime($assign_date)); ?> </h5>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered complex-headers">
                                <thead>
                                    <tr>
                                    
                                        <th colspan="2" style="text-align:center;">Executive </th>
                                        <th colspan="2" style="text-align:center;">Assigned</th>
                                        <th colspan="2" style="text-align:center;">Completed</th>
                                        <th colspan="2" style="text-align:center;">Last Active</th>
                                       
                                        
                                    </tr>
                                    <tr>
                                    
                                        <th style="text-align:center;">Sr.No.</th>
                                        <th style="text-align:center;">Executive Name</th>
                                        <th style="text-align:center;">Pockets</th>
                                        <th style="text-align:center;">Shops</th>
                                        <th style="text-align:center;">Pockets</th>
                                        <th style="text-align:center;">Shops</th>
                                        <th style="text-align:center;">Datetime</th>
                                        <th style="text-align:center;">Action</th>
                                   </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $srNo=1;
                                        foreach ($dataAssignExeSummary as $key => $value) {
                                    ?>
                                        <tr>
                                            <td style="text-align:center;"><?php echo $srNo++; ?></td>
                                            <td style="text-align:center;"><?php echo $value["ExecutiveName"]; ?></br><?php echo $value["MobileNo"]; ?></td>
                                            <td style="text-align:center;"><?php echo $value["PocketCount"]; ?></td>
                                            <td style="text-align:center;"><?php echo $value["ShopCount"]; ?></td>
                                            <td style="text-align:center;"><?php echo $value["PocketsCompleted"]; ?></td>
                                            <td style="text-align:center;"><?php echo $value["ShopsCompleted"]; ?></td>
                                            <td style="text-align:center;"><?php if(!empty($value["LastActiveTime"])){ echo date('h:i a', strtotime($value["LastActiveTime"])); }  ?></td>
                                            <td style="text-align:center;">
                                                <a title="View" href="home.php?p=shops-assign-list&assignDate=<?php echo $assign_date; ?>&assignExeCd=<?php echo $value["Executive_Cd"]; ?>&action=view" ><i class="feather icon-eye" style="font-size: 1.2rem;color:#c90d41;"></i></a>&nbsp;&nbsp;&nbsp;
                                                <a title="Edit" href="home.php?p=shops-assign-list&assignDate=<?php echo $assign_date; ?>&assignExeCd=<?php echo $value["Executive_Cd"]; ?>&action=edit" ><i class="feather icon-edit" style="font-size: 1.2rem;color:#c90d41;"></i></a>&nbsp;&nbsp;&nbsp;
                                                <a title="Transfer" href="home.php?p=shops-assign-list&assignDate=<?php echo $assign_date; ?>&assignExeCd=<?php echo $value["Executive_Cd"]; ?>&action=transfer" ><i class="feather icon-log-out" style="font-size: 1.2rem;color:#c90d41;"></i></a>&nbsp;&nbsp;&nbsp;

                                            </td>
                                        </tr>
                                     <?php
                                        }
                                    ?>
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>