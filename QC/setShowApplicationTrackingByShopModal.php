<?php
if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['shopid']) && !empty($_GET['shopid']) ){
    
    session_start();
    include '../api/includes/DbOperation.php';

    try  
        {  
            
        $ScheduleCall_Cd = $_GET['schedulecallid'];
        $Shop_Cd = $_GET['shopid'];
        $srNo = $_GET['srNo'];

        $db=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];


        $loginExecutiveCd = 0;
        $userId = $_SESSION['SAL_UserId'];
        if($userId != 0){
            $exeData = $db->ExecutveQuerySingleRowSALData("SELECT Executive_Cd FROM LoginMaster WHERE User_Cd = $userId ", $electionName, $developmentMode);
            if(sizeof($exeData)>0){
                $loginExecutiveCd = $exeData["Executive_Cd"];
            }
        }

        $getShopName = '';
        $getShopNameMar = '';
        $getShopArea_Cd = '';
        $getShopAreaName = '';
        $getShopCategory = '';

        $getPocketName = '';
        $getNodeName = '';
        $getWardNo = '';
        $getWardArea = '';

        $getShopAddress_1 = '';
        $getShopAddress_2 = '';

        $getAddedDate = '';
        $getSurveyDate = '';

        $getQC_Flag = '';
        $getQC_UpdatedDate = '';

        $getShopKeeperName = '';
        $getShopKeeperMobile = '';

        $getShopOutsideImage1 = '';
        $getShopOutsideImage2 = '';
        $getShopInsideImage1 = '';
        $getShopInsideImage2 = '';


        $getShopStatus = '';
        $getShopStatusTextColor = '';
        $getShopStatusFaIcon = '';
        $getShopStatusIconUrl = '';
        $getShopStatusDate = '';
        $getShopStatusRemark = '';

        $getBusinessCat_Cd = '';
        $getNature_of_Business = '';

        $getCalling_Category = '';
         
        
        $surveyInfoQuery = "SELECT 
              COALESCE(sd.ScheduleCall_Cd, 0) as ScheduleCall_Cd, 
              COALESCE(sd.Shop_Cd, 0) as Shop_Cd, 
              COALESCE(sm.ShopName, '') as ShopName, 
              COALESCE(sm.ShopNameMar, '') as ShopNameMar, 

              COALESCE(sam.ShopArea_Cd, 0) as ShopArea_Cd, 
              COALESCE(sam.ShopAreaName, '') as ShopAreaName, 
              COALESCE(sam.ShopAreaNameMar, '') as ShopAreaNameMar,
              COALESCE(sm.ShopCategory, '') as ShopCategory, 

              ISNULL(pm.PocketName,'') as PocketName,
              ISNULL(nm.NodeName,'') as NodeName,
              ISNULL(nm.Ward_No,0) as Ward_No,
              ISNULL(nm.Area,'') as WardArea,

              COALESCE(sm.ShopAddress_1, '') as ShopAddress_1, 
              COALESCE(sm.ShopAddress_2, '') as ShopAddress_2, 
              
              COALESCE(sm.ShopKeeperName, '') as ShopKeeperName, 
              COALESCE(sm.ShopKeeperMobile, '') as ShopKeeperMobile,

              COALESCE(CONVERT(VARCHAR, sm.AddedDate, 100), '') as AddedDate, 
              COALESCE(CONVERT(VARCHAR, sm.SurveyDate, 100), '') as SurveyDate, 

              COALESCE(sm.QC_Flag, 0) as QC_Flag,
              COALESCE(CONVERT(VARCHAR, sm.QC_UpdatedDate, 100), '') as QC_UpdatedDate, 

              COALESCE(sm.LetterGiven, '') as LetterGiven, 
              COALESCE(sm.IsCertificateIssued, 0) as IsCertificateIssued, 
              COALESCE(CONVERT(VARCHAR, sm.RenewalDate, 105), '') as RenewalDate, 
              COALESCE(sm.ParwanaDetCd, 0) as ParwanaDetCd, 
              
              COALESCE(ccm.Calling_Category,'') as Calling_Category,
              
              COALESCE(sm.ConsumerNumber, '') as ConsumerNumber, 

              COALESCE(sm.ShopOwnStatus, '') as ShopOwnStatus, 
              COALESCE(sm.ShopOwnPeriod, 0) as ShopOwnPeriod, 
              COALESCE(sm.ShopOwnerName, '') as ShopOwnerName, 
              COALESCE(sm.ShopOwnerMobile, '') as ShopOwnerMobile, 
              COALESCE(sm.ShopContactNo_1, '') as ShopContactNo_1, 
              COALESCE(sm.ShopContactNo_2, '') as ShopContactNo_2,
              COALESCE(sm.ShopEmailAddress, '') as ShopEmailAddress, 
              COALESCE(sm.ShopOwnerAddress, '') as ShopOwnerAddress,

              COALESCE(sm.MaleEmp, '') as MaleEmp,
              COALESCE(sm.FemaleEmp, '') as FemaleEmp,
              COALESCE(sm.OtherEmp, '') as OtherEmp,
              COALESCE(sm.ContactNo3, '') as ContactNo3,
              COALESCE(sm.GSTNno, '') as GSTNno,


              COALESCE(sm.ShopOutsideImage1, '') as ShopOutsideImage1, 
              COALESCE(sm.ShopOutsideImage2, '') as ShopOutsideImage2, 
              COALESCE(sm.ShopInsideImage1,'') as ShopInsideImage1, 
              COALESCE(sm.ShopInsideImage2,'') as ShopInsideImage2,

              COALESCE(sm.ShopDimension, '') as ShopDimension, 

              COALESCE(sm.ShopStatus, '') as ShopStatus, 
              COALESCE(stm.TextColor, '') as ShopStatusTextColor, 
              COALESCE(stm.FaIcon, '') as ShopStatusFaIcon, 
              COALESCE(stm.IconUrl, '') as ShopStatusIconUrl, 
              COALESCE(CONVERT(VARCHAR, sm.ShopStatusDate, 100), '') as ShopStatusDate, 
              COALESCE(sm.ShopStatusRemark, '') as ShopStatusRemark,  

              COALESCE(bcm.BusinessCat_Cd, 0) as BusinessCat_Cd, 
              COALESCE(bcm.BusinessCatName, '') as BusinessCatName, 
              COALESCE(bcm.BusinessCatNameMar, '') as BusinessCatNameMar

              FROM ScheduleDetails sd
              INNER JOIN ShopMaster AS sm ON (sd.Shop_Cd=sm.Shop_Cd)
              LEFT JOIN StatusMaster AS stm ON (stm.ApplicationStatus=sm.ShopStatus)
              INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
              INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
              INNER JOIN CallingCategoryMaster ccm on ccm.Calling_Category_Cd = sd.Calling_Category_Cd
              LEFT JOIN BusinessCategoryMaster AS bcm ON (sm.BusinessCat_Cd = bcm.BusinessCat_Cd) 
              LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd) 
              WHERE sd.ScheduleCall_Cd = $ScheduleCall_Cd AND sd.Shop_Cd = $Shop_Cd AND sm.IsActive = 1;";

              // echo $surveyInfoQuery;
            $ShopListCallingDataEdit = $db->ExecutveQuerySingleRowSALData($surveyInfoQuery, $electionName, $developmentMode);

            if(sizeof($ShopListCallingDataEdit)>0){
                $Shop_Cd = $ShopListCallingDataEdit["Shop_Cd"];
                $ScheduleCall_Cd = $ShopListCallingDataEdit["ScheduleCall_Cd"];
                $getShopName = $ShopListCallingDataEdit["ShopName"];
                $getShopNameMar = $ShopListCallingDataEdit["ShopNameMar"];

                $getShopArea_Cd = $ShopListCallingDataEdit["ShopArea_Cd"];
                $getShopAreaName = $ShopListCallingDataEdit["ShopAreaName"];
                $getShopCategory = $ShopListCallingDataEdit["ShopCategory"];

                $getPocketName = $ShopListCallingDataEdit["PocketName"];
                $getNodeName = $ShopListCallingDataEdit["NodeName"];
                $getWardNo = $ShopListCallingDataEdit["Ward_No"];
                $getWardArea = $ShopListCallingDataEdit["WardArea"];

                $getShopAddress_1 = $ShopListCallingDataEdit["ShopAddress_1"];
                $getShopAddress_2 = $ShopListCallingDataEdit["ShopAddress_2"];

                $getShopKeeperName = $ShopListCallingDataEdit["ShopKeeperName"];
                $getShopKeeperMobile = $ShopListCallingDataEdit["ShopKeeperMobile"];


                $getAddedDate = $ShopListCallingDataEdit["AddedDate"];
                $getSurveyDate = $ShopListCallingDataEdit["SurveyDate"];

                $getShopOutsideImage1 = $ShopListCallingDataEdit["ShopOutsideImage1"];
                $getShopOutsideImage2 = $ShopListCallingDataEdit["ShopOutsideImage2"];
                $getShopInsideImage1 = $ShopListCallingDataEdit["ShopInsideImage1"];
                $getShopInsideImage2 = $ShopListCallingDataEdit["ShopInsideImage2"];              

                $getShopStatus = $ShopListCallingDataEdit["ShopStatus"];
                $getShopStatusTextColor = $ShopListCallingDataEdit["ShopStatusTextColor"];
                $getShopStatusFaIcon = $ShopListCallingDataEdit["ShopStatusFaIcon"];
                $getShopStatusIconUrl = $ShopListCallingDataEdit["ShopStatusIconUrl"];
                $getShopStatusDate = $ShopListCallingDataEdit["ShopStatusDate"];
                $getShopStatusRemark = $ShopListCallingDataEdit["ShopStatusRemark"];


                $getBusinessCat_Cd = $ShopListCallingDataEdit["BusinessCat_Cd"];
                $getNature_of_Business = $ShopListCallingDataEdit["BusinessCatName"];

                $getCalling_Category = $ShopListCallingDataEdit["Calling_Category"];
            }

            
            $query14 = "SELECT Type_SrNo, Calling_Type
                FROM CallingCategoryMaster 
                WHERE IsActive = 1
                GROUP BY Type_SrNo, Calling_Type";

            $CallingTypeDropDown = $db->ExecutveQueryMultipleRowSALData($query14, $electionName, $developmentMode);

            $query15 = "SELECT ISNULL(st.ScheduleCall_Cd,0) as ST_ScheduleCall_Cd, sd.ScheduleCall_Cd, sd.Shop_Cd, sd.Calling_Category_Cd, sd.Executive_Cd, CONVERT(VARCHAR,sd.CallingDate,100) as CallingDate, sd.CallReason, ISNULL(sd.Remark, '') as Remark, ccm.Calling_Category, ccm.Calling_Type, em.ExecutiveName
                FROM ScheduleDetails sd 
                INNER JOIN ShopMaster sm on sm.Shop_Cd=sd.Shop_Cd 
                INNER JOIN CallingCategoryMaster ccm on ccm.Calling_Category_Cd=sd.Calling_Category_Cd 
                INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd=sd.Executive_Cd 
                LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                WHERE sd.IsActive = 1 AND sm.IsActive = 1 AND sd.Shop_Cd = $Shop_Cd ORDER BY sd.CallingDate;";

            $shopScheduleDetailsData = $db->ExecutveQueryMultipleRowSALData($query15, $electionName, $developmentMode);
                       
            $ST_Date = "";
            $queryST = "SELECT CONVERT(VARCHAR,ST_DateTime,23) as ST_Date from ShopTracking Where ScheduleCall_Cd = $ScheduleCall_Cd AND ST_Status = 1";
            $STForQC = $db->ExecutveQuerySingleRowSALData($queryST, $electionName, $developmentMode);

            if(sizeof($STForQC)>0){
                $ST_Date = $STForQC["ST_Date"];
            }

    ?>

        <div class="row">
            <legend><b><?php echo $srNo.") "; ?> Shop QC :: <?php echo $getShopName." - ".$getCalling_Category; ?> - <?php echo date('d/m/Y',strtotime($ST_Date)); ?></b></legend>
            <div class="col-12 col-sm-12 col-md-5">
                <div class="row">
                    <div class="avatar mr-75 col-md-3" style="margin-top: 10px;">
                        <?php if($getShopOutsideImage1 != ''){ ?>
                            <img src="<?php echo $getShopOutsideImage1; ?>" title="Outside Image 1" class="rounded" width="100%" height="150" alt="Avatar" />
                        <?php } else { ?>   
                            <img src="pics/shopDefault.jpeg" class="rounded" title="Outside Image 1" width="150" height="150" alt="Avatar" />
                        <?php } ?>
                    </div>
                    <div class="media-body my-10px col-md-9" style="margin-top: 10px;">
                        <h6>    
                            <b><?php echo $getShopNameMar; ?></b> 
                        </h6>
                        <h6><b><?php echo $getShopKeeperName; ?> - <?php echo $getShopKeeperMobile; ?></b></h6>
                        
                        
                        <h6><?php echo $getNature_of_Business; ?></h6>
                        <h6><?php echo "Pocket : ".$getPocketName.", Ward : ".$getWardNo.", ".$getWardArea.", ".$getNodeName; ?></h6>
                        <h6><?php echo $getShopAddress_1." ".$getShopAddress_2; ?></h6>
                    
                    </div>
                    
                    

                </div>

            </div>

            <div class="col-12 col-sm-12 col-md-4">
                <div class="row">
                    <?php if($getShopOutsideImage2 != ''){ ?>
                        <div class="avatar mr-75 col-md-4">
                            <img src="<?php echo $getShopOutsideImage2; ?>" title="Outside Image 2" class="rounded" width="100%" height="150" alt="Avatar" />
                        </div>
                    <?php } ?>

                    <?php if($getShopInsideImage1 != ''){ ?>
                        <div class="avatar mr-75 col-md-4">
                            <img src="<?php echo $getShopInsideImage1; ?>" title="Inside Image 1" class="rounded" width="100%" height="150" alt="Avatar" />
                        </div>
                    <?php } ?>

                    <?php if($getShopInsideImage2 != ''){ ?>
                        <div class="avatar mr-75 col-md-4">
                            <img src="<?php echo $getShopInsideImage2; ?>" title="Inside Image 2" class="rounded" width="100%" height="150" alt="Avatar" />
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-3 text-right" >
                <div class="media">
                    <div class="media-body my-10px">
                        <h5>
                            <?php if(!empty($getShopStatus)) { ?> 
                                    <b style="color:<?php echo $getShopStatusTextColor; ?>;"><?php echo $getShopStatus; ?></b>
                                    <i class="<?php echo $getShopStatusFaIcon; ?>" style="color:<?php echo $getShopStatusTextColor; ?>;font-size:22px"></i>
                            <?php } ?>
                        </h5>
                        <h6><?php echo "<b>Shop Listed : </b>  ".$getAddedDate; ?></h6>
                        <h6><?php if(!empty($getSurveyDate)){ echo "<b>Survey Date : </b>".$getSurveyDate; }  ?></h6>
                        <h6><?php if(!empty($getShopStatusDate)){ echo "<b>Status Date : </b>".$getShopStatusDate; }  ?></h6>
                        
                    </div>

                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered complex-headers zero-configuration" width="100%">
                    <thead>
                        <tr>
                        
                            <th style="text-align:center;">Sr<br>No</th>
                            <th style="text-align:left;">Shop Schedule Detail</th>
                            <?php
                                foreach ($CallingTypeDropDown as $key => $CallingTypeValue) {
                                    $callingType = $CallingTypeValue["Calling_Type"];
                            ?>
                                <th style="text-align:center;"><?php echo $callingType; ?></th>
                            <?php
                                }
                            ?>
                             
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $srno = 1;
                        foreach($shopScheduleDetailsData as $value){
                        $stScheduleCall_Cd = $value["ST_ScheduleCall_Cd"];        
                        $scheduleCall_Cd = $value["ScheduleCall_Cd"];        
                        $sd_executive_Cd = $value["Executive_Cd"];        
                        $shop_Cd = $value["Shop_Cd"];        
                        $calling_Category_Cd = $value["Calling_Category_Cd"];        
                        $callingDate = $value["CallingDate"];        
                        $callingCategory = $value["Calling_Category"];        
                        $executiveName = $value["ExecutiveName"];        
                        $ScheduleReason = $value["CallReason"];        
                        $remark = $value["Remark"];        
                        ?>
                        <tr>
                            <td><?php echo $srno++; ?> 
                                <?php 
                                    if($stScheduleCall_Cd == 0 && $sd_executive_Cd == $loginExecutiveCd){
                                ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a onclick="setDeleteScheduledShopDetail(<?php echo $scheduleCall_Cd; ?>)"><i class="feather icon-trash-2 mr-50 font-medium-3"></i></a>
                                <?php
                                    }
                                ?>
                                
                            </td>
                            <td>
                                <h6><b><?php  echo $callingDate; ?></b></h6>  
                                <h6><b><?php  echo $callingCategory; ?> </b></h6>   
                                <h6><?php  echo $ScheduleReason; ?></h6>   
                                <h6><?php  echo $remark; ?></h6>   
                                <h6 class="text-right"><?php  echo "Scheduled By: ".$executiveName; ?></h6>   
                            </td>
                            <?php 
                                
                                foreach ($CallingTypeDropDown as $key => $CallingTypeValue) {
                                    $callingType = $CallingTypeValue["Calling_Type"];
                                    $queryST = "SELECT TOP (1)
                                                ISNULL(st.ScheduleCall_Cd,0) as ScheduleCall_Cd, 
                                                ISNULL(st.Shop_Cd,0) as Shop_Cd, 
                                                ISNULL(st.Calling_Category_Cd,0) as Calling_Category_Cd,
                                                ISNULL(CONVERT(VARCHAR,st.AssignDate,105),'') as AssignDate, 
                                                ISNULL(st.AssignExec_Cd,0) as AssignExec_Cd, 
                                                ISNULL(st.AssignTempExec_Cd,0) as AssignTempExec_Cd, 
                                                ISNULL(CONVERT(VARCHAR,st.ST_DateTime,100),'') as ST_DateTime, 
                                                ISNULL(st.ST_Exec_Cd,0) as ST_Exec_Cd, 
                                                ISNULL(st.ST_Status,0) as ST_Status, 
                                                ISNULL(st.ST_StageName,'') as ST_StageName, 
                                                ISNULL(st.ST_Remark_1,'') as ST_Remark_1, 
                                                ISNULL(st.ST_Remark_2,'') as ST_Remark_2, 
                                                ISNULL(st.ST_Remark_3,'') as ST_Remark_3,
                                                ISNULL(em.ExecutiveName,'') as ST_ExecutiveName
                                            FROM ShopTracking st 
                                            INNER JOIN CallingCategoryMaster ccm on st.Calling_Category_Cd=ccm.Calling_Category_Cd
                                            INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd=st.ST_Exec_Cd 
                                            WHERE st.ScheduleCall_Cd = $scheduleCall_Cd AND st.Shop_Cd = $shop_Cd AND st.Calling_Category_Cd = $calling_Category_Cd AND ccm.Calling_Type = '$callingType' ";
                                        // echo $queryST;
                                    $dbST=new DbOperation();
                                    $STData = array();
                                    $STData = $dbST->ExecutveQuerySingleRowSALData($queryST, $electionName, $developmentMode);
                                    if(sizeof($STData)>0){
                                        $AssignDate = $STData["AssignDate"];
                                        $ST_DateTime = $STData["ST_DateTime"];
                                        $ST_Status = $STData["ST_Status"];
                                        $ST_StageName = $STData["ST_StageName"];
                                        $ST_Remark_1 = $STData["ST_Remark_1"];
                                        $ST_Remark_2 = $STData["ST_Remark_2"];
                                        $ST_Remark_3 = $STData["ST_Remark_3"];
                                        $ST_ExecutiveName = $STData["ST_ExecutiveName"];
                                ?>
                                    <td>
                                        <h6><b><?php echo "Assigned on : ".$AssignDate; ?></b></h6>
                                        <?php if($ST_Status == 1){ ?>
                                            <h6><b><?php echo "Completed on : ".$ST_DateTime; ?></b></h6>
                                            <h6><?php  echo $ST_StageName; ?></h6>   
                                            <h6><?php  echo $ST_Remark_1; ?></h6>   
                                            <h6><?php  echo $ST_Remark_2; ?></h6>   
                                            <h6><?php  echo $ST_Remark_3; ?></h6>   
                                            <h6><?php  echo "Completed By: ".$ST_ExecutiveName; ?></h6> 
                                        <?php } ?>
                                          
                                    </td>
                                <?php }else{ ?>
                                    <td></td>
                                <?php } ?>
                                   
                            <?php
                                }
                            ?>
                            
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

                            
            <?php


        } 
        catch(Exception $e)  
        {  
            echo("Error!");  
        }
                                                          

  }else{
    //echo "ddd";
  }

}
?>

