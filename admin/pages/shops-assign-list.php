 <style type="text/css">
     .avatar .avatar-content .avatar-icon {
        font-size: 2.2rem;
    }
    .btn{
        padding: 8px;
    }
    .table thead th{
        background-color: #ddd !important;
        color: #000;
        vertical-align: middle;
    }
    tr.group,
    tr.group:hover {
        background-color: #EDEDED !important;
    }
   
 </style>
 <section id="nav-justified">
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

        $assignDate = '';
        if(isset($_GET['assignDate'])){
            $assignDate = $_GET['assignDate'];
        }else{
            if(!isset($_SESSION['SAL_Assign_Date'])){
                $currentDate = date('Y-m-d');
                $curDate = date('Y');
                $assignDate = $currentDate;
            }else{
                $assignDate = $_SESSION['SAL_Assign_Date'];
            }
            
        }

        $multiplePockets = '';

        if(isset($_GET['pocktCd'])){
            $multiplePockets = $_GET['pocktCd'];
        }

        $tempAssignExeCd = 0;
        $assignExeCd = 0;

        if(isset($_GET['assignExeCd']) && isset($_GET['action']) && $_GET['action'] == 'transfer'){
            $tempAssignExeCd = $_GET['assignExeCd'];
            $_SESSION['SAL_Executive_Cd'] = $tempAssignExeCd;
        }else if(isset($_GET['assignExeCd']) && isset($_GET['action']) && $_GET['action'] == 'edit'){
            $assignExeCd = $_GET['assignExeCd'];
            $_SESSION['SAL_Executive_Cd'] = $assignExeCd;
            $tempAssignExeCd = $assignExeCd;
        }else if(isset($_GET['assignExeCd']) && isset($_GET['action']) && $_GET['action'] == 'view'){
            $assignExeCd = $_GET['assignExeCd'];
            $_SESSION['SAL_Executive_Cd'] = $assignExeCd;
            $tempAssignExeCd = $assignExeCd;
        }else  if(isset($_SESSION['SAL_Executive_Cd'])){
            $assignExeCd = $_SESSION['SAL_Executive_Cd'];
            $tempAssignExeCd = $assignExeCd;
        }

        $exeTransferCondition = "";
        if(isset($_GET['assignExeCd']) &&  isset($_GET['action']) && $_GET['action'] == 'transfer'){
            $exeTransferCondition = " AND lm.Executive_Cd <> $tempAssignExeCd ";
        }
        
        $shopAssingFilterTypeCondition = "";
        if($shopAssignFilterType=="New"){
            $shopAssingFilterTypeCondition = " AND ( ISNULL(sm.ShopStatus,'') = '' OR sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) ) AND sm.IsActive = 1 AND sm.SurveyDate IS NULL ";    
        }else if($shopAssignFilterType=="SurveyShopReVisitUsingQuery"){
            $shopAssingFilterTypeCondition = " --AND sm.surveyby ='AMIRODDIN_S'
                            AND sm.surveyby ='BHUSHAN_P16'
                            AND MONTH(sm.SurveyDate) = 12
                            AND sm.IsActive = 1 
                            AND ( 
                                 ISNULL(sm.ShopStatus,'') = '' OR 
                                sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                            )
                            AND sd.CallReason in ( '2nd Premise Visit' , 'Re-Collect Shop Documents' ) ";    
        }else if($shopAssignFilterType=="InvalidMobilePhoto"){
            $shopAssingFilterTypeCondition = " AND ( 
                                --ISNULL(sm.ShopStatus,'') = '' OR 
                                sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                                )
                            AND sm.SurveyDate IS NOT NULL
                            --AND ( 
                            --        (sm.ShopKeeperMobile IS NULL OR ISNULL(sm.ShopKeeperMobile,'') = '' OR LEFT(sm.ShopKeeperMobile, 1) NOT IN (6,7,8,9) OR LEN(sm.ShopKeeperMobile) != 10 )
                            --        OR 
                            --        ( sm.ShopOutsideImage1 IS NULL AND sm.ShopOutsideImage2 IS NULL ) 
                            --        OR 
                            --        ( ISNULL(sm.ShopKeeperName,'') = '' )
                            --        OR 
                            --        ( ISNULL(sm.ShopAddress_1,'') = '' OR ISNULL(sm.ShopAddress_2,'') = '' )  
                            --    )
                            --AND sd.CallReason in ( '2nd Premise Visit' , 'Re-Collect Shop Documents' )
                            AND sm.IsActive = 1 ";    
        }else if($shopAssignFilterType=="NoDocument"){
            $shopAssingFilterTypeCondition = " AND ( 
                                    ISNULL(sm.ShopStatus,'') <> 'Verified' AND sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND ApplicationStatus <> 'Verified' AND IsActive = 1) AND (SELECT COUNT(Shop_Cd) FROM ShopDocuments WHERE Shop_Cd = sm.Shop_Cd AND IsActive = 1 ) = 0  
                                )
                            AND sm.SurveyDate IS NOT NULL
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
                            AND sd.CallReason in ( 'Re-Collect Shop Documents' )
                            AND sm.IsActive = 1 ";    
        }else if($shopAssignFilterType=="QCDocumentPending"){
            $shopAssingFilterTypeCondition = " AND ( 
                                ISNULL(sm.ShopStatus,'') <> 'Verified' AND sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND ApplicationStatus <> 'Verified' AND IsActive = 1) AND (SELECT COUNT(Shop_Cd) FROM ShopDocuments WHERE Shop_Cd = sm.Shop_Cd AND IsActive = 1 ) <> 0 
                                )
                            AND sm.SurveyDate IS NOT NULL
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
                            AND sd.CallReason in ( 'Re-Collect Shop Documents' )
                            AND sm.IsActive = 1 ";    
        }else if($shopAssignFilterType=="DocumentsDenied"){
            $shopAssingFilterTypeCondition = " 
                            AND sm.IsActive = 1 
                            AND ( 
                                sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1) 
                            )
                            AND sd.CallReason in ( '2nd Premise Visit' , 'Re-Collect Shop Documents' ) ";    
        }else{
            $shopAssingFilterTypeCondition = "";
        }
       
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];
    ?>

<style>
    img.galleryimg{
        transition: 0.4s ease;
        transform-origin: 70% 70%;}

    img.galleryimg:hover{
        transform: scale(3.2);
        z-index: 9999;
    }

</style>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">
                    <h4 class="card-title">Call Assign</h4>
                </div> -->
                <div class="card-content">
                    <div class="card-body">
                    
                        <div class="row">
                            
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="assign_date">Assign Date</label>
                                    <input type='text' name="assign_date" value="<?php echo $assignDate;?>" class="form-control pickadate-disable-backdates"
                                    <?php if(isset($_GET['assignExeCd']) &&  isset($_GET['action']) && $_GET['action'] == 'transfer'){ ?>

                                    <?php }else if(isset($_GET['assignExeCd']) &&  isset($_GET['action']) && $_GET['action'] == 'edit'){ ?>
                                     
                                    <?php }else if(isset($_GET['pocktCd']) &&  isset($_GET['action']) && $_GET['action'] == 'assign'){ ?>

                                    <?php }else{   ?>
                                        onchange="setAssignDateInSession()"
                                    <?php } ?>
                                     />
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-2 col-xl-2">
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

                            <div class="col-md-2 col-12">
                                <?php include 'dropdown-calling-type.php'; ?>
                            </div>
                            <div class="col-md-3 col-12">
                                
                                 <?php 
                                    if($callingType == 'Survey'){
                                        $userTypeCondition = " lm.User_Type like '%Executive%' ";       
                                    }else if($callingType == 'Calling'){
                                        $userTypeCondition = " lm.User_Type like '%Calling%' ";       
                                    }else if($callingType == 'Collection'){
                                        $userTypeCondition = " lm.User_Type like '%Collection%' ";       
                                    }else{
                                        $userTypeCondition = " ";
                                    }
                                 
                                if(isset($_GET['assignExeCd']) &&  isset($_GET['action']) && ( $_GET['action'] == 'transfer' ||  $_GET['action'] == 'edit'  ) ){
                                    $query1 = "SELECT
                                        ISNULL(lm.Executive_Cd,0) as Executive_Cd, 
                                        ISNULL(em.ExecutiveName,'')  as ExecutiveName,
                                        ISNULL(em.MobileNo,'')  as MobileNo
                                        FROM LoginMaster lm
                                        INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = lm.Executive_Cd
                                        WHERE $userTypeCondition
                                        $exeTransferCondition
                                        GROUP BY lm.Executive_Cd, em.ExecutiveName, em.MobileNo
                                        ";
                                }else if(isset($_GET['pocktCd']) &&  isset($_GET['action']) && ( $_GET['action'] == 'assign' ) ){
                                    $query1 = "SELECT
                                        ISNULL(lm.Executive_Cd,0) as Executive_Cd, 
                                        ISNULL(em.ExecutiveName,'')  as ExecutiveName,
                                        ISNULL(em.MobileNo,'')  as MobileNo
                                        FROM LoginMaster lm
                                        INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = lm.Executive_Cd
                                        WHERE $userTypeCondition
                                        GROUP BY lm.Executive_Cd, em.ExecutiveName, em.MobileNo
                                        ";
                                }else{
                                    $query1 = "SELECT
                                        ISNULL(lm.Executive_Cd,0) as Executive_Cd, 
                                        ISNULL(em.ExecutiveName,'')  as ExecutiveName,
                                        ISNULL(em.MobileNo,'')  as MobileNo
                                        FROM LoginMaster lm
                                        INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = lm.Executive_Cd
                                        INNER JOIN ShopTracking st on (st.AssignExec_Cd = lm.Executive_Cd AND st.AssignDate = '$assignDate')
                                        WHERE $userTypeCondition
                                        GROUP BY lm.Executive_Cd, em.ExecutiveName, em.MobileNo
                                        ";
                                }
                                        // echo $query1;
                                            $db1=new DbOperation();
                                            $userName=$_SESSION['SAL_UserName'];
                                            $appName=$_SESSION['SAL_AppName'];
                                            $electionName=$_SESSION['SAL_ElectionName'];
                                            $developmentMode=$_SESSION['SAL_DevelopmentMode'];
                                            $dataSurveyAssignExecutives = $db1->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);
                            ?>
                                <div class="form-group">
                                    <label for="survey_executive_name"><?php  if(isset($_GET['action']) && $_GET['action'] == 'transfer'){  ?>  Transfer    <?php }   ?>    <?php echo $callingType; ?> Executive Name</label>
                                    <select class="select2 form-control" name="executiveCd" 
                                    <?php if(isset($_GET['assignExeCd']) && isset($_GET['action']) && $_GET['action'] == 'transfer'){ ?>

                                    <?php }else if(isset($_GET['pocktCd']) && isset($_GET['action']) && $_GET['action'] == 'assign'){ ?>

                                    <?php }else if(isset($_GET['assignExeCd']) && isset($_GET['action']) && $_GET['action'] == 'edit'){ ?>
                                            disabled
                                    <?php }else{ ?>       
                                            onchange="setExecutiveNameInSession()" 
                                    <?php } ?>
                                       

                                     >
                                        <option value="">--Select--</option>
                                       <?php 

                                        if(!isset($_SESSION['SAL_Executive_Cd']) && !isset($_GET['action'])){
                                            if(sizeof($dataSurveyAssignExecutives)>0){
                                            $_SESSION['SAL_Executive_Cd'] = $dataSurveyAssignExecutives[0]["Executive_Cd"];
                                               $tempAssignExeCd = $_SESSION['SAL_Executive_Cd'];
                                            }
                                        }else if(!isset($_SESSION['SAL_Executive_Cd']) && !isset($_GET['assignExeCd']) && isset($_GET['action']) && $_GET['action'] == 'view'){
                                            if(sizeof($dataSurveyAssignExecutives)>0){
                                            $_SESSION['SAL_Executive_Cd'] = $dataSurveyAssignExecutives[0]["Executive_Cd"];
                                               $tempAssignExeCd = $_SESSION['SAL_Executive_Cd'];
                                            }
                                        }else if(isset($_SESSION['SAL_Executive_Cd']) ){
                                            $assignExeCd = $_SESSION['SAL_Executive_Cd'];
                                            $tempAssignExeCd = $_SESSION['SAL_Executive_Cd'];
                                        }


                                            foreach ($dataSurveyAssignExecutives as $key => $value) {
                                                $selectedExe="";
                                                 if(isset($_GET['action']) && $_GET['action'] == 'transfer'){

                                                 }else{
                                                    if(isset($_SESSION['SAL_Executive_Cd'])){
                                                        if($value["Executive_Cd"] == $_SESSION['SAL_Executive_Cd']){
                                                            $selectedExe = "selected";
                                                        }
                                                    }
                                                 }
                                        ?>
                                                 <option <?php echo $selectedExe; ?> value="<?php echo $value["Executive_Cd"]; ?>"><?php echo $value["ExecutiveName"]; ?></option>   
                                        <?php
                                            }
                                       ?>
                                    </select>
                                </div>
                            </div>
                            <?php  if(isset($_GET['action']) && ( $_GET['action'] == 'transfer' || $_GET['action'] == 'edit'  || $_GET['action'] == 'assign') ) {  ?>

                                <input type="hidden" class="form-control" name="pocketsCount" value="" disabled>
                                <input type="hidden" class="form-control" name="shopsCount" value="" disabled>
                                <div class="col-md-1 col-12">
                                    <div class="form-group">
                                        <label for="shops"><?php if(isset($_GET['action']) && $_GET['action'] == 'transfer'){  ?>  Transfer    <?php }   ?>  Shops</label>
                                        <input type="text" class="form-control" name="shopsAssignCount" value="" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" required>
                                    </div>
                                </div>
                            
                            <?php  if(isset($_GET['action']) && ( $_GET['action'] == 'transfer' || $_GET['action'] == 'edit' ) ) {  ?>
                                <div class="col-md-1 col-12 text-right" style="margin-top: 25px;">
                                     <div class="form-group">
                                        <label for="refesh"></label>
                                        <button type="button" name="refesh" class="btn btn-primary" id="submitTransferAssignShopsBtnId" onclick="submitTransferOrEditAssignedShopsData()" ><?php  if(isset($_GET['action']) && $_GET['action'] == 'transfer'){  ?>  Transfer <?php }else if(isset($_GET['action']) && $_GET['action'] == 'edit'){  ?>  Edit  <?php }   ?> </button>
                                    </div>
                                </div>
                            <?php }else if(isset($_GET['action']) && ( $_GET['action'] == 'assign' ) ) {  ?>
                                <div class="col-md-1 col-12 text-right"  style="margin-top: 25px;">
                                     <div class="form-group">
                                        <label for="refesh"></label>
                                        <button type="button" name="refesh" class="btn btn-primary" id="submitAssignShopsSchedulesBtnId" onclick="submitAssignShopsToExecutiveByPocketsAndSchedules()" ><?php  if(isset($_GET['action']) && $_GET['action'] == 'assign'){  ?>  Assign  <?php }  ?> </button>
                                    </div>
                                </div>
                            <?php } ?> 

                                <div class="col-md-12 col-12" >
                                    <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <?php  if(isset($_GET['action']) && ( $_GET['action'] == 'transfer' || $_GET['action'] == 'edit' ) ){  ?>
                                        <input type="hidden" class="form-control" name="action" value="<?php echo $_GET['action'];  ?>" >
                                        <input type="hidden" class="form-control" name="multipleShopTrackings" >
                                    <?php }else if(isset($_GET['action']) && ( $_GET['action'] == 'assign' ) ){  ?>
                                        <input type="hidden" class="form-control" name="action" value="<?php echo $_GET['action'];  ?>" >
                                        <input type="hidden" class="form-control" name="multipleShopSchedules" >
                                    <?php }  ?>
                                    <input type="hidden" class="form-control" name="multiplePockets" value="<?php echo $multiplePockets; ?>">
                                    <input type="hidden" class="form-control" name="tempExecutive_Cd" value="<?php echo $tempAssignExeCd; ?>" >
                                    <div id="submitmsgsuccess" class="controls alert alert-success" role="alert" style="display: none;"></div>
                                    <div id="submitmsgfailed"  class="controls alert alert-danger" role="alert" style="display: none;"></div>
                                </div>

                            <?php } ?>
                            

                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
    
$db3=new DbOperation();
$dataShopsAssignList=array();
$dataAssignShopsCount=array();

// if(!empty($shopAssingFilterTypeCondition)){
    if(isset($_GET['action']) && ( $_GET['action'] == 'view' ) ){
        $dataShopsAssignList = array();
                $query3 = "SELECT 
                ISNULL(sd.ScheduleCall_Cd,0) as ScheduleCall_Cd, 
                ISNULL(CONVERT(VARCHAR,sd.CallingDate,105),'') as ScheduleDate,
                ISNULL(sd.CallReason,'') as ScheduleReason,
                ISNULL(sd.Remark,'') as ScheduleRemark,
                ISNULL(st.ST_Cd,0) as ST_Cd, 
                ISNULL(st.ScheduleCall_Cd,0) as ScheduleCall_Cd,
                ISNULL(st.Shop_Cd,0) as Shop_Cd, 
                ISNULL(sm.ShopName,'') as ShopName,
				ISNULL(sm.ShopStatus,'') as ShopStatus,
                ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1,
                ISNULL(sm.Shop_UID,'') as Shop_UID,
                ISNULL(sm.Pocket_Cd,0) as Pocket_Cd, 
                ISNULL(pm.PocketName,'') as PocketName, 
                ISNULL(nm.NodeName,'') as NodeName, 
                ISNULL(nm.Ward_No,'') as Ward_No,
                ISNULL(nm.Area,'') as WardArea,
                ISNULL(st.AssignExec_Cd,0) as AssignExec_Cd, 
                ISNULL(st.Calling_Category_Cd,0) as Calling_Category_Cd, 
                ISNULL(ccm.Calling_Category,'') as Calling_Category,
                ISNULL(ccm.Calling_Type,'') as Calling_Type,

                ISNULL(CONVERT(VARCHAR,st.ST_DateTime,121),'') as ST_DateTime,
                ISNULL(st.ST_Status,0) as ST_Status, 
                ISNULL(st.ST_Exec_Cd,0) as ST_Exec_Cd,
                ISNULL(st.ST_StageName,'') as ST_StageName,
                ISNULL(CONVERT(VARCHAR,st.AssignDate,23),'') as AssignDate,
                ISNULL(st.ST_Remark_1,'') as ST_Remark_1, 
                ISNULL(st.ST_Remark_2,'') as ST_Remark_2, 
                ISNULL(st.ST_Remark_3,'') as ST_Remark_3
            FROM ShopTracking st, ScheduleDetails sd,
            CallingCategoryMaster ccm,
            ShopMaster sm, PocketMaster pm,
            NodeMaster nm
            WHERE CONVERT(VARCHAR,st.AssignDate,23)  = '$assignDate'
            AND sd.ScheduleCall_Cd = st.ScheduleCall_Cd
            AND sm.Shop_Cd = st.Shop_Cd
            AND ccm.Calling_Category_Cd = st.Calling_Category_Cd
            AND pm.Pocket_Cd = sm.Pocket_Cd
            AND nm.Node_Cd = pm.Node_Cd
            AND st.AssignExec_Cd = $tempAssignExeCd
            AND st.Calling_Category_Cd in (
                SELECT Calling_Category_Cd 
                FROM CallingCategoryMaster WHERE Calling_Type = '$callingType'
            )
            
            ORDER BY st.Shop_Cd";   
                // echo $query3;
        $dataShopsAssignList = $db3->ExecutveQueryMultipleRowSALData($query3, $electionName, $developmentMode);

        $queryCount = "SELECT SUM(t.ShopCount) as ShopCount
                FROM (
                    SELECT
                        ISNULL(COUNT(DISTINCT(st.Shop_Cd)),0) as ShopCount
                    FROM ShopTracking st, ScheduleDetails sd,
                    CallingCategoryMaster ccm,
                    ShopMaster sm, PocketMaster pm,
                    NodeMaster nm
                    WHERE CONVERT(VARCHAR,st.AssignDate,23)  = '$assignDate'
                    AND sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                    AND sm.Shop_Cd = st.Shop_Cd
                    AND ccm.Calling_Category_Cd = st.Calling_Category_Cd
                    AND pm.Pocket_Cd = sm.Pocket_Cd
                    AND nm.Node_Cd = pm.Node_Cd
                    AND st.AssignExec_Cd = $tempAssignExeCd
                    AND st.Calling_Category_Cd in (
                        SELECT Calling_Category_Cd 
                        FROM CallingCategoryMaster WHERE Calling_Type = '$callingType'
                    )
                    GROUP BY st.Shop_Cd
                ) as t ";
            // echo $queryCount;
        $dataAssignShopsCount = $db3->ExecutveQuerySingleRowSALData($queryCount, $electionName, $developmentMode);
        // print_r($dataAssignShopsCount);
    }else if(isset($_GET['action']) && ( $_GET['action'] == 'transfer' || $_GET['action'] == 'edit' ) ){
        $dataShopsAssignList = array();
            $query3 = "SELECT 
                ISNULL(sd.ScheduleCall_Cd,0) as ScheduleCall_Cd, 
                ISNULL(CONVERT(VARCHAR,sd.CallingDate,105),'') as ScheduleDate,
                ISNULL(sd.CallReason,'') as ScheduleReason,
                ISNULL(sd.Remark,'') as ScheduleRemark,
                ISNULL(st.ST_Cd,0) as ST_Cd, 
                ISNULL(st.ScheduleCall_Cd,0) as ScheduleCall_Cd,
                ISNULL(st.Shop_Cd,0) as Shop_Cd, 
                ISNULL(sm.ShopName,'') as ShopName,
				ISNULL(sm.ShopStatus,'') as ShopStatus,
                ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1,
                ISNULL(sm.Shop_UID,'') as Shop_UID,
                ISNULL(sm.Pocket_Cd,0) as Pocket_Cd, 
                ISNULL(pm.PocketName,'') as PocketName, 
                ISNULL(nm.NodeName,'') as NodeName, 
                ISNULL(nm.Ward_No,'') as Ward_No,
                ISNULL(nm.Area,'') as WardArea,
                ISNULL(st.AssignExec_Cd,0) as AssignExec_Cd, 
                ISNULL(st.Calling_Category_Cd,0) as Calling_Category_Cd, 
                ISNULL(ccm.Calling_Category,'') as Calling_Category,
                ISNULL(ccm.Calling_Type,'') as Calling_Type,

                ISNULL(CONVERT(VARCHAR,st.ST_DateTime,121),'') as ST_DateTime,
                ISNULL(st.ST_Status,0) as ST_Status, 
                ISNULL(st.ST_Exec_Cd,0) as ST_Exec_Cd,
                ISNULL(st.ST_StageName,'') as ST_StageName,
                ISNULL(CONVERT(VARCHAR,st.AssignDate,23),'') as AssignDate,
                ISNULL(st.ST_Remark_1,'') as ST_Remark_1, 
                ISNULL(st.ST_Remark_2,'') as ST_Remark_2, 
                ISNULL(st.ST_Remark_3,'') as ST_Remark_3
            FROM ShopTracking st, ScheduleDetails sd,
            CallingCategoryMaster ccm,
            ShopMaster sm, PocketMaster pm,
            NodeMaster nm
            WHERE CONVERT(VARCHAR,st.AssignDate,23)  = '$assignDate'
            AND sd.ScheduleCall_Cd = st.ScheduleCall_Cd
            AND sm.Shop_Cd = st.Shop_Cd
            AND ccm.Calling_Category_Cd = st.Calling_Category_Cd
            AND pm.Pocket_Cd = sm.Pocket_Cd
            AND nm.Node_Cd = pm.Node_Cd
            AND st.AssignExec_Cd = $tempAssignExeCd
            AND st.Calling_Category_Cd in (
                SELECT Calling_Category_Cd 
                FROM CallingCategoryMaster WHERE Calling_Type = '$callingType'
            )
            AND st.ST_Status = 0
            ORDER BY st.Shop_Cd";   
                // echo $query3;
        $dataShopsAssignList = $db3->ExecutveQueryMultipleRowSALData($query3, $electionName, $developmentMode);

        $queryCount = "SELECT SUM(t.ShopCount) as ShopCount
                FROM (
                    SELECT
                        ISNULL(COUNT(DISTINCT(st.Shop_Cd)),0) as ShopCount
                    FROM ShopTracking st, ScheduleDetails sd,
                    CallingCategoryMaster ccm,
                    ShopMaster sm, PocketMaster pm,
                    NodeMaster nm
                    WHERE CONVERT(VARCHAR,st.AssignDate,23)  = '$assignDate'
                    AND sd.ScheduleCall_Cd = st.ScheduleCall_Cd
                    AND sm.Shop_Cd = st.Shop_Cd
                    AND ccm.Calling_Category_Cd = st.Calling_Category_Cd
                    AND pm.Pocket_Cd = sm.Pocket_Cd
                    AND nm.Node_Cd = pm.Node_Cd
                    AND st.AssignExec_Cd = $tempAssignExeCd
                    AND st.Calling_Category_Cd in (
                        SELECT Calling_Category_Cd 
                        FROM CallingCategoryMaster WHERE Calling_Type = '$callingType'
                    )
                    AND st.ST_Status = 0
                    GROUP BY st.Shop_Cd
                ) as t "; 
            // echo $queryCount;
        $dataAssignShopsCount = $db3->ExecutveQuerySingleRowSALData($queryCount, $electionName, $developmentMode);
        // print_r($dataAssignShopsCount);
    }else if(isset($_GET['pocktCd']) && isset($_GET['action']) && ( $_GET['action'] == 'assign' ) ){
        $query3 = "SELECT
                        ISNULL(sd.ScheduleCall_Cd,0) as ScheduleCall_Cd,
                        ISNULL(CONVERT(VARCHAR,sd.CallingDate,105),'') as ScheduleDate,
                        ISNULL(sd.CallReason,'') as ScheduleReason,
                        ISNULL(sd.Remark,'') as ScheduleRemark, 
                        ISNULL(sd.Shop_Cd,0) as Shop_Cd, 
                        ISNULL(sd.Calling_Category_Cd,0) as Calling_Category_Cd,
                        ISNULL(sm.ShopName,'') as ShopName,
						ISNULL(sm.ShopStatus,'') as ShopStatus,
                        ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1,
                        ISNULL(sm.Shop_UID,'') as Shop_UID,
                        ISNULL(sm.Pocket_Cd,0) as Pocket_Cd, 
                        ISNULL(pm.PocketName,'') as PocketName, 
                        ISNULL(nm.NodeName,'') as NodeName, 
                        ISNULL(nm.Ward_No,'') as Ward_No,
                        ISNULL(nm.Area,'') as WardArea,
                        ISNULL(ccm.Calling_Category,'') as Calling_Category,
                        ISNULL(ccm.Calling_Type,'') as Calling_Type
                    FROM ScheduleDetails sd
                    INNER JOIN ShopMaster sm on (
                            sm.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assignDate' 
                            AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                FROM CallingCategoryMaster WHERE Calling_Type = '$callingType')
                        )
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                    INNER JOIN CallingCategoryMaster ccm on ccm.Calling_Category_Cd = sd.Calling_Category_Cd
                    LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                    WHERE st.ScheduleCall_Cd IS NULL
                    AND sm.Pocket_Cd in ($multiplePockets)
                    ORDER BY sd.Shop_Cd ";
            // echo $query3;
        $dataShopsAssignList = $db3->ExecutveQueryMultipleRowSALData($query3, $electionName, $developmentMode);

        $queryCount = "SELECT SUM(t.ShopCount) as ShopCount
                FROM (
                    SELECT
                        ISNULL(COUNT(DISTINCT(sd.Shop_Cd)),0) as ShopCount
                    FROM ScheduleDetails sd
                    INNER JOIN ShopMaster sm on (
                            sm.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assignDate' 
                            AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                FROM CallingCategoryMaster WHERE Calling_Type = '$callingType')
                        )
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                    INNER JOIN CallingCategoryMaster ccm on ccm.Calling_Category_Cd = sd.Calling_Category_Cd
                    LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                    WHERE st.ScheduleCall_Cd IS NULL
                    AND sm.Pocket_Cd in ($multiplePockets)
                    GROUP BY sd.Shop_Cd 
                ) as t";
            // echo $queryCount;
        $dataAssignShopsCount = $db3->ExecutveQuerySingleRowSALData($queryCount, $electionName, $developmentMode);
         // print_r($dataAssignShopsCount);
    }    
// }           
?>


<?php
if(sizeof($dataShopsAssignList)>0){
?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>
                        <?php echo $callingType; ?> <?php if(isset($_GET['action']) && ( $_GET['action'] != 'assign' ) ){ ?> Assigned List 

                            <?php
                                $tempAssignExeName = '';
                                if($tempAssignExeCd != 0 ){
                                    $querytempAssignExe = "SELECT
                                            ISNULL(lm.Executive_Cd,0) as Executive_Cd, 
                                            ISNULL(em.ExecutiveName,'')  as ExecutiveName,
                                            ISNULL(em.MobileNo,'')  as MobileNo
                                        FROM LoginMaster lm
                                        INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = lm.Executive_Cd
                                        WHERE $userTypeCondition
                                        AND lm.Executive_Cd = $tempAssignExeCd
                                        GROUP BY lm.Executive_Cd, em.ExecutiveName, em.MobileNo
                                        ";
                                    $dataTempAssignExe = $db3->ExecutveQueryMultipleRowSALData($querytempAssignExe, $electionName, $developmentMode);                            
                                    foreach ($dataTempAssignExe as $key => $value) {
                                        $tempAssignExeName = $value["ExecutiveName"]." ".$value["MobileNo"];
                                    }
                                    echo " - ".$tempAssignExeName;
                                }
                                    
                            ?> 

                        <?php }else{ ?> Assigning :: Shops List <?php } ?>
                           
                        <?php 
                            if(sizeof($dataAssignShopsCount)>0){
                                echo " ( ".$dataAssignShopsCount["ShopCount"]." ) "; 
                            }else{
                                echo " ( 0 ) ";
                            }
                        ?>
                    </h5>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table id="assignShopList" class="table">
                                <thead>
                                    <tr>
                                        <?php  if(isset($_GET['action']) && ( $_GET['action'] == 'transfer' || $_GET['action'] == 'edit' ) ){  ?>
                                            <th >
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox"  name="assignAllShopTrackings[]" onclick="setAllShopAssignTrackings(this)"   >
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                </div>
                                           
                                            </th>
                                        <?php }else{  ?>  
                                            <th>Sr No</th>
                                        <?php  }  ?>  
                                        <th>Shop Detail</th>
                                        <th>Ward Area</th>
                                        <th>Schedule Detail</th>
										<th>Shop Status</th>
                                    <?php if(isset($_GET['action']) && ( $_GET['action'] != 'assign' ) ){ ?>
                                        <th>Schedule Status</th>
                                        <th>Stages</th>
                                        <th>Remark</th>
                                        <?php 
                                            if($callingType == 'Calling'){
                                        ?>
                                            <th>Action</th>
                                        <?php
                                            }
                                        ?>
                                    <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $srNo = 1;
                                        foreach ($dataShopsAssignList as $key => $value) {
                                    ?>
                                        <tr>
                                            <?php  if(isset($_GET['action']) && ( $_GET['action'] == 'transfer' || $_GET['action'] == 'edit' ) ){  ?>
                                                <td> 
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" value="<?php echo $value["ST_Cd"]; ?>,<?php echo $value["ST_Status"]; ?>" name="assignShopTrackings" onclick="setSelectMultipleAssignShopTrackings()"  <?php if($value["ST_Status"]==1){ ?>  disabled  <?php } ?>   >
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </td>
                                            <?php }else if(isset($_GET['action']) && ( $_GET['action'] == 'assign'  ) ){  ?>
                                                <td> 
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" value="<?php echo $value["ScheduleCall_Cd"]; ?>,<?php echo $value["Shop_Cd"]; ?>" name="assignShopSchedules" onclick="setSelectMultipleAssignShopSchedules()"  >
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </td>
                                            <?php }else{   ?> 
                                                <td><?php echo $srNo++; ?></td>
                                            <?php }  ?>
                                            <td>
                                                <div class="employee-task d-flex justify-content-between align-items-top">
                                                   <div class="media">
                                                       <!-- <div class="avatar mr-75">
                                                            <?php //if($value["ShopOutsideImage1"] != '') { ?>
                                                                <img src="<?php //echo $value["ShopOutsideImage1"]; ?>" class="rounded galleryimg" width="90" height="90" alt="Avatar" />
                                                            <?php //}  else { ?>   
                                                                <img src="pics/shopDefault.jpeg" class="rounded galleryimg" width="90" height="90" alt="Avatar" />
                                                            <?php //} ?>
                                                        </div> -->
                                                   <div class="media-body my-10px">
                                                        <h5><?php echo $value["ShopName"]; ?></h5>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <!-- <?php echo "  Pocket : ".$value["PocketName"]; ?> -->
                                                <?php echo " ".$value["Ward_No"]. " - ".$value["WardArea"]; ?>
                                                <!-- <?php echo " Zone : ".$value["NodeName"]; ?></span> -->
                                            </td>
                                            <td>
                                                <!-- <h6><?php echo "Scheduled on ".$value["ScheduleDate"]; ?></h6> -->
                                                <b><?php echo $value["Calling_Category"]; ?></b>
                                                <?php echo " : ".$value["ScheduleReason"]; ?>
                                                <br>
                                                <span style="font-size: 12px;"><?php echo $value["ScheduleRemark"]; ?></span>
                                                
                                            </td>
                                            <td>
												<?php 
                                                    if($value["ShopStatus"]=='Verified'){
                                                ?>
                                                    <span class="badge badge-success"><?php echo $value["ShopStatus"]; ?></span>
                                                <?php
                                                    }else{
                                                ?>
                                                    <span class="badge badge-danger"><?php echo $value["ShopStatus"]; ?></span>
                                                <?php
                                                    }
                                                ?>
											</td>
                                        <?php if(isset($_GET['action']) && ( $_GET['action'] != 'assign' ) ){ ?>
                                            <td>
                                                <?php 
                                                    if($value["ST_Status"]==1){
                                                ?>
                                                    <span class="badge badge-success">Completed</span>
                                                <?php
                                                    }else{
                                                ?>
                                                    <span class="badge badge-danger">Not Completed</span>
                                                <?php
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo $value["ST_StageName"]; ?></td>
                                            <td>
                                                <?php echo $value["ST_Remark_1"]; ?> 
                                                <br>
                                                <?php echo $value["ST_Remark_2"]; ?>
                                                <br>
                                                <?php echo $value["ST_Remark_3"]; ?>
                                            </td>
                                            <?php 
                                                if($callingType == 'Calling'){
                                                    if($value["ST_Status"]==1){
                                            ?>
                                               <td> <button class="btn btn-danger" onclick="setShowShopCallingDetail(<?php echo $value["ScheduleCall_Cd"]; ?>, <?php echo $value["Shop_Cd"]; ?>, <?php echo $value["AssignExec_Cd"]; ?>)" >QC</button> </td>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        <?php } ?>
                                        
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
   
<?php
}
?>

    <div id="qcShopCallingDetailId">

    </div>